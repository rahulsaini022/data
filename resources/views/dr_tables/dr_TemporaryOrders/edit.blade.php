@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_temporaryorders_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Temporary Order Info') }}</strong>
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
                    <form role="form" id="dr_temporaryorders" method="POST" action="{{route('drtemporaryorders.update',['id'=>$drtemporaryorders->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary child support?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Child_Custody_Client_Y_N_Yes" name="Temp_Child_Custody_Client_Y_N" value="Yes" <?php if(isset($drtemporaryorders->Temp_Child_Custody_Client_Y_N) && $drtemporaryorders->Temp_Child_Custody_Client_Y_N=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Temp_Child_Custody_Client_Y_N_No" name="Temp_Child_Custody_Client_Y_N" value="No" <?php if(isset($drtemporaryorders->Temp_Child_Custody_Client_Y_N) && $drtemporaryorders->Temp_Child_Custody_Client_Y_N=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary custody?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Child_Support_Y_N_Yes" name="Temp_Child_Support_Y_N" value="Yes" <?php if(isset($drtemporaryorders->Temp_Child_Support_Y_N) && $drtemporaryorders->Temp_Child_Support_Y_N=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Temp_Child_Support_Y_N_No" name="Temp_Child_Support_Y_N" value="No" <?php if(isset($drtemporaryorders->Temp_Child_Support_Y_N) && $drtemporaryorders->Temp_Child_Support_Y_N=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} seek temporary spousal support?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Temp_Spousal_Support_Y_N_Yes" name="Temp_Spousal_Support_Y_N" value="Yes" <?php if(isset($drtemporaryorders->Temp_Spousal_Support_Y_N) && $drtemporaryorders->Temp_Spousal_Support_Y_N=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Temp_Spousal_Support_Y_N_No" name="Temp_Spousal_Support_Y_N" value="No" <?php if(isset($drtemporaryorders->Temp_Spousal_Support_Y_N) && $drtemporaryorders->Temp_Spousal_Support_Y_N=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are there any current Domestic Violence orders?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_DV_Orders_Yes" name="Current_DV_Orders" value="Yes" onchange="onRadioChange(this.value,'Current_DV_Order_Case_Num');" <?php if(isset($drtemporaryorders->Current_DV_Orders) && $drtemporaryorders->Current_DV_Orders=='Yes'){ echo "checked"; $hide=''; } ?>> Yes</label>
                                    <label><input type="radio" id="Current_DV_Orders_No" name="Current_DV_Orders" value="No" onchange="onRadioChange(this.value,'Current_DV_Order_Case_Num');" <?php if(isset($drtemporaryorders->Current_DV_Orders) && $drtemporaryorders->Current_DV_Orders=='No'){ echo "checked"; $hide='style="display: none;"'; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_DV_Order_Case_Num_Div" <?php echo $hide; ?>>
                                <label for="Current_DV_Order_Case_Num">Domestic Violence Case Number</label>
                                <input type="text" class="form-control Current_DV_Order_Case_Num" id="Current_DV_Order_Case_Num" name="Current_DV_Order_Case_Num" value="<?php if(isset($drtemporaryorders->Current_DV_Order_Case_Num)){ echo $drtemporaryorders->Current_DV_Order_Case_Num; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are there any current Juvenile cases?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_Juvenile_Case_Yes" name="Current_Juvenile_Case" value="Yes" onchange="onRadioChange(this.value,'Current_Juvenile_Case_Num');" <?php if(isset($drtemporaryorders->Current_Juvenile_Case) && $drtemporaryorders->Current_Juvenile_Case=='Yes'){ echo "checked"; $hide=''; } ?>> Yes</label>
                                    <label><input type="radio" id="Current_Juvenile_Case_No" name="Current_Juvenile_Case" value="No" onchange="onRadioChange(this.value,'Current_Juvenile_Case_Num');" <?php if(isset($drtemporaryorders->Current_Juvenile_Case) && $drtemporaryorders->Current_Juvenile_Case=='No'){ echo "checked"; $hide='style="display: none;"'; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_Juvenile_Case_Num_Div" <?php echo $hide; ?>>
                                <label for="Current_Juvenile_Case_Num">Juvenile Case Number</label>
                                <input type="text" class="form-control Current_Juvenile_Case_Num" id="Current_Juvenile_Case_Num" name="Current_Juvenile_Case_Num" value="<?php if(isset($drtemporaryorders->Current_Juvenile_Case_Num)){ echo $drtemporaryorders->Current_Juvenile_Case_Num; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Is there a current Bankruptcy case for either party?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Current_Bankruptcy_Case_Yes" name="Current_Bankruptcy_Case" value="Yes" onchange="onRadioChange(this.value,'Current_Bankruptcy_Case_Fields');" <?php if(isset($drtemporaryorders->Current_Bankruptcy_Case) && $drtemporaryorders->Current_Bankruptcy_Case=='Yes'){ echo "checked"; $hide=''; } ?>> Yes</label>
                                    <label><input type="radio" id="Current_Bankruptcy_Case_No" name="Current_Bankruptcy_Case" value="No" onchange="onRadioChange(this.value,'Current_Bankruptcy_Case_Fields');" <?php if(isset($drtemporaryorders->Current_Bankruptcy_Case) && $drtemporaryorders->Current_Bankruptcy_Case=='No'){ echo "checked"; $hide='style="display: none;"'; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Current_Bankruptcy_Case_Fields_Div" <?php echo $hide; ?>>
                                <label for="Current_Bankruptcy_Case_Num">Bankruptcy Case Number</label>
                                <input type="text" class="form-control Current_Bankruptcy_Case_Fields" id="Current_Bankruptcy_Case_Num" name="Current_Bankruptcy_Case_Num" value="<?php if(isset($drtemporaryorders->Current_Bankruptcy_Case_Num)){ echo $drtemporaryorders->Current_Bankruptcy_Case_Num; } ?>">
                            </div>
                            <div class="form-group col-sm-6 Current_Bankruptcy_Case_Fields_Div" <?php echo $hide; ?>>
                                <label for="Current_Bankruptcy_Date_Filed">Bankruptcy Case Filed Date</label>
                                <input type="text" class="form-control hasDatepicker Current_Bankruptcy_Case_Fields" id="Current_Bankruptcy_Date_Filed" name="Current_Bankruptcy_Date_Filed" placeholder="MM/DD/YYYY" autocomplete="nope" value="<?php if(isset($drtemporaryorders->Current_Bankruptcy_Date_Filed)){ echo date("m/d/Y", strtotime($drtemporaryorders->Current_Bankruptcy_Date_Filed)); } ?>">
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