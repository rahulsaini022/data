@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Annuity Value Calculator') }}</strong>
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
                                    <input type="number" class="form-control" id="number_of_payments_annuity" name="number_of_payments_annuity" value="" placeholder="Number of Payments" onchange="calculatePaymentAmountForAnnuity(this);" oninput="calculatePaymentAmountForAnnuity(this);">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Estimated Yearly Rate (%)</label>
                                    <input type="number" class="form-control" id="yearly_rate_annuity" name="yearly_rate_annuity" value="" placeholder="Estimated Yearly Rate (%)" onchange="calculatePaymentAmountForAnnuity(this);" oninput="calculatePaymentAmountForAnnuity(this);" min="0.00" max="100">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="payment_amount_annuity" name="payment_amount_annuity" value="" placeholder="Payment Amount" onchange="calculatePaymentAmountForAnnuity(this);" oninput="calculatePaymentAmountForAnnuity(this);">
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
                                    <label>Net Present Value (Today)</label>
                                    <input type="number" class="form-control" id="net_present_value_todays_date_annuity" name="net_present_value_todays_date_annuity" value="" placeholder="Net Present Value (Today)" readonly="">           
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