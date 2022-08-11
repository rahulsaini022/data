@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_monthlylivingexpenses_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Monthly Living Expenses Info') }}</strong>
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
                    <form role="form" id="dr_monthlylivingexpenses" method="POST" action="{{route('drmonthlylivingexpenses.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Monthly Living Expenses Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" class="col-form-label text-md-left">Monthly Cost of Groceries, including Laundry/Cleaning Products & Toiletries?</label>
                                <input id="Client_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" type="number" class="form-control" name="Client_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Restaurant" class="col-form-label text-md-left">Monthly Restaurant Expenses?</label>
                                <input id="Client_Monthly_Restaurant" type="number" class="form-control" name="Client_Monthly_Restaurant" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6" style="display: none;">
                                <label for="Client_Monthly_Vehicle_Loan_Payment" class="col-form-label text-md-left">N/A CALCULATED FROM VEHICLES</label>
                                <input id="Client_Monthly_Vehicle_Loan_Payment" type="number" class="form-control" name="Client_Monthly_Vehicle_Loan_Payment" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6" style="display: none;">
                                <label for="Client_Monthly_Vehicle_Lease_Payment" class="col-form-label text-md-left">N/A CALCULATED FROM VEHICLES</label>
                                <input id="Client_Monthly_Vehicle_Lease_Payment" type="number" class="form-control" name="Client_Monthly_Vehicle_Lease_Payment" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Fuel_and_Oil_for_Transportation" class="col-form-label text-md-left">Monthly Cost for Fuel and Oil for Transportation?</label>
                                <input id="Client_Monthly_Fuel_and_Oil_for_Transportation" type="number" class="form-control" name="Client_Monthly_Fuel_and_Oil_for_Transportation" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Car_Repairs" class="col-form-label text-md-left">Monthly Cost of Car Repairs?</label>
                                <input id="Client_Monthly_Car_Repairs" type="number" class="form-control" name="Client_Monthly_Car_Repairs" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Parking" class="col-form-label text-md-left">Monthly Cost of Parking?</label>
                                <input id="Client_Monthly_Parking" type="number" class="form-control" name="Client_Monthly_Parking" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Public_Transportation" class="col-form-label text-md-left">Monthly Cost of Public Transporation?</label>
                                <input id="Client_Monthly_Public_Transportation" type="number" class="form-control" name="Client_Monthly_Public_Transportation" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Clothing" class="col-form-label text-md-left">Monthly Cost of Clothing?</label>
                                <input id="Client_Monthly_Clothing" type="number" class="form-control" name="Client_Monthly_Clothing" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Dry_Cleaning_Laundry" class="col-form-label text-md-left">Monthly Cost of Dry Cleaning and Laundry?</label>
                                <input id="Client_Monthly_Dry_Cleaning_Laundry" type="number" class="form-control" name="Client_Monthly_Dry_Cleaning_Laundry" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Hair_and_Nail_Care" class="col-form-label text-md-left">Monthly Cost of Hair and Nail Care?</label>
                                <input id="Client_Monthly_Hair_and_Nail_Care" type="number" class="form-control" name="Client_Monthly_Hair_and_Nail_Care" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Personal_Grooming_Other_Type1" class="col-form-label text-md-left">Other Type of Personal Grooming?</label>
                                <input id="Client_Monthly_Personal_Grooming_Other_Type1" type="text" class="form-control" name="Client_Monthly_Personal_Grooming_Other_Type1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Personal_Grooming_Other_Amt1" class="col-form-label text-md-left">Monthly Cost of Other Type1 of Personal Grooming?</label>
                                <input id="Client_Monthly_Personal_Grooming_Other_Amt1" type="number" class="form-control" name="Client_Monthly_Personal_Grooming_Other_Amt1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Personal_Grooming_Other_Type2" class="col-form-label text-md-left">Other Type2 of Personal Grooming?</label>
                                <input id="Client_Monthly_Personal_Grooming_Other_Type2" type="text" class="form-control" name="Client_Monthly_Personal_Grooming_Other_Type2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Personal_Grooming_Other_Amt2" class="col-form-label text-md-left">Monthly Cost of Other Type2 of Personal Grooming?</label>
                                <input id="Client_Monthly_Personal_Grooming_Other_Amt2" type="number" class="form-control" name="Client_Monthly_Personal_Grooming_Other_Amt2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Internet_IF_NOT_Included" class="col-form-label text-md-left">Monthly Cost of Internet?</label>
                                <input id="Client_Monthly_Internet_IF_NOT_Included" type="number" class="form-control" name="Client_Monthly_Internet_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other1_Name" class="col-form-label text-md-left">Other Type1 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other1_Name" type="text" class="form-control" name="Client_Monthly_Other_Other1_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other1_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type1 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other1_Amt" type="number" class="form-control" name="Client_Monthly_Other_Other1_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other2_Name" class="col-form-label text-md-left">Other Type2 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other2_Name" type="text" class="form-control" name="Client_Monthly_Other_Other2_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other2_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type2 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other2_Amt" type="number" class="form-control" name="Client_Monthly_Other_Other2_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other3_Name" class="col-form-label text-md-left">Other Type3 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other3_Name" type="text" class="form-control" name="Client_Monthly_Other_Other3_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other3_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type3 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other3_Amt" type="number" class="form-control" name="Client_Monthly_Other_Other3_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other4_Name" class="col-form-label text-md-left">Other Type4 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other4_Name" type="text" class="form-control" name="Client_Monthly_Other_Other4_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Other4_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type4 of Living Expenses?</label>
                                <input id="Client_Monthly_Other_Other4_Amt" type="number" class="form-control" name="Client_Monthly_Other_Other4_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Extra_Obs_MinorHandicapped_Children" class="col-form-label text-md-left">Monthly Cost of Extraordinary Obligations to Minor/Dependent Children?</label>
                                <input id="Client_Monthly_Extra_Obs_MinorHandicapped_Children" type="number" class="form-control" name="Client_Monthly_Extra_Obs_MinorHandicapped_Children" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Pays_Spousal_Support_NOM" class="col-form-label text-md-left">Monthly Cost of Spousal Support Payments (NOT this marriage)?</label>
                                <input id="Client_Monthly_Pays_Spousal_Support_NOM" type="number" class="form-control" name="Client_Monthly_Pays_Spousal_Support_NOM" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Subscriptions_and_Books" class="col-form-label text-md-left">Monthly Cost of Subscriptions & Books?</label>
                                <input id="Client_Monthly_Subscriptions_and_Books" type="number" class="form-control" name="Client_Monthly_Subscriptions_and_Books" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Entertainment" class="col-form-label text-md-left">Monthly Cost of Entertainment?</label>
                                <input id="Client_Monthly_Entertainment" type="number" class="form-control" name="Client_Monthly_Entertainment" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Charitable_Contributions_Tithing" class="col-form-label text-md-left">Monthly Cost of Charity and Tithing?</label>
                                <input id="Client_Monthly_Charitable_Contributions_Tithing" type="number" class="form-control" name="Client_Monthly_Charitable_Contributions_Tithing" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Memberships_Associations_Clubs" class="col-form-label text-md-left">Monthly Cost of Membership in Associations/Club?</label>
                                <input id="Client_Monthly_Memberships_Associations_Clubs" type="number" class="form-control" name="Client_Monthly_Memberships_Associations_Clubs" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Travel_Vacations" class="col-form-label text-md-left">Monthly Cost of Vacation/Travel?</label>
                                <input id="Client_Monthly_Travel_Vacations" type="number" class="form-control" name="Client_Monthly_Travel_Vacations" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Pet_Expenses" class="col-form-label text-md-left">Monthly Amount of Pet Expenses?</label>
                                <input id="Client_Monthly_Pet_Expenses" type="number" class="form-control" name="Client_Monthly_Pet_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Gifts_Expenses" class="col-form-label text-md-left">Monthly Cost of Gifts?</label>
                                <input id="Client_Monthly_Gifts_Expenses" type="number" class="form-control" name="Client_Monthly_Gifts_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Bankruptcy_Payments" class="col-form-label text-md-left">Monthly Amount of Bankruptcy Payments?</label>
                                <input id="Client_Monthly_Bankruptcy_Payments" type="number" class="form-control" name="Client_Monthly_Bankruptcy_Payments" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Attorney_Fees" class="col-form-label text-md-left">Monthly Cost of Attorney Fees?</label>
                                <input id="Client_Monthly_Attorney_Fees" type="number" class="form-control" name="Client_Monthly_Attorney_Fees" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" class="col-form-label text-md-left">Type of Additional Taxes Not Deducted from Pay?</label>
                                <input id="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" type="text" class="form-control" name="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" class="col-form-label text-md-left">Monthly Cost of Additional Taxes Not Deducted from Pay?</label>
                                <input id="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" type="number" class="form-control" name="Client_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Misc_Name1" class="col-form-label text-md-left">Other Misc Type of Living Expense</label>
                                <input id="Client_Monthly_Other_Misc_Name1" type="text" class="form-control" name="Client_Monthly_Other_Misc_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Misc_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Misc Type of Living Expense</label>
                                <input id="Client_Monthly_Other_Misc_Amount1" type="number" class="form-control" name="Client_Monthly_Other_Misc_Amount1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Misc_Name2" class="col-form-label text-md-left">Other Misc Type of Living Expense</label>
                                <input id="Client_Monthly_Other_Misc_Name2" type="text" class="form-control" name="Client_Monthly_Other_Misc_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Misc_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Misc Type of Living Expense</label>
                                <input id="Client_Monthly_Other_Misc_Amount2" type="number" class="form-control" name="Client_Monthly_Other_Misc_Amount2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div> 
                        </div>
                        <!-- End of Client Monthly Living Expenses Info Section -->

                        <!-- Opponent Monthly Living Expenses Info Section -->
                        <div class="form-row mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" class="col-form-label text-md-left">Monthly Cost of Groceries, including Laundry/Cleaning Products & Toiletries?</label>
                                <input id="Op_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" type="number" class="form-control" name="Op_Monthly_Grocery_incLaundry_CleaningProds_Toiletries" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Restaurant" class="col-form-label text-md-left">Monthly Restaurant Expenses?</label>
                                <input id="Op_Monthly_Restaurant" type="number" class="form-control" name="Op_Monthly_Restaurant" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6" style="display: none;">
                                <label for="Op_Monthly_Vehicle_Loan_Payment" class="col-form-label text-md-left">N/A CALCULATED FROM VEHICLES</label>
                                <input id="Op_Monthly_Vehicle_Loan_Payment" type="number" class="form-control" name="Op_Monthly_Vehicle_Loan_Payment" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6" style="display: none;">
                                <label for="Op_Monthly_Vehicle_Lease_Payment" class="col-form-label text-md-left">N/A CALCULATED FROM VEHICLES</label>
                                <input id="Op_Monthly_Vehicle_Lease_Payment" type="number" class="form-control" name="Op_Monthly_Vehicle_Lease_Payment" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Fuel_and_Oil_for_Transportation" class="col-form-label text-md-left">Monthly Cost for Fuel and Oil for Transportation?</label>
                                <input id="Op_Monthly_Fuel_and_Oil_for_Transportation" type="number" class="form-control" name="Op_Monthly_Fuel_and_Oil_for_Transportation" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Car_Repairs" class="col-form-label text-md-left">Monthly Cost of Car Repairs?</label>
                                <input id="Op_Monthly_Car_Repairs" type="number" class="form-control" name="Op_Monthly_Car_Repairs" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Parking" class="col-form-label text-md-left">Monthly Cost of Parking?</label>
                                <input id="Op_Monthly_Parking" type="number" class="form-control" name="Op_Monthly_Parking" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Public_Transportation" class="col-form-label text-md-left">Monthly Cost of Public Transporation?</label>
                                <input id="Op_Monthly_Public_Transportation" type="number" class="form-control" name="Op_Monthly_Public_Transportation" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Clothing" class="col-form-label text-md-left">Monthly Cost of Clothing?</label>
                                <input id="Op_Monthly_Clothing" type="number" class="form-control" name="Op_Monthly_Clothing" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Dry_Cleaning_Laundry" class="col-form-label text-md-left">Monthly Cost of Dry Cleaning and Laundry?</label>
                                <input id="Op_Monthly_Dry_Cleaning_Laundry" type="number" class="form-control" name="Op_Monthly_Dry_Cleaning_Laundry" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Hair_and_Nail_Care" class="col-form-label text-md-left">Monthly Cost of Hair and Nail Care?</label>
                                <input id="Op_Monthly_Hair_and_Nail_Care" type="number" class="form-control" name="Op_Monthly_Hair_and_Nail_Care" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Personal_Grooming_Other_Type1" class="col-form-label text-md-left">Other Type of Personal Grooming?</label>
                                <input id="Op_Monthly_Personal_Grooming_Other_Type1" type="text" class="form-control" name="Op_Monthly_Personal_Grooming_Other_Type1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Personal_Grooming_Other_Amt1" class="col-form-label text-md-left">Monthly Cost of Other Type1 of Personal Grooming?</label>
                                <input id="Op_Monthly_Personal_Grooming_Other_Amt1" type="number" class="form-control" name="Op_Monthly_Personal_Grooming_Other_Amt1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Personal_Grooming_Other_Type2" class="col-form-label text-md-left">Other Type2 of Personal Grooming?</label>
                                <input id="Op_Monthly_Personal_Grooming_Other_Type2" type="text" class="form-control" name="Op_Monthly_Personal_Grooming_Other_Type2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Personal_Grooming_Other_Amt2" class="col-form-label text-md-left">Monthly Cost of Other Type2 of Personal Grooming?</label>
                                <input id="Op_Monthly_Personal_Grooming_Other_Amt2" type="number" class="form-control" name="Op_Monthly_Personal_Grooming_Other_Amt2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Internet_IF_NOT_Included" class="col-form-label text-md-left">Monthly Cost of Internet?</label>
                                <input id="Op_Monthly_Internet_IF_NOT_Included" type="number" class="form-control" name="Op_Monthly_Internet_IF_NOT_Included" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other1_Name" class="col-form-label text-md-left">Other Type1 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other1_Name" type="text" class="form-control" name="Op_Monthly_Other_Other1_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other1_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type1 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other1_Amt" type="number" class="form-control" name="Op_Monthly_Other_Other1_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other2_Name" class="col-form-label text-md-left">Other Type2 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other2_Name" type="text" class="form-control" name="Op_Monthly_Other_Other2_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other2_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type2 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other2_Amt" type="number" class="form-control" name="Op_Monthly_Other_Other2_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other3_Name" class="col-form-label text-md-left">Other Type3 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other3_Name" type="text" class="form-control" name="Op_Monthly_Other_Other3_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other3_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type3 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other3_Amt" type="number" class="form-control" name="Op_Monthly_Other_Other3_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other4_Name" class="col-form-label text-md-left">Other Type4 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other4_Name" type="text" class="form-control" name="Op_Monthly_Other_Other4_Name" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Other4_Amt" class="col-form-label text-md-left">Monthly Cost of Other Type4 of Living Expenses?</label>
                                <input id="Op_Monthly_Other_Other4_Amt" type="number" class="form-control" name="Op_Monthly_Other_Other4_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Extra_Obs_MinorHandicapped_Children" class="col-form-label text-md-left">Monthly Cost of Extraordinary Obligations to Minor/Dependent Children?</label>
                                <input id="Op_Monthly_Extra_Obs_MinorHandicapped_Children" type="number" class="form-control" name="Op_Monthly_Extra_Obs_MinorHandicapped_Children" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Pays_Spousal_Support_NOM" class="col-form-label text-md-left">Monthly Cost of Spousal Support Payments (NOT this marriage)?</label>
                                <input id="Op_Monthly_Pays_Spousal_Support_NOM" type="number" class="form-control" name="Op_Monthly_Pays_Spousal_Support_NOM" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Subscriptions_and_Books" class="col-form-label text-md-left">Monthly Cost of Subscriptions & Books?</label>
                                <input id="Op_Monthly_Subscriptions_and_Books" type="number" class="form-control" name="Op_Monthly_Subscriptions_and_Books" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Entertainment" class="col-form-label text-md-left">Monthly Cost of Entertainment?</label>
                                <input id="Op_Monthly_Entertainment" type="number" class="form-control" name="Op_Monthly_Entertainment" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Charitable_Contributions_Tithing" class="col-form-label text-md-left">Monthly Cost of Charity and Tithing?</label>
                                <input id="Op_Monthly_Charitable_Contributions_Tithing" type="number" class="form-control" name="Op_Monthly_Charitable_Contributions_Tithing" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Memberships_Associations_Clubs" class="col-form-label text-md-left">Monthly Cost of Membership in Associations/Club?</label>
                                <input id="Op_Monthly_Memberships_Associations_Clubs" type="number" class="form-control" name="Op_Monthly_Memberships_Associations_Clubs" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Travel_Vacations" class="col-form-label text-md-left">Monthly Cost of Vacation/Travel?</label>
                                <input id="Op_Monthly_Travel_Vacations" type="number" class="form-control" name="Op_Monthly_Travel_Vacations" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Pet_Expenses" class="col-form-label text-md-left">Monthly Amount of Pet Expenses?</label>
                                <input id="Op_Monthly_Pet_Expenses" type="number" class="form-control" name="Op_Monthly_Pet_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Gifts_Expenses" class="col-form-label text-md-left">Monthly Cost of Gifts?</label>
                                <input id="Op_Monthly_Gifts_Expenses" type="number" class="form-control" name="Op_Monthly_Gifts_Expenses" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Bankruptcy_Payments" class="col-form-label text-md-left">Monthly Amount of Bankruptcy Payments?</label>
                                <input id="Op_Monthly_Bankruptcy_Payments" type="number" class="form-control" name="Op_Monthly_Bankruptcy_Payments" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Attorney_Fees" class="col-form-label text-md-left">Monthly Cost of Attorney Fees?</label>
                                <input id="Op_Monthly_Attorney_Fees" type="number" class="form-control" name="Op_Monthly_Attorney_Fees" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" class="col-form-label text-md-left">Type of Additional Taxes Not Deducted from Pay?</label>
                                <input id="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" type="text" class="form-control" name="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Type" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" class="col-form-label text-md-left">Monthly Cost of Additional Taxes Not Deducted from Pay?</label>
                                <input id="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" type="number" class="form-control" name="Op_Monthly_Additional_Taxes_NOT_DEDUCTED_Amt" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Misc_Name1" class="col-form-label text-md-left">Other Misc Type of Living Expense</label>
                                <input id="Op_Monthly_Other_Misc_Name1" type="text" class="form-control" name="Op_Monthly_Other_Misc_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Misc_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Misc Type of Living Expense</label>
                                <input id="Op_Monthly_Other_Misc_Amount1" type="number" class="form-control" name="Op_Monthly_Other_Misc_Amount1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Misc_Name2" class="col-form-label text-md-left">Other Misc Type of Living Expense</label>
                                <input id="Op_Monthly_Other_Misc_Name2" type="text" class="form-control" name="Op_Monthly_Other_Misc_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Misc_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Misc Type of Living Expense</label>
                                <input id="Op_Monthly_Other_Misc_Amount2" type="number" class="form-control" name="Op_Monthly_Other_Misc_Amount2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-12 text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Living Expenses Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dr_monthlylivingexpenses').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection