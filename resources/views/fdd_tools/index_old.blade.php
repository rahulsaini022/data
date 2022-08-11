@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('FDD Tools') }}</strong></div>
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

                    <div class="row"> 

                        <div class="col-sm-12 fdd-quick-child-support-section">
                            <label class="fdd-tools-main-label">FDD Quick Child Support</label>
                            <form method="POST" action="#" id="computation_sheet_form">
                                @csrf
                                <input type="hidden" id="selected_state" value="{{$attorney_data->state_id}}">
                                <div class="row">
                                    <div class="col-sm-3 column-box-width">    
                                        <select id="sheet_state" name="sheet_state" class="form-control" required="" autofocus="">
                                            <option value="">Choose State</option>
                                        </select>           
                                    </div>
                                    <div class="col-sm-3 column-box-width">    
                                        <select id="sheet_custody" name="sheet_custody" class="form-control" required="" autofocus="">
                                            <option value="">Choose Custody</option>
                                            <option value="sole">Sole</option>
                                            <option value="shared">Shared</option>
                                            <option value="split">Split</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 column-box-width prefill-check">        
                                        <input type="checkbox" name="chk_prefill" id="chk_prefill" value="1" checked=""><label for="chk_prefill" class="chk_prefill" >Prefill with my last submission.</label>
                                    </div>  
                                    <div class="col-sm-3 column-box-width">        
                                        <input type="submit" id="computation-btn" class="btn btn-success btn-computation new-btn new-btn-green" value="FDD Quick
                                        Child Computation Worksheet">       
                                    </div>
                                </div>  
                            </form>
                        </div>

                        <div class="col-sm-12 annual-income-calculation-section">
                            <label class="fdd-tools-main-label">Annual Income Calculation</label>
                            <div class="row">
                                <div class="col-sm-3 column-box-width">
                                    <input type="number" class="form-control" id="annual_income_amount" name="annual_income_amount" value="" placeholder="Amount" value="0.00" min="0.00" step="0.01" autocomplete="off" onchange="onAmountChange(this);" onkeyup="onAmountChange(this);">           
                                </div>
                                <div class="col-sm-3 column-box-width annual_column">
                                    <input type="radio" id="annual_income_income_frequency_radio" name="annual_income_income_frequency_ytd_radio" class="annual_income_radio" value="frequency" onchange="onAnnlIncmCalcFrequenceYtdRadioChange(this,'annual_income_income_frequency', 'ytd_date', 'frequency')" autocomplete="off">
                                    <select id="annual_income_income_frequency" name="annual_income_income_frequency" class="form-control annual_income_inputs" disabled="" onchange="onAnnlIncmCalcFrequenceChange(this)" autocomplete="off">
                                        <option value="0" selected="">Frequency</option>
                                        <option value="1">Yearly</option>
                                        <option value="12">Monthly</option>
                                        <option value="24">Bi-Monthly</option>
                                        <option value="26">Bi-Weekly</option>
                                        <option value="52">Weekly</option>
                                    </select>           
                                </div>
                                <div class="col-sm-3 column-box-width annual_column">
                                    <input type="radio" id="annual_income_ytd_radio" name="annual_income_income_frequency_ytd_radio" class="annual_income_radio" value="ytd_date_radio" onchange="onAnnlIncmCalcFrequenceYtdRadioChange(this,'ytd_date', 'annual_income_income_frequency' , 'ytd_date')" autocomplete="off">
                                    <input type="text" class="form-control hasDatepicker annual_income_inputs" id="ytd_date" name="ytd_date" value="" placeholder="YTD (Date)" disabled="" onchange="onAnnlIncmCalcYtdDateChange(this)" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>          
                                </div>
                                <div class="col-sm-3 column-box-width">
                                    <input type="number" class="form-control" id="annual_income_annual_pay" name="annual_income_annual_pay" value="" placeholder="Annual Pay" readonly="" autocomplete="off">           
                                </div>
                            </div>
                        </div>   

                        <div class="col-sm-12 time-money-payments-section">
                            <label class="fdd-tools-main-label">Time/Money/Payments</label>
                            <h6>Loan/Finance</h6>
                            <div class="row loan-finance-main">
                                <!-- <div class="col-sm-4 column-box-width">
                                    <input type="text" class="form-control hasDatepicker" id="tmp_first_payment_date" name="tmp_first_payment_date" value="" placeholder="First Payment Date">      
                                     <i class="fa fa-calendar" aria-hidden="true"></i>         
                                </div> -->
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Frequency</label>
                                    <select id="payments_frequency_loan_finance" name="payments_frequency_loan_finance" class="form-control" onchange="calculatePaymentAmountForLoanFinance(this);">
                                        <option value="0" selected="">Select</option>
                                        <option value="1">Yearly</option>
                                        <option value="12">Monthly</option>
                                        <option value="24">Bi-Monthly</option>
                                        <option value="26">Bi-Weekly</option>
                                        <option value="52">Weekly</option>
                                    </select>           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Number of Payments</label>
                                    <input type="number" class="form-control" id="number_of_payments_loan_finance" name="number_of_payments_loan_finance" value="" placeholder="Number of Payments" onchange="calculatePaymentAmountForLoanFinance(this);" onkeyup="calculatePaymentAmountForLoanFinance(this);">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Yearly Rate1 (%)</label>
                                    <input type="number" class="form-control" id="yearly_rate_loan_finance" name="yearly_rate_loan_finance" value="" placeholder="Yearly Rate1 (%)" onchange="calculatePaymentAmountForLoanFinance(this);" onkeyup="calculatePaymentAmountForLoanFinance(this);" min="0.00" max="100">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Amount Loaned or Financed</label>
                                    <input type="number" class="form-control" id="amount_loaned_financed_loan_finance" name="amount_loaned_financed_loan_finance" value="" placeholder="Amount Loaned or Financed" onchange="calculatePaymentAmountForLoanFinance(this);" onkeyup="calculatePaymentAmountForLoanFinance(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="payment_amount_loan_finance" name="payment_amount_loan_finance" value="" placeholder="Payment Amount" readonly="">
                                </div>
                            </div>
                            <h6>Annuity</h6>
                            <div class="row annuity-main">
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Frequency</label>
                                    <select id="payments_frequency_annuity" name="payments_frequency_annuity" class="form-control" onchange="calculatePaymentAmountForAnnuity(this);">
                                        <option value="0" selected="">Select</option>
                                        <option value="1">Yearly</option>
                                        <option value="12">Monthly</option>
                                        <option value="24">Bi-Monthly</option>
                                        <option value="26">Bi-Weekly</option>
                                        <option value="52">Weekly</option>
                                    </select>           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Number of Payments</label>
                                    <input type="number" class="form-control" id="number_of_payments_annuity" name="number_of_payments_annuity" value="" placeholder="Number of Payments" onchange="calculatePaymentAmountForAnnuity(this);" onkeyup="calculatePaymentAmountForAnnuity(this);">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Estimated Yearly Rate1 (%)</label>
                                    <input type="number" class="form-control" id="yearly_rate_annuity" name="yearly_rate_annuity" value="" placeholder="Estimated Yearly Rate1 (%)" onchange="calculatePaymentAmountForAnnuity(this);" onkeyup="calculatePaymentAmountForAnnuity(this);" min="0.00" max="100">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="payment_amount_annuity" name="payment_amount_annuity" value="" placeholder="Payment Amount" onchange="calculatePaymentAmountForAnnuity(this);" onkeyup="calculatePaymentAmountForAnnuity(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>First Payment Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="first_payment_date_annuity" name="first_payment_date_annuity" value="" placeholder="First Payment Date" onchange="calculatePaymentAmountForAnnuity(this);" autocomplete="off">
                                    <!-- <i class="fa fa-calendar" aria-hidden="true"></i> -->
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Present Value (On First Payment Date)</label>
                                    <input type="number" class="form-control" id="present_value_on_first_payment_date_annuity" name="present_value_on_first_payment_date_annuity" value="" placeholder="Present Value (On First Payment Date)" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Months Before First Payment</label>
                                    <input type="number" class="form-control" id="months_before_first_payment_annuity" name="months_before_first_payment_annuity" value="" placeholder="Months Before First Payment" readonly="">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Net Present Value (on Today’s Date)</label>
                                    <input type="number" class="form-control" id="net_present_value_todays_date_annuity" name="net_present_value_todays_date_annuity" value="" placeholder="Net Present Value (on Today’s Date)" readonly="">           
                                </div>
                            </div>
                            <h6>Estimate Pension Benefits and Buyouts</h6>
                            <input type="hidden" name="" id="months_diff_of_B13_and_today">
                            <input type="hidden" name="" id="months_diff_of_B15_and_today">
                            <div class="row estimate_pension_benefits_and_buyouts-main">
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Birth Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="pensioners_birth_date_epbab" name="pensioners_birth_date_epbab" value="" placeholder="Pensioner’s Birth Date" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" autocomplete="off">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Life Expectancy of Pensioner</label>
                                    <input type="number" class="form-control" id="life_expectancy_of_pensioner_epbab" name="life_expectancy_of_pensioner_epbab" value="" placeholder="Life Expectancy of Pensioner" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Birth Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="pensioners_spouse_birth_date_epbab" name="pensioners_spouse_birth_date_epbab" value="" placeholder="Pensioner’s Spouse’s Birth Date" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" autocomplete="off">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Life Expectancy of Pensioner’s Spouse</label>
                                    <input type="number" class="form-control" id="life_expectancy_of_pensioners_spouse_epbab" name="life_expectancy_of_pensioners_spouse_epbab" value="" placeholder="Life Expectancy of Pensioner’s Spouse" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Retirement Age</label>
                                    <input type="number" class="form-control" id="pensioners_retirement_age_epbab" name="pensioners_retirement_age_epbab" value="" placeholder="Pensioner’s Retirement Age" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Estimated Monthly Pension Payment</label>
                                    <input type="number" class="form-control" id="estimated_monthly_pension_payment_epbab" name="estimated_monthly_pension_payment_epbab" value="" placeholder="Estimated Monthly Pension Payment" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Share %</label>
                                    <input type="number" class="form-control" id="pensioners_spouse_share_epbab" name="pensioners_spouse_share_epbab" value="" placeholder="Pensioner’s Spouse’s Share %" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Survivorship Benefit %</label>
                                    <input type="number" class="form-control" id="survivorship_benefit_epbab" name="survivorship_benefit_epbab" value="" placeholder="Survivorship Benefit %" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthlly Survivorship Cost Total</label>
                                    <input type="number" class="form-control" id="monthly_survivorship_cost_total_epbab" name="monthly_survivorship_cost_total_epbab" value="" placeholder="Monthlly Survivorship Cost Total" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthly Pensioner Cost of Survivorship</label>
                                    <input type="number" class="form-control" id="monthly_pensioner_cost_of_survivorship_epbab" name="monthly_pensioner_cost_of_survivorship_epbab" value="" placeholder="Monthly Pensioner Cost of Survivorship" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthly Pensioner Spouse Cost of Survivorship</label>
                                    <input type="number" class="form-control" id="monthly_pensioner_spouse_cost_of_survivorship_epbab" name="monthly_pensioner_spouse_cost_of_survivorship_epbab" value="" placeholder="Monthly Pensioner Spouse Cost of Survivorship" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>10-Year Treasure Rate</label>
                                    <input type="number" class="form-control" id="ten_year_treasury_epbab" name="ten_year_treasury_epbab" value="" placeholder="10-Year Treasure Rate" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" onkeyup="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
                                </div>
                                <h6 class="col-sm-12" style="color: #0cb521;">Pensioner’s DIVIDED Pension</h6>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Divided Monthly Benefit</label>
                                    <input type="number" class="form-control" id="divided_pensioners_monthly_benefit_epbab" name="divided_pensioners_monthly_benefit_epbab" value="" placeholder="Pensioner’s Divided Monthly Benefit" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Months of Pensioner’s Benefit</label>
                                    <input type="number" class="form-control" id="divided_months_of_pensioners_benefit_epbab" name="divided_months_of_pensioners_benefit_epbab" value="" placeholder="Months of Pensioner’s Benefit" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Value as of Retirement Date</label>
                                    <input type="number" class="form-control" id="divided_pensioners_value_as_of_retirement_date_epbab" name="divided_pensioners_value_as_of_retirement_date_epbab" value="" placeholder="Pensioner’s Value as of Retirement Date" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Value as of Today Date</label>
                                    <input type="number" class="form-control" id="divided_pensioners_value_as_of_todays_date_epbab" name="divided_pensioners_value_as_of_todays_date_epbab" value="" placeholder="Pensioner’s Value as of Today Date" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Divided Monthly Benefit</label>
                                    <input type="number" class="form-control" id="divided_pensioners_spouse_monthly_benefit_epbab" name="divided_pensioners_spouse_monthly_benefit_epbab" value="" placeholder="Pensioner’s Spouse’s Divided Monthly Benefit (with Survivorship Cost)" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Months of Pensioner’s Spouse Benefit</label>
                                    <input type="number" class="form-control" id="divided_months_of_pensioners_spouse_benefit_epbab" name="divided_months_of_pensioners_spouse_benefit_epbab" value="" placeholder="Months of Pensioner’s Spouse Benefit (with Survivorship Cost)" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Monthly Survivorship Benefit</label>
                                    <input type="number" class="form-control" id="divided_pensioners_spouse_monthly_survivorship_benefit_epbab" name="divided_pensioners_spouse_monthly_survivorship_benefit_epbab" value="" placeholder="Pensioner’s Spouse’s Monthly Survivorship Benefit (without Survivorship Cost)" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Additional Months for Pensioner’s Spouse</label>
                                    <input type="number" class="form-control" id="divided_additional_months_for_pensioners_spouse_epbab" name="divided_additional_months_for_pensioners_spouse_epbab" value="" placeholder="Additional Months for Pensioner’s Spouse (without Survivorship Cost)" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Value as of Retirement Date</label>
                                    <input type="number" class="form-control" id="divided_pensioners_spouse_value_as_of_retirement_date_epbab" name="divided_pensioners_spouse_value_as_of_retirement_date_epbab" value="" placeholder="Pensioner’s Spouse’s Value as of Retirement Date" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Value as of Today Date</label>
                                    <input type="number" class="form-control" id="divided_pensioners_spouse_value_as_of_todays_date_epbab" name="divided_pensioners_spouse_value_as_of_todays_date_epbab" value="" placeholder="Pensioner’s Spouse’s Value as of Today Date" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Cost of Division with Survivorship</label>
                                    <input type="number" class="form-control" id="divided_cost_of_division_with_survivorship_epbab" name="divided_cost_of_division_with_survivorship_epbab" value="" placeholder="Cost of Division with Survivorship" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Cost of Division with Survivorship</label>
                                    <input type="number" class="form-control" id="divided_pensioners_cost_of_division_with_survivorship_epbab" name="divided_pensioners_cost_of_division_with_survivorship_epbab" value="" placeholder="Pensioner’s Cost of Division with Survivorship" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse‘s Cost of Division with Survivorship</label>
                                    <input type="number" class="form-control" id="divided_pensioners_spouse_cost_of_division_with_survivorship_epbab" name="divided_pensioners_spouse_cost_of_division_with_survivorship_epbab" value="" placeholder="Pensioner’s Spouse‘s Cost of Division with Survivorship" readonly="">
                                </div>
                                <h6 class="col-sm-12" style="color: #0cb521;">Pensioner’s UNDIVIDED Pension</h6>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Undivided Monthly Benefit</label>
                                    <input type="number" class="form-control" id="undivided_pensioners_monthly_benefit_epbab" name="undivided_pensioners_monthly_benefit_epbab" value="" placeholder="Pensioner’s Undivided Monthly Benefit" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Months of Pensioner’s Benefit</label>
                                    <input type="number" class="form-control" id="undivided_months_of_pensioners_benefit_epbab" name="undivided_months_of_pensioners_benefit_epbab" value="" placeholder="Months of Pensioner’s Benefit" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Value as of Retirement Date</label>
                                    <input type="number" class="form-control" id="undivided_pensioners_value_as_of_retirement_date_epbab" name="undivided_pensioners_value_as_of_retirement_date_epbab" value="" placeholder="Pensioner’s Value as of Retirement Date" readonly="">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Value as of Today Date</label>
                                    <input type="number" class="form-control" id="undivided_pensioners_value_as_of_todays_date_epbab" name="undivided_pensioners_value_as_of_todays_date_epbab" value="" placeholder="Pensioner’s Value as of Today Date" readonly="">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 squeeze-a-pdf-section">
                            <label class="fdd-tools-main-label">Squeeze a pdf</label>
                            <form method="POST" action="{{ route('squeez_pdf') }}" id="squeez_pdf_form" enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="col-sm-4 column-box-width">
                                        <input type="file" name="file_to_compress" id="file_to_compress" accept="application/pdf" required="">
                                    </div>
                                    <div class="col-sm-4 column-box-width">
                                        <select id="compress_level" name="compress_level" class="form-control">
                                            <option value="low">Low</option>
                                            <option value="recommended" selected="">Recommended</option>
                                            <option value="extreme">Extreme</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 column-box-width">
                                        <input type="submit" class="btn btn-info new-btn" id="squeeze_download_file" name="squeeze_download_file" value="Submit File">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-12 strip-a-pdf-section">
                            <label class="fdd-tools-main-label">Strip a pdf</label>
                            <form method="POST" action="{{ route('strip_pdf') }}" id="strip_pdf_form" enctype="multipart/form-data">
                                <div class="row">
                                    @csrf
                                    <div class="col-sm-4 column-box-width">
                                        <input type="file" name="file_to_strip" id="file_to_strip" accept="application/pdf" required="">
                                    </div>
                                    <div class="col-sm-4 column-box-width">
                                        <input type="text" name="strip_range" id="strip_range" class="form-control" placeholder="Enter Range" required="">
                                    </div>

                                    <div class="col-sm-4 column-box-width">
                                        <input type="submit" class="btn btn-info new-btn" id="squeeze_download_file" name="squeeze_download_file" value="Submit File">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/polyfiller.js') }}"></script>

<script type="text/javascript">
    // to conver number to currency
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');


    // on Annual income Amount change
    function onAmountChange(input){
        if(input.value ==''){
            $('#annual_income_annual_pay, #ytd_date').val('');
            $('.annual_income_radio').prop("checked", false);
            $('#annual_income_income_frequency option[value="0"]').prop("selected","selected");
            $('#annual_income_income_frequency, #ytd_date').prop("disabled", true);

        }
    }
    // on Annual Income Calculation frequency or ytd date radio change
    function onAnnlIncmCalcFrequenceYtdRadioChange(freqytdradio, enableid, disableid, type){
        if($('#annual_income_amount').val() == ''){
            alert('Enter Amount First');
            $(freqytdradio).prop("checked", false);
            return false;
        }
        if(freqytdradio.checked){
            $('#'+enableid+'').prop("disabled", false);
            $('#'+disableid+'').prop("disabled", true);
        }
        if(freqytdradio.value != undefined && freqytdradio.value != '') {
            if($('#annual_income_ytd_radio').is(":checked") && $('#ytd_date').val()==''){
            } else {
                calcuAnnualGrossIncome(type);
            }
        }
    }

    // on Annual Income Calculation frequency change
    function onAnnlIncmCalcFrequenceChange(frequency){
        var fixAmount='';

        if ($("#annual_income_income_frequency_radio").is(":checked"))
        {
          fixAmount = document.getElementById("annual_income_amount").value;

        }

        if (fixAmount == '')
        {
          alert('Please enter the amount first.');
          return false;

        } else {

          calcuAnnualGrossIncome('frequency');
        }
    }

    // on Annual Income Calculation ytd date change
    function onAnnlIncmCalcYtdDateChange(ytddate){
        var fixAmount='';

        if ($("#annual_income_ytd_radio").is(":checked"))
        {
          fixAmount = document.getElementById("annual_income_amount").value;

        }

        if (fixAmount == '')
        {
          alert('Please enter the amount first.');
          return false;

        } else {
            calcuAnnualGrossIncome('ytd_date');
        }
    }

    // calculate Annual Gross Income
    function calcuAnnualGrossIncome(type){ 
        //var minWage = "<?php //echo isset($other_data['OH_Minimum_Wage'])?$other_data['OH_Minimum_Wage']:''?>";
        var tmpAmount='';

        var obligeeMinWageCheck = $("#obligee_1_ohio_minimum_wage");
        var obligeeYtdCheckDate = $("#obligee_1_ytd_chk_date");
        var obligeeCheckYear = $("#obligee_1_checks_year");

        var amount= document.getElementById("annual_income_amount").value;
        if (amount != undefined && amount != '') {

        } else {
          amount = 2000;
        }

        if (type=='frequency')
        {
          var frequencyForObligee = $('#annual_income_income_frequency').val();
          tmpAmount = amount * frequencyForObligee;

          $("#annual_income_annual_pay").prop("readonly", true).val(tmpAmount.toFixed(2));

        } else if (type=='ytd_date') {

          var obligee_1_Datepick = $("#ytd_date").val();

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

          $("#annual_income_annual_pay").prop("readonly", true).val(tmpAmount.toFixed(2));
        }
    }

    // Calculate Payment Amount For Loan/Finance
    function calculatePaymentAmountForLoanFinance(value){
        var frequency=$('#payments_frequency_loan_finance').val();
        var number_of_payments=$('#number_of_payments_loan_finance').val();
        var yearly_rate=$('#yearly_rate_loan_finance').val();
        var amount_loaned_financed=$('#amount_loaned_financed_loan_finance').val();
        amount_loaned_financed=parseFloat(amount_loaned_financed).toFixed(2);
        if(frequency && frequency > 0 && number_of_payments && !isNaN(number_of_payments) && yearly_rate && !isNaN(yearly_rate) && amount_loaned_financed && !isNaN(amount_loaned_financed)){
            var B2=parseFloat(frequency).toFixed(2);
            var B3=parseFloat(number_of_payments).toFixed(2);
            var B4=parseFloat(yearly_rate/100).toFixed(2);
            var B5=parseFloat(amount_loaned_financed).toFixed(2);
            // var B6=B5*((B4/B2)*(1+B4/B2)^B3)/(((1+B4/B2)^B3)-1);
            var B4_by_B2=(B4/B2);
            var B4_by_B2_add_1=B4_by_B2+1;
            var B4_by_B2_add_1_power_B3=Math.pow(B4_by_B2_add_1, B3);
            
            var numerator=B5*B4_by_B2*B4_by_B2_add_1_power_B3;
            var denominator=B4_by_B2_add_1_power_B3-1;
            var B6=(numerator/denominator);
            var payment_amount=parseFloat(B6).toFixed(2);
            $('#payment_amount_loan_finance').val(payment_amount);
        }
    }

    // Calculate Payment Amount For Annuity
    function calculatePaymentAmountForAnnuity(value){
        var frequency=$('#payments_frequency_annuity').val();
        var number_of_payments=$('#number_of_payments_annuity').val();
        var yearly_rate=$('#yearly_rate_annuity').val();
        var payment_amount=$('#payment_amount_annuity').val();
        amount_loaned_financed=parseFloat(payment_amount).toFixed(2);
        var first_payment_date=  $('#first_payment_date_annuity').val();

        if(frequency && frequency > 0 && number_of_payments && !isNaN(number_of_payments) && yearly_rate && !isNaN(yearly_rate) && payment_amount && !isNaN(payment_amount)){
            var E2=parseFloat(frequency).toFixed(2);
            var E3=parseFloat(number_of_payments).toFixed(2);
            var E4=parseFloat(yearly_rate/100).toFixed(2);
            var E5=parseFloat(payment_amount).toFixed(2);
            var E6=first_payment_date;
            // var E7=E5*(1-(1+E4/E2)^-E3)/(E4/E2);
            var E4_by_E2=(E4/E2);
            var E4_by_E2_add_1=E4_by_E2+1;
            var E4_by_E2_add_1_power_minus_E3=Math.pow(E4_by_E2_add_1, -(E3));
            var one_sub_E4_by_E2_add_1_power_minus_E3=1-E4_by_E2_add_1_power_minus_E3;
            var numerator_for_E7=(E5) * (one_sub_E4_by_E2_add_1_power_minus_E3);
            var denominator_for_E7=E4_by_E2;
            var E7=(numerator_for_E7/denominator_for_E7);
            var E7=parseFloat(E7).toFixed(2);
            $('#present_value_on_first_payment_date_annuity').val(E7);
            if(frequency && frequency > 0 && number_of_payments && !isNaN(number_of_payments) && yearly_rate && !isNaN(yearly_rate) && payment_amount && !isNaN(payment_amount) && E6 && E6 !=''){
                // E8=MONTHS(TODAY();E6;0);
                // var E6 = new Date(E6);
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();
                today = mm + '/' + dd + '/' + yyyy; 
                var token= $('input[name=_token]').val();
                var E8 = 0;
                if (today && E6) {
                    $.ajax({
                        url:"{{route('ajax_get_months_diff')}}",
                        method:"POST",
                        // dataType: 'json',
                        data:{
                            max_date: E6, 
                            min_date: today, 
                            _token: token,
                        },
                        success: function(data){
                            console.log(data);
                            if(data=='null' || data==''){
                            } else {
                                E8=data;
                                $('#months_before_first_payment_annuity').val(E8);
                                var E8=$('#months_before_first_payment_annuity').val();
                                var numerator_for_E9=E7;
                                var denominator_for_E9=Math.pow(E4_by_E2_add_1, E8);
                                var E9=(numerator_for_E9/denominator_for_E9);
                                var E9=parseFloat(E9).toFixed(2);

                                $('#net_present_value_todays_date_annuity').val(E9);
                            }
                        }
                    });
                }
                // E9=E7/(1+(E4/E2))^E8;
                // var E8=$('#months_before_first_payment_annuity').val();
                // var numerator_for_E9=E7;
                // var denominator_for_E9=Math.pow(E4_by_E2_add_1, E8);
                // var E9=(numerator_for_E9/denominator_for_E9);
                // var E9=parseFloat(E9).toFixed(2);

                // $('#net_present_value_todays_date_annuity').val(E9);
            }
        }
    }

    // Estimate Pension Benefits and Buyouts Calculations
    function calculateEstimatePensionBenefitsAndBuyouts(value){
        var pensioners_birth_date=$('#pensioners_birth_date_epbab').val();
        var life_expectancy_of_pensioner=$('#life_expectancy_of_pensioner_epbab').val();
        var pensioners_spouse_birth_date=$('#pensioners_spouse_birth_date_epbab').val();
        var life_expectancy_of_pensioners_spouse=$('#life_expectancy_of_pensioners_spouse_epbab').val();
        var pensioners_retirement_age=$('#pensioners_retirement_age_epbab').val();
        var estimated_monthly_pension_payment=$('#estimated_monthly_pension_payment_epbab').val();
        var pensioners_spouse_share=$('#pensioners_spouse_share_epbab').val();
        if(pensioners_spouse_share && !isNaN(pensioners_spouse_share)){
        } else {
            var pensioners_spouse_share=0;
        }
        var survivorship_benefit=$('#survivorship_benefit_epbab').val();
        if(survivorship_benefit && !isNaN(survivorship_benefit)){
            // if(pensioners_spouse_share && !isNaN(pensioners_spouse_share)){
            //     if(survivorship_benefit > pensioners_spouse_share){
            //         alert('Survivorship Benefit % should be Less than Equal to Pensioner’s Spouse’s Share %');
            //         var survivorship_benefit=0;
            //         $('#survivorship_benefit_epbab').val(survivorship_benefit);
            //     }
            // } else {
            // }
        } else {
            var survivorship_benefit=0;
        }
        var monthly_survivorship_cost_total=$('#monthly_survivorship_cost_total_epbab').val();
        var monthly_pensioner_cost_of_survivorship=$('#monthly_pensioner_cost_of_survivorship_epbab').val();
        var monthly_pensioner_spouse_cost_of_survivorship=$('#monthly_pensioner_spouse_cost_of_survivorship_epbab').val();
        var ten_year_treasury=$('#ten_year_treasury_epbab').val();

        var B13=pensioners_birth_date;
        var B14=parseFloat(life_expectancy_of_pensioner).toFixed(2);
        var B15=pensioners_spouse_birth_date;
        var B16=parseFloat(life_expectancy_of_pensioners_spouse).toFixed(2);
        var B17=parseFloat(pensioners_retirement_age).toFixed(2);
        var B18=parseFloat(estimated_monthly_pension_payment).toFixed(2);
        var B19=parseFloat(pensioners_spouse_share/100).toFixed(2);
        var B20=parseFloat(survivorship_benefit/100).toFixed(2);
        var B21=parseFloat(monthly_survivorship_cost_total).toFixed(2);
        var B22=parseFloat(monthly_pensioner_cost_of_survivorship).toFixed(2);
        var B23=parseFloat(monthly_pensioner_spouse_cost_of_survivorship).toFixed(2);
        if(ten_year_treasury && !isNaN(ten_year_treasury)){
            var B24=parseFloat(ten_year_treasury/100).toFixed(2);
        }

        // get months difference between B13 and today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        today = mm + '/' + dd + '/' + yyyy; 
        var token= $('input[name=_token]').val();
        if (today && B13 && B13 !='') {
            $.ajax({
                url:"{{route('ajax_get_months_diff')}}",
                method:"POST",
                // dataType: 'json',
                data:{
                    max_date: B13,
                    min_date: today, 
                    _token: token,
                },
                success: function(data){
                    // console.log(data);
                    if(data=='null' || data==''){
                    } else {
                        $('#months_diff_of_B13_and_today').val(data);
                    }
                }
            });
        }
        // get months difference between B15 and today
        if (today && B15 && B15 !='') {
            $.ajax({
                url:"{{route('ajax_get_months_diff')}}",
                method:"POST",
                // dataType: 'json',
                data:{
                    max_date: B15,
                    min_date: today, 
                    _token: token,
                },
                success: function(data){
                    // console.log(data);
                    if(data=='null' || data==''){
                    } else {
                        $('#months_diff_of_B15_and_today').val(data);
                    }
                }
            });
        }

        // Calculations for  Pensioner’s UNDIVIDED Pension
        if(B18 && !isNaN(B18)){
            var B27=B18;
            $('#undivided_pensioners_monthly_benefit_epbab').val(B27);
        }

        if(B13 && B13 !='' && B14 && !isNaN(B14) && B17 && !isNaN(B17)){
            // B28=(12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17));
            var B14_mul_12=12*B14;
            var B17_mul_12=12*B17;
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B28=(B14_mul_12)-Math.max((months_diff_of_B13_and_today),(B17_mul_12));
            B28=parseFloat(B28).toFixed(2);
            $('#undivided_months_of_pensioners_benefit_epbab').val(B28);
        }

        if(B18 && !isNaN(B18) && B28 && !isNaN(B28)){
            // B29=B18*((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)));
            var B29=B18*(B28);
            B29=parseFloat(B29).toFixed(2);
            $('#undivided_pensioners_value_as_of_retirement_date_epbab').val(B29);
        }

        if(B29 && !isNaN(B29) && B24 && !isNaN(B24) && B13 && B13 !='' && B17 && !isNaN(B17)){
            // B30=B29/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)));
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var numerator=B29;
            var B24_by_12=(B24)/(12);
            var B24_by_12_add_1=B24_by_12+1;
            var B17_mul_12=12*(B17);
            var B17_mul_12_sub_months_diff_of_B13_and_today=(B17_mul_12)-(months_diff_of_B13_and_today);
            var denominator=Math.pow(B24_by_12_add_1, B17_mul_12_sub_months_diff_of_B13_and_today);
            // var denominator=(B24_by_12_add_1_power_B17_mul_12)-(months_diff_of_B13_and_today);
            var B30=(numerator)/(denominator);
            B30=parseFloat(B30).toFixed(2);
            $('#undivided_pensioners_value_as_of_todays_date_epbab').val(B30);
        }
        
        // Calculations for  Pensioner’s DIVIDED Pension
        if(B18 && !isNaN(B18) && B19 && !isNaN(B19) && B22 && !isNaN(B22)){
            var E14=(((1-B19)*B18)-B22);
            var E14=parseFloat(E14).toFixed(2);
            $('#divided_pensioners_monthly_benefit_epbab').val(E14);
        }
        if(B14 && !isNaN(B14) && B13 && B13 !='' && B17 && !isNaN(B17)){
            // E15=(12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17));
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B17_mul_12=12*B17;
            var max_of_month_diff_and_B17_mul_12=Math.max(months_diff_of_B13_and_today, B17_mul_12);
            var B14_mul_12=12*B14;
            var E15=(B14_mul_12)-(max_of_month_diff_and_B17_mul_12);
            E15=parseFloat(E15).toFixed(2);
            $('#divided_months_of_pensioners_benefit_epbab').val(E15);
        }
        
        if(B19 && !isNaN(B19) && B18 && !isNaN(B18) && B22 && !isNaN(B22) && B14 && !isNaN(B14) && B13 && B13 !='' && B17 && !isNaN(B17)){
            var E15=$('#divided_months_of_pensioners_benefit_epbab').val();
            var E15=parseFloat(E15).toFixed(2);
            // E16=(((1-B19)*B18)-B22)*(E15);
            var E16=(((1-B19)*B18)-B22)*(E15);
            var E16=parseFloat(E16).toFixed(2);
            $('#divided_pensioners_value_as_of_retirement_date_epbab').val(E16);
        }

        if(B13 && B13 !='' && B17 && !isNaN(B17) && B24 && !isNaN(B24) && E16 && !isNaN(E16)){
            // E17==E16/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)));
            var numerator=E16;
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B24_by_12=(B24/12);
            var B24_by_12_add_1=B24_by_12+1;
            var B17_mul_12_sub_months_diff_of_B13_and_today=(B17_mul_12)-(months_diff_of_B13_and_today);
            var denominator=Math.pow(B24_by_12_add_1, B17_mul_12_sub_months_diff_of_B13_and_today);
            var E17=numerator/denominator;
            var E17=parseFloat(E17).toFixed(2);
            $('#divided_pensioners_value_as_of_todays_date_epbab').val(E17);
        }

        if(B19 && !isNaN(B19) && B18 && !isNaN(B18) && B23 && !isNaN(B23)){
            var E20=(((B19)*B18)-B23);
            E20=parseFloat(E20).toFixed(2);
            $('#divided_pensioners_spouse_monthly_benefit_epbab').val(E20);
        }

        if(B13 && B13 !='' && B15 && B15 !='' && B17 && !isNaN(B17) && B16 && !isNaN(B16)){
            // E21=MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17))));
            // E21=MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));(E15));
            var B17_mul_12=12*B17;
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B17_mul_12_add_months_diff_of_B13_and_today=(+B17_mul_12)+(+months_diff_of_B13_and_today);
            var B16_mul_12=12*B16;
            var months_diff_of_B15_and_today=$('#months_diff_of_B15_and_today').val();
            months_diff_of_B15_and_today=parseFloat(months_diff_of_B15_and_today).toFixed(2);
            var B16_mul_12_sub_months_diff_of_B15_and_today=(B16_mul_12)-(months_diff_of_B15_and_today);
            var E21=Math.min(Math.max(B16_mul_12_sub_months_diff_of_B15_and_today,B17_mul_12_add_months_diff_of_B13_and_today),(E15));
            E21=parseFloat(E21).toFixed(2);
            $('#divided_months_of_pensioners_spouse_benefit_epbab').val(E21);
        }

        if(B18 && !isNaN(B18) && B19 && !isNaN(B19)){
            var E22=(((B19)*B18));
            E22=parseFloat(E22).toFixed(2);
            $('#divided_pensioners_spouse_monthly_survivorship_benefit_epbab').val(E22);
        }

        if(B13 && B13 !='' && B15 && B15 !='' && B14 && !isNaN(B14) && B17 && !isNaN(B17) && B16 && !isNaN(B16)){
            // E23=MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)-MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))));

            var B17_mul_12_sub_months_diff_of_B13_and_today=(B17_mul_12)-(months_diff_of_B13_and_today);
            
            var sub_month_diff=((B16_mul_12_sub_months_diff_of_B15_and_today)-(B17_mul_12_sub_months_diff_of_B13_and_today));
            // console.log('sub_month_diff='+sub_month_diff);
            var max2_for_E23=Math.max(months_diff_of_B13_and_today,(12*B17));
            // console.log('max2_for_E23='+max2_for_E23);
            var min_for_E23=Math.min(sub_month_diff,((12*B14)-max2_for_E23));
            // console.log('min_for_E23='+min_for_E23);
            var E23=max1_for_E23=Math.max(0,(sub_month_diff)-(min_for_E23));
            E23=parseFloat(E23).toFixed(2);
            // console.log('E23='+E23);

            // var E23=Math.max(0,((B16_mul_12_sub_months_diff_of_B15_and_today)-(B17_mul_12_sub_months_diff_of_B13_and_today))-Math.min((B16_mul_12_sub_months_diff_of_B15_and_today)-(B17_mul_12_sub_months_diff_of_B13_and_today),((12*B14)-Math.max(months_diff_of_B13_and_today,(12*B17)))));
            // var B14_mul_12=12*B14;
            // var E23=Math.max((sub_month_diff),Math.min((B16_mul_12_sub_months_diff_of_B15_and_today)-(B17_mul_12_sub_months_diff_of_B13_and_today),(B14_mul_12-Math.max(months_diff_of_B13_and_today,(B17_mul_12)))));
            $('#divided_additional_months_for_pensioners_spouse_epbab').val(E23);
        }

        if(B13 && B13 !='' && B15 && B15 !='' && B14 && !isNaN(B14) && B17 && !isNaN(B17) && B16 && !isNaN(B16) && B18 && !isNaN(B18) && B19 && !isNaN(B19) && B23 && !isNaN(B23) && B28 && E15){
            // E24=((((B19)*B18)-B23)*MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)-MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))+((((B19)*B18))*MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17))))));

            var B19_mul_B18=(B19)*(B18);
            var B19_mul_B18_sub_B23=(B19_mul_B18)-(B23);
            
            var E24=((B19_mul_B18_sub_B23)*Math.min(Math.max(0,(sub_month_diff)),(B28)))+((B19_mul_B18)*Math.max(0,(sub_month_diff)-Math.min((sub_month_diff),(E15))));

            E24=parseFloat(E24).toFixed(2);
            $('#divided_pensioners_spouse_value_as_of_retirement_date_epbab').val(E24);
            
        }

        if(B13 && B13 !='' && B17 && !isNaN(B17) && B24 && !isNaN(B24) && E24){
            // E25=(((((B19)*B18)-B23)*MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))+((((B19)*B18))*MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))))/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)));

            var numerator=E24;
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B24_by_12=(B24)/(12);
            var B24_by_12_add_1=B24_by_12+1;
            var B17_mul_12=12*(B17);
            var B17_mul_12_sub_months_diff_of_B13_and_today=(B17_mul_12)-(months_diff_of_B13_and_today);
            var denominator=Math.pow(B24_by_12_add_1, B17_mul_12_sub_months_diff_of_B13_and_today);
            var E25=(numerator)/(denominator);
            var E25=parseFloat(E25).toFixed(2);
            $('#divided_pensioners_spouse_value_as_of_todays_date_epbab').val(E25);
        }

        if(B13 && B13 !='' && B17 && !isNaN(B17) && B30 && E16 && E25 && B24){
            // E28=B30-E16/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)))-(((((B19)*B18)-B23)*MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))+((((B19)*B18))*MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))))/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)));
            var months_diff_of_B13_and_today=$('#months_diff_of_B13_and_today').val();
            months_diff_of_B13_and_today=parseFloat(months_diff_of_B13_and_today).toFixed(2);
            var B24_by_12=(B24)/(12);
            var B24_by_12_add_1=B24_by_12+1;
            var B17_mul_12=12*(B17);
            var B17_mul_12_sub_months_diff_of_B13_and_today=(B17_mul_12)-(months_diff_of_B13_and_today);
            var denominator=Math.pow(B24_by_12_add_1, B17_mul_12_sub_months_diff_of_B13_and_today);
            var E28=B30-E16/(denominator)-((E24)/(denominator));
            // var E28=B30-(E16/(denominator))-(E25);// this is also correct
            E28=B30-E16/(denominator)-(E25);
            var E28=parseFloat(E28).toFixed(2);
            $('#divided_cost_of_division_with_survivorship_epbab').val(E28);
        }

        if(E28 && B22 && !isNaN(B22) && B23 && !isNaN(B23)){
            // E29=(B30-E16/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)))-((((((B19)*B18)-B23)*MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))+((((B19)*B18))*MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))))/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)))))*(B22/(B22+B23))

            // var E29=(E28)*(B22/(B22+B23));
            var B22_add_B23=(+B22)+(+B23);
            var B22_by_B22_add_B23=(B22)/(B22_add_B23);
            var E29=(E28)*(B22_by_B22_add_B23);
            var E29=parseFloat(E29).toFixed(2);
            $('#divided_pensioners_cost_of_division_with_survivorship_epbab').val(E29);
        }

        if(E28 && B22 && !isNaN(B22) && B23 && !isNaN(B23)){
            // E29=(B30-E16/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)))-((((((B19)*B18)-B23)*MIN(MAX(0;(12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0));((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))+((((B19)*B18))*MAX(0;((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0))-MIN((12*B16)-MONTHS(B15;TODAY();0)-(12*B17)+MONTHS(B13;TODAY();0);((12*B14)-MAX(MONTHS(B13;TODAY();0);(12*B17)))))))/((1+B24/12)^((12*B17)-MONTHS(B13;TODAY();0)))))*(B22/(B22+B23))

            // var E29=(E28)*(B22/(B22+B23));
            var B22_add_B23=(+B22)+(+B23);
            var B23_by_B22_add_B23=(B23)/(B22_add_B23);
            var E30=(E28)*(B23_by_B22_add_B23);
            var E30=parseFloat(E30).toFixed(2);
            $('#divided_pensioners_spouse_cost_of_division_with_survivorship_epbab').val(E30);
        }

    }

    $(document).ready(function(){
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1901",
            // endDate: '+0d',
        });

        $('#computation-btn').click(function(){
            var state=$('#sheet_state').val();
            var type=$('#sheet_custody').val();
            
            if(type=='sole' || type=='shared')    
            {
                type='sole-shared';
            }    
            else
            {
                type='split';
            }

            if($('#chk_prefill').prop("checked") == true){
                 var prefill='1';
            } else {
                 var prefill='0';
            }
            
            $('#computation_sheet_form').attr('action', '/computations/'+type);
        });

        $.ajax({
            url:"{{route('ajax_get_active_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#sheet_state').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_state=$('#selected_state').val();
                    $('#sheet_state option[value="'+selected_state+'"]').prop('selected', true);
                }
            }
        });  
    });
</script>    
@endsection