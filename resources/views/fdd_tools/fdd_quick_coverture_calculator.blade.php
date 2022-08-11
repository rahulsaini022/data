@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Quick Coverture Calculator') }}</strong>
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
                                <div class="col-sm-6">
                                    <label>Date of Marriage</label>
                                    <input type="text" class="form-control hasDatepicker quick_coverture_inputs" id="date_of_marriage" name="date_of_marriage" value="" placeholder="Date of Marriage" onchange="calculateQuickCoverture()" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                <div class="col-sm-6">
                                    <label>End of Marriage Date</label>
                                    <input type="text" class="form-control hasDatepicker quick_coverture_inputs" id="end_of_marriage_date" name="end_of_marriage_date" value="" placeholder="End of Marriage Date" onchange="calculateQuickCoverture()" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>   
                                </div>
                                <div class="col-sm-6">
                                    <label>Date started Earning Pension</label>
                                    <input type="text" class="form-control hasDatepicker quick_coverture_inputs" id="date_started_earning_pension" name="date_started_earning_pension" value="" placeholder="Date started Earning Pension" onchange="calculateQuickCoverture()" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                                <div class="col-sm-6">
                                    <label>Date Pension Vested (or Vests)</label>
                                    <input type="text" class="form-control hasDatepicker quick_coverture_inputs" id="date_pension_vests" name="date_pension_vests" value="" placeholder="Date Pension Vested (or Vests)" onchange="calculateQuickCoverture()" autocomplete="off">  
                                   <i class="fa fa-calendar" aria-hidden="true"></i>   
                                </div>
                                <div class="col-sm-12">
                                    <label>Calculation Units</label>        
                                </div>
                                <div class="col-sm-6">
                                    <label> Days
                                    <input type="radio" id="calculation_units_days" name="calculation_units" class="calculation_units_radio mt-1" value="days" onchange="calculateQuickCoverture()" autocomplete="off" checked=""> </label>
                                    <label> Months
                                    <input type="radio" id="calculation_units_months" name="calculation_units" class="calculation_units_radio mt-1" value="months" onchange="calculateQuickCoverture()" autocomplete="off">
                                    </label>
                                </div>
                                <div class="col-sm-12">
                                    <h6>Marriage Overlap with Pension</h6>
                                </div>
                                <div class="col-sm-6">
                                    <label>Overlap Start Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="overlap_start_date" name="overlap_start_date" value="" placeholder="Overlap Start Date" disabled="" autocomplete="off">           
                                </div>
                                <div class="col-sm-6">
                                    <label>Overlap Stop Date</label>
                                    <input type="text" class="form-control hasDatepicker" id="overlap_stop_date" name="overlap_stop_date" value="" placeholder="Overlap Stop Date" disabled="" autocomplete="off">           
                                </div>
                                <div class="col-sm-6">
                                    <label>Marriage Overlap Duration<span class="checked_calc_units">(Days)</span></label>
                                    <input type="text" class="form-control" id="marriage_overlap_duration" name="marriage_overlap_duration" value="" placeholder="Marriage Overlap Duration" readonly="" autocomplete="off">           
                                </div>
                                <div class="col-sm-6">
                                    <label>Pension Earning Duration<span class="checked_calc_units">(Days)</span></label>
                                    <input type="text" class="form-control" id="pension_earning_duration" name="pension_earning_duration" value="" placeholder="Pension Earning Duration" readonly="" autocomplete="off">           
                                </div>
                                <div class="col-sm-6">
                                    <label>Coverture Fraction to Owner(%)</label>
                                    <input type="text" class="form-control" id="coverture_fraction_to_owner" name="coverture_fraction_to_owner" value="" placeholder="Coverture Fraction to Owner" readonly="" autocomplete="off">           
                                </div>
                                <div class="col-sm-6">
                                    <label>Coverture Fraction to Spouse(%)</label>
                                    <input type="text" class="form-control" id="coverture_fraction_to_spouse" name="coverture_fraction_to_spouse" value="" placeholder="Coverture Fraction to Spouse" readonly="" autocomplete="off">           
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">

    // to convert number to currency
    webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number'
    });
    webshims.polyfill('forms forms-ext');

 var coverture_fraction_to_spouse = ' ';
 var coverture_fraction_to_owner = ' '
    // calculate Annual Gross Income
    function calculateQuickCoverture(){ 

        var date_of_marriage = $("#date_of_marriage").val();
        var end_of_marriage_date = $("#end_of_marriage_date").val();
        var date_started_earning_pension = $("#date_started_earning_pension").val();
        var date_pension_vests = $("#date_pension_vests").val();
        var calculation_units = $('input[name=calculation_units]:checked').val();

        if(calculation_units == 'months'){
            $('.checked_calc_units').text('(Months)');
        } else {
            $('.checked_calc_units').text('(Days)');
        }

        // calculate Overlap Start Date
        if(date_of_marriage && date_started_earning_pension){
            date_of_marriage = new Date(date_of_marriage);
            date_started_earning_pension = new Date(date_started_earning_pension);
            if(date_of_marriage > date_started_earning_pension){
                var overlap_start_date = date_of_marriage;
            } else {
                var overlap_start_date = date_started_earning_pension;
            }
            overlap_start_date = new Date(overlap_start_date);
            $('#overlap_start_date').datepicker("setDate", overlap_start_date );
        }

        // calculate Overlap Stop Date
        if(end_of_marriage_date && date_pension_vests){
            end_of_marriage_date = new Date(end_of_marriage_date);
            date_pension_vests = new Date(date_pension_vests);
            if(end_of_marriage_date > date_pension_vests){
                var overlap_stop_date = date_pension_vests;
            } else {
                var overlap_stop_date = end_of_marriage_date;
            }
            overlap_stop_date = new Date(overlap_stop_date);
            $('#overlap_stop_date').datepicker("setDate", overlap_stop_date );
        }

        // to calculate Pension Earning Duration
        if(overlap_stop_date && overlap_start_date){
            // var diffTime = Math.abs(overlap_stop_date - overlap_start_date);
            // var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            var startDate = moment(overlap_start_date, "DD.MM.YYYY");

            var endDate = moment(overlap_stop_date, "DD.MM.YYYY");


            if(calculation_units == 'months'){
                // var marriage_overlap_duration = diffDays;
                var marriage_overlap_duration = endDate.diff(startDate, 'months');
                // console.log('months', marriage_overlap_duration);
            } else {
                var marriage_overlap_duration = endDate.diff(startDate, 'days');
                // console.log('days', marriage_overlap_duration);
            }

            $('#marriage_overlap_duration').val(marriage_overlap_duration);

        }

        // to calculate Pension Earning Duration
        if(date_pension_vests && date_started_earning_pension){
            // var diffTime = Math.abs(date_pension_vests - date_started_earning_pension);
            // var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            var startDate = moment(date_started_earning_pension, "DD.MM.YYYY");

            var endDate = moment(date_pension_vests, "DD.MM.YYYY");


            if(calculation_units == 'months'){
                // var pension_earning_duration = diffDays;
                var pension_earning_duration = endDate.diff(startDate, 'months');
                // console.log('months', pension_earning_duration);
            } else {
                var pension_earning_duration = endDate.diff(startDate, 'days');
                // console.log('days', pension_earning_duration);
            }

            $('#pension_earning_duration').val(pension_earning_duration);

        }


        // to calculate Coverture Fraction to Owner && Coverture Fraction to Spouse
       if(marriage_overlap_duration != 0 && pension_earning_duration !=0){

            var coverture_fraction_to_spouse = (marriage_overlap_duration/pension_earning_duration)/2;
            
            coverture_fraction_to_spouse = parseFloat(coverture_fraction_to_spouse);
             
            $('#coverture_fraction_to_spouse').val(!isNaN(coverture_fraction_to_spouse * 100) ? (coverture_fraction_to_spouse * 100).toFixed(2) : '0.00');

            var coverture_fraction_to_owner = 1 - coverture_fraction_to_spouse;
            coverture_fraction_to_owner = parseFloat(coverture_fraction_to_owner);
            
            $('#coverture_fraction_to_owner').val(!isNaN(coverture_fraction_to_owner * 100) ? (coverture_fraction_to_owner * 100).toFixed(2) : '0.00');
            
        }else{
            $('#coverture_fraction_to_spouse').val('0');
             $('#coverture_fraction_to_owner').val('100');
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