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
                    <form role="form" id="dr_monthlydebtpayments" method="POST" action="{{route('drmonthlydebtpayments.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <input id="" type="hidden" class="form-control" name="client_name" value="{{$client_name}}"> 
                        <input id="" type="hidden" class="form-control" name="opponent_name" value="{{$opponent_name}}"> 
                        <!-- Joint Monthly Debt Payments Info Section -->
                        <div class="form-row num_Joint_debt_payment_info">
                            <h4 class="col-sm-12">Joint Debt Payments Info Section</h4>
                            <div class="col-sm-6">
                                <label for="Num_Joint_Monthly_Debts_Creditors">How Many Loans in Both Parties Names?</label>
                                <input id="Num_Joint_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Joint_Monthly_Debts_Creditors" value="0" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Joint_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name1">Joint Creditor Name</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security1" name="Joint_Monthly_Debt_Purpose_Security1" class="form-control 1_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security1_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security1_Input" name="Joint_Monthly_Debt_Other_Type1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_Both" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary1_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment1" type="number" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance1">Balance Owed</label>
                                    <input id="Joint_Debt_Balance1" type="number" class="form-control 1_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_Both" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt1_OpName" name="Post_Decree_Responsible_Party_Joint_Debt1" class="1_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name2">Joint Creditor Nam2</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security2" name="Joint_Monthly_Debt_Purpose_Security2" class="form-control 2_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security2_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security2_Input" name="Joint_Monthly_Debt_Other_Type2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_Both" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary2_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment2" type="number" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance2">Balance Owed</label>
                                    <input id="Joint_Debt_Balance2" type="number" class="form-control 2_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_Both" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt2_OpName" name="Post_Decree_Responsible_Party_Joint_Debt2" class="2_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name3">Joint Creditor Nam3</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security3" name="Joint_Monthly_Debt_Purpose_Security3" class="form-control 3_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security3_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security3_Input" name="Joint_Monthly_Debt_Other_Type3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_Both" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary3_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment3" type="number" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance3">Balance Owed</label>
                                    <input id="Joint_Debt_Balance3" type="number" class="form-control 3_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_Both" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt3_OpName" name="Post_Decree_Responsible_Party_Joint_Debt3" class="3_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name4">Joint Creditor Nam4</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security4" name="Joint_Monthly_Debt_Purpose_Security4" class="form-control 4_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security4_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security4_Input" name="Joint_Monthly_Debt_Other_Type4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_Both" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary4_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment4" type="number" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance4">Balance Owed</label>
                                    <input id="Joint_Debt_Balance4" type="number" class="form-control 4_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_Both" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt4_OpName" name="Post_Decree_Responsible_Party_Joint_Debt4" class="4_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name5">Joint Creditor Nam5</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security5" name="Joint_Monthly_Debt_Purpose_Security5" class="form-control 5_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security5_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security5_Input" name="Joint_Monthly_Debt_Other_Type5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_Both" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary5_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment5" type="number" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance5">Balance Owed</label>
                                    <input id="Joint_Debt_Balance5" type="number" class="form-control 5_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_Both" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt5_OpName" name="Post_Decree_Responsible_Party_Joint_Debt5" class="5_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name6">Joint Creditor Nam6</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security6" name="Joint_Monthly_Debt_Purpose_Security6" class="form-control 6_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security6_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security6_Input" name="Joint_Monthly_Debt_Other_Type6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_Both" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary6_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment6" type="number" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance6">Balance Owed</label>
                                    <input id="Joint_Debt_Balance6" type="number" class="form-control 6_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_Both" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt6_OpName" name="Post_Decree_Responsible_Party_Joint_Debt6" class="6_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name7">Joint Creditor Nam7</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security7" name="Joint_Monthly_Debt_Purpose_Security7" class="form-control 7_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security7_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security7_Input" name="Joint_Monthly_Debt_Other_Type7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_Both" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary7_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment7" type="number" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance7">Balance Owed</label>
                                    <input id="Joint_Debt_Balance7" type="number" class="form-control 7_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_Both" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt7_OpName" name="Post_Decree_Responsible_Party_Joint_Debt7" class="7_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name8">Joint Creditor Nam8</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security8" name="Joint_Monthly_Debt_Purpose_Security8" class="form-control 8_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security8_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security8_Input" name="Joint_Monthly_Debt_Other_Type8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_Both" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary8_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment8" type="number" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance8">Balance Owed</label>
                                    <input id="Joint_Debt_Balance8" type="number" class="form-control 8_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_Both" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt8_OpName" name="Post_Decree_Responsible_Party_Joint_Debt8" class="8_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name9">Joint Creditor Nam9</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security9" name="Joint_Monthly_Debt_Purpose_Security9" class="form-control 9_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security9_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security9_Input" name="Joint_Monthly_Debt_Other_Type9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_Both" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary9_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment9" type="number" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance9">Balance Owed</label>
                                    <input id="Joint_Debt_Balance9" type="number" class="form-control 9_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_Both" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt9_OpName" name="Post_Decree_Responsible_Party_Joint_Debt9" class="9_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name10">Joint Creditor Nam10</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security10" name="Joint_Monthly_Debt_Purpose_Security10" class="form-control 10_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security10_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security10_Input" name="Joint_Monthly_Debt_Other_Type10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_Both" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary10_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment10" type="number" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance10">Balance Owed</label>
                                    <input id="Joint_Debt_Balance10" type="number" class="form-control 10_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_Both" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt10_OpName" name="Post_Decree_Responsible_Party_Joint_Debt10" class="10_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name11">Joint Creditor Nam11</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security11" name="Joint_Monthly_Debt_Purpose_Security11" class="form-control 11_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security11_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security11_Input" name="Joint_Monthly_Debt_Other_Type11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_Both" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary11_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment11" type="number" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance11">Balance Owed</label>
                                    <input id="Joint_Debt_Balance11" type="number" class="form-control 11_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_Both" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt11_OpName" name="Post_Decree_Responsible_Party_Joint_Debt11" class="11_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelveth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name12">Joint Creditor Nam12</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security12" name="Joint_Monthly_Debt_Purpose_Security12" class="form-control 12_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security12_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security12_Input" name="Joint_Monthly_Debt_Other_Type12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_Both" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary12_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment12" type="number" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance12">Balance Owed</label>
                                    <input id="Joint_Debt_Balance12" type="number" class="form-control 12_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_Both" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt12_OpName" name="Post_Decree_Responsible_Party_Joint_Debt12" class="12_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name13">Joint Creditor Nam13</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security13" name="Joint_Monthly_Debt_Purpose_Security13" class="form-control 13_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security13_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security13_Input" name="Joint_Monthly_Debt_Other_Type13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_Both" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary13_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment13" type="number" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance13">Balance Owed</label>
                                    <input id="Joint_Debt_Balance13" type="number" class="form-control 13_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_Both" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt13_OpName" name="Post_Decree_Responsible_Party_Joint_Debt13" class="13_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name14">Joint Creditor Nam14</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security14" name="Joint_Monthly_Debt_Purpose_Security14" class="form-control 14_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security14_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security14_Input" name="Joint_Monthly_Debt_Other_Type14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_Both" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary14_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment14" type="number" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance14">Balance Owed</label>
                                    <input id="Joint_Debt_Balance14" type="number" class="form-control 14_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_Both" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt14_OpName" name="Post_Decree_Responsible_Party_Joint_Debt14" class="14_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Joint_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteen Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Creditor_Name15">Joint Creditor Nam15</label>
                                    <input id="Joint_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Creditor_Name15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Joint_Monthly_Debt_Purpose_Security15" name="Joint_Monthly_Debt_Purpose_Security15" class="form-control 15_Joint_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Joint_Monthly_Debt_Purpose_Security15_Text" style="display: none;">
                                    <label for="Joint_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Joint_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Joint_debt_payment_info_inputs Joint_Monthly_Debt_Purpose_Security15_Input" name="Joint_Monthly_Debt_Other_Type15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_Both" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Joint_Monthly_Debt_Primary_Beneficiary15_OpName" name="Joint_Monthly_Debt_Primary_Beneficiary15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Joint_Monthly_Debt_Payment15" type="number" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Monthly_Debt_Payment15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Joint_Debt_Balance15">Balance Owed</label>
                                    <input id="Joint_Debt_Balance15" type="number" class="form-control 15_Joint_debt_payment_info_inputs" name="Joint_Debt_Balance15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Joint Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_Both" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_ClientName" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Joint_Debt15_OpName" name="Post_Decree_Responsible_Party_Joint_Debt15" class="15_Joint_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
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
                                <input id="Num_Client_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Client_Monthly_Debts_Creditors" value="0" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Client_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name1">Client Creditor Name</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security1" name="Client_Monthly_Debt_Purpose_Security1" class="form-control 1_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security1_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security1_Input" name="Client_Monthly_Debt_Other_Type1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_Both" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary1_OpName" name="Client_Monthly_Debt_Primary_Beneficiary1" class="1_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment1" type="number" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance1">Balance Owed</label>
                                    <input id="Client_Debt_Balance1" type="number" class="form-control 1_Client_debt_payment_info_inputs" name="Client_Debt_Balance1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_Both" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_ClientName" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt1_OpName" name="Post_Decree_Responsible_Party_Client_Debt1" class="1_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name2">Client Creditor Nam2</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security2" name="Client_Monthly_Debt_Purpose_Security2" class="form-control 2_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security2_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security2_Input" name="Client_Monthly_Debt_Other_Type2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_Both" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary2_OpName" name="Client_Monthly_Debt_Primary_Beneficiary2" class="2_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment2" type="number" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance2">Balance Owed</label>
                                    <input id="Client_Debt_Balance2" type="number" class="form-control 2_Client_debt_payment_info_inputs" name="Client_Debt_Balance2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_Both" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_ClientName" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt2_OpName" name="Post_Decree_Responsible_Party_Client_Debt2" class="2_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name3">Client Creditor Nam3</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security3" name="Client_Monthly_Debt_Purpose_Security3" class="form-control 3_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security3_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security3_Input" name="Client_Monthly_Debt_Other_Type3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_Both" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary3_OpName" name="Client_Monthly_Debt_Primary_Beneficiary3" class="3_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment3" type="number" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance3">Balance Owed</label>
                                    <input id="Client_Debt_Balance3" type="number" class="form-control 3_Client_debt_payment_info_inputs" name="Client_Debt_Balance3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_Both" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_ClientName" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt3_OpName" name="Post_Decree_Responsible_Party_Client_Debt3" class="3_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name4">Client Creditor Nam4</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security4" name="Client_Monthly_Debt_Purpose_Security4" class="form-control 4_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security4_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security4_Input" name="Client_Monthly_Debt_Other_Type4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_Both" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary4_OpName" name="Client_Monthly_Debt_Primary_Beneficiary4" class="4_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment4" type="number" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance4">Balance Owed</label>
                                    <input id="Client_Debt_Balance4" type="number" class="form-control 4_Client_debt_payment_info_inputs" name="Client_Debt_Balance4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_Both" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_ClientName" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt4_OpName" name="Post_Decree_Responsible_Party_Client_Debt4" class="4_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name5">Client Creditor Nam5</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security5" name="Client_Monthly_Debt_Purpose_Security5" class="form-control 5_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security5_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security5_Input" name="Client_Monthly_Debt_Other_Type5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_Both" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary5_OpName" name="Client_Monthly_Debt_Primary_Beneficiary5" class="5_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment5" type="number" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance5">Balance Owed</label>
                                    <input id="Client_Debt_Balance5" type="number" class="form-control 5_Client_debt_payment_info_inputs" name="Client_Debt_Balance5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_Both" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_ClientName" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt5_OpName" name="Post_Decree_Responsible_Party_Client_Debt5" class="5_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name6">Client Creditor Nam6</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security6" name="Client_Monthly_Debt_Purpose_Security6" class="form-control 6_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security6_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security6_Input" name="Client_Monthly_Debt_Other_Type6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_Both" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary6_OpName" name="Client_Monthly_Debt_Primary_Beneficiary6" class="6_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment6" type="number" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance6">Balance Owed</label>
                                    <input id="Client_Debt_Balance6" type="number" class="form-control 6_Client_debt_payment_info_inputs" name="Client_Debt_Balance6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_Both" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_ClientName" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt6_OpName" name="Post_Decree_Responsible_Party_Client_Debt6" class="6_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name7">Client Creditor Nam7</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security7" name="Client_Monthly_Debt_Purpose_Security7" class="form-control 7_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security7_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security7_Input" name="Client_Monthly_Debt_Other_Type7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_Both" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary7_OpName" name="Client_Monthly_Debt_Primary_Beneficiary7" class="7_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment7" type="number" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance7">Balance Owed</label>
                                    <input id="Client_Debt_Balance7" type="number" class="form-control 7_Client_debt_payment_info_inputs" name="Client_Debt_Balance7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_Both" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_ClientName" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt7_OpName" name="Post_Decree_Responsible_Party_Client_Debt7" class="7_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name8">Client Creditor Nam8</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security8" name="Client_Monthly_Debt_Purpose_Security8" class="form-control 8_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security8_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security8_Input" name="Client_Monthly_Debt_Other_Type8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_Both" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary8_OpName" name="Client_Monthly_Debt_Primary_Beneficiary8" class="8_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment8" type="number" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance8">Balance Owed</label>
                                    <input id="Client_Debt_Balance8" type="number" class="form-control 8_Client_debt_payment_info_inputs" name="Client_Debt_Balance8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_Both" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_ClientName" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt8_OpName" name="Post_Decree_Responsible_Party_Client_Debt8" class="8_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name9">Client Creditor Nam9</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security9" name="Client_Monthly_Debt_Purpose_Security9" class="form-control 9_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security9_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security9_Input" name="Client_Monthly_Debt_Other_Type9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_Both" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary9_OpName" name="Client_Monthly_Debt_Primary_Beneficiary9" class="9_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment9" type="number" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance9">Balance Owed</label>
                                    <input id="Client_Debt_Balance9" type="number" class="form-control 9_Client_debt_payment_info_inputs" name="Client_Debt_Balance9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_Both" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_ClientName" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt9_OpName" name="Post_Decree_Responsible_Party_Client_Debt9" class="9_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name10">Client Creditor Nam10</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security10" name="Client_Monthly_Debt_Purpose_Security10" class="form-control 10_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security10_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security10_Input" name="Client_Monthly_Debt_Other_Type10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_Both" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary10_OpName" name="Client_Monthly_Debt_Primary_Beneficiary10" class="10_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment10" type="number" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance10">Balance Owed</label>
                                    <input id="Client_Debt_Balance10" type="number" class="form-control 10_Client_debt_payment_info_inputs" name="Client_Debt_Balance10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_Both" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_ClientName" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt10_OpName" name="Post_Decree_Responsible_Party_Client_Debt10" class="10_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name11">Client Creditor Nam11</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security11" name="Client_Monthly_Debt_Purpose_Security11" class="form-control 11_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security11_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security11_Input" name="Client_Monthly_Debt_Other_Type11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_Both" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary11_OpName" name="Client_Monthly_Debt_Primary_Beneficiary11" class="11_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment11" type="number" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance11">Balance Owed</label>
                                    <input id="Client_Debt_Balance11" type="number" class="form-control 11_Client_debt_payment_info_inputs" name="Client_Debt_Balance11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_Both" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_ClientName" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt11_OpName" name="Post_Decree_Responsible_Party_Client_Debt11" class="11_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelveth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name12">Client Creditor Nam12</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security12" name="Client_Monthly_Debt_Purpose_Security12" class="form-control 12_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security12_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security12_Input" name="Client_Monthly_Debt_Other_Type12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_Both" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary12_OpName" name="Client_Monthly_Debt_Primary_Beneficiary12" class="12_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment12" type="number" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance12">Balance Owed</label>
                                    <input id="Client_Debt_Balance12" type="number" class="form-control 12_Client_debt_payment_info_inputs" name="Client_Debt_Balance12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_Both" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_ClientName" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt12_OpName" name="Post_Decree_Responsible_Party_Client_Debt12" class="12_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name13">Client Creditor Nam13</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security13" name="Client_Monthly_Debt_Purpose_Security13" class="form-control 13_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security13_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security13_Input" name="Client_Monthly_Debt_Other_Type13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_Both" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary13_OpName" name="Client_Monthly_Debt_Primary_Beneficiary13" class="13_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment13" type="number" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance13">Balance Owed</label>
                                    <input id="Client_Debt_Balance13" type="number" class="form-control 13_Client_debt_payment_info_inputs" name="Client_Debt_Balance13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_Both" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_ClientName" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt13_OpName" name="Post_Decree_Responsible_Party_Client_Debt13" class="13_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name14">Client Creditor Nam14</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security14" name="Client_Monthly_Debt_Purpose_Security14" class="form-control 14_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security14_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security14_Input" name="Client_Monthly_Debt_Other_Type14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_Both" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary14_OpName" name="Client_Monthly_Debt_Primary_Beneficiary14" class="14_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment14" type="number" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance14">Balance Owed</label>
                                    <input id="Client_Debt_Balance14" type="number" class="form-control 14_Client_debt_payment_info_inputs" name="Client_Debt_Balance14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_Both" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_ClientName" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt14_OpName" name="Post_Decree_Responsible_Party_Client_Debt14" class="14_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Client_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteen Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Creditor_Name15">Client Creditor Nam15</label>
                                    <input id="Client_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Creditor_Name15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Client_Monthly_Debt_Purpose_Security15" name="Client_Monthly_Debt_Purpose_Security15" class="form-control 15_Client_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Monthly_Debt_Purpose_Security15_Text" style="display: none;">
                                    <label for="Client_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Client_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Client_debt_payment_info_inputs Client_Monthly_Debt_Purpose_Security15_Input" name="Client_Monthly_Debt_Other_Type15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_Both" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Client_Monthly_Debt_Primary_Beneficiary15_OpName" name="Client_Monthly_Debt_Primary_Beneficiary15" class="15_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Client_Monthly_Debt_Payment15" type="number" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Monthly_Debt_Payment15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Debt_Balance15">Balance Owed</label>
                                    <input id="Client_Debt_Balance15" type="number" class="form-control 15_Client_debt_payment_info_inputs" name="Client_Debt_Balance15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Client Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_Both" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_ClientName" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Client_Debt15_OpName" name="Post_Decree_Responsible_Party_Client_Debt15" class="15_Client_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
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
                                <input id="Num_Op_Monthly_Debts_Creditors" type="number" class="form-control" name="Num_Op_Monthly_Debts_Creditors" value="0" min="0" max="15"> 
                            </div>
                        </div>
                        <div class="form-row Opponent_debt_payment_info_section">
                            <div class="col-sm-12 mt-4 1_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">First Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name1">Opponent Creditor Name</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name1" type="text" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security1">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security1" name="Op_Monthly_Debt_Purpose_Security1" class="form-control 1_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security1_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type1">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type1" type="text" class="form-control 1_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security1_Input" name="Op_Monthly_Debt_Other_Type1" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_Both" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary1_OpName" name="Op_Monthly_Debt_Primary_Beneficiary1" class="1_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment1">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment1" type="number" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance1">Balance Owed</label>
                                    <input id="Op_Debt_Balance1" type="number" class="form-control 1_Op_debt_payment_info_inputs" name="Op_Debt_Balance1" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_Both" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_ClientName" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt1_OpName" name="Post_Decree_Responsible_Party_Op_Debt1" class="1_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 2_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Second Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name2">Opponent Creditor Nam2</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name2" type="text" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security2">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security2" name="Op_Monthly_Debt_Purpose_Security2" class="form-control 2_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security2_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type2">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type2" type="text" class="form-control 2_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security2_Input" name="Op_Monthly_Debt_Other_Type2" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_Both" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary2_OpName" name="Op_Monthly_Debt_Primary_Beneficiary2" class="2_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment2">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment2" type="number" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance2">Balance Owed</label>
                                    <input id="Op_Debt_Balance2" type="number" class="form-control 2_Op_debt_payment_info_inputs" name="Op_Debt_Balance2" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_Both" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_ClientName" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt2_OpName" name="Post_Decree_Responsible_Party_Op_Debt2" class="2_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 3_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Third Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name3">Opponent Creditor Nam3</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name3" type="text" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security3">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security3" name="Op_Monthly_Debt_Purpose_Security3" class="form-control 3_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security3_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type3">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type3" type="text" class="form-control 3_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security3_Input" name="Op_Monthly_Debt_Other_Type3" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_Both" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary3_OpName" name="Op_Monthly_Debt_Primary_Beneficiary3" class="3_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment3">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment3" type="number" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance3">Balance Owed</label>
                                    <input id="Op_Debt_Balance3" type="number" class="form-control 3_Op_debt_payment_info_inputs" name="Op_Debt_Balance3" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_Both" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_ClientName" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt3_OpName" name="Post_Decree_Responsible_Party_Op_Debt3" class="3_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 4_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name4">Opponent Creditor Nam4</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name4" type="text" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security4">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security4" name="Op_Monthly_Debt_Purpose_Security4" class="form-control 4_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security4_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type4">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type4" type="text" class="form-control 4_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security4_Input" name="Op_Monthly_Debt_Other_Type4" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_Both" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary4_OpName" name="Op_Monthly_Debt_Primary_Beneficiary4" class="4_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment4">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment4" type="number" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance4">Balance Owed</label>
                                    <input id="Op_Debt_Balance4" type="number" class="form-control 4_Op_debt_payment_info_inputs" name="Op_Debt_Balance4" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_Both" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_ClientName" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt4_OpName" name="Post_Decree_Responsible_Party_Op_Debt4" class="4_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 5_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name5">Opponent Creditor Nam5</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name5" type="text" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security5">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security5" name="Op_Monthly_Debt_Purpose_Security5" class="form-control 5_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security5_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type5">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type5" type="text" class="form-control 5_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security5_Input" name="Op_Monthly_Debt_Other_Type5" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_Both" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary5_OpName" name="Op_Monthly_Debt_Primary_Beneficiary5" class="5_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment5">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment5" type="number" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance5">Balance Owed</label>
                                    <input id="Op_Debt_Balance5" type="number" class="form-control 5_Op_debt_payment_info_inputs" name="Op_Debt_Balance5" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_Both" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_ClientName" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt5_OpName" name="Post_Decree_Responsible_Party_Op_Debt5" class="5_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 6_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Sixth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name6">Opponent Creditor Nam6</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name6" type="text" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security6">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security6" name="Op_Monthly_Debt_Purpose_Security6" class="form-control 6_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security6_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type6">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type6" type="text" class="form-control 6_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security6_Input" name="Op_Monthly_Debt_Other_Type6" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_Both" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary6_OpName" name="Op_Monthly_Debt_Primary_Beneficiary6" class="6_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment6">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment6" type="number" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance6">Balance Owed</label>
                                    <input id="Op_Debt_Balance6" type="number" class="form-control 6_Op_debt_payment_info_inputs" name="Op_Debt_Balance6" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_Both" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_ClientName" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt6_OpName" name="Post_Decree_Responsible_Party_Op_Debt6" class="6_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 7_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Seventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name7">Opponent Creditor Nam7</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name7" type="text" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security7">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security7" name="Op_Monthly_Debt_Purpose_Security7" class="form-control 7_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security7_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type7">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type7" type="text" class="form-control 7_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security7_Input" name="Op_Monthly_Debt_Other_Type7" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_Both" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary7_OpName" name="Op_Monthly_Debt_Primary_Beneficiary7" class="7_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment7">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment7" type="number" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance7">Balance Owed</label>
                                    <input id="Op_Debt_Balance7" type="number" class="form-control 7_Op_debt_payment_info_inputs" name="Op_Debt_Balance7" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_Both" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_ClientName" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt7_OpName" name="Post_Decree_Responsible_Party_Op_Debt7" class="7_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 8_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eighth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name8">Opponent Creditor Nam8</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name8" type="text" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security8">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security8" name="Op_Monthly_Debt_Purpose_Security8" class="form-control 8_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security8_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type8">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type8" type="text" class="form-control 8_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security8_Input" name="Op_Monthly_Debt_Other_Type8" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_Both" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary8_OpName" name="Op_Monthly_Debt_Primary_Beneficiary8" class="8_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment8">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment8" type="number" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance8">Balance Owed</label>
                                    <input id="Op_Debt_Balance8" type="number" class="form-control 8_Op_debt_payment_info_inputs" name="Op_Debt_Balance8" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_Both" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_ClientName" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt8_OpName" name="Post_Decree_Responsible_Party_Op_Debt8" class="8_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 9_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Nineth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name9">Opponent Creditor Nam9</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name9" type="text" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security9">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security9" name="Op_Monthly_Debt_Purpose_Security9" class="form-control 9_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security9_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type9">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type9" type="text" class="form-control 9_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security9_Input" name="Op_Monthly_Debt_Other_Type9" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_Both" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary9_OpName" name="Op_Monthly_Debt_Primary_Beneficiary9" class="9_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment9">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment9" type="number" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance9">Balance Owed</label>
                                    <input id="Op_Debt_Balance9" type="number" class="form-control 9_Op_debt_payment_info_inputs" name="Op_Debt_Balance9" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_Both" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_ClientName" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt9_OpName" name="Post_Decree_Responsible_Party_Op_Debt9" class="9_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 10_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Tenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name10">Opponent Creditor Nam10</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name10" type="text" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security10">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security10" name="Op_Monthly_Debt_Purpose_Security10" class="form-control 10_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security10_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type10">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type10" type="text" class="form-control 10_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security10_Input" name="Op_Monthly_Debt_Other_Type10" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_Both" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary10_OpName" name="Op_Monthly_Debt_Primary_Beneficiary10" class="10_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment10">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment10" type="number" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance10">Balance Owed</label>
                                    <input id="Op_Debt_Balance10" type="number" class="form-control 10_Op_debt_payment_info_inputs" name="Op_Debt_Balance10" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_Both" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_ClientName" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt10_OpName" name="Post_Decree_Responsible_Party_Op_Debt10" class="10_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 11_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Eleventh Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name11">Opponent Creditor Nam11</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name11" type="text" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security11">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security11" name="Op_Monthly_Debt_Purpose_Security11" class="form-control 11_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security11_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type11">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type11" type="text" class="form-control 11_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security11_Input" name="Op_Monthly_Debt_Other_Type11" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_Both" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary11_OpName" name="Op_Monthly_Debt_Primary_Beneficiary11" class="11_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment11">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment11" type="number" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance11">Balance Owed</label>
                                    <input id="Op_Debt_Balance11" type="number" class="form-control 11_Op_debt_payment_info_inputs" name="Op_Debt_Balance11" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_Both" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_ClientName" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt11_OpName" name="Post_Decree_Responsible_Party_Op_Debt11" class="11_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 12_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Twelveth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name12">Opponent Creditor Nam12</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name12" type="text" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security12">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security12" name="Op_Monthly_Debt_Purpose_Security12" class="form-control 12_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security12_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type12">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type12" type="text" class="form-control 12_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security12_Input" name="Op_Monthly_Debt_Other_Type12" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_Both" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary12_OpName" name="Op_Monthly_Debt_Primary_Beneficiary12" class="12_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment12">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment12" type="number" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance12">Balance Owed</label>
                                    <input id="Op_Debt_Balance12" type="number" class="form-control 12_Op_debt_payment_info_inputs" name="Op_Debt_Balance12" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_Both" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_ClientName" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt12_OpName" name="Post_Decree_Responsible_Party_Op_Debt12" class="12_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 13_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Thirteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name13">Opponent Creditor Nam13</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name13" type="text" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security13">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security13" name="Op_Monthly_Debt_Purpose_Security13" class="form-control 13_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security13_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type13">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type13" type="text" class="form-control 13_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security13_Input" name="Op_Monthly_Debt_Other_Type13" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_Both" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary13_OpName" name="Op_Monthly_Debt_Primary_Beneficiary13" class="13_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment13">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment13" type="number" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance13">Balance Owed</label>
                                    <input id="Op_Debt_Balance13" type="number" class="form-control 13_Op_debt_payment_info_inputs" name="Op_Debt_Balance13" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_Both" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_ClientName" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt13_OpName" name="Post_Decree_Responsible_Party_Op_Debt13" class="13_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 14_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fourteenth Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name14">Opponent Creditor Nam14</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name14" type="text" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security14">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security14" name="Op_Monthly_Debt_Purpose_Security14" class="form-control 14_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security14_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type14">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type14" type="text" class="form-control 14_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security14_Input" name="Op_Monthly_Debt_Other_Type14" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_Both" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary14_OpName" name="Op_Monthly_Debt_Primary_Beneficiary14" class="14_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment14">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment14" type="number" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance14">Balance Owed</label>
                                    <input id="Op_Debt_Balance14" type="number" class="form-control 14_Op_debt_payment_info_inputs" name="Op_Debt_Balance14" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_Both" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_ClientName" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt14_OpName" name="Post_Decree_Responsible_Party_Op_Debt14" class="14_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-4 15_Op_debt_payment_info_section" style="display: none;"><h5 class="col-sm-12">Fifteen Loan Info</h5>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Creditor_Name15">Opponent Creditor Nam15</label>
                                    <input id="Op_Monthly_Debt_Creditor_Name15" type="text" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Creditor_Name15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Purpose_Security15">Purpose or Security</label>
                                    <select id="Op_Monthly_Debt_Purpose_Security15" name="Op_Monthly_Debt_Purpose_Security15" class="form-control 15_Op_debt_payment_info_inputs_select" onchange="onSelectChange(this);">
                                        <option value="" selected="">Select</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Car Loan">Car Loan</option>
                                        <option value="Motorcycle Loan">Motorcycle Loan</option>
                                        <option value="RV Loan">RV Loan</option>
                                        <option value="Personal Loan">Personal Loan</option>
                                        <option value="Line of Credit">Line of Credit</option>
                                        <option value="Education Loan">Education Loan</option>
                                        <option value="Medical Bills">Medical Bills</option>
                                        <option value="Other">Other</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Monthly_Debt_Purpose_Security15_Text" style="display: none;">
                                    <label for="Op_Monthly_Debt_Other_Type15">Enter Purpose or Security?</label>
                                    <input id="Op_Monthly_Debt_Other_Type15" type="text" class="form-control 15_Op_debt_payment_info_inputs Op_Monthly_Debt_Purpose_Security15_Input" name="Op_Monthly_Debt_Other_Type15" value=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Who Primarily Benefited From This Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_Both" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_ClientName" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Op_Monthly_Debt_Primary_Beneficiary15_OpName" name="Op_Monthly_Debt_Primary_Beneficiary15" class="15_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Debt_Payment15">Monthly Payment</label>
                                    <input id="Op_Monthly_Debt_Payment15" type="number" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Monthly_Debt_Payment15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Debt_Balance15">Balance Owed</label>
                                    <input id="Op_Debt_Balance15" type="number" class="form-control 15_Op_debt_payment_info_inputs" name="Op_Debt_Balance15" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Party to be Responsible for this Opponent Debt?</label>
                                    <div class="w-100 dataInput">
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_Both" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="Both" checked=""> Both</label>
                                        <label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_ClientName" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="{{$client_name}}"> {{$client_name}}</label><label><input type="radio" id="Post_Decree_Responsible_Party_Op_Debt15_OpName" name="Post_Decree_Responsible_Party_Op_Debt15" class="15_Op_debt_payment_info_inputs_radio" value="{{$opponent_name}}"> {{$opponent_name}}</label>
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
        $('#Num_Joint_Monthly_Debts_Creditors, #Num_Client_Monthly_Debts_Creditors, #Num_Op_Monthly_Debts_Creditors').val('0');
        $('.Joint_debt_payment_info_section input, .Client_debt_payment_info_section input, .Op_debt_payment_info_section input').prop('required',false);
        $('.Joint_debt_payment_info_section select option[value=""], .Client_debt_payment_info_section select option[value=""], .Op_debt_payment_info_section select option[value=""]').prop('selected','selected');
        // on number of joint monthly debts creditors input change
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
                $('.'+i+'_Joint_debt_payment_info_section select option[value=""]').prop('selected','selected');
                $('.Joint_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
                $('.Joint_Monthly_Debt_Purpose_Security'+i+'_Input').val('');
            }
        });
        // on number of client monthly debts creditors input change
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
                $('.'+i+'_Client_debt_payment_info_section select option[value=""]').prop('selected','selected');
                $('.Client_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
                $('.Client_Monthly_Debt_Purpose_Security'+i+'_Input').val('');
            }
        });
        // on number of opponent monthly debts creditors input change
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
                $('.'+i+'_Op_debt_payment_info_section select option[value=""]').prop('selected','selected');
                $('.Op_Monthly_Debt_Purpose_Security'+i+'_Text').hide();
                $('.Op_Monthly_Debt_Purpose_Security'+i+'_Input').val('');
            }
        });
    });
</script>   
@endsection