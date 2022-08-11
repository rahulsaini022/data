@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Annual Income Calculator') }}</strong>
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
                        <div class="col-sm-12 annual-income-calculation-section">
                            <div class="row">
                                <div class="col-sm-3 column-box-width">
                                    <label>Pay Amount</label>
                                    <input type="number" class="form-control" id="annual_income_amount" name="annual_income_amount" value="" placeholder="Pay Amount" value="0.00" min="0.00" step="0.01" autocomplete="off" onchange="onAmountChange(this);" onkeyup="onAmountChange(this);">           
                                </div>
                                <div class="col-sm-3 column-box-width">
                                    <input type="radio" id="annual_income_income_frequency_radio" name="annual_income_income_frequency_ytd_radio" class="annual_income_radio mt-1" value="frequency" onchange="onAnnlIncmCalcFrequenceYtdRadioChange(this,'annual_income_income_frequency', 'ytd_date', 'frequency')" autocomplete="off">
                                    <label>Frequency</label>
                                    <select id="annual_income_income_frequency" name="annual_income_income_frequency" class="form-control annual_income_inputs" disabled="" onchange="onAnnlIncmCalcFrequenceChange(this)" autocomplete="off">
                                        <option value="0" selected="">Select</option>
                                        <option value="1">Yearly</option>
                                        <option value="12">Monthly</option>
                                        <option value="24">Bi-Monthly</option>
                                        <option value="26">Bi-Weekly</option>
                                        <option value="52">Weekly</option>
                                    </select>           
                                </div>
                                <div class="col-sm-3 column-box-width">
                                    <input type="radio" id="annual_income_ytd_radio" name="annual_income_income_frequency_ytd_radio" class="annual_income_radio mt-1" value="ytd_date_radio" onchange="onAnnlIncmCalcFrequenceYtdRadioChange(this,'ytd_date', 'annual_income_income_frequency' , 'ytd_date')" autocomplete="off">
                                    <label>YTD (Date)</label>
                                    <input type="text" class="form-control hasDatepicker annual_income_inputs" id="ytd_date" name="ytd_date" value="" placeholder="YTD (Date)" disabled="" onchange="onAnnlIncmCalcYtdDateChange(this)" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>          
                                </div>
                                <div class="col-sm-3 column-box-width">
                                    <label>Annual Income</label>
                                    <input type="number" class="form-control" id="annual_income_annual_pay" name="annual_income_annual_pay" value="" placeholder="Annual Income" readonly="" autocomplete="off">           
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
            orientation: "top auto"
        });
    });
        
</script>    
@endsection