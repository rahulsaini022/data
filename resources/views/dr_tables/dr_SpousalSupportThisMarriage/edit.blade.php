@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_SpousalSupportThisMarriage_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Spousal Support This Marriage Info') }}</strong>
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
                    <form role="form" id="dr_SpousalSupportThisMarriage" method="POST" action="{{route('drspousalsupportthismarriage.update',['id'=>$drspousalsupportthismarriage->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        {{$hide=''}}
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Will there be spousal support paid for this marriage?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Spousal_Support_This_Marriage_Yes" name="Spousal_Support_This_Marriage" value="Yes" <?php if(isset($drspousalsupportthismarriage->Spousal_Support_This_Marriage) && $drspousalsupportthismarriage->Spousal_Support_This_Marriage=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Spousal_Support_This_Marriage_No" name="Spousal_Support_This_Marriage" value="No" <?php if(isset($drspousalsupportthismarriage->Spousal_Support_This_Marriage) && $drspousalsupportthismarriage->Spousal_Support_This_Marriage=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                        </div>
                        <?php 
                            if(isset($drspousalsupportthismarriage->Spousal_Support_This_Marriage) && $drspousalsupportthismarriage->Spousal_Support_This_Marriage=='No'){ echo '<div class="form-row Spousal_Support_This_Marriage_Section" style="display: none;">'; 
                            } else {
                                echo '<div class="form-row Spousal_Support_This_Marriage_Section">';
                            }
                        ?> 
                            <div class="form-group col-sm-6">
                                <label>Who will be the obligor (person who pays)?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Spousal_Support_Obligor_Client" name="Spousal_Support_Obligor" value="{{$client_name}}" <?php if(isset($drspousalsupportthismarriage->Spousal_Support_Obligor) && $drspousalsupportthismarriage->Spousal_Support_Obligor==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                    <label><input type="radio" id="Spousal_Support_Obligor_Opponent" name="Spousal_Support_Obligor" value="{{$opponent_name}}" <?php if(isset($drspousalsupportthismarriage->Spousal_Support_Obligor) && $drspousalsupportthismarriage->Spousal_Support_Obligor==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Monthly_Spousal_Support_Amount">Amount of monthly spousal support?</label>
                                <input id="Monthly_Spousal_Support_Amount" type="number" class="form-control" name="Monthly_Spousal_Support_Amount" value="<?php if(isset($drspousalsupportthismarriage->Monthly_Spousal_Support_Amount)){ echo $drspousalsupportthismarriage->Monthly_Spousal_Support_Amount; } ?>" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Start_Date_Spousal_Support">What day is first spousal support payment?</label>
                                <input type="text" class="form-control hasDatepicker" id="Start_Date_Spousal_Support" name="Start_Date_Spousal_Support" placeholder="MM/DD/YYYY" autocomplete="nope" value="<?php if(isset($drspousalsupportthismarriage->Start_Date_Spousal_Support)){ echo date("m/d/Y", strtotime($drspousalsupportthismarriage->Start_Date_Spousal_Support)); } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Is spousal support for lifetime?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Duration_Spousal_Support_LIFETIME_Yes" name="Duration_Spousal_Support_LIFETIME" value="Yes" onchange="onRadioChange(this.value,'Duration_Spousal_Support_LIFETIME');" <?php if(isset($drspousalsupportthismarriage->Duration_Spousal_Support_LIFETIME) && $drspousalsupportthismarriage->Duration_Spousal_Support_LIFETIME=='Yes'){ echo "checked"; $hide='style="display: none;"'; } ?>> Yes</label>
                                    <label><input type="radio" id="Duration_Spousal_Support_LIFETIME_No" name="Duration_Spousal_Support_LIFETIME" value="No" onchange="onRadioChange(this.value,'Duration_Spousal_Support_LIFETIME');" <?php if(isset($drspousalsupportthismarriage->Duration_Spousal_Support_LIFETIME) && $drspousalsupportthismarriage->Duration_Spousal_Support_LIFETIME=='No'){ echo "checked"; $hide=''; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div" <?php echo $hide; ?>>
                                <label for="Duration_Spousal_Support_MONTHS">Number of minor or dependant children born to and/or adopted by the parties during marriage?</label>
                                <input type="number" class="form-control Duration_Spousal_Support_MONTHS" id="Duration_Spousal_Support_MONTHS" name="Duration_Spousal_Support_MONTHS" value="<?php if(isset($drspousalsupportthismarriage->Duration_Spousal_Support_MONTHS)){ echo $drspousalsupportthismarriage->Duration_Spousal_Support_MONTHS; } ?>" min="0">
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div" <?php echo $hide; ?>>
                                <label for="Final_Spousal_Support_Payment_Date">N/A Calculated</label>
                                <input type="number" class="form-control Final_Spousal_Support_Payment_Date" id="Final_Spousal_Support_Payment_Date" name="Final_Spousal_Support_Payment_Date" value="<?php if(isset($drspousalsupportthismarriage->Final_Spousal_Support_Payment_Date)){ echo $drspousalsupportthismarriage->Final_Spousal_Support_Payment_Date; } ?>" min="0">
                            </div>
                            <div class="form-group col-sm-6 Duration_Spousal_Support_LIFETIME_Div" <?php echo $hide; ?>>
                                <label for="Final_Spousal_Support_Payment_Amount">N/A Calculated</label>
                                <input id="Final_Spousal_Support_Payment_Amount" type="number" class="form-control" name="Final_Spousal_Support_Payment_Amount" value="<?php if(isset($drspousalsupportthismarriage->Final_Spousal_Support_Payment_Amount)){ echo $drspousalsupportthismarriage->Final_Spousal_Support_Payment_Amount; } ?>" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Will the Court be able to change the amount later?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Amount_Yes" name="Court_Retains_Jurisdiction_Amount" value="Yes" <?php if(isset($drspousalsupportthismarriage->Court_Retains_Jurisdiction_Amount) && $drspousalsupportthismarriage->Court_Retains_Jurisdiction_Amount=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Amount_No" name="Court_Retains_Jurisdiction_Amount" value="No" <?php if(isset($drspousalsupportthismarriage->Court_Retains_Jurisdiction_Amount) && $drspousalsupportthismarriage->Court_Retains_Jurisdiction_Amount=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Will the Court be able to change the duration later?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Duration_Yes" name="Court_Retains_Jurisdiction_Duration" value="Yes" <?php if(isset($drspousalsupportthismarriage->Court_Retains_Jurisdiction_Duration) && $drspousalsupportthismarriage->Court_Retains_Jurisdiction_Duration=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Court_Retains_Jurisdiction_Duration_No" name="Court_Retains_Jurisdiction_Duration" value="No" <?php if(isset($drspousalsupportthismarriage->Court_Retains_Jurisdiction_Duration) && $drspousalsupportthismarriage->Court_Retains_Jurisdiction_Duration=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when either party dies?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Death_Either_Yes" name="Terminates_On_Death_Either" value="Yes" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Death_Either) && $drspousalsupportthismarriage->Terminates_On_Death_Either=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Death_Either_No" name="Terminates_On_Death_Either" value="No" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Death_Either) && $drspousalsupportthismarriage->Terminates_On_Death_Either=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when obligee remarries?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Remarriage_Obligee_Yes" name="Terminates_On_Remarriage_Obligee" value="Yes" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Remarriage_Obligee) && $drspousalsupportthismarriage->Terminates_On_Remarriage_Obligee=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Remarriage_Obligee_No" name="Terminates_On_Remarriage_Obligee" value="No" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Remarriage_Obligee) && $drspousalsupportthismarriage->Terminates_On_Remarriage_Obligee=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when obligee cohabitates?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Cohabitation_Obligee_Yes" name="Terminates_On_Cohabitation_Obligee" value="Yes" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Cohabitation_Obligee) && $drspousalsupportthismarriage->Terminates_On_Cohabitation_Obligee=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Cohabitation_Obligee_No" name="Terminates_On_Cohabitation_Obligee" value="No" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Cohabitation_Obligee) && $drspousalsupportthismarriage->Terminates_On_Cohabitation_Obligee=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does spousal support terminate when disability causes the obligee to apply for medicaid?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Terminates_On_Disability_Leading_Application_Medicaid_Yes" name="Terminates_On_Disability_Leading_Application_Medicaid" value="Yes" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Disability_Leading_Application_Medicaid) && $drspousalsupportthismarriage->Terminates_On_Disability_Leading_Application_Medicaid=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Terminates_On_Disability_Leading_Application_Medicaid_No" name="Terminates_On_Disability_Leading_Application_Medicaid" value="No" <?php if(isset($drspousalsupportthismarriage->Terminates_On_Disability_Leading_Application_Medicaid) && $drspousalsupportthismarriage->Terminates_On_Disability_Leading_Application_Medicaid=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>How will monthly spousal support be paid?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Method_Of_Payment_CSEA" name="Method_Of_Payment" value="CSEA" <?php if(isset($drspousalsupportthismarriage->Method_Of_Payment) && $drspousalsupportthismarriage->Method_Of_Payment=='CSEA'){ echo "checked"; } ?>> CSEA</label>
                                    <label><input type="radio" id="Method_Of_Payment_Check_Money Order" name="Method_Of_Payment" value="Check/Money Order" <?php if(isset($drspousalsupportthismarriage->Method_Of_Payment) && $drspousalsupportthismarriage->Method_Of_Payment=='Check/Money Order'){ echo "checked"; } ?>> Check/Money Order</label>
                                    <label><input type="radio" id="Method_Of_Payment_Witholding_Direct_Deposit" name="Method_Of_Payment" value="Witholding/Direct Deposit" <?php if(isset($drspousalsupportthismarriage->Method_Of_Payment) && $drspousalsupportthismarriage->Method_Of_Payment=='Witholding/Direct Deposit'){ echo "checked"; } ?>> Witholding/Direct Deposit</label>
                                    <label><input type="radio" id="Method_Of_Payment_Bank_Transfer" name="Method_Of_Payment" value="Bank Transfer" <?php if(isset($drspousalsupportthismarriage->Method_Of_Payment) && $drspousalsupportthismarriage->Method_Of_Payment=='Bank Transfer'){ echo "checked"; } ?>> Bank Transfer</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Special_Provisions">Any special payment provisions?</label>
                                <input id="Special_Provisions" type="text" class="form-control" name="Special_Provisions" value="<?php if(isset($drspousalsupportthismarriage->Special_Provisions)){ echo $drspousalsupportthismarriage->Special_Provisions; } ?>"> 
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