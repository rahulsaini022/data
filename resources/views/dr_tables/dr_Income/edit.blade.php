@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Income_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Income Info') }}</strong>
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
                    <?php 
                        $Client_Yearly_Interest_Dividends=$data['stockinvestmentinfo']->StocksInvestments_Total_Yearly_Income_to_Client+$data['fundsondepositinfo']->Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Client;
                        $Op_Yearly_Interest_Dividends=$data['stockinvestmentinfo']->StocksInvestments_Total_Yearly_Income_to_Op+$data['fundsondepositinfo']->Funds_on_Deposit_Total_Estimated_Yearly_Income_to_Op;
                    ?>
                    <form role="form" id="dr_Income" method="POST" action="{{route('drincome.update',['id'=>$drincome->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_data->id}}">
                        <input id="month_diff" type="hidden" class="form-control" name="" value="">

                        <!-- Client Income Info Section -->
                        <div class="form-row Client_Income_section">
                            <h4 class="col-sm-12">{{$client_name}} Income Info Section</h4>
                            <div class="col-sm-12 mt-3">
                                <div class="form-group col-sm-6">
                                    <label>{{$client_name}} Employed?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Employed_Yes" name="Client_Employed" value="Yes" onchange="isEmployed(this, 'Client');" data-onload="isEmployed(this, 'Client');" <?php if(isset($drincome->Client_Employed) && $drincome->Client_Employed=='Yes'){ echo "checked"; } ?>> Yes</label>
                                         <label><input type="radio" id="Client_Employed_No" name="Client_Employed" value="No" onchange="isEmployed(this, 'Client');" data-onload="isEmployed(this, 'Client');" <?php if(isset($drincome->Client_Employed) && $drincome->Client_Employed=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_is_Employed_Div" style="display: none;">
                                    <label for="Client_Inc_Employer">Employer</label>
                                    <input id="Client_Inc_Employer" type="text" class="form-control Client_Income_inputs" name="Client_Inc_Employer" value="<?php if(isset($drincome->Client_Inc_Employer)){ echo $drincome->Client_Inc_Employer; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_is_Employed_Div" style="display: none;">
                                    <label for="Client_Inc_Employer_Payroll_Street_Address">Employer Street Address</label>
                                    <input id="Client_Inc_Employer_Payroll_Street_Address" type="text" class="form-control Client_Income_inputs" name="Client_Inc_Employer_Payroll_Street_Address" value="<?php if(isset($drincome->Client_Inc_Employer_Payroll_Street_Address)){ echo $drincome->Client_Inc_Employer_Payroll_Street_Address; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_is_Employed_Div" style="display: none;">
                                    <label for="Client_Inc_Employer_Payroll_City_State_Zip">Employer City, State Zip</label>
                                    <input id="Client_Inc_Employer_Payroll_City_State_Zip" type="text" class="form-control Client_Income_inputs" name="Client_Inc_Employer_Payroll_City_State_Zip" value="<?php if(isset($drincome->Client_Inc_Employer_Payroll_City_State_Zip)){ echo $drincome->Client_Inc_Employer_Payroll_City_State_Zip; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Wages Actual or Estimated?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Client_Wages_Actual_Actual" name="Client_Wages_Actual" value="Actual" <?php if(isset($drincome->Client_Wages_Actual) && $drincome->Client_Wages_Actual=='Actual'){ echo "checked"; } ?>> Actual</label>
                                         <label><input type="radio" id="Client_Wages_Actual_Estimated" name="Client_Wages_Actual" value="Estimated" <?php if(isset($drincome->Client_Wages_Actual) && $drincome->Client_Wages_Actual=='Estimated'){ echo "checked"; } ?>> Estimated</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_RegWage_YTD_MinWage">Are wages regular/salary, irregular/seasonal, or minimum wage?</label>
                                    <select id="Client_RegWage_YTD_MinWage" name="Client_RegWage_YTD_MinWage" class="form-control Client_Income_inputs" data-onload="onInitialMinWageChange(this, 'Client');" onchange="onMinWageChange(this, 'Client');">
                                        <option value="1" <?php if(isset($drincome->Client_RegWage_YTD_MinWage) && $drincome->Client_RegWage_YTD_MinWage=='1'){ echo "selected"; } ?>>Regular/salary</option>
                                        <option value="2" <?php if(isset($drincome->Client_RegWage_YTD_MinWage) && $drincome->Client_RegWage_YTD_MinWage=='2'){ echo "selected"; } ?>>Irregular/seasonal</option>
                                        <option value="3" <?php if(isset($drincome->Client_RegWage_YTD_MinWage) && $drincome->Client_RegWage_YTD_MinWage=='3'){ echo "selected"; } ?>>Minimum Wage</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_RegWage_YTD_MinWage_Div Client_RegWage_YTD_MinWage_1_Div">
                                    <label for="Client_Wages_per_Period">Wages per Pay Period</label>
                                    <input id="Client_Wages_per_Period" type="number" class="form-control Client_Income_inputs" name="Client_Wages_per_Period" value="<?php if(isset($drincome->Client_Wages_per_Period)){ echo $drincome->Client_Wages_per_Period; } ?>" min="0.00" step="0.01" max="999999.99" onchange="calculateBaseYearlyWagesByPerYear(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_RegWage_YTD_MinWage_Div Client_RegWage_YTD_MinWage_1_Div">
                                    <label for="Client_Pay_Periods_Yearly">Pay Periods per Year</label>
                                    <select id="Client_Pay_Periods_Yearly" name="Client_Pay_Periods_Yearly" class="form-control Client_Income_inputs" onchange="calculateBaseYearlyWagesByPerYear(this, 'Client');">
                                        <option value="1" <?php if(isset($drincome->Client_Pay_Periods_Yearly) && $drincome->Client_Pay_Periods_Yearly=='1'){ echo "selected"; } ?>>1</option>
                                        <option value="12" <?php if(isset($drincome->Client_Pay_Periods_Yearly) && $drincome->Client_Pay_Periods_Yearly=='12'){ echo "selected"; } ?>>12</option>
                                        <option value="24" <?php if(isset($drincome->Client_Pay_Periods_Yearly) && $drincome->Client_Pay_Periods_Yearly=='24'){ echo "selected"; } ?>>24</option>
                                        <option value="26" <?php if(isset($drincome->Client_Pay_Periods_Yearly) && $drincome->Client_Pay_Periods_Yearly=='26'){ echo "selected"; } ?>>26</option>
                                        <option value="52" <?php if(isset($drincome->Client_Pay_Periods_Yearly) && $drincome->Client_Pay_Periods_Yearly=='52'){ echo "selected"; } ?>>52</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_RegWage_YTD_MinWage_Div Client_RegWage_YTD_MinWage_2_Div" style="display: none;">
                                    <label for="Client_Pay_YTD">{{ $client_name }}’s Pay YTD</label>
                                    <input id="Client_Pay_YTD" type="number" class="form-control Client_Income_inputs" name="Client_Pay_YTD" value="<?php if(isset($drincome->Client_Pay_YTD)){ echo $drincome->Client_Pay_YTD; } ?>" min="0.00" step="0.01" max="999999.99" onchange="calculateBaseYearlyWagesByYTDPayDate(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_RegWage_YTD_MinWage_Div Client_RegWage_YTD_MinWage_2_Div" style="display: none;">
                                    <label for="Client_YTD_Date">YTD Pay Date</label>
                                    <input id="Client_YTD_Date" type="text" class="form-control hasDatepicker Client_Income_inputs" name="Client_YTD_Date" value="<?php if(isset($drincome->Client_YTD_Date)){ echo date("m/d/Y", strtotime($drincome->Client_YTD_Date)); } ?>" onchange="calculateBaseYearlyWagesByYTDPayDate(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_RegWage_YTD_MinWage_3_Div Client_RegWage_YTD_MinWage_Base_Yearly_Wages_Div">
                                    <label for="Client_Base_Yearly_Wages">{{$client_name}} Base Yearly Wages</label>
                                    <input id="Client_Base_Yearly_Wages" type="number" class="form-control Client_Income_inputs" name="Client_Base_Yearly_Wages" value="<?php if(isset($drincome->Client_Base_Yearly_Wages)){ echo $drincome->Client_Base_Yearly_Wages; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Last_Year_Base_Wages">Last Year Base Wages? (Yearly)</label>
                                    <input id="Client_Last_Year_Base_Wages" type="number" class="form-control Client_Income_inputs" name="Client_Last_Year_Base_Wages" value="<?php if(isset($drincome->Client_Last_Year_Base_Wages)){ echo $drincome->Client_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Year_Before_Last_Year_Base_Wages">Two Years Ago Base Wages (Yearly)?</label>
                                    <input id="Client_Year_Before_Last_Year_Base_Wages" type="number" class="form-control Client_Income_inputs" name="Client_Year_Before_Last_Year_Base_Wages" value="<?php if(isset($drincome->Client_Year_Before_Last_Year_Base_Wages)){ echo $drincome->Client_Year_Before_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Two_Years_Before_Last_Year_Base_Wages">Three Years Ago Base Wages (Yearly)?</label>
                                    <input id="Client_Two_Years_Before_Last_Year_Base_Wages" type="number" class="form-control Client_Income_inputs" name="Client_Two_Years_Before_Last_Year_Base_Wages" value="<?php if(isset($drincome->Client_Two_Years_Before_Last_Year_Base_Wages)){ echo $drincome->Client_Two_Years_Before_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Most_Recent_Yearly_OT_Comms_Bonuses">Last Year Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Client_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Client_Income_inputs" name="Client_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Client_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Client_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses">Two Years Ago Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Client_Income_inputs" name="Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Client_Second_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses">Three Years Ago Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Client_Income_inputs" name="Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Client_Third_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Min_Ave_OT_Comms_Bonuses">N/A = MIN(L24,(L24+L25+L26)/3)</label>
                                    <input id="Client_Min_Ave_OT_Comms_Bonuses" type="number" class="form-control Client_Income_inputs" name="Client_Min_Ave_OT_Comms_Bonuses" value="<?php if(isset($drincome->Client_Min_Ave_OT_Comms_Bonuses)){ echo $drincome->Client_Min_Ave_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Unemployment_Compensation">Current Yearly Unemployment Compensation?</label>
                                    <input id="Client_Yearly_Unemployment_Compensation" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Unemployment_Compensation" value="<?php if(isset($drincome->Client_Yearly_Unemployment_Compensation)){ echo $drincome->Client_Yearly_Unemployment_Compensation; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Workers_Compensation">Current Yearly Workers’ Compensation?</label>
                                    <input id="Client_Yearly_Workers_Compensation" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Workers_Compensation" value="<?php if(isset($drincome->Client_Yearly_Workers_Compensation)){ echo $drincome->Client_Yearly_Workers_Compensation; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Social_Security_Disability">Current Yearly Social Security Disability?</label>
                                    <input id="Client_Yearly_Social_Security_Disability" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Social_Security_Disability" value="<?php if(isset($drincome->Client_Yearly_Social_Security_Disability)){ echo $drincome->Client_Yearly_Social_Security_Disability; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Other_Disability_Source">Source of Yearly Disability Income Other than Social Security?</label>
                                    <input id="Client_Yearly_Other_Disability_Source" type="text" class="form-control Client_Income_inputs" name="Client_Yearly_Other_Disability_Source" value="<?php if(isset($drincome->Client_Yearly_Other_Disability_Source)){ echo $drincome->Client_Yearly_Other_Disability_Source; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Other_Disability_Income">Current Yearly Income for Disability Other than Social Security?</label>
                                    <input id="Client_Yearly_Other_Disability_Income" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Other_Disability_Income" value="<?php if(isset($drincome->Client_Yearly_Other_Disability_Income)){ echo $drincome->Client_Yearly_Other_Disability_Income; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Social_Security_Retirement">Current Yearly Social Security Retirement Income?</label>
                                    <input id="Client_Yearly_Social_Security_Retirement" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Social_Security_Retirement" value="<?php if(isset($drincome->Client_Yearly_Social_Security_Retirement)){ echo $drincome->Client_Yearly_Social_Security_Retirement; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Gross_Self_Employment_Income">Current Yearly Gross Self-Employment Income?</label>
                                    <input id="Client_Yearly_Gross_Self_Employment_Income" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Gross_Self_Employment_Income" value="<?php if(isset($drincome->Client_Yearly_Gross_Self_Employment_Income)){ echo $drincome->Client_Yearly_Gross_Self_Employment_Income; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Self_Employment_Expenses">Current Yearly Self-Employment Expenses?</label>
                                    <input id="Client_Yearly_Self_Employment_Expenses" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Self_Employment_Expenses" value="<?php if(isset($drincome->Client_Yearly_Self_Employment_Expenses)){ echo $drincome->Client_Yearly_Self_Employment_Expenses; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Rent">Rent</label>
                                    <input id="Client_Rent" type="number" class="form-control Client_Income_inputs" name="Client_Rent" value="{{ $data['Client_Rent'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Retirement_Pensions">Retirement Benefits</label>
                                    <input id="Client_Retirement_Pensions" type="number" class="form-control Client_Income_inputs" name="Client_Retirement_Pensions" value="{{ $data['Client_Retirement_Pensions'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Interest_Dividends">Current Yearly Interest & Dividends?</label>
                                    <input id="Client_Yearly_Interest_Dividends" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Interest_Dividends" value="<?php if(isset($Client_Yearly_Interest_Dividends)){ echo $Client_Yearly_Interest_Dividends; } else if(isset($drincome->Client_Yearly_Interest_Dividends)){ echo $drincome->Client_Yearly_Interest_Dividends; } else { echo "0.00"; } ?>" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Interest_Dividends">N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Client )</label>
                                    <input id="Client_Interest_Dividends" type="number" class="form-control Client_Income_inputs" name="Client_Interest_Dividends" value="{{ $data['Client_Interest_Dividends'] }}" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type">Type of Current Monthly Mandatory Work Deductions (Not Taxes)</label>
                                    <input id="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type" type="text" class="form-control Client_Income_inputs" name="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type" value="<?php if(isset($drincome->Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type)){ echo $drincome->Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt">Amount of Current Monthly Mandatory Work Deductions (Not Taxes)</label>
                                    <input id="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt" type="number" class="form-control Client_Income_inputs" name="Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt" value="<?php if(isset($drincome->Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt)){ echo $drincome->Client_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlyDeduction(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt">N/A, Calculated = 12*Client_Inc_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt</label>
                                    <input id="Client_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt" value="<?php if(isset($drincome->Client_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt)){ echo $drincome->Client_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Position">Work Position</label>
                                    <input id="Client_Position" type="text" class="form-control Client_Income_inputs" name="Client_Position" value="<?php if(isset($drincome->Client_Position)){ echo $drincome->Client_Position; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Weekly_Hours">Work Hours per Week</label>
                                    <input id="Client_Weekly_Hours" type="number" class="form-control Client_Income_inputs" name="Client_Weekly_Hours" value="<?php if(isset($drincome->Client_Weekly_Hours)){ echo $drincome->Client_Weekly_Hours; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Work_Phone">Work Phone</label>
                                    <input id="Client_Work_Phone" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Work_Phone" value="<?php if(isset($drincome->Client_Work_Phone)){ echo $drincome->Client_Work_Phone; } ?>" placeholder="(XXX) XXX-XXXX"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Yearly_Spousal_Support_Received_Not_This_Marriage">N/A, Calculated from dr_PersonalInfo * 12</label>
                                    <input id="Client_Yearly_Spousal_Support_Received_Not_This_Marriage" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Spousal_Support_Received_Not_This_Marriage" value="{{ $data['Client_Yearly_Spousal_Support_Received_Not_This_Marriage'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_SSI">Amount of Current Monthly SSI?</label>
                                    <input id="Client_Monthly_SSI" type="number" class="form-control Client_Income_inputs" name="Client_Monthly_SSI" value="<?php if(isset($drincome->Client_Monthly_SSI)){ echo $drincome->Client_Monthly_SSI; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlySSI(this, 'Client');">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Yearly_SSI">N/A, Calculated = 12*Client_Monthly_SSI</label>
                                    <input id="Client_Yearly_SSI" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_SSI" value="<?php if(isset($drincome->Client_Yearly_SSI)){ echo $drincome->Client_Yearly_SSI; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Public_Assistance_Amt">Amount of Monthly Public Assistance?</label>
                                    <input id="Client_Monthly_Public_Assistance_Amt" type="number" class="form-control Client_Income_inputs" name="Client_Monthly_Public_Assistance_Amt" value="<?php if(isset($drincome->Client_Monthly_Public_Assistance_Amt)){ echo $drincome->Client_Monthly_Public_Assistance_Amt; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlyPublicAssistanceAmt(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Client_Yearly_Public_Assistance_Amt">N/A, Calculated = 12*Client_Inc_Monthly_Public_Assistance_Amt</label>
                                    <input id="Client_Yearly_Public_Assistance_Amt" type="number" class="form-control Client_Income_inputs" name="Client_Yearly_Public_Assistance_Amt" value="<?php if(isset($drincome->Client_Yearly_Public_Assistance_Amt)){ echo $drincome->Client_Yearly_Public_Assistance_Amt; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Client_Monthly_Gets_Child_Support_NoM">N/A, Calculated from dr_Children</label>
                                    <input id="Client_Monthly_Gets_Child_Support_NoM" type="number" class="form-control Client_Income_inputs" name="Client_Monthly_Gets_Child_Support_NoM" value="{{ $data['Client_Monthly_Gets_Child_Support_NoM'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Check if {{ $client_name }} has another Source of Income.</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="checkbox" id="Client_Other_Source_Income" name="Client_Other_Source_Income" value="1" data-onload="hasAnotherSourceOfIncome(this, 'Client');" onchange="hasAnotherSourceOfIncome(this, 'Client');" <?php if(isset($drincome->Client_Other_Source_Income) && $drincome->Client_Other_Source_Income=='1'){ echo "checked"; } ?>> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Name1">Name of Other Source of Income #1</label>
                                    <input id="Client_Other_Source_Name1" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Other_Source_Name1" value="<?php if(isset($drincome->Client_Other_Source_Name1)){ echo $drincome->Client_Other_Source_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 1_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Other_Source_Zip1">Other Source of Income #1 Zip Code?</label>
                                    <input id="Client_Other_Source_Zip1" type="text" class="form-control Client_Income_inputs 1_Client_Other_Income_inputs" name="Client_Other_Source_Zip1" value="<?php if(isset($drincome->Client_Other_Source_Zip1)){ echo $drincome->Client_Other_Source_Zip1; } ?>" onkeyup="getCityStateForZip(this, '1', 'Client');" data-onload="getCityStateForZip(this, '1', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Street_Address1">Other Source of Income #1 Street Address?</label>
                                    <input id="Client_Other_Source_Street_Address1" type="text" class="form-control Client_Income_inputs 1_Client_Other_Income_inputs" name="Client_Other_Source_Street_Address1" value="<?php if(isset($drincome->Client_Other_Source_Street_Address1)){ echo $drincome->Client_Other_Source_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_City1">Other Source of Income #1 City?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_City1_Value" value="<?php if(isset($drincome->Client_Other_Source_City1)){ echo $drincome->Client_Other_Source_City1; } ?>">
                                    <select id="Client_Other_Source_City1" name="Client_Other_Source_City1" class="form-control 1_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_State1">Other Source of Income #1 State?</label>
                                     <input type="hidden" name="" id="Client_Other_Source_State1_Value" value="<?php if(isset($drincome->Client_Other_Source_State1)){ echo $drincome->Client_Other_Source_State1; } ?>">
                                    <select id="Client_Other_Source_State1" name="Client_Other_Source_State1" class="form-control 1_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Acct_Num_or_Description1">Account # or Description of Other Source of Income #1</label>
                                    <input id="Client_Other_Source_Acct_Num_or_Description1" type="text" class="form-control Client_Income_inputs 1_Client_Other_Income_inputs" name="Client_Other_Source_Acct_Num_or_Description1" value="<?php if(isset($drincome->Client_Other_Source_Acct_Num_or_Description1)){ echo $drincome->Client_Other_Source_Acct_Num_or_Description1; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Yearly_Income1">Yearly Amount of Other Source of Income #1</label>
                                    <input id="Client_Other_Source_Yearly_Income1" type="number" class="form-control Client_Income_inputs" name="Client_Other_Source_Yearly_Income1" value="<?php if(isset($drincome->Client_Other_Source_Yearly_Income1)){ echo $drincome->Client_Other_Source_Yearly_Income1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Client');">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Name2">Name of Other Source of Income #2</label>
                                    <input id="Client_Other_Source_Name2" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Other_Source_Name2" value="<?php if(isset($drincome->Client_Other_Source_Name2)){ echo $drincome->Client_Other_Source_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 2_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Other_Source_Zip2">Other Source of Income #2 Zip Code?</label>
                                    <input id="Client_Other_Source_Zip2" type="text" class="form-control Client_Income_inputs 2_Client_Other_Income_inputs" name="Client_Other_Source_Zip2" value="<?php if(isset($drincome->Client_Other_Source_Zip2)){ echo $drincome->Client_Other_Source_Zip2; } ?>" onkeyup="getCityStateForZip(this, '2', 'Client');" data-onload="getCityStateForZip(this, '2', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Street_Address2">Other Source of Income #2 Street Address?</label>
                                    <input id="Client_Other_Source_Street_Address2" type="text" class="form-control Client_Income_inputs 2_Client_Other_Income_inputs" name="Client_Other_Source_Street_Address2" value="<?php if(isset($drincome->Client_Other_Source_Street_Address2)){ echo $drincome->Client_Other_Source_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_City2">Other Source of Income #2 City?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_City2_Value" value="<?php if(isset($drincome->Client_Other_Source_City2)){ echo $drincome->Client_Other_Source_City2; } ?>">
                                    <select id="Client_Other_Source_City2" name="Client_Other_Source_City2" class="form-control 2_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_State2">Other Source of Income #2 State?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_State2_Value" value="<?php if(isset($drincome->Client_Other_Source_State2)){ echo $drincome->Client_Other_Source_State2; } ?>">
                                    <select id="Client_Other_Source_State2" name="Client_Other_Source_State2" class="form-control 2_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Acct_Num_or_Description2">Account # or Description of Other Source of Income #2</label>
                                    <input id="Client_Other_Source_Acct_Num_or_Description2" type="text" class="form-control Client_Income_inputs 2_Client_Other_Income_inputs" name="Client_Other_Source_Acct_Num_or_Description2" value="<?php if(isset($drincome->Client_Other_Source_Acct_Num_or_Description2)){ echo $drincome->Client_Other_Source_Acct_Num_or_Description2; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Yearly_Income2">Yearly Amount of Other Source of Income #2</label>
                                    <input id="Client_Other_Source_Yearly_Income2" type="number" class="form-control Client_Income_inputs" name="Client_Other_Source_Yearly_Income2" value="<?php if(isset($drincome->Client_Other_Source_Yearly_Income2)){ echo $drincome->Client_Other_Source_Yearly_Income2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Name3">Name of Other Source of Income #3</label>
                                    <input id="Client_Other_Source_Name3" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Other_Source_Name3" value="<?php if(isset($drincome->Client_Other_Source_Name3)){ echo $drincome->Client_Other_Source_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 3_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Other_Source_Zip3">Other Source of Income #3 Zip Code?</label>
                                    <input id="Client_Other_Source_Zip3" type="text" class="form-control Client_Income_inputs 3_Client_Other_Income_inputs" name="Client_Other_Source_Zip3" value="<?php if(isset($drincome->Client_Other_Source_Zip3)){ echo $drincome->Client_Other_Source_Zip3; } ?>" onkeyup="getCityStateForZip(this, '3', 'Client');" data-onload="getCityStateForZip(this, '3', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Street_Address3">Other Source of Income #3 Street Address?</label>
                                    <input id="Client_Other_Source_Street_Address3" type="text" class="form-control Client_Income_inputs 3_Client_Other_Income_inputs" name="Client_Other_Source_Street_Address3" value="<?php if(isset($drincome->Client_Other_Source_Street_Address3)){ echo $drincome->Client_Other_Source_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_City3">Other Source of Income #3 City?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_City3_Value" value="<?php if(isset($drincome->Client_Other_Source_City3)){ echo $drincome->Client_Other_Source_City3; } ?>">
                                    <select id="Client_Other_Source_City3" name="Client_Other_Source_City3" class="form-control 3_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_State3">Other Source of Income #3 State?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_State3_Value" value="<?php if(isset($drincome->Client_Other_Source_State3)){ echo $drincome->Client_Other_Source_State3; } ?>">
                                    <select id="Client_Other_Source_State3" name="Client_Other_Source_State3" class="form-control 3_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Acct_Num_or_Description3">Account # or Description of Other Source of Income #3</label>
                                    <input id="Client_Other_Source_Acct_Num_or_Description3" type="text" class="form-control Client_Income_inputs 3_Client_Other_Income_inputs" name="Client_Other_Source_Acct_Num_or_Description3" value="<?php if(isset($drincome->Client_Other_Source_Acct_Num_or_Description3)){ echo $drincome->Client_Other_Source_Acct_Num_or_Description3; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Yearly_Income3">Yearly Amount of Other Source of Income #3</label>
                                    <input id="Client_Other_Source_Yearly_Income3" type="number" class="form-control Client_Income_inputs" name="Client_Other_Source_Yearly_Income3" value="<?php if(isset($drincome->Client_Other_Source_Yearly_Income3)){ echo $drincome->Client_Other_Source_Yearly_Income3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Name4">Name of Other Source of Income #4</label>
                                    <input id="Client_Other_Source_Name4" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Other_Source_Name4" value="<?php if(isset($drincome->Client_Other_Source_Name4)){ echo $drincome->Client_Other_Source_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 4_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Other_Source_Zip4">Other Source of Income #4 Zip Code?</label>
                                    <input id="Client_Other_Source_Zip4" type="text" class="form-control Client_Income_inputs 4_Client_Other_Income_inputs" name="Client_Other_Source_Zip4" value="<?php if(isset($drincome->Client_Other_Source_Zip4)){ echo $drincome->Client_Other_Source_Zip4; } ?>" onkeyup="getCityStateForZip(this, '4', 'Client');" data-onload="getCityStateForZip(this, '4', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Street_Address4">Other Source of Income #4 Street Address?</label>
                                    <input id="Client_Other_Source_Street_Address4" type="text" class="form-control Client_Income_inputs 4_Client_Other_Income_inputs" name="Client_Other_Source_Street_Address4" value="<?php if(isset($drincome->Client_Other_Source_Street_Address4)){ echo $drincome->Client_Other_Source_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_City4">Other Source of Income #4 City?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_City4_Value" value="<?php if(isset($drincome->Client_Other_Source_City4)){ echo $drincome->Client_Other_Source_City4; } ?>">
                                    <select id="Client_Other_Source_City4" name="Client_Other_Source_City4" class="form-control 4_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_State4">Other Source of Income #4 State?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_State4_Value" value="<?php if(isset($drincome->Client_Other_Source_State4)){ echo $drincome->Client_Other_Source_State4; } ?>">
                                    <select id="Client_Other_Source_State4" name="Client_Other_Source_State4" class="form-control 4_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Acct_Num_or_Description4">Account # or Description of Other Source of Income #4</label>
                                    <input id="Client_Other_Source_Acct_Num_or_Description4" type="text" class="form-control Client_Income_inputs 4_Client_Other_Income_inputs" name="Client_Other_Source_Acct_Num_or_Description4" value="<?php if(isset($drincome->Client_Other_Source_Acct_Num_or_Description4)){ echo $drincome->Client_Other_Source_Acct_Num_or_Description4; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Yearly_Income4">Yearly Amount of Other Source of Income #4</label>
                                    <input id="Client_Other_Source_Yearly_Income4" type="number" class="form-control Client_Income_inputs" name="Client_Other_Source_Yearly_Income4" value="<?php if(isset($drincome->Client_Other_Source_Yearly_Income4)){ echo $drincome->Client_Other_Source_Yearly_Income4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Name5">Name of Other Source of Income #5</label>
                                    <input id="Client_Other_Source_Name5" type="text" class="form-control Client_Income_inputs phone_input" name="Client_Other_Source_Name5" value="<?php if(isset($drincome->Client_Other_Source_Name5)){ echo $drincome->Client_Other_Source_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 5_Client_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Client_Other_Source_Zip5">Other Source of Income #5 Zip Code?</label>
                                    <input id="Client_Other_Source_Zip5" type="text" class="form-control Client_Income_inputs 5_Client_Other_Income_inputs" name="Client_Other_Source_Zip5" value="<?php if(isset($drincome->Client_Other_Source_Zip5)){ echo $drincome->Client_Other_Source_Zip5; } ?>" onkeyup="getCityStateForZip(this, '5', 'Client');" data-onload="getCityStateForZip(this, '5', 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Street_Address5">Other Source of Income #5 Street Address?</label>
                                    <input id="Client_Other_Source_Street_Address5" type="text" class="form-control Client_Income_inputs 5_Client_Other_Income_inputs" name="Client_Other_Source_Street_Address5" value="<?php if(isset($drincome->Client_Other_Source_Street_Address5)){ echo $drincome->Client_Other_Source_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_City5">Other Source of Income #5 City?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_City5_Value" value="<?php if(isset($drincome->Client_Other_Source_City5)){ echo $drincome->Client_Other_Source_City5; } ?>">

                                    <select id="Client_Other_Source_City5" name="Client_Other_Source_City5" class="form-control 5_Client_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_State5">Other Source of Income #5 State?</label>
                                    <input type="hidden" name="" id="Client_Other_Source_State5_Value" value="<?php if(isset($drincome->Client_Other_Source_State5)){ echo $drincome->Client_Other_Source_State5; } ?>">
                                    <select id="Client_Other_Source_State5" name="Client_Other_Source_State5" class="form-control 5_Client_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Acct_Num_or_Description5">Account # or Description of Other Source of Income #5</label>
                                    <input id="Client_Other_Source_Acct_Num_or_Description5" type="text" class="form-control Client_Income_inputs 5_Client_Other_Income_inputs" name="Client_Other_Source_Acct_Num_or_Description5" value="<?php if(isset($drincome->Client_Other_Source_Acct_Num_or_Description5)){ echo $drincome->Client_Other_Source_Acct_Num_or_Description5; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Source_Yearly_Income5">Yearly Amount of Other Source of Income #5</label>
                                    <input id="Client_Other_Source_Yearly_Income5" type="number" class="form-control Client_Income_inputs" name="Client_Other_Source_Yearly_Income5" value="<?php if(isset($drincome->Client_Other_Source_Yearly_Income5)){ echo $drincome->Client_Other_Source_Yearly_Income5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Client');"> 
                                </div>
                                <div class="form-group col-sm-6 Client_Other_Source_Income_Div" style="display: none;">
                                    <label for="Client_Other_Yearly_Income_Total">Total Yearly Amount of Other Sources of Income</label>
                                    <input id="Client_Other_Yearly_Income_Total" type="number" class="form-control Client_Income_inputs" name="Client_Other_Yearly_Income_Total" value="<?php if(isset($drincome->Client_Other_Yearly_Income_Total)){ echo $drincome->Client_Other_Yearly_Income_Total; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                            </div>
                        </div>
                        <!-- End of Client Income Info Section -->

                        <!-- Op Income Info Section -->
                        <div class="form-row mt-2 Op_Income_section">
                            <h4 class="col-sm-12">{{$opponent_name}} Income Info Section</h4>
                            <div class="col-sm-12 mt-3">
                                <div class="form-group col-sm-6">
                                    <label>{{$opponent_name}} Employed?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Employed_Yes" name="Op_Employed" value="Yes" onchange="isEmployed(this, 'Op');" <?php if(isset($drincome->Op_Employed) && $drincome->Op_Employed=='Yes'){ echo "checked"; } ?>> Yes</label>
                                         <label><input type="radio" id="Op_Employed_No" name="Op_Employed" value="No" onchange="isEmployed(this, 'Op');" <?php if(isset($drincome->Op_Employed) && $drincome->Op_Employed=='No'){ echo "checked"; } ?>> No</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_is_Employed_Div" style="display: none;">
                                    <label for="Op_Inc_Employer">Employer</label>
                                    <input id="Op_Inc_Employer" type="text" class="form-control Op_Income_inputs" name="Op_Inc_Employer" value="<?php if(isset($drincome->Op_Inc_Employer)){ echo $drincome->Op_Inc_Employer; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_is_Employed_Div" style="display: none;">
                                    <label for="Op_Inc_Employer_Payroll_Street_Address">Employer Street Address</label>
                                    <input id="Op_Inc_Employer_Payroll_Street_Address" type="text" class="form-control Op_Income_inputs" name="Op_Inc_Employer_Payroll_Street_Address" value="<?php if(isset($drincome->Op_Inc_Employer_Payroll_Street_Address)){ echo $drincome->Op_Inc_Employer_Payroll_Street_Address; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_is_Employed_Div" style="display: none;">
                                    <label for="Op_Inc_Employer_Payroll_City_State_Zip">Employer City, State Zip</label>
                                    <input id="Op_Inc_Employer_Payroll_City_State_Zip" type="text" class="form-control Op_Income_inputs" name="Op_Inc_Employer_Payroll_City_State_Zip" value="<?php if(isset($drincome->Op_Inc_Employer_Payroll_City_State_Zip)){ echo $drincome->Op_Inc_Employer_Payroll_City_State_Zip; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Wages Actual or Estimated?</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="radio" id="Op_Wages_Actual_Actual" name="Op_Wages_Actual" value="Actual" <?php if(isset($drincome->Op_Wages_Actual) && $drincome->Op_Wages_Actual=='Actual'){ echo "checked"; } ?>> Actual</label>
                                         <label><input type="radio" id="Op_Wages_Actual_Estimated" name="Op_Wages_Actual" value="Estimated" <?php if(isset($drincome->Op_Wages_Actual) && $drincome->Op_Wages_Actual=='Estimated'){ echo "checked"; } ?>> Estimated</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_RegWage_YTD_MinWage">Are wages regular/salary, irregular/seasonal, or minimum wage?</label>
                                    <select id="Op_RegWage_YTD_MinWage" name="Op_RegWage_YTD_MinWage" class="form-control Op_Income_inputs" data-onload="onInitialMinWageChange(this, 'Op');" onchange="onMinWageChange(this, 'Op');">
                                        <option value="1" <?php if(isset($drincome->Op_RegWage_YTD_MinWage) && $drincome->Op_RegWage_YTD_MinWage=='1'){ echo "selected"; } ?>>Regular/salary</option>
                                        <option value="2" <?php if(isset($drincome->Op_RegWage_YTD_MinWage) && $drincome->Op_RegWage_YTD_MinWage=='2'){ echo "selected"; } ?>>Irregular/seasonal</option>
                                        <option value="3" <?php if(isset($drincome->Op_RegWage_YTD_MinWage) && $drincome->Op_RegWage_YTD_MinWage=='3'){ echo "selected"; } ?>>Minimum Wage</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_RegWage_YTD_MinWage_Div Op_RegWage_YTD_MinWage_1_Div">
                                    <label for="Op_Wages_per_Period">Wages per Pay Period</label>
                                    <input id="Op_Wages_per_Period" type="number" class="form-control Op_Income_inputs" name="Op_Wages_per_Period" value="<?php if(isset($drincome->Op_Wages_per_Period)){ echo $drincome->Op_Wages_per_Period; } ?>" min="0.00" step="0.01" max="999999.99" onchange="calculateBaseYearlyWagesByPerYear(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_RegWage_YTD_MinWage_Div Op_RegWage_YTD_MinWage_1_Div">
                                    <label for="Op_Pay_Periods_Yearly">Pay Periods per Year</label>
                                    <select id="Op_Pay_Periods_Yearly" name="Op_Pay_Periods_Yearly" class="form-control Op_Income_inputs" onchange="calculateBaseYearlyWagesByPerYear(this, 'Op');">
                                        <option value="1" <?php if(isset($drincome->Op_Pay_Periods_Yearly) && $drincome->Op_Pay_Periods_Yearly=='1'){ echo "selected"; } ?>>1</option>
                                        <option value="12" <?php if(isset($drincome->Op_Pay_Periods_Yearly) && $drincome->Op_Pay_Periods_Yearly=='12'){ echo "selected"; } ?>>12</option>
                                        <option value="24" <?php if(isset($drincome->Op_Pay_Periods_Yearly) && $drincome->Op_Pay_Periods_Yearly=='24'){ echo "selected"; } ?>>24</option>
                                        <option value="26" <?php if(isset($drincome->Op_Pay_Periods_Yearly) && $drincome->Op_Pay_Periods_Yearly=='26'){ echo "selected"; } ?>>26</option>
                                        <option value="52" <?php if(isset($drincome->Op_Pay_Periods_Yearly) && $drincome->Op_Pay_Periods_Yearly=='52'){ echo "selected"; } ?>>52</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_RegWage_YTD_MinWage_Div Op_RegWage_YTD_MinWage_2_Div" style="display: none;">
                                    <label for="Op_Pay_YTD">{{ $opponent_name }}’s Pay YTD</label>
                                    <input id="Op_Pay_YTD" type="number" class="form-control Op_Income_inputs" name="Op_Pay_YTD" value="<?php if(isset($drincome->Op_Pay_YTD)){ echo $drincome->Op_Pay_YTD; } ?>" min="0.00" step="0.01" max="999999.99" onchange="calculateBaseYearlyWagesByYTDPayDate(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_RegWage_YTD_MinWage_Div Op_RegWage_YTD_MinWage_2_Div" style="display: none;">
                                    <label for="Op_YTD_Date">YTD Pay Date</label>
                                    <input id="Op_YTD_Date" type="text" class="form-control hasDatepicker Op_Income_inputs" name="Op_YTD_Date" value="<?php if(isset($drincome->Op_YTD_Date)){ echo date("m/d/Y", strtotime($drincome->Op_YTD_Date)); } ?>" onchange="calculateBaseYearlyWagesByYTDPayDate(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_RegWage_YTD_MinWage_3_Div Op_RegWage_YTD_MinWage_Base_Yearly_Wages_Div">
                                    <label for="Op_Base_Yearly_Wages">{{$opponent_name}} Base Yearly Wages</label>
                                    <input id="Op_Base_Yearly_Wages" type="number" class="form-control Op_Income_inputs" name="Op_Base_Yearly_Wages" value="<?php if(isset($drincome->Op_Base_Yearly_Wages)){ echo $drincome->Op_Base_Yearly_Wages; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Last_Year_Base_Wages">Last Year Base Wages? (Yearly)</label>
                                    <input id="Op_Last_Year_Base_Wages" type="number" class="form-control Op_Income_inputs" name="Op_Last_Year_Base_Wages" value="<?php if(isset($drincome->Op_Last_Year_Base_Wages)){ echo $drincome->Op_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Year_Before_Last_Year_Base_Wages">Two Years Ago Base Wages (Yearly)?</label>
                                    <input id="Op_Year_Before_Last_Year_Base_Wages" type="number" class="form-control Op_Income_inputs" name="Op_Year_Before_Last_Year_Base_Wages" value="<?php if(isset($drincome->Op_Year_Before_Last_Year_Base_Wages)){ echo $drincome->Op_Year_Before_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Two_Years_Before_Last_Year_Base_Wages">Three Years Ago Base Wages (Yearly)?</label>
                                    <input id="Op_Two_Years_Before_Last_Year_Base_Wages" type="number" class="form-control Op_Income_inputs" name="Op_Two_Years_Before_Last_Year_Base_Wages" value="<?php if(isset($drincome->Op_Two_Years_Before_Last_Year_Base_Wages)){ echo $drincome->Op_Two_Years_Before_Last_Year_Base_Wages; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Most_Recent_Yearly_OT_Comms_Bonuses">Last Year Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Op_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Op_Income_inputs" name="Op_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Op_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Op_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses">Two Years Ago Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Op_Income_inputs" name="Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Op_Second_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses">Three Years Ago Overtime, Commissions, Bonuses, Etc. (Yearly)?</label>
                                    <input id="Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses" type="number" class="form-control Op_Income_inputs" name="Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses" value="<?php if(isset($drincome->Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses)){ echo $drincome->Op_Third_Most_Recent_Yearly_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getMinAvgCommBonuses(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Min_Ave_OT_Comms_Bonuses">N/A = MIN(L24,(L24+L25+L26)/3)</label>
                                    <input id="Op_Min_Ave_OT_Comms_Bonuses" type="number" class="form-control Op_Income_inputs" name="Op_Min_Ave_OT_Comms_Bonuses" value="<?php if(isset($drincome->Op_Min_Ave_OT_Comms_Bonuses)){ echo $drincome->Op_Min_Ave_OT_Comms_Bonuses; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Unemployment_Compensation">Current Yearly Unemployment Compensation?</label>
                                    <input id="Op_Yearly_Unemployment_Compensation" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Unemployment_Compensation" value="<?php if(isset($drincome->Op_Yearly_Unemployment_Compensation)){ echo $drincome->Op_Yearly_Unemployment_Compensation; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Workers_Compensation">Current Yearly Workers’ Compensation?</label>
                                    <input id="Op_Yearly_Workers_Compensation" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Workers_Compensation" value="<?php if(isset($drincome->Op_Yearly_Workers_Compensation)){ echo $drincome->Op_Yearly_Workers_Compensation; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Social_Security_Disability">Current Yearly Social Security Disability?</label>
                                    <input id="Op_Yearly_Social_Security_Disability" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Social_Security_Disability" value="<?php if(isset($drincome->Op_Yearly_Social_Security_Disability)){ echo $drincome->Op_Yearly_Social_Security_Disability; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Other_Disability_Source">Source of Yearly Disability Income Other than Social Security?</label>
                                    <input id="Op_Yearly_Other_Disability_Source" type="text" class="form-control Op_Income_inputs" name="Op_Yearly_Other_Disability_Source" value="<?php if(isset($drincome->Op_Yearly_Other_Disability_Source)){ echo $drincome->Op_Yearly_Other_Disability_Source; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Other_Disability_Income">Current Yearly Income for Disability Other than Social Security?</label>
                                    <input id="Op_Yearly_Other_Disability_Income" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Other_Disability_Income" value="<?php if(isset($drincome->Op_Yearly_Other_Disability_Income)){ echo $drincome->Op_Yearly_Other_Disability_Income; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Social_Security_Retirement">Current Yearly Social Security Retirement Income?</label>
                                    <input id="Op_Yearly_Social_Security_Retirement" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Social_Security_Retirement" value="<?php if(isset($drincome->Op_Yearly_Social_Security_Retirement)){ echo $drincome->Op_Yearly_Social_Security_Retirement; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Gross_Self_Employment_Income">Current Yearly Gross Self-Employment Income?</label>
                                    <input id="Op_Yearly_Gross_Self_Employment_Income" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Gross_Self_Employment_Income" value="<?php if(isset($drincome->Op_Yearly_Gross_Self_Employment_Income)){ echo $drincome->Op_Yearly_Gross_Self_Employment_Income; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Self_Employment_Expenses">Current Yearly Self-Employment Expenses?</label>
                                    <input id="Op_Yearly_Self_Employment_Expenses" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Self_Employment_Expenses" value="<?php if(isset($drincome->Op_Yearly_Self_Employment_Expenses)){ echo $drincome->Op_Yearly_Self_Employment_Expenses; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Rent">Rent</label>
                                    <input id="Op_Rent" type="number" class="form-control Op_Income_inputs" name="Op_Rent" value="{{ $data['Op_Rent'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Retirement_Pensions">Retirement Benefits</label>
                                    <input id="Op_Retirement_Pensions" type="number" class="form-control Op_Income_inputs" name="Op_Retirement_Pensions" value="{{ $data['Op_Retirement_Pensions'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Interest_Dividends">Current Yearly Interest & Dividends?</label>
                                    <input id="Op_Yearly_Interest_Dividends" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Interest_Dividends" value="<?php if(isset($Op_Yearly_Interest_Dividends)){ echo $Op_Yearly_Interest_Dividends; } else if(isset($drincome->Op_Yearly_Interest_Dividends)){ echo $drincome->Op_Yearly_Interest_Dividends; } else { echo "0.00"; } ?>" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Interest_Dividends">N/A, Calculated from dr_Stocks_Investments & dr_FundsOnDeposit = SUM(Joint/Client/Op_StockInvestments_Yearly_Interest_Dividend * Joint/Client/Op_StockInvestments_Percent_Marital_Equity_to_Client ) + SUM(Joint/Client/Op_Funds_on_Deposit_Institution_Yearly_Interest_Dividend * Joint/Client/Op Funds_on_Deposit_Percent_Marital_Equity_to_Op )</label>
                                    <input id="Op_Interest_Dividends" type="number" class="form-control Op_Income_inputs" name="Op_Interest_Dividends" value="{{ $data['Op_Interest_Dividends'] }}" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type">Type of Current Monthly Mandatory Work Deductions (Not Taxes)</label>
                                    <input id="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type" type="text" class="form-control Op_Income_inputs" name="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type" value="<?php if(isset($drincome->Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type)){ echo $drincome->Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Type; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt">Amount of Current Monthly Mandatory Work Deductions (Not Taxes)</label>
                                    <input id="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt" type="number" class="form-control Op_Income_inputs" name="Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt" value="<?php if(isset($drincome->Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt)){ echo $drincome->Op_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlyDeduction(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt">N/A, Calculated = 12*Op_Inc_Monthly_Mandatory_Work_Deductions_NOT_TAXES_Amt</label>
                                    <input id="Op_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt" value="<?php if(isset($drincome->Op_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt)){ echo $drincome->Op_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Position">Work Position</label>
                                    <input id="Op_Position" type="text" class="form-control Op_Income_inputs" name="Op_Position" value="<?php if(isset($drincome->Op_Position)){ echo $drincome->Op_Position; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Weekly_Hours">Work Hours per Week</label>
                                    <input id="Op_Weekly_Hours" type="number" class="form-control Op_Income_inputs" name="Op_Weekly_Hours" value="<?php if(isset($drincome->Op_Weekly_Hours)){ echo $drincome->Op_Weekly_Hours; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Work_Phone">Work Phone</label>
                                    <input id="Op_Work_Phone" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Work_Phone" value="<?php if(isset($drincome->Op_Work_Phone)){ echo $drincome->Op_Work_Phone; } ?>" placeholder="(XXX) XXX-XXXX"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Yearly_Spousal_Support_Received_Not_This_Marriage">N/A, Calculated from dr_PersonalInfo * 12</label>
                                    <input id="Op_Yearly_Spousal_Support_Received_Not_This_Marriage" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Spousal_Support_Received_Not_This_Marriage" value="{{ $data['Op_Yearly_Spousal_Support_Received_Not_This_Marriage'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_SSI">Amount of Current Monthly SSI?</label>
                                    <input id="Op_Monthly_SSI" type="number" class="form-control Op_Income_inputs" name="Op_Monthly_SSI" value="<?php if(isset($drincome->Op_Monthly_SSI)){ echo $drincome->Op_Monthly_SSI; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlySSI(this, 'Op');">
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Yearly_SSI">N/A, Calculated = 12*Op_Monthly_SSI</label>
                                    <input id="Op_Yearly_SSI" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_SSI" value="<?php if(isset($drincome->Op_Yearly_SSI)){ echo $drincome->Op_Yearly_SSI; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Public_Assistance_Amt">Amount of Monthly Public Assistance?</label>
                                    <input id="Op_Monthly_Public_Assistance_Amt" type="number" class="form-control Op_Income_inputs" name="Op_Monthly_Public_Assistance_Amt" value="<?php if(isset($drincome->Op_Monthly_Public_Assistance_Amt)){ echo $drincome->Op_Monthly_Public_Assistance_Amt; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getYearlyPublicAssistanceAmt(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6" style="display: none;">
                                    <label for="Op_Yearly_Public_Assistance_Amt">N/A, Calculated = 12*Op_Inc_Monthly_Public_Assistance_Amt</label>
                                    <input id="Op_Yearly_Public_Assistance_Amt" type="number" class="form-control Op_Income_inputs" name="Op_Yearly_Public_Assistance_Amt" value="<?php if(isset($drincome->Op_Yearly_Public_Assistance_Amt)){ echo $drincome->Op_Yearly_Public_Assistance_Amt; } ?>" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="Op_Monthly_Gets_Child_Support_NoM">N/A, Calculated from dr_Children</label>
                                    <input id="Op_Monthly_Gets_Child_Support_NoM" type="number" class="form-control Op_Income_inputs" name="Op_Monthly_Gets_Child_Support_NoM" value="{{ $data['Op_Monthly_Gets_Child_Support_NoM'] }}" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Check if {{ $opponent_name }} has another Source of Income.</label>
                                    <div class="w-100 dataInput">
                                         <label><input type="checkbox" id="Op_Other_Source_Income" name="Op_Other_Source_Income" value="1" data-onload="hasAnotherSourceOfIncome(this, 'Op');" onchange="hasAnotherSourceOfIncome(this, 'Op');" <?php if(isset($drincome->Op_Other_Source_Income) && $drincome->Op_Other_Source_Income=='1'){ echo "checked"; } ?>> Yes</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Name1">Name of Other Source of Income #1</label>
                                    <input id="Op_Other_Source_Name1" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Other_Source_Name1" value="<?php if(isset($drincome->Op_Other_Source_Name1)){ echo $drincome->Op_Other_Source_Name1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 1_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Other_Source_Zip1">Other Source of Income #1 Zip Code?</label>
                                    <input id="Op_Other_Source_Zip1" type="text" class="form-control Op_Income_inputs 1_Op_Other_Income_inputs" name="Op_Other_Source_Zip1" value="<?php if(isset($drincome->Op_Other_Source_Zip1)){ echo $drincome->Op_Other_Source_Zip1; } ?>" onkeyup="getCityStateForZip(this, '1', 'Op');" data-onload="getCityStateForZip(this, '1', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Street_Address1">Other Source of Income #1 Street Address?</label>
                                    <input id="Op_Other_Source_Street_Address1" type="text" class="form-control Op_Income_inputs 1_Op_Other_Income_inputs" name="Op_Other_Source_Street_Address1" value="<?php if(isset($drincome->Op_Other_Source_Street_Address1)){ echo $drincome->Op_Other_Source_Street_Address1; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_City1">Other Source of Income #1 City?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_City1_Value" value="<?php if(isset($drincome->Op_Other_Source_City1)){ echo $drincome->Op_Other_Source_City1; } ?>">
                                    <select id="Op_Other_Source_City1" name="Op_Other_Source_City1" class="form-control 1_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_State1">Other Source of Income #1 State?</label>
                                     <input type="hidden" name="" id="Op_Other_Source_State1_Value" value="<?php if(isset($drincome->Op_Other_Source_State1)){ echo $drincome->Op_Other_Source_State1; } ?>">
                                    <select id="Op_Other_Source_State1" name="Op_Other_Source_State1" class="form-control 1_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Acct_Num_or_Description1">Account # or Description of Other Source of Income #1</label>
                                    <input id="Op_Other_Source_Acct_Num_or_Description1" type="text" class="form-control Op_Income_inputs 1_Op_Other_Income_inputs" name="Op_Other_Source_Acct_Num_or_Description1" value="<?php if(isset($drincome->Op_Other_Source_Acct_Num_or_Description1)){ echo $drincome->Op_Other_Source_Acct_Num_or_Description1; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Yearly_Income1">Yearly Amount of Other Source of Income #1</label>
                                    <input id="Op_Other_Source_Yearly_Income1" type="number" class="form-control Op_Income_inputs" name="Op_Other_Source_Yearly_Income1" value="<?php if(isset($drincome->Op_Other_Source_Yearly_Income1)){ echo $drincome->Op_Other_Source_Yearly_Income1; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Op');">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Name2">Name of Other Source of Income #2</label>
                                    <input id="Op_Other_Source_Name2" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Other_Source_Name2" value="<?php if(isset($drincome->Op_Other_Source_Name2)){ echo $drincome->Op_Other_Source_Name2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 2_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Other_Source_Zip2">Other Source of Income #2 Zip Code?</label>
                                    <input id="Op_Other_Source_Zip2" type="text" class="form-control Op_Income_inputs 2_Op_Other_Income_inputs" name="Op_Other_Source_Zip2" value="<?php if(isset($drincome->Op_Other_Source_Zip2)){ echo $drincome->Op_Other_Source_Zip2; } ?>" onkeyup="getCityStateForZip(this, '2', 'Op');" data-onload="getCityStateForZip(this, '2', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Street_Address2">Other Source of Income #2 Street Address?</label>
                                    <input id="Op_Other_Source_Street_Address2" type="text" class="form-control Op_Income_inputs 2_Op_Other_Income_inputs" name="Op_Other_Source_Street_Address2" value="<?php if(isset($drincome->Op_Other_Source_Street_Address2)){ echo $drincome->Op_Other_Source_Street_Address2; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_City2">Other Source of Income #2 City?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_City2_Value" value="<?php if(isset($drincome->Op_Other_Source_City2)){ echo $drincome->Op_Other_Source_City2; } ?>">
                                    <select id="Op_Other_Source_City2" name="Op_Other_Source_City2" class="form-control 2_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_State2">Other Source of Income #2 State?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_State2_Value" value="<?php if(isset($drincome->Op_Other_Source_State2)){ echo $drincome->Op_Other_Source_State2; } ?>">
                                    <select id="Op_Other_Source_State2" name="Op_Other_Source_State2" class="form-control 2_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Acct_Num_or_Description2">Account # or Description of Other Source of Income #2</label>
                                    <input id="Op_Other_Source_Acct_Num_or_Description2" type="text" class="form-control Op_Income_inputs 2_Op_Other_Income_inputs" name="Op_Other_Source_Acct_Num_or_Description2" value="<?php if(isset($drincome->Op_Other_Source_Acct_Num_or_Description2)){ echo $drincome->Op_Other_Source_Acct_Num_or_Description2; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Yearly_Income2">Yearly Amount of Other Source of Income #2</label>
                                    <input id="Op_Other_Source_Yearly_Income2" type="number" class="form-control Op_Income_inputs" name="Op_Other_Source_Yearly_Income2" value="<?php if(isset($drincome->Op_Other_Source_Yearly_Income2)){ echo $drincome->Op_Other_Source_Yearly_Income2; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Name3">Name of Other Source of Income #3</label>
                                    <input id="Op_Other_Source_Name3" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Other_Source_Name3" value="<?php if(isset($drincome->Op_Other_Source_Name3)){ echo $drincome->Op_Other_Source_Name3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 3_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Other_Source_Zip3">Other Source of Income #3 Zip Code?</label>
                                    <input id="Op_Other_Source_Zip3" type="text" class="form-control Op_Income_inputs 3_Op_Other_Income_inputs" name="Op_Other_Source_Zip3" value="<?php if(isset($drincome->Op_Other_Source_Zip3)){ echo $drincome->Op_Other_Source_Zip3; } ?>" onkeyup="getCityStateForZip(this, '3', 'Op');" data-onload="getCityStateForZip(this, '3', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Street_Address3">Other Source of Income #3 Street Address?</label>
                                    <input id="Op_Other_Source_Street_Address3" type="text" class="form-control Op_Income_inputs 3_Op_Other_Income_inputs" name="Op_Other_Source_Street_Address3" value="<?php if(isset($drincome->Op_Other_Source_Street_Address3)){ echo $drincome->Op_Other_Source_Street_Address3; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_City3">Other Source of Income #3 City?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_City3_Value" value="<?php if(isset($drincome->Op_Other_Source_City3)){ echo $drincome->Op_Other_Source_City3; } ?>">
                                    <select id="Op_Other_Source_City3" name="Op_Other_Source_City3" class="form-control 3_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_State3">Other Source of Income #3 State?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_State3_Value" value="<?php if(isset($drincome->Op_Other_Source_State3)){ echo $drincome->Op_Other_Source_State3; } ?>">
                                    <select id="Op_Other_Source_State3" name="Op_Other_Source_State3" class="form-control 3_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Acct_Num_or_Description3">Account # or Description of Other Source of Income #3</label>
                                    <input id="Op_Other_Source_Acct_Num_or_Description3" type="text" class="form-control Op_Income_inputs 3_Op_Other_Income_inputs" name="Op_Other_Source_Acct_Num_or_Description3" value="<?php if(isset($drincome->Op_Other_Source_Acct_Num_or_Description3)){ echo $drincome->Op_Other_Source_Acct_Num_or_Description3; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Yearly_Income3">Yearly Amount of Other Source of Income #3</label>
                                    <input id="Op_Other_Source_Yearly_Income3" type="number" class="form-control Op_Income_inputs" name="Op_Other_Source_Yearly_Income3" value="<?php if(isset($drincome->Op_Other_Source_Yearly_Income3)){ echo $drincome->Op_Other_Source_Yearly_Income3; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Name4">Name of Other Source of Income #4</label>
                                    <input id="Op_Other_Source_Name4" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Other_Source_Name4" value="<?php if(isset($drincome->Op_Other_Source_Name4)){ echo $drincome->Op_Other_Source_Name4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 4_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Other_Source_Zip4">Other Source of Income #4 Zip Code?</label>
                                    <input id="Op_Other_Source_Zip4" type="text" class="form-control Op_Income_inputs 4_Op_Other_Income_inputs" name="Op_Other_Source_Zip4" value="<?php if(isset($drincome->Op_Other_Source_Zip4)){ echo $drincome->Op_Other_Source_Zip4; } ?>" onkeyup="getCityStateForZip(this, '4', 'Op');" data-onload="getCityStateForZip(this, '4', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Street_Address4">Other Source of Income #4 Street Address?</label>
                                    <input id="Op_Other_Source_Street_Address4" type="text" class="form-control Op_Income_inputs 4_Op_Other_Income_inputs" name="Op_Other_Source_Street_Address4" value="<?php if(isset($drincome->Op_Other_Source_Street_Address4)){ echo $drincome->Op_Other_Source_Street_Address4; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_City4">Other Source of Income #4 City?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_City4_Value" value="<?php if(isset($drincome->Op_Other_Source_City4)){ echo $drincome->Op_Other_Source_City4; } ?>">
                                    <select id="Op_Other_Source_City4" name="Op_Other_Source_City4" class="form-control 4_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_State4">Other Source of Income #4 State?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_State4_Value" value="<?php if(isset($drincome->Op_Other_Source_State4)){ echo $drincome->Op_Other_Source_State4; } ?>">
                                    <select id="Op_Other_Source_State4" name="Op_Other_Source_State4" class="form-control 4_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Acct_Num_or_Description4">Account # or Description of Other Source of Income #4</label>
                                    <input id="Op_Other_Source_Acct_Num_or_Description4" type="text" class="form-control Op_Income_inputs 4_Op_Other_Income_inputs" name="Op_Other_Source_Acct_Num_or_Description4" value="<?php if(isset($drincome->Op_Other_Source_Acct_Num_or_Description4)){ echo $drincome->Op_Other_Source_Acct_Num_or_Description4; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Yearly_Income4">Yearly Amount of Other Source of Income #4</label>
                                    <input id="Op_Other_Source_Yearly_Income4" type="number" class="form-control Op_Income_inputs" name="Op_Other_Source_Yearly_Income4" value="<?php if(isset($drincome->Op_Other_Source_Yearly_Income4)){ echo $drincome->Op_Other_Source_Yearly_Income4; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Name5">Name of Other Source of Income #5</label>
                                    <input id="Op_Other_Source_Name5" type="text" class="form-control Op_Income_inputs phone_input" name="Op_Other_Source_Name5" value="<?php if(isset($drincome->Op_Other_Source_Name5)){ echo $drincome->Op_Other_Source_Name5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <p class="text-danger 5_Op_no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                    <label for="Op_Other_Source_Zip5">Other Source of Income #5 Zip Code?</label>
                                    <input id="Op_Other_Source_Zip5" type="text" class="form-control Op_Income_inputs 5_Op_Other_Income_inputs" name="Op_Other_Source_Zip5" value="<?php if(isset($drincome->Op_Other_Source_Zip5)){ echo $drincome->Op_Other_Source_Zip5; } ?>" onkeyup="getCityStateForZip(this, '5', 'Op');" data-onload="getCityStateForZip(this, '5', 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Street_Address5">Other Source of Income #5 Street Address?</label>
                                    <input id="Op_Other_Source_Street_Address5" type="text" class="form-control Op_Income_inputs 5_Op_Other_Income_inputs" name="Op_Other_Source_Street_Address5" value="<?php if(isset($drincome->Op_Other_Source_Street_Address5)){ echo $drincome->Op_Other_Source_Street_Address5; } ?>"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_City5">Other Source of Income #5 City?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_City5_Value" value="<?php if(isset($drincome->Op_Other_Source_City5)){ echo $drincome->Op_Other_Source_City5; } ?>">

                                    <select id="Op_Other_Source_City5" name="Op_Other_Source_City5" class="form-control 5_Op_city_select">
                                        <option value="">Choose City</option>
                                    </select>   
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_State5">Other Source of Income #5 State?</label>
                                    <input type="hidden" name="" id="Op_Other_Source_State5_Value" value="<?php if(isset($drincome->Op_Other_Source_State5)){ echo $drincome->Op_Other_Source_State5; } ?>">
                                    <select id="Op_Other_Source_State5" name="Op_Other_Source_State5" class="form-control 5_Op_state_select">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Acct_Num_or_Description5">Account # or Description of Other Source of Income #5</label>
                                    <input id="Op_Other_Source_Acct_Num_or_Description5" type="text" class="form-control Op_Income_inputs 5_Op_Other_Income_inputs" name="Op_Other_Source_Acct_Num_or_Description5" value="<?php if(isset($drincome->Op_Other_Source_Acct_Num_or_Description5)){ echo $drincome->Op_Other_Source_Acct_Num_or_Description5; } ?>">
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Source_Yearly_Income5">Yearly Amount of Other Source of Income #5</label>
                                    <input id="Op_Other_Source_Yearly_Income5" type="number" class="form-control Op_Income_inputs" name="Op_Other_Source_Yearly_Income5" value="<?php if(isset($drincome->Op_Other_Source_Yearly_Income5)){ echo $drincome->Op_Other_Source_Yearly_Income5; } ?>" min="0.00" step="0.01" max="999999.99" onchange="getOtherYearlyIncomeTotal(this, 'Op');"> 
                                </div>
                                <div class="form-group col-sm-6 Op_Other_Source_Income_Div" style="display: none;">
                                    <label for="Op_Other_Yearly_Income_Total">Total Yearly Amount of Other Sources of Income</label>
                                    <input id="Op_Other_Yearly_Income_Total" type="number" class="form-control Op_Income_inputs" name="Op_Other_Yearly_Income_Total" value="<?php if(isset($drincome->Op_Other_Yearly_Income_Total)){ echo $drincome->Op_Other_Yearly_Income_Total; } ?>" min="0.00" step="0.01" max="999999.99" readonly=""> 
                                </div>
                            </div>
                        </div>
                        <!-- End of Op Income Info Section -->


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

// If Client or Opponent are Employed
function isEmployed(employed, type){
    if(employed.checked && employed.value=='Yes'){
        $('.'+type+'_is_Employed_Div').show();
    } 
    if(employed.checked && employed.value=='No'){
        $('.'+type+'_is_Employed_Div').hide();
        $('.'+type+'_is_Employed_Div input').val('');
    }
}

function onInitialMinWageChange(wagetype, type){
    $('.'+type+'_RegWage_YTD_MinWage_Div').hide();
    if(wagetype.value){
        $('.'+type+'_RegWage_YTD_MinWage_'+wagetype.value+'_Div').show();
        // $("#"+type+"_Base_Yearly_Wages").prop("readonly", true).val('0.00');
    }
    if(wagetype.value && wagetype.value=='3'){
        // $("#"+type+"_Base_Yearly_Wages").prop("readonly", true).val('17100.00');
    }
}

function onMinWageChange(wagetype, type){
    $('.'+type+'_RegWage_YTD_MinWage_Div').hide();
    $('.'+type+'_RegWage_YTD_MinWage_Div input[type="number"]').val('0.00');
    if(wagetype.value){
        $('.'+type+'_RegWage_YTD_MinWage_'+wagetype.value+'_Div').show();
        $("#"+type+"_Base_Yearly_Wages").prop("readonly", true).val('0.00');
    }
    if(wagetype.value && wagetype.value=='3'){
        $("#"+type+"_Base_Yearly_Wages").prop("readonly", true).val('17100.00');
    }
}


function calculateBaseYearlyWagesByPerYear(inputdata, type){
    calcuAnnualGrossIncome('frequency', type);
}

function calculateBaseYearlyWagesByYTDPayDate(inputdata, type){
    calcuAnnualGrossIncome('ytd_date', type);
}

function calcuAnnualGrossIncome(type, usertype){ 
    //var minWage = "<?php //echo isset($other_data['OH_Minimum_Wage'])?$other_data['OH_Minimum_Wage']:''?>";
    var tmpAmount='';

    var amount= document.getElementById(""+usertype+"_Wages_per_Period").value;
    if (amount != undefined && amount != '') {

    } else {
      amount = 2000;
    }

    if (type=='frequency')
    {
      var frequencyForObligee = $('#'+usertype+'_Pay_Periods_Yearly').val();
      tmpAmount = amount * frequencyForObligee;
      $("#"+usertype+"_Base_Yearly_Wages").prop("readonly", true).val(parseFloat(tmpAmount).toFixed(2));

    } else if (type=='ytd_date') {
      var amount= document.getElementById(""+usertype+"_Pay_YTD").value;
      if (amount != undefined && amount != '') {

      } else {
        amount = 2000;
      }
      var obligee_1_Datepick = $("#"+usertype+"_YTD_Date").val();

      var currentDate = new Date(obligee_1_Datepick);
      var first = new Date(currentDate.getFullYear(), 0, 1);
      var theDay = Math.round(((currentDate - first) / 1000 / 60 / 60 / 24) + .5, 0);

      if(isNaN(theDay))
      {
      }
      else
      {
        tmpAmount = amount * (365/theDay);
      }

      $("#"+usertype+"_Base_Yearly_Wages").prop("readonly", true).val(parseFloat(tmpAmount).toFixed(2));
    }
}

function getMinAvgCommBonuses(inputdata, type){
    var most_recent=$('#'+type+'_Most_Recent_Yearly_OT_Comms_Bonuses').val();
    var second_most_recent=$('#'+type+'_Second_Most_Recent_Yearly_OT_Comms_Bonuses').val();
    var third_most_recent=$('#'+type+'_Third_Most_Recent_Yearly_OT_Comms_Bonuses').val();
    most_recent=parseFloat(most_recent).toFixed(2);
    second_most_recent=parseFloat(second_most_recent).toFixed(2);
    third_most_recent=parseFloat(third_most_recent).toFixed(2);
    var avg_bonuses = Math.min(most_recent,((+most_recent)+(+second_most_recent)+(+third_most_recent))/3);
    avg_bonuses=parseFloat(avg_bonuses).toFixed(2);
    $('#'+type+'_Min_Ave_OT_Comms_Bonuses').val(avg_bonuses);
}

function getYearlyDeduction(inputdata, type){
    var per_month_amt=inputdata.value;
    per_month_amt=parseFloat(per_month_amt).toFixed(2);
    per_month_amt=12*per_month_amt;
    $('#'+type+'_Yearly_Mandatory_Work_Deductions_NOT_TAXES_Amt').val(per_month_amt);
}

function getYearlySSI(inputdata, type){
    var per_month_amt=inputdata.value;
    per_month_amt=parseFloat(per_month_amt).toFixed(2);
    per_month_amt=12*per_month_amt;
    $('#'+type+'_Yearly_SSI').val(per_month_amt);
}

function getYearlyPublicAssistanceAmt(inputdata, type){
    var per_month_amt=inputdata.value;
    per_month_amt=parseFloat(per_month_amt).toFixed(2);
    per_month_amt=12*per_month_amt;
    $('#'+type+'_Yearly_Public_Assistance_Amt').val(per_month_amt);
}

function hasAnotherSourceOfIncome(inputdata, type){
    if(inputdata.checked && inputdata.value=='1'){
        $('.'+type+'_Other_Source_Income_Div').show();
    } else {
        $('.'+type+'_Other_Source_Income_Div').hide();
    }
}

function getOtherYearlyIncomeTotal(inputdata, type){
    var first_income=$('#'+type+'_Other_Source_Yearly_Income1').val();
    var second_income=$('#'+type+'_Other_Source_Yearly_Income2').val();
    var third_income=$('#'+type+'_Other_Source_Yearly_Income3').val();
    var fourth_income=$('#'+type+'_Other_Source_Yearly_Income4').val();
    var fifth_income=$('#'+type+'_Other_Source_Yearly_Income5').val();
    first_income=parseFloat(first_income).toFixed(2);
    second_income=parseFloat(second_income).toFixed(2);
    third_income=parseFloat(third_income).toFixed(2);
    fourth_income=parseFloat(fourth_income).toFixed(2);
    fifth_income=parseFloat(fifth_income).toFixed(2);

    var total_other_income=(+first_income)+(+second_income)+(+third_income)+(+fourth_income)+(+fifth_income);
    total_other_income=parseFloat(total_other_income).toFixed(2);
    $('#'+type+'_Other_Yearly_Income_Total').val(total_other_income);
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

                    var slctd_city=$('#'+ziptype+'_Other_Source_City'+zipinputnum+'_Value').val();
                    if(slctd_city){
                        $('.'+zipclass+'_city_select option[value="'+slctd_city+'"]').attr('selected','selected');
                    }

                    var slctd_state=$('#'+ziptype+'_Other_Source_State'+zipinputnum+'_Value').val();
                    if(slctd_state){
                        $('.'+zipclass+'_state_select option[value="'+slctd_state+'"]').attr('selected','selected');
                    }
                    $('.'+zipclass+'_no-state-county-found').hide();
                }
            }
        });        
    }

}


// format amounts to currency inputs
const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

$(document).ready(function(){

    $('#dr_Income').validate({
        rules: {
            Client_Work_Phone: {
                // phoneUS: true
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
            Op_Work_Phone: {
                // phoneUS: true
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
        }
    });

    $('[data-onload]').each(function(){
        eval($(this).data('onload'));
    });

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

    // $('input[type="text"]').rules("add", { 
    //       maxlength:255
    // });
});
</script>   
@endsection