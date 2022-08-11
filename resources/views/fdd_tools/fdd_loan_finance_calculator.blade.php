@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Loan/Finance Calculator') }}</strong>
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
                            <div class="row loan-finance-main">
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
                                    <input type="number" class="form-control" id="number_of_payments_loan_finance" name="number_of_payments_loan_finance" value="" placeholder="Number of Payments" onchange="calculatePaymentAmountForLoanFinance(this);" oninput="calculatePaymentAmountForLoanFinance(this);">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Yearly Rate (%)</label>
                                    <input type="number" class="form-control" id="yearly_rate_loan_finance" name="yearly_rate_loan_finance" value="" placeholder="Yearly Rate (%)" onchange="calculatePaymentAmountForLoanFinance(this);" oninput="calculatePaymentAmountForLoanFinance(this);" min="0.00" max="100">           
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Amount Loaned or Financed</label>
                                    <input type="number" class="form-control" id="amount_loaned_financed_loan_finance" name="amount_loaned_financed_loan_finance" value="" placeholder="Amount Loaned or Financed" onchange="calculatePaymentAmountForLoanFinance(this);" oninput="calculatePaymentAmountForLoanFinance(this);">
                                </div>
                                <div class="col-sm-4 column-box-width">
                                    <label>Payment Amount</label>
                                    <input type="number" class="form-control" id="payment_amount_loan_finance" name="payment_amount_loan_finance" value="" placeholder="Payment Amount" readonly="">
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