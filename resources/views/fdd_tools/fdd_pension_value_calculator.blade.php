@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Pension Value Calculator') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('fdd_tools') }}"> Back</a>
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

                    <div class="row">
                       <div class="col-sm-12 time-money-payments-section">
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
                                    <input type="number" class="form-control" id="life_expectancy_of_pensioner_epbab" name="life_expectancy_of_pensioner_epbab" value="" placeholder="Life Expectancy of Pensioner" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Birth Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="pensioners_spouse_birth_date_epbab" name="pensioners_spouse_birth_date_epbab" value="" placeholder="Pensioner’s Spouse’s Birth Date" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" autocomplete="off">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Life Expectancy of Pensioner’s Spouse</label>
                                    <input type="number" class="form-control" id="life_expectancy_of_pensioners_spouse_epbab" name="life_expectancy_of_pensioners_spouse_epbab" value="" placeholder="Life Expectancy of Pensioner’s Spouse" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Retirement Age</label>
                                    <input type="number" class="form-control" id="pensioners_retirement_age_epbab" name="pensioners_retirement_age_epbab" value="" placeholder="Pensioner’s Retirement Age" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Estimated Monthly Pension Payment</label>
                                    <input type="number" class="form-control" id="estimated_monthly_pension_payment_epbab" name="estimated_monthly_pension_payment_epbab" value="" placeholder="Estimated Monthly Pension Payment" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Pensioner’s Spouse’s Share %</label>
                                    <input type="number" class="form-control" id="pensioners_spouse_share_epbab" name="pensioners_spouse_share_epbab" value="" placeholder="Pensioner’s Spouse’s Share %" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Survivorship Benefit %</label>
                                    <input type="number" class="form-control" id="survivorship_benefit_epbab" name="survivorship_benefit_epbab" value="" placeholder="Survivorship Benefit %" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthlly Survivorship Cost Total</label>
                                    <input type="number" class="form-control" id="monthly_survivorship_cost_total_epbab" name="monthly_survivorship_cost_total_epbab" value="" placeholder="Monthlly Survivorship Cost Total" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthly Pensioner Cost of Survivorship</label>
                                    <input type="number" class="form-control" id="monthly_pensioner_cost_of_survivorship_epbab" name="monthly_pensioner_cost_of_survivorship_epbab" value="" placeholder="Monthly Pensioner Cost of Survivorship" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Monthly Pensioner Spouse Cost of Survivorship</label>
                                    <input type="number" class="form-control" id="monthly_pensioner_spouse_cost_of_survivorship_epbab" name="monthly_pensioner_spouse_cost_of_survivorship_epbab" value="" placeholder="Monthly Pensioner Spouse Cost of Survivorship" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>10-Year Treasure Rate</label>
                                    <input type="number" class="form-control" id="ten_year_treasury_epbab" name="ten_year_treasury_epbab" value="" placeholder="10-Year Treasure Rate" onchange="calculateEstimatePensionBenefitsAndBuyouts(this);" oninput="calculateEstimatePensionBenefitsAndBuyouts(this);" min="0.00" max="100">
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
                    </div>   
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/polyfiller.js') }}"></script>

<script type="text/javascript">

    // to convert number to currency
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');


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
    });
        
</script>    
@endsection