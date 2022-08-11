@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_monthlyhousingexpenses_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Monthly Housing Expenses Info') }}</strong>
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
                    <form role="form" id="dr_monthlyhousingexpenses" method="POST" action="{{route('drmonthlyhousingexpenses.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Monthly Housing Expenses Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Name_of_Person_Helping_with_Monthly_Expenses" class="col-form-label text-md-left">Name(s) of any Person(s) Helping with Monthly Expenses</label>
                                <input id="Client_Name_of_Person_Helping_with_Monthly_Expenses" type="text" class="form-control" name="Client_Name_of_Person_Helping_with_Monthly_Expenses" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Amount_of_Help_with_Monthly_Expenses" class="col-form-label text-md-left">Amount of Help Received for Monthly Expenses</label>
                                <input id="Client_Amount_of_Help_with_Monthly_Expenses" type="number" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="col-form-label text-md-left">Housing is Rented or Owned? </label><br>
                                <label for="Client_Rent_Own_Rented" class="col-md-2 radio-label">Rented
                                    <input id="Client_Rent_Own_Rented" class="Client_Rent_Own_radio" type="radio" name="Client_Rent_Own" value="Rented" checked="">
                                </label>
                                <label for="Client_Rent_Own_Owned" class="col-md-2 radio-label">Owned
                                    <input id="Client_Rent_Own_Owned" class="Client_Rent_Own_radio" type="radio" name="Client_Rent_Own" value="Owned"> 
                                </label>
                            </div>
                            <div class="form-group col-sm-6 Client_Rent_Own_Fields_Div">
                                <label for="Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" class="col-form-label text-md-left">Monthly Rent or Mortgage Amount</label>
                                <input id="Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" type="number" class="form-control" name="Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Client_Rent_Own_Fields_Div">
                                <label for="Client_Monthly_Homeowners_Insurance_IF_NOT_Included" class="col-form-label text-md-left">Monthly Homeowners Insurance Amount (If not included in last response)</label>
                                <input id="Client_Monthly_Homeowners_Insurance_IF_NOT_Included" type="number" class="form-control Client_Rent_Own_Fields_input" name="Client_Monthly_Homeowners_Insurance_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Client_Rent_Own_Fields_Div">
                                <label for="Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment" class="col-form-label text-md-left">Monthly Second Mortgage and/or Equity Loan Payment</label>
                                <input id="Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment" type="number" class="form-control Client_Rent_Own_Fields_input" name="Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Client_Rent_Own_Fields_Div">
                                <label for="Client_Monthly_Renters_Insurance_IF_NOT_Included" class="col-form-label text-md-left">Monthly Renter’s Insurance Amount (If not included in last response)</label>
                                <input id="Client_Monthly_Renters_Insurance_IF_NOT_Included" type="number" class="form-control Client_Rent_Own_Fields_input" name="Client_Monthly_Renters_Insurance_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Gas" class="col-form-label text-md-left">Monthly Gas Fuel Amount for Housing</label>
                                <input id="Client_Monthly_Gas" type="number" class="form-control" name="Client_Monthly_Gas" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Fuel_Oil" class="col-form-label text-md-left">Monthly Fuel Oil Amount for Housing</label>
                                <input id="Client_Monthly_Fuel_Oil" type="number" class="form-control" name="Client_Monthly_Fuel_Oil" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Propane" class="col-form-label text-md-left">Monthly Propane Amount for Housing</label>
                                <input id="Client_Monthly_Propane" type="number" class="form-control" name="Client_Monthly_Propane" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Electric" class="col-form-label text-md-left">Monthly Electric Amount for Housing</label>
                                <input id="Client_Monthly_Electric" type="number" class="form-control" name="Client_Monthly_Electric" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Water_and_Sewer" class="col-form-label text-md-left">Monthly Water and Sewer Amount for Housing</label>
                                <input id="Client_Monthly_Water_and_Sewer" type="number" class="form-control" name="Client_Monthly_Water_and_Sewer" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Sewer_IF_NOT_Included" class="col-form-label text-md-left">Monthly Sewer Amount for Housing (If not included in last response)</label>
                                <input id="Client_Monthly_Sewer_IF_NOT_Included" type="number" class="form-control" name="Client_Monthly_Sewer_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Landline_Telephone" class="col-form-label text-md-left">Monthly Lineline Telephone Amount for Housing</label>
                                <input id="Client_Monthly_Landline_Telephone" type="number" class="form-control" name="Client_Monthly_Landline_Telephone" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Cell_Phone_IF_NOT_Included" class="col-form-label text-md-left">Monthly Cell Phone Amount (If not included elsewhere)</label>
                                <input id="Client_Monthly_Cell_Phone_IF_NOT_Included" type="number" class="form-control" name="Client_Monthly_Cell_Phone_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Trash" class="col-form-label text-md-left">Monthly Trash Amount</label>
                                <input id="Client_Monthly_Trash" type="number" class="form-control" name="Client_Monthly_Trash" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Cable_Or_Satellite_TV" class="col-form-label text-md-left">Monthly Cable Or Satellite TV</label>
                                <input id="Client_Monthly_Cable_Or_Satellite_TV" type="number" class="form-control" name="Client_Monthly_Cable_Or_Satellite_TV" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_House_Cleaning" class="col-form-label text-md-left">Monthly House Cleaning</label>
                                <input id="Client_Monthly_House_Cleaning" type="number" class="form-control" name="Client_Monthly_House_Cleaning" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Maintenance" class="col-form-label text-md-left">Monthly Housing Maintenance</label>
                                <input id="Client_Monthly_Housing_Maintenance" type="number" class="form-control" name="Client_Monthly_Housing_Maintenance" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Repair" class="col-form-label text-md-left">Monthly Housing Repair</label>
                                <input id="Client_Monthly_Housing_Repair" type="number" class="form-control" name="Client_Monthly_Housing_Repair" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Lawn_Service" class="col-form-label text-md-left">Monthly Lawn Service</label>
                                <input id="Client_Monthly_Lawn_Service" type="number" class="form-control" name="Client_Monthly_Lawn_Service" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Snow_Removal" class="col-form-label text-md-left">Monthly Snow Removal</label>
                                <input id="Client_Monthly_Snow_Removal" type="number" class="form-control" name="Client_Monthly_Snow_Removal" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other1_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Client_Monthly_Housing_Other1_Name" type="text" class="form-control" name="Client_Monthly_Housing_Other1_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other1_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Client_Monthly_Housing_Other1_Amt" type="number" class="form-control" name="Client_Monthly_Housing_Other1_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other2_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Client_Monthly_Housing_Other2_Name" type="text" class="form-control" name="Client_Monthly_Housing_Other2_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other2_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Client_Monthly_Housing_Other2_Amt" type="number" class="form-control" name="Client_Monthly_Housing_Other2_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other3_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Client_Monthly_Housing_Other3_Name" type="text" class="form-control" name="Client_Monthly_Housing_Other3_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other3_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Client_Monthly_Housing_Other3_Amt" type="number" class="form-control" name="Client_Monthly_Housing_Other3_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other4_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Client_Monthly_Housing_Other4_Name" type="text" class="form-control" name="Client_Monthly_Housing_Other4_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Housing_Other4_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Client_Monthly_Housing_Other4_Amt" type="number" class="form-control" name="Client_Monthly_Housing_Other4_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                        </div>
                        <!-- End of Client Monthly Housing Expenses Info Section -->

                        <!-- Opponent Monthly Housing Expenses Info Section -->
                        <div class="form-row mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Name_of_Person_Helping_with_Monthly_Expenses" class="col-form-label text-md-left">Name(s) of any Person(s) Helping with Monthly Expenses</label>
                                <input id="Op_Name_of_Person_Helping_with_Monthly_Expenses" type="text" class="form-control" name="Op_Name_of_Person_Helping_with_Monthly_Expenses" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Amount_of_Help_with_Monthly_Expenses" class="col-form-label text-md-left">Amount of Help Received for Monthly Expenses</label>
                                <input id="Op_Amount_of_Help_with_Monthly_Expenses" type="number" class="form-control" name="Op_Amount_of_Help_with_Monthly_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="col-form-label text-md-left">Housing is Rented or Owned? </label><br>
                                <label for="Op_Rent_Own_Rented" class="col-md-2 radio-label">Rented
                                    <input id="Op_Rent_Own_Rented" class="Op_Rent_Own_radio" type="radio" name="Op_Rent_Own" value="Rented" checked="">
                                </label>
                                <label for="Op_Rent_Own_Owned" class="col-md-2 radio-label">Owned
                                    <input id="Op_Rent_Own_Owned" class="Op_Rent_Own_radio" type="radio" name="Op_Rent_Own" value="Owned"> 
                                </label>
                            </div>
                            <div class="form-group col-sm-6 Op_Rent_Own_Fields_Div">
                                <label for="Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" class="col-form-label text-md-left">Monthly Rent or Mortgage Amount</label>
                                <input id="Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" type="number" class="form-control Op_Rent_Own_Fields_input" name="Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Op_Rent_Own_Fields_Div">
                                <label for="Op_Monthly_Homeowners_Insurance_IF_NOT_Included" class="col-form-label text-md-left">Monthly Homeowners Insurance Amount (If not included in last response)</label>
                                <input id="Op_Monthly_Homeowners_Insurance_IF_NOT_Included" type="number" class="form-control Op_Rent_Own_Fields_input" name="Op_Monthly_Homeowners_Insurance_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Op_Rent_Own_Fields_Div">
                                <label for="Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment" class="col-form-label text-md-left">Monthly Second Mortgage and/or Equity Loan Payment</label>
                                <input id="Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment" type="number" class="form-control Op_Rent_Own_Fields_input" name="Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6 Op_Rent_Own_Fields_Div">
                                <label for="Op_Monthly_Renters_Insurance_IF_NOT_Included" class="col-form-label text-md-left">Monthly Renter’s Insurance Amount (If not included in last response)</label>
                                <input id="Op_Monthly_Renters_Insurance_IF_NOT_Included" type="number" class="form-control Op_Rent_Own_Fields_input" name="Op_Monthly_Renters_Insurance_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Gas" class="col-form-label text-md-left">Monthly Gas Fuel Amount for Housing</label>
                                <input id="Op_Monthly_Gas" type="number" class="form-control" name="Op_Monthly_Gas" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Fuel_Oil" class="col-form-label text-md-left">Monthly Fuel Oil Amount for Housing</label>
                                <input id="Op_Monthly_Fuel_Oil" type="number" class="form-control" name="Op_Monthly_Fuel_Oil" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Propane" class="col-form-label text-md-left">Monthly Propane Amount for Housing</label>
                                <input id="Op_Monthly_Propane" type="number" class="form-control" name="Op_Monthly_Propane" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Electric" class="col-form-label text-md-left">Monthly Electric Amount for Housing</label>
                                <input id="Op_Monthly_Electric" type="number" class="form-control" name="Op_Monthly_Electric" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Water_and_Sewer" class="col-form-label text-md-left">Monthly Water and Sewer Amount for Housing</label>
                                <input id="Op_Monthly_Water_and_Sewer" type="number" class="form-control" name="Op_Monthly_Water_and_Sewer" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Sewer_IF_NOT_Included" class="col-form-label text-md-left">Monthly Sewer Amount for Housing (If not included in last response)</label>
                                <input id="Op_Monthly_Sewer_IF_NOT_Included" type="number" class="form-control" name="Op_Monthly_Sewer_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Landline_Telephone" class="col-form-label text-md-left">Monthly Lineline Telephone Amount for Housing</label>
                                <input id="Op_Monthly_Landline_Telephone" type="number" class="form-control" name="Op_Monthly_Landline_Telephone" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Cell_Phone_IF_NOT_Included" class="col-form-label text-md-left">Monthly Cell Phone Amount (If not included elsewhere)</label>
                                <input id="Op_Monthly_Cell_Phone_IF_NOT_Included" type="number" class="form-control" name="Op_Monthly_Cell_Phone_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Trash" class="col-form-label text-md-left">Monthly Trash Amount</label>
                                <input id="Op_Monthly_Trash" type="number" class="form-control" name="Op_Monthly_Trash" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Cable_Or_Satellite_TV" class="col-form-label text-md-left">Monthly Cable Or Satellite TV</label>
                                <input id="Op_Monthly_Cable_Or_Satellite_TV" type="number" class="form-control" name="Op_Monthly_Cable_Or_Satellite_TV" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_House_Cleaning" class="col-form-label text-md-left">Monthly House Cleaning</label>
                                <input id="Op_Monthly_House_Cleaning" type="number" class="form-control" name="Op_Monthly_House_Cleaning" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Maintenance" class="col-form-label text-md-left">Monthly Housing Maintenance</label>
                                <input id="Op_Monthly_Housing_Maintenance" type="number" class="form-control" name="Op_Monthly_Housing_Maintenance" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Repair" class="col-form-label text-md-left">Monthly Housing Repair</label>
                                <input id="Op_Monthly_Housing_Repair" type="number" class="form-control" name="Op_Monthly_Housing_Repair" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Lawn_Service" class="col-form-label text-md-left">Monthly Lawn Service</label>
                                <input id="Op_Monthly_Lawn_Service" type="number" class="form-control" name="Op_Monthly_Lawn_Service" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Snow_Removal" class="col-form-label text-md-left">Monthly Snow Removal</label>
                                <input id="Op_Monthly_Snow_Removal" type="number" class="form-control" name="Op_Monthly_Snow_Removal" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other1_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Op_Monthly_Housing_Other1_Name" type="text" class="form-control" name="Op_Monthly_Housing_Other1_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other1_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Op_Monthly_Housing_Other1_Amt" type="number" class="form-control" name="Op_Monthly_Housing_Other1_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other2_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Op_Monthly_Housing_Other2_Name" type="text" class="form-control" name="Op_Monthly_Housing_Other2_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other2_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Op_Monthly_Housing_Other2_Amt" type="number" class="form-control" name="Op_Monthly_Housing_Other2_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other3_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Op_Monthly_Housing_Other3_Name" type="text" class="form-control" name="Op_Monthly_Housing_Other3_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other3_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Op_Monthly_Housing_Other3_Amt" type="number" class="form-control" name="Op_Monthly_Housing_Other3_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other4_Name" class="col-form-label text-md-left">Monthly Housing Other Name</label>
                                <input id="Op_Monthly_Housing_Other4_Name" type="text" class="form-control" name="Op_Monthly_Housing_Other4_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Housing_Other4_Amt" class="col-form-label text-md-left">Monthly Housing Other Amount</label>
                                <input id="Op_Monthly_Housing_Other4_Amt" type="number" class="form-control" name="Op_Monthly_Housing_Other4_Amt" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-12 text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Housing Expenses Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dr_monthlyhousingexpenses').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $('.Client_Rent_Own_radio').on('change', function(){
            if(this.value=='Rented'){
                $('.Client_Rent_Own_Fields_Div').show();
            } else {
                $('.Client_Rent_Own_Fields_Div').hide();
            }
        });

        $('.Op_Rent_Own_radio').on('change', function(){
            if(this.value=='Rented'){
                $('.Op_Rent_Own_Fields_Div').show();
            } else {
                $('.Op_Rent_Own_Fields_Div').hide();
            }
        });
    });
</script>   
@endsection