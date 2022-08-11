@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_temporaryorders_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Temporary Order Info') }}</strong>
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
                    <form role="form" id="dr_temporaryorders" method="POST" action="{{route('drtemporaryorders.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary child support?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Child_Custody_Client_Y_N_Yes" name="Temp_Child_Custody_Client_Y_N" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Temp_Child_Custody_Client_Y_N_No" name="Temp_Child_Custody_Client_Y_N" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary custody?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Child_Support_Y_N_Yes" name="Temp_Child_Support_Y_N" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Temp_Child_Support_Y_N_No" name="Temp_Child_Support_Y_N" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary spousal support?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Spousal_Support_Y_N_Yes" name="Temp_Spousal_Support_Y_N" value="Yes" checked=""> Yes</label>
                                    <label><input type="radio" id="Temp_Spousal_Support_Y_N_No" name="Temp_Spousal_Support_Y_N" value="No"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are there any current Domestic Violence orders?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_DV_Orders_Yes" name="Current_DV_Orders" value="Yes" onchange="onRadioChange(this.value,'Current_DV_Order_Case_Num');"> Yes</label>
                                    <label><input type="radio" id="Current_DV_Orders_No" name="Current_DV_Orders" value="No" checked="" onchange="onRadioChange(this.value,'Current_DV_Order_Case_Num');"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_DV_Order_Case_Num_Div" style="display: none;">
                                <label for="Current_DV_Order_Case_Num">Domestic Violence Case Number</label>
                                <input type="text" class="form-control Current_DV_Order_Case_Num" id="Current_DV_Order_Case_Num" name="Current_DV_Order_Case_Num">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are there any current Juvenile cases?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_Juvenile_Case_Yes" name="Current_Juvenile_Case" value="Yes" onchange="onRadioChange(this.value,'Current_Juvenile_Case_Num');"> Yes</label>
                                    <label><input type="radio" id="Current_Juvenile_Case_No" name="Current_Juvenile_Case" value="No" checked="" onchange="onRadioChange(this.value,'Current_Juvenile_Case_Num');"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_Juvenile_Case_Num_Div" style="display: none;">
                                <label for="Current_Juvenile_Case_Num">Juvenile Case Number</label>
                                <input type="text" class="form-control Current_Juvenile_Case_Num" id="Current_Juvenile_Case_Num" name="Current_Juvenile_Case_Num">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Is there a current Bankruptcy case for either party?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_Bankruptcy_Case_Yes" name="Current_Bankruptcy_Case" value="Yes" onchange="onRadioChange(this.value,'Current_Bankruptcy_Case_Fields');"> Yes</label>
                                    <label><input type="radio" id="Current_Bankruptcy_Case_No" name="Current_Bankruptcy_Case" value="No" checked="" onchange="onRadioChange(this.value,'Current_Bankruptcy_Case_Fields');"> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_Bankruptcy_Case_Fields_Div" style="display: none;">
                                <label for="Current_Bankruptcy_Case_Num">Bankruptcy Case Number</label>
                                <input type="text" class="form-control Current_Bankruptcy_Case_Fields" id="Current_Bankruptcy_Case_Num" name="Current_Bankruptcy_Case_Num">
                            </div>
                            <div class="form-group col-sm-6 Current_Bankruptcy_Case_Fields_Div" style="display: none;">
                                <label for="Current_Bankruptcy_Date_Filed">Bankruptcy Case Filed Date</label>
                                <input type="text" class="form-control hasDatepicker Current_Bankruptcy_Case_Fields" id="Current_Bankruptcy_Date_Filed" name="Current_Bankruptcy_Date_Filed" placeholder="MM/DD/YYYY" autocomplete="nope">
                            </div>
                            <div class="form-group col-sm-12 text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
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
            $('.'+cls+'_Div').show();
        } else{
            $('.'+cls+'_Div').hide();
        }

    }
    $(document).ready(function(){

        $('#dr_temporaryorders').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1900",
            endDate: '+0d',
        });
    });
</script>   
@endsection