@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_SpousalSupportThisMarriage_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Spousal Support This Marriage Info') }}</strong>
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
                    <form role="form" id="dr_SpousalSupportThisMarriage" method="POST" action="{{route('drspousalsupportthismarriage.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Will there be spousal support paid for this marriage?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Spousal_Support_This_Marriage_Yes" name="Spousal_Support_This_Marriage" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Spousal_Support_This_Marriage_No" name="Spousal_Support_This_Marriage" value="No" checked=""> No</label>
                                </div>
                            </div>
                        </div> 
                        <div class="form-row Spousal_Support_This_Marriage_Section" style="display: none;">
                            <div class="form-group col-sm-6">
                                <label>Who will be the obligor (person who pays)?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Spousal_Support_Obligor_Client" name="Spousal_Support_Obligor" value="{{$client_name}}" checked=""> {{$client_name}}</label>
                                    <label><input type="radio" id="Spousal_Support_Obligor_Opponent" name="Spousal_Support_Obligor" value="{{$opponent_name}}"> {{$opponent_name}}</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Monthly_Spousal_Support_Amount">Amount of monthly spousal support?</label>
                                <input id="Monthly_Spousal_Support_Amount" type="number" class="form-control" name="Monthly_Spousal_Support_Amount" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Start_Date_Spousal_Support">What day is first spousal support payment?</label>
                                <input type="text" class="form-control hasDatepicker" id="Start_Date_Spousal_Support" name="Start_Date_Spousal_Support" placeholder="MM/DD/YYYY" autocomplete="nope">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Is spousal support for lifetime?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Duration_Spousal_Support_LIFETIME_Yes" name="Duration_Spousal_Support_LIFETIME" value="Yes" onchange="onRadioChange(this.value,'Duration_Spousal_Support_LIFETIME');"> Yes</label>
                                    <label><input type="radio" id="Duration_Spousal_Support_LIFETIME_No" name="Duration_Spousal_Support_LIFETIME" value="No" checked="" onchange="onRadioChange(this.value,'Duration_Spousal_Support_LIFETIME');"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div">
                                <label for="Duration_Spousal_Support_MONTHS">Number of minor or dependant children born to and/or adopted by the parties during marriage?</label>
                                <input type="number" class="form-control Duration_Spousal_Support_MONTHS" id="Duration_Spousal_Support_MONTHS" name="Duration_Spousal_Support_MONTHS" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div">
                                <label for="Final_Spousal_Support_Payment_Date">N/A Calculated</label>
                                <input type="number" class="form-control Final_Spousal_Support_Payment_Date" id="Final_Spousal_Support_Payment_Date" name="Final_Spousal_Support_Payment_Date" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div">
                                <label for="Final_Spousal_Support_Payment_Amount">N/A Calculated</label>
                                <input id="Final_Spousal_Support_Payment_Amount" type="number" class="form-control" name="Final_Spousal_Support_Payment_Amount" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Will the Court be able to change the amount later?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Amount_Yes" name="Court_Retains_Jurisdiction_Amount" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Amount_No" name="Court_Retains_Jurisdiction_Amount" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Will the Court be able to change the duration later?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Duration_Yes" name="Court_Retains_Jurisdiction_Duration" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Duration_No" name="Court_Retains_Jurisdiction_Duration" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when either party dies?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Death_Either_Yes" name="Terminates_On_Death_Either" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Death_Either_No" name="Terminates_On_Death_Either" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when obligee remarries?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Remarriage_Obligee_Yes" name="Terminates_On_Remarriage_Obligee" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Remarriage_Obligee_No" name="Terminates_On_Remarriage_Obligee" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when obligee cohabitates?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Cohabitation_Obligee_Yes" name="Terminates_On_Cohabitation_Obligee" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Cohabitation_Obligee_No" name="Terminates_On_Cohabitation_Obligee" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when disability causes the obligee to apply for medicaid?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Disability_Leading_Application_Medicaid_Yes" name="Terminates_On_Disability_Leading_Application_Medicaid" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Disability_Leading_Application_Medicaid_No" name="Terminates_On_Disability_Leading_Application_Medicaid" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>How will monthly spousal support be paid?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Method_Of_Payment_CSEA" name="Method_Of_Payment" value="CSEA" checked=""> CSEA</label>
                                    <label><input type="radio" id="Method_Of_Payment_Check_Money Order" name="Method_Of_Payment" value="Check/Money Order"> Check/Money Order</label>
                                    <label><input type="radio" id="Method_Of_Payment_Witholding_Direct_Deposit" name="Method_Of_Payment" value="Witholding/Direct Deposit"> Witholding/Direct Deposit</label>
                                    <label><input type="radio" id="Method_Of_Payment_Bank_Transfer" name="Method_Of_Payment" value="Bank Transfer"> Bank Transfer</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Special_Provisions">Any special payment provisions?</label>
                                <input id="Special_Provisions" type="text" class="form-control" name="Special_Provisions" value=""> 
                            </div>
                        </div>
                        <div class="form-group col-sm-12 text-center">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    function onRadioChange(value,cls){
        if(value=='Yes'){
            $('.'+cls+'_Div').hide();
        } else{
            $('.'+cls+'_Div').show();
        }

    }
    $(document).ready(function(){

        $('#dr_SpousalSupportThisMarriage').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $('#Spousal_Support_This_Marriage_No').prop('checked', true);
        $('input[name="Spousal_Support_This_Marriage"]').on('change', function(){
            if(this.value=='Yes'){
                $('.Spousal_Support_This_Marriage_Section').show();
            } else {
                $('.Spousal_Support_This_Marriage_Section').hide();
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: new Date(),
            minDate: new Date()
        });
    });
</script>   
@endsection