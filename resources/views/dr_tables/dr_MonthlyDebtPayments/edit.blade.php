@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_monthlydebtpayments_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Monthly Debt Payments Info') }}</strong>
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
                    <form role="form" id="dr_monthlydebtpayments" method="POST" action="{{route('drmonthlydebtpayments.update',['id'=>$drmonthlydebtpayments->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <input id="" type="hidden" class="form-control" name="client_name" value="{{$client_name}}"> 
                        <input id="" type="hidden" class="form-control" name="opponent_name" value="{{$opponent_name}}"> 
                        <!-- Joint Monthly Debt Payments Info Section -->
                        <div class="form-row num_Joint_debt_payment_info">
                            <h4 class="col-sm-12">Joint Debt Payments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_Monthly_Debts_Creditors">How Many Loans in Both Parties Names?</label>
                                <input id="Num_Joint_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Joint_Monthly_Debts_Creditors" value="<?php if(isset($drmonthlydebtpayments->Num_Joint_Monthly_Debts_Creditors)){ echo $drmonthlydebtpayments->Num_Joint_Monthly_Debts_Creditors; } ?>" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Joint_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name1">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name1" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name1)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security1" name="Joint_Monthly_Debt_Purpose_Security1" class="form-control 1_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security1!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security1_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security1_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security1_Input" name="Joint_Monthly_Debt_Other_Type1" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type1)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_Both" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment1" type="number" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment1" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment1)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance1">Balance Owed</label>
                                    <input id="Joint_Debt_Balance1" type="number" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance1" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance1)){ echo $drmonthlydebtpayments->Joint_Debt_Balance1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_Both" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_OpName" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name2">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name2" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name2)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security2" name="Joint_Monthly_Debt_Purpose_Security2" class="form-control 2_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security2!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security2_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security2_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security2_Input" name="Joint_Monthly_Debt_Other_Type2" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type2)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_Both" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment2" type="number" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment2" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment2)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance2">Balance Owed</label>
                                    <input id="Joint_Debt_Balance2" type="number" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance2" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance2)){ echo $drmonthlydebtpayments->Joint_Debt_Balance2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_Both" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_OpName" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name3">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name3" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name3)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security3" name="Joint_Monthly_Debt_Purpose_Security3" class="form-control 3_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security3!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security3_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security3_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security3_Input" name="Joint_Monthly_Debt_Other_Type3" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type3)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_Both" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment3" type="number" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment3" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment3)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance3">Balance Owed</label>
                                    <input id="Joint_Debt_Balance3" type="number" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance3" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance3)){ echo $drmonthlydebtpayments->Joint_Debt_Balance3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_Both" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_OpName" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name4">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name4" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name4)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security4" name="Joint_Monthly_Debt_Purpose_Security4" class="form-control 4_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security4!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security4_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security4_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security4_Input" name="Joint_Monthly_Debt_Other_Type4" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type4)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_Both" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment4" type="number" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment4" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment4)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance4">Balance Owed</label>
                                    <input id="Joint_Debt_Balance4" type="number" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance4" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance4)){ echo $drmonthlydebtpayments->Joint_Debt_Balance4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_Both" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_OpName" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name5">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name5" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name5)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security5" name="Joint_Monthly_Debt_Purpose_Security5" class="form-control 5_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security5!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security5_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security5_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security5_Input" name="Joint_Monthly_Debt_Other_Type5" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type5)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_Both" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment5" type="number" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment5" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment5)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance5">Balance Owed</label>
                                    <input id="Joint_Debt_Balance5" type="number" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance5" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance5)){ echo $drmonthlydebtpayments->Joint_Debt_Balance5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_Both" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_OpName" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name6">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name6" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name6)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security6" name="Joint_Monthly_Debt_Purpose_Security6" class="form-control 6_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security6!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security6_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security6_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security6_Input" name="Joint_Monthly_Debt_Other_Type6" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type6)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_Both" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment6" type="number" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment6" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment6)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance6">Balance Owed</label>
                                    <input id="Joint_Debt_Balance6" type="number" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance6" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance6)){ echo $drmonthlydebtpayments->Joint_Debt_Balance6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_Both" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_OpName" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name7">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name7" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name7)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security7" name="Joint_Monthly_Debt_Purpose_Security7" class="form-control 7_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security7!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security7_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security7_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security7_Input" name="Joint_Monthly_Debt_Other_Type7" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type7)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_Both" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment7" type="number" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment7" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment7)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance7">Balance Owed</label>
                                    <input id="Joint_Debt_Balance7" type="number" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance7" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance7)){ echo $drmonthlydebtpayments->Joint_Debt_Balance7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_Both" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_OpName" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name8">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name8" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name8)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security8" name="Joint_Monthly_Debt_Purpose_Security8" class="form-control 8_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security8!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security8_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security8_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security8_Input" name="Joint_Monthly_Debt_Other_Type8" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type8)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_Both" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment8" type="number" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment8" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment8)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance8">Balance Owed</label>
                                    <input id="Joint_Debt_Balance8" type="number" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance8" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance8)){ echo $drmonthlydebtpayments->Joint_Debt_Balance8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_Both" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_OpName" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name9">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name9" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name9)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security9" name="Joint_Monthly_Debt_Purpose_Security9" class="form-control 9_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security9!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security9_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security9_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security9_Input" name="Joint_Monthly_Debt_Other_Type9" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type9)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_Both" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment9" type="number" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment9" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment9)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance9">Balance Owed</label>
                                    <input id="Joint_Debt_Balance9" type="number" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance9" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance9)){ echo $drmonthlydebtpayments->Joint_Debt_Balance9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_Both" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_OpName" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name10">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name10" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name10)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security10" name="Joint_Monthly_Debt_Purpose_Security10" class="form-control 10_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security10!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security10_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security10_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security10_Input" name="Joint_Monthly_Debt_Other_Type10" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type10)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_Both" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment10" type="number" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment10" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment10)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance10">Balance Owed</label>
                                    <input id="Joint_Debt_Balance10" type="number" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance10" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance10)){ echo $drmonthlydebtpayments->Joint_Debt_Balance10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_Both" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_OpName" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name11">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name11" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name11)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security11" name="Joint_Monthly_Debt_Purpose_Security11" class="form-control 11_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security11!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security11_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security11_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security11_Input" name="Joint_Monthly_Debt_Other_Type11" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type11)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_Both" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment11" type="number" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment11" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment11)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance11">Balance Owed</label>
                                    <input id="Joint_Debt_Balance11" type="number" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance11" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance11)){ echo $drmonthlydebtpayments->Joint_Debt_Balance11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_Both" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_OpName" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name12">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name12" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name12)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security12" name="Joint_Monthly_Debt_Purpose_Security12" class="form-control 12_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security12!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security12_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security12_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security12_Input" name="Joint_Monthly_Debt_Other_Type12" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type12)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_Both" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment12" type="number" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment12" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment12)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance12">Balance Owed</label>
                                    <input id="Joint_Debt_Balance12" type="number" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance12" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance12)){ echo $drmonthlydebtpayments->Joint_Debt_Balance12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_Both" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_OpName" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name13">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name13" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name13)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security13" name="Joint_Monthly_Debt_Purpose_Security13" class="form-control 13_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security13!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security13_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security13_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security13_Input" name="Joint_Monthly_Debt_Other_Type13" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type13)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_Both" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment13" type="number" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment13" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment13)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance13">Balance Owed</label>
                                    <input id="Joint_Debt_Balance13" type="number" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance13" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance13)){ echo $drmonthlydebtpayments->Joint_Debt_Balance13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_Both" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_OpName" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name14">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name14" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name14)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security14" name="Joint_Monthly_Debt_Purpose_Security14" class="form-control 14_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security14!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security14_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security14_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security14_Input" name="Joint_Monthly_Debt_Other_Type14" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type14)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_Both" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment14" type="number" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment14" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment14)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance14">Balance Owed</label>
                                    <input id="Joint_Debt_Balance14" type="number" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance14" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance14)){ echo $drmonthlydebtpayments->Joint_Debt_Balance14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_Both" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_OpName" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name15">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name15" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name15)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Creditor_Name15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security15" name="Joint_Monthly_Debt_Purpose_Security15" class="form-control 15_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Purpose_Security15!='Other'){ echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security15_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security15_Text">';
                                } ?>
                                
                                    <label for="Joint_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security15_Input" name="Joint_Monthly_Debt_Other_Type15" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type15)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Other_Type15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_Both" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Joint_Monthly_Debt_Primary_Beneficiary15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment15" type="number" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment15" value="<?php if(isset($drmonthlydebtpayments->Joint_Monthly_Debt_Payment15)){ echo $drmonthlydebtpayments->Joint_Monthly_Debt_Payment15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance15">Balance Owed</label>
                                    <input id="Joint_Debt_Balance15" type="number" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance15" value="<?php if(isset($drmonthlydebtpayments->Joint_Debt_Balance15)){ echo $drmonthlydebtpayments->Joint_Debt_Balance15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_Both" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_OpName" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Joint_Debt15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- End ofJoint Monthly Debt Payments Info Section -->

                        <!-- Client Monthly Debt Payments Info Section -->
                        <div class="form-row num_Client_debt_payment_info mt-4">
                            <h4 class="col-sm-12">{{$client_name}} Debt Payments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Client_Monthly_Debts_Creditors">How Many Loans in {{$client_name}}’s Name Only?</label>
                                <input id="Num_Client_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Client_Monthly_Debts_Creditors" value="<?php if(isset($drmonthlydebtpayments->Num_Client_Monthly_Debts_Creditors)){ echo $drmonthlydebtpayments->Num_Client_Monthly_Debts_Creditors; } ?>" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Client_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name1">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name1" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name1)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security1" name="Client_Monthly_Debt_Purpose_Security1" class="form-control 1_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security1!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security1_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security1_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security1_Input" name="Client_Monthly_Debt_Other_Type1" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type1)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_Both" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_OpName" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment1" type="number" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment1" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment1)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance1">Balance Owed</label>
                                    <input id="Client_Debt_Balance1" type="number" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Debt_Balance1" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance1)){ echo $drmonthlydebtpayments->Client_Debt_Balance1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_Both" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_ClientName" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_OpName" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name2">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name2" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name2)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security2" name="Client_Monthly_Debt_Purpose_Security2" class="form-control 2_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security2!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security2_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security2_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security2_Input" name="Client_Monthly_Debt_Other_Type2" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type2)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_Both" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_OpName" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment2" type="number" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment2" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment2)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance2">Balance Owed</label>
                                    <input id="Client_Debt_Balance2" type="number" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Debt_Balance2" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance2)){ echo $drmonthlydebtpayments->Client_Debt_Balance2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_Both" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_ClientName" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_OpName" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name3">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name3" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name3)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security3" name="Client_Monthly_Debt_Purpose_Security3" class="form-control 3_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security3!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security3_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security3_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security3_Input" name="Client_Monthly_Debt_Other_Type3" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type3)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_Both" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_OpName" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment3" type="number" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment3" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment3)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance3">Balance Owed</label>
                                    <input id="Client_Debt_Balance3" type="number" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Debt_Balance3" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance3)){ echo $drmonthlydebtpayments->Client_Debt_Balance3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_Both" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_ClientName" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_OpName" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name4">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name4" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name4)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security4" name="Client_Monthly_Debt_Purpose_Security4" class="form-control 4_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security4!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security4_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security4_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security4_Input" name="Client_Monthly_Debt_Other_Type4" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type4)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_Both" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_OpName" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment4" type="number" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment4" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment4)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance4">Balance Owed</label>
                                    <input id="Client_Debt_Balance4" type="number" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Debt_Balance4" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance4)){ echo $drmonthlydebtpayments->Client_Debt_Balance4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_Both" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_ClientName" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_OpName" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name5">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name5" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name5)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security5" name="Client_Monthly_Debt_Purpose_Security5" class="form-control 5_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security5!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security5_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security5_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security5_Input" name="Client_Monthly_Debt_Other_Type5" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type5)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_Both" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_OpName" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment5" type="number" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment5" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment5)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance5">Balance Owed</label>
                                    <input id="Client_Debt_Balance5" type="number" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Debt_Balance5" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance5)){ echo $drmonthlydebtpayments->Client_Debt_Balance5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_Both" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_ClientName" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_OpName" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name6">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name6" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name6)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security6" name="Client_Monthly_Debt_Purpose_Security6" class="form-control 6_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security6!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security6_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security6_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security6_Input" name="Client_Monthly_Debt_Other_Type6" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type6)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_Both" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_OpName" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment6" type="number" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment6" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment6)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance6">Balance Owed</label>
                                    <input id="Client_Debt_Balance6" type="number" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Debt_Balance6" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance6)){ echo $drmonthlydebtpayments->Client_Debt_Balance6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_Both" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_ClientName" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_OpName" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name7">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name7" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name7)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security7" name="Client_Monthly_Debt_Purpose_Security7" class="form-control 7_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security7!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security7_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security7_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security7_Input" name="Client_Monthly_Debt_Other_Type7" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type7)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_Both" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_OpName" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment7" type="number" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment7" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment7)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance7">Balance Owed</label>
                                    <input id="Client_Debt_Balance7" type="number" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Debt_Balance7" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance7)){ echo $drmonthlydebtpayments->Client_Debt_Balance7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_Both" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_ClientName" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_OpName" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name8">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name8" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name8)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security8" name="Client_Monthly_Debt_Purpose_Security8" class="form-control 8_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security8!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security8_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security8_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security8_Input" name="Client_Monthly_Debt_Other_Type8" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type8)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_Both" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_OpName" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment8" type="number" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment8" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment8)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance8">Balance Owed</label>
                                    <input id="Client_Debt_Balance8" type="number" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Debt_Balance8" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance8)){ echo $drmonthlydebtpayments->Client_Debt_Balance8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_Both" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_ClientName" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_OpName" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name9">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name9" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name9)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security9" name="Client_Monthly_Debt_Purpose_Security9" class="form-control 9_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security9!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security9_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security9_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security9_Input" name="Client_Monthly_Debt_Other_Type9" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type9)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_Both" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_OpName" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment9" type="number" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment9" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment9)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance9">Balance Owed</label>
                                    <input id="Client_Debt_Balance9" type="number" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Debt_Balance9" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance9)){ echo $drmonthlydebtpayments->Client_Debt_Balance9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_Both" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_ClientName" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_OpName" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name10">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name10" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name10)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security10" name="Client_Monthly_Debt_Purpose_Security10" class="form-control 10_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security10!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security10_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security10_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security10_Input" name="Client_Monthly_Debt_Other_Type10" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type10)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_Both" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_OpName" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment10" type="number" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment10" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment10)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance10">Balance Owed</label>
                                    <input id="Client_Debt_Balance10" type="number" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Debt_Balance10" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance10)){ echo $drmonthlydebtpayments->Client_Debt_Balance10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_Both" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_ClientName" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_OpName" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name11">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name11" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name11)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security11" name="Client_Monthly_Debt_Purpose_Security11" class="form-control 11_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security11!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security11_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security11_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security11_Input" name="Client_Monthly_Debt_Other_Type11" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type11)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_Both" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_OpName" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment11" type="number" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment11" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment11)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance11">Balance Owed</label>
                                    <input id="Client_Debt_Balance11" type="number" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Debt_Balance11" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance11)){ echo $drmonthlydebtpayments->Client_Debt_Balance11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_Both" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_ClientName" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_OpName" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name12">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name12" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name12)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security12" name="Client_Monthly_Debt_Purpose_Security12" class="form-control 12_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security12!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security12_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security12_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security12_Input" name="Client_Monthly_Debt_Other_Type12" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type12)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_Both" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_OpName" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment12" type="number" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment12" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment12)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance12">Balance Owed</label>
                                    <input id="Client_Debt_Balance12" type="number" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Debt_Balance12" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance12)){ echo $drmonthlydebtpayments->Client_Debt_Balance12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_Both" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_ClientName" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_OpName" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name13">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name13" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name13)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security13" name="Client_Monthly_Debt_Purpose_Security13" class="form-control 13_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security13!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security13_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security13_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security13_Input" name="Client_Monthly_Debt_Other_Type13" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type13)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_Both" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_OpName" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment13" type="number" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment13" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment13)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance13">Balance Owed</label>
                                    <input id="Client_Debt_Balance13" type="number" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Debt_Balance13" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance13)){ echo $drmonthlydebtpayments->Client_Debt_Balance13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_Both" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_ClientName" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_OpName" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name14">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name14" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name14)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security14" name="Client_Monthly_Debt_Purpose_Security14" class="form-control 14_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security14!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security14_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security14_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security14_Input" name="Client_Monthly_Debt_Other_Type14" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type14)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_Both" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_OpName" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment14" type="number" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment14" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment14)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance14">Balance Owed</label>
                                    <input id="Client_Debt_Balance14" type="number" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Debt_Balance14" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance14)){ echo $drmonthlydebtpayments->Client_Debt_Balance14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_Both" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_ClientName" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_OpName" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name15">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name15" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name15)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Creditor_Name15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security15" name="Client_Monthly_Debt_Purpose_Security15" class="form-control 15_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Client_Monthly_Debt_Purpose_Security15!='Other'){ echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security15_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security15_Text">';
                                } ?>
                                
                                    <label for="Client_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security15_Input" name="Client_Monthly_Debt_Other_Type15" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Other_Type15)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Other_Type15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_Both" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_OpName" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Client_Monthly_Debt_Primary_Beneficiary15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment15" type="number" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment15" value="<?php if(isset($drmonthlydebtpayments->Client_Monthly_Debt_Payment15)){ echo $drmonthlydebtpayments->Client_Monthly_Debt_Payment15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance15">Balance Owed</label>
                                    <input id="Client_Debt_Balance15" type="number" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Debt_Balance15" value="<?php if(isset($drmonthlydebtpayments->Client_Debt_Balance15)){ echo $drmonthlydebtpayments->Client_Debt_Balance15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_Both" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_ClientName" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_OpName" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Client_Debt15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Client Monthly Debt Payments Info Section -->

                        <!-- Opponent Monthly Debt Payments Info Section -->
                        <div class="form-row num_Opponent_debt_payment_info mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Debt Payments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Op_Monthly_Debts_Creditors">How Many Loans in {{$opponent_name}}’s Name Only?</label>
                                <input id="Num_Op_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Op_Monthly_Debts_Creditors" value="<?php if(isset($drmonthlydebtpayments->Num_Op_Monthly_Debts_Creditors)){ echo $drmonthlydebtpayments->Num_Op_Monthly_Debts_Creditors; } ?>" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name1">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name1" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name1)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security1" name="Op_Monthly_Debt_Purpose_Security1" class="form-control 1_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security1!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security1_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security1_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security1_Input" name="Op_Monthly_Debt_Other_Type1" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type1)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_Both" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_OpName" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment1" type="number" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment1" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment1)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance1">Balance Owed</label>
                                    <input id="Op_Debt_Balance1" type="number" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Debt_Balance1" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance1)){ echo $drmonthlydebtpayments->Op_Debt_Balance1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_Both" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_ClientName" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_OpName" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt1==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name2">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name2" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name2)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security2" name="Op_Monthly_Debt_Purpose_Security2" class="form-control 2_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security2!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security2_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security2_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security2_Input" name="Op_Monthly_Debt_Other_Type2" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type2)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_Both" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_OpName" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment2" type="number" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment2" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment2)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance2">Balance Owed</label>
                                    <input id="Op_Debt_Balance2" type="number" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Debt_Balance2" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance2)){ echo $drmonthlydebtpayments->Op_Debt_Balance2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_Both" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_ClientName" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_OpName" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt2==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name3">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name3" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name3)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security3" name="Op_Monthly_Debt_Purpose_Security3" class="form-control 3_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security3!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security3_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security3_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security3_Input" name="Op_Monthly_Debt_Other_Type3" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type3)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_Both" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_OpName" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment3" type="number" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment3" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment3)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance3">Balance Owed</label>
                                    <input id="Op_Debt_Balance3" type="number" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Debt_Balance3" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance3)){ echo $drmonthlydebtpayments->Op_Debt_Balance3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_Both" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_ClientName" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_OpName" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt3==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name4">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name4" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name4)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security4" name="Op_Monthly_Debt_Purpose_Security4" class="form-control 4_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security4!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security4_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security4_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security4_Input" name="Op_Monthly_Debt_Other_Type4" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type4)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_Both" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_OpName" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment4" type="number" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment4" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment4)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance4">Balance Owed</label>
                                    <input id="Op_Debt_Balance4" type="number" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Debt_Balance4" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance4)){ echo $drmonthlydebtpayments->Op_Debt_Balance4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_Both" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_ClientName" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_OpName" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt4==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name5">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name5" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name5)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security5" name="Op_Monthly_Debt_Purpose_Security5" class="form-control 5_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security5!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security5_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security5_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security5_Input" name="Op_Monthly_Debt_Other_Type5" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type5)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_Both" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_OpName" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment5" type="number" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment5" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment5)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance5">Balance Owed</label>
                                    <input id="Op_Debt_Balance5" type="number" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Debt_Balance5" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance5)){ echo $drmonthlydebtpayments->Op_Debt_Balance5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_Both" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_ClientName" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_OpName" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt5==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name6">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name6" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name6)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security6" name="Op_Monthly_Debt_Purpose_Security6" class="form-control 6_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security6!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security6_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security6_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security6_Input" name="Op_Monthly_Debt_Other_Type6" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type6)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type6; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_Both" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_OpName" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment6" type="number" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment6" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment6)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance6">Balance Owed</label>
                                    <input id="Op_Debt_Balance6" type="number" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Debt_Balance6" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance6)){ echo $drmonthlydebtpayments->Op_Debt_Balance6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_Both" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_ClientName" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_OpName" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt6==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name7">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name7" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name7)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security7" name="Op_Monthly_Debt_Purpose_Security7" class="form-control 7_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security7!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security7_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security7_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security7_Input" name="Op_Monthly_Debt_Other_Type7" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type7)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type7; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_Both" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_OpName" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment7" type="number" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment7" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment7)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance7">Balance Owed</label>
                                    <input id="Op_Debt_Balance7" type="number" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Debt_Balance7" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance7)){ echo $drmonthlydebtpayments->Op_Debt_Balance7; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_Both" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_ClientName" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_OpName" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt7==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name8">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name8" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name8)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security8" name="Op_Monthly_Debt_Purpose_Security8" class="form-control 8_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security8!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security8_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security8_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security8_Input" name="Op_Monthly_Debt_Other_Type8" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type8)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type8; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_Both" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_OpName" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment8" type="number" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment8" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment8)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance8">Balance Owed</label>
                                    <input id="Op_Debt_Balance8" type="number" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Debt_Balance8" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance8)){ echo $drmonthlydebtpayments->Op_Debt_Balance8; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_Both" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_ClientName" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_OpName" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt8==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name9">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name9" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name9)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security9" name="Op_Monthly_Debt_Purpose_Security9" class="form-control 9_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security9!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security9_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security9_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security9_Input" name="Op_Monthly_Debt_Other_Type9" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type9)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type9; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_Both" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_OpName" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment9" type="number" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment9" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment9)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance9">Balance Owed</label>
                                    <input id="Op_Debt_Balance9" type="number" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Debt_Balance9" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance9)){ echo $drmonthlydebtpayments->Op_Debt_Balance9; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_Both" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_ClientName" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_OpName" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt9==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name10">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name10" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name10)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security10" name="Op_Monthly_Debt_Purpose_Security10" class="form-control 10_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security10!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security10_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security10_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security10_Input" name="Op_Monthly_Debt_Other_Type10" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type10)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type10; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_Both" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_OpName" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment10" type="number" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment10" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment10)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance10">Balance Owed</label>
                                    <input id="Op_Debt_Balance10" type="number" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Debt_Balance10" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance10)){ echo $drmonthlydebtpayments->Op_Debt_Balance10; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_Both" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_ClientName" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_OpName" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt10==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name11">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name11" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name11)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security11" name="Op_Monthly_Debt_Purpose_Security11" class="form-control 11_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security11!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security11_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security11_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security11_Input" name="Op_Monthly_Debt_Other_Type11" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type11)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type11; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_Both" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_OpName" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment11" type="number" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment11" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment11)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance11">Balance Owed</label>
                                    <input id="Op_Debt_Balance11" type="number" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Debt_Balance11" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance11)){ echo $drmonthlydebtpayments->Op_Debt_Balance11; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_Both" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_ClientName" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_OpName" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt11==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name12">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name12" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name12)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security12" name="Op_Monthly_Debt_Purpose_Security12" class="form-control 12_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security12!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security12_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security12_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security12_Input" name="Op_Monthly_Debt_Other_Type12" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type12)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type12; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_Both" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_OpName" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment12" type="number" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment12" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment12)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance12">Balance Owed</label>
                                    <input id="Op_Debt_Balance12" type="number" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Debt_Balance12" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance12)){ echo $drmonthlydebtpayments->Op_Debt_Balance12; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_Both" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_ClientName" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_OpName" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt12==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name13">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name13" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name13)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security13" name="Op_Monthly_Debt_Purpose_Security13" class="form-control 13_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security13!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security13_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security13_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security13_Input" name="Op_Monthly_Debt_Other_Type13" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type13)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type13; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_Both" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_OpName" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment13" type="number" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment13" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment13)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance13">Balance Owed</label>
                                    <input id="Op_Debt_Balance13" type="number" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Debt_Balance13" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance13)){ echo $drmonthlydebtpayments->Op_Debt_Balance13; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_Both" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_ClientName" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_OpName" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt13==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name14">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name14" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name14)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security14" name="Op_Monthly_Debt_Purpose_Security14" class="form-control 14_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security14!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security14_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security14_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security14_Input" name="Op_Monthly_Debt_Other_Type14" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type14)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type14; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_Both" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_OpName" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment14" type="number" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment14" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment14)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance14">Balance Owed</label>
                                    <input id="Op_Debt_Balance14" type="number" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Debt_Balance14" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance14)){ echo $drmonthlydebtpayments->Op_Debt_Balance14; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_Both" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_ClientName" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_OpName" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt14==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name15">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name15" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name15)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Creditor_Name15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security15" name="Op_Monthly_Debt_Purpose_Security15" class="form-control 15_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="">Select</option>
                                        <option value="Credit Card" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Credit Card'){ echo 'selected="selected"'; } ?>>Credit Card</option>
                                        <option value="Car Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Car Loan'){ echo 'selected="selected"'; } ?>>Car Loan</option>
                                        <option value="Motorcycle Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Motorcycle Loan'){ echo 'selected="selected"'; } ?>>Motorcycle Loan</option>
                                        <option value="RV Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='RV Loan'){ echo 'selected="selected"'; } ?>>RV Loan</option>
                                        <option value="Personal Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Personal Loan'){ echo 'selected="selected"'; } ?>>Personal Loan</option>
                                        <option value="Line of Credit" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Line of Credit'){ echo 'selected="selected"'; } ?>>Line of Credit</option>
                                        <option value="Education Loan" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Education Loan'){ echo 'selected="selected"'; } ?>>Education Loan</option>
                                        <option value="Medical Bills" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Medical Bills'){ echo 'selected="selected"'; } ?>>Medical Bills</option>
                                        <option value="Other" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15=='Other'){ echo 'selected="selected"'; } ?>>Other</option>
                                    </select>   
                                </div>
                                <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15) && $drmonthlydebtpayments->Op_Monthly_Debt_Purpose_Security15!='Other'){ echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security15_Text" style="display: none;">'; } else {
                                    echo '<div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security15_Text">';
                                } ?>
                                
                                    <label for="Op_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security15_Input" name="Op_Monthly_Debt_Other_Type15" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Other_Type15)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Other_Type15; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_Both" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15=='Both'){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_OpName" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15) && $drmonthlydebtpayments->Op_Monthly_Debt_Primary_Beneficiary15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment15" type="number" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment15" value="<?php if(isset($drmonthlydebtpayments->Op_Monthly_Debt_Payment15)){ echo $drmonthlydebtpayments->Op_Monthly_Debt_Payment15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance15">Balance Owed</label>
                                    <input id="Op_Debt_Balance15" type="number" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Debt_Balance15" value="<?php if(isset($drmonthlydebtpayments->Op_Debt_Balance15)){ echo $drmonthlydebtpayments->Op_Debt_Balance15; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_Both" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="Both" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15=="Both"){ echo "checked"; } ?>> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_ClientName" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="{{$client_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15==$client_name){ echo "checked"; } ?>> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_OpName" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}" <?php if(isset($drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15) && $drmonthlydebtpayments->Post_Decree_Responsible_Party_Op_Debt15==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Debt Payments Info Section -->
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

    // show hide/show fields based on selected options
    function onSelectChange(select){
        var id=select.id;
        var value=select.value;
        if(value=='Other'){
            $('.'+id+'_Input').prop('required',true);
            $('.'+id+'_Text').show();
        } else{
            $('.'+id+'_Input').prop('required',false);
            $('.'+id+'_Text').hide();
        }


    }
    $(document).ready(function(){

        $('#dr_monthlydebtpayments').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        // on number of joint monthly debts creditors input change
        var total_joint_debt=$('#Num_Joint_Monthly_Debts_Creditors').val();
        if(total_joint_debt > 0 && total_joint_debt <= 15){
            for (var i = 1; i <= total_joint_debt; i++) {
                $('.'+i+'_Joint_debt_payment_info_section').show();
            }     
        }
        $('#Num_Joint_Monthly_Debts_Creditors').on('change keyup', function(){
            $('.1_Joint_debt_payment_info_section, .2_Joint_debt_payment_info_section, .3_Joint_debt_payment_info_section, .4_Joint_debt_payment_info_section, .5_Joint_debt_payment_info_section, .6_Joint_debt_payment_info_section, .7_Joint_debt_payment_info_section, .8_Joint_debt_payment_info_section, .9_Joint_debt_payment_info_section, .10_Joint_debt_payment_info_section, .11_Joint_debt_payment_info_section, .12_Joint_debt_payment_info_section, .13_Joint_debt_payment_info_section, .14_Joint_debt_payment_info_section, .15_Joint_debt_payment_info_section').hide();
            if(this.value > 0 &&  this.value <= 15 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Joint_debt_payment_info_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 15; i++) {
                $('.'+i+'_Joint_debt_payment_info_section input').prop('required',false);
                // $('.'+i+'_Joint_debt_payment_info_section select option[value=""]').prop('selected','selected');
                // $('.Joint_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
            }
        });
        // on number of client monthly debts creditors input change
        var total_client_debt=$('#Num_Client_Monthly_Debts_Creditors').val();
        if(total_client_debt > 0 && total_client_debt <= 15){
            for (var i = 1; i <= total_client_debt; i++) {
                $('.'+i+'_Client_debt_payment_info_section').show();
            }     
        }
        $('#Num_Client_Monthly_Debts_Creditors').on('change keyup', function(){
            $('.1_Client_debt_payment_info_section, .2_Client_debt_payment_info_section, .3_Client_debt_payment_info_section, .4_Client_debt_payment_info_section, .5_Client_debt_payment_info_section, .6_Client_debt_payment_info_section, .7_Client_debt_payment_info_section, .8_Client_debt_payment_info_section, .9_Client_debt_payment_info_section, .10_Client_debt_payment_info_section, .11_Client_debt_payment_info_section, .12_Client_debt_payment_info_section, .13_Client_debt_payment_info_section, .14_Client_debt_payment_info_section, .15_Client_debt_payment_info_section').hide();
            if(this.value > 0 &&  this.value <= 15 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Client_debt_payment_info_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 15; i++) {
                $('.'+i+'_Client_debt_payment_info_section input').prop('required',false);
                // $('.'+i+'_Client_debt_payment_info_section select option[value=""]').prop('selected','selected');
                // $('.Client_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
            }
        });
        // on number of opponent monthly debts creditors input change
        var total_opponent_debt=$('#Num_Op_Monthly_Debts_Creditors').val();
        if(total_opponent_debt > 0 && total_opponent_debt <= 15){
            for (var i = 1; i <= total_opponent_debt; i++) {
                $('.'+i+'_Op_debt_payment_info_section').show();
            }     
        }
        $('#Num_Op_Monthly_Debts_Creditors').on('change keyup', function(){
            $('.1_Op_debt_payment_info_section, .2_Op_debt_payment_info_section, .3_Op_debt_payment_info_section, .4_Op_debt_payment_info_section, .5_Op_debt_payment_info_section, .6_Op_debt_payment_info_section, .7_Op_debt_payment_info_section, .8_Op_debt_payment_info_section, .9_Op_debt_payment_info_section, .10_Op_debt_payment_info_section, .11_Op_debt_payment_info_section, .12_Op_debt_payment_info_section, .13_Op_debt_payment_info_section, .14_Op_debt_payment_info_section, .15_Op_debt_payment_info_section').hide();
            if(this.value > 0 &&  this.value <= 15 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_Op_debt_payment_info_section').show();
                }
            }
            var val=parseInt(this.value)+1;
            for (var i = val; i <= 15; i++) {
                $('.'+i+'_Op_debt_payment_info_section input').prop('required',false);
                // $('.'+i+'_Op_debt_payment_info_section select option[value=""]').prop('selected','selected');
                // $('.Op_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
            }
        });
    });
</script>   
@endsection