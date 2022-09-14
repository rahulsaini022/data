@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_MarriageInfo_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Marriage Info') }}</strong>
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
                    <form role="form" id="dr_MarriageInfo" method="POST" action="{{route('drmarriageinfo.update',['id'=>$drmarriageinfo->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label for="Marriage_Location">Location where you were married?</label>
                                <input type="text" class="form-control" id="Marriage_Location" name="Marriage_Location" value="<?php if(isset($drmarriageinfo->Marriage_Location)){ echo $drmarriageinfo->Marriage_Location; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Marriage_Date">When were you married?</label>
                                <input type="text" class="form-control hasDatepicker" id="Marriage_Date" name="Marriage_Date" placeholder="MM/DD/YYYY" autocomplete="nope" value="<?php if(isset($drmarriageinfo->Marriage_Date)){ echo date("m/d/Y", strtotime($drmarriageinfo->Marriage_Date)); } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are there minor children born to and/or adopted during marriage?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Minor_Children_these_Parties_Yes" name="Minor_Children_these_Parties" value="Yes" onchange="onRadioChange(this.value,'Num_MinorDependant_Children_of_this_Marriage');" <?php if(isset($drmarriageinfo->Minor_Children_these_Parties) && $drmarriageinfo->Minor_Children_these_Parties=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Minor_Children_these_Parties_No" name="Minor_Children_these_Parties" value="No" onchange="onRadioChange(this.value,'Num_MinorDependant_Children_of_this_Marriage');" <?php if(isset($drmarriageinfo->Minor_Children_these_Parties) && $drmarriageinfo->Minor_Children_these_Parties=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <?php 
                                if(isset($drmarriageinfo->Minor_Children_these_Parties) && $drmarriageinfo->Minor_Children_these_Parties=='Yes'){ 
                                    echo '<div class="form-group col-sm-6 Num_MinorDependant_Children_of_this_Marriage_Div">'; 
                                } else {
                                    echo '<div class="form-group col-sm-6 Num_MinorDependant_Children_of_this_Marriage_Div" style="display: none;">';
                                }  
                            ?>
                                <label for="Num_MinorDependant_Children_of_this_Marriage">Number of minor or dependant children born to and/or adopted by the parties during marriage?</label>
                                <input type="number" class="form-control Num_MinorDependant_Children_of_this_Marriage" id="Num_MinorDependant_Children_of_this_Marriage" name="Num_MinorDependant_Children_of_this_Marriage" value="<?php if(isset($drmarriageinfo->Num_MinorDependant_Children_of_this_Marriage)){ echo $drmarriageinfo->Num_MinorDependant_Children_of_this_Marriage; } ?>" min="0" max="20">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>What type of domestic relations case is this?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Type_Action_Div_Dis_Ann_Sep_Dissolution" name="Type_Action_Div_Dis_Ann_Sep" value="Dissolution" <?php if(isset($drmarriageinfo->Type_Action_Div_Dis_Ann_Sep) && $drmarriageinfo->Type_Action_Div_Dis_Ann_Sep=='Dissolution'){ echo "checked"; } ?>> Dissolution</label>
                                    <label><input type="radio" id="Type_Action_Div_Dis_Ann_Sep_Divorce" name="Type_Action_Div_Dis_Ann_Sep" value="Divorce" <?php if(isset($drmarriageinfo->Type_Action_Div_Dis_Ann_Sep) && $drmarriageinfo->Type_Action_Div_Dis_Ann_Sep=='Divorce'){ echo "checked"; } ?>> Divorce</label>
                                    <label><input type="radio" id="Type_Action_Div_Dis_Ann_Sep_Legal_Separation" name="Type_Action_Div_Dis_Ann_Sep" value="Legal Separation" <?php if(isset($drmarriageinfo->Type_Action_Div_Dis_Ann_Sep) && $drmarriageinfo->Type_Action_Div_Dis_Ann_Sep=='Legal Separation'){ echo "checked"; } ?>> Legal Separation</label>
                                    <label><input type="radio" id="Type_Action_Div_Dis_Ann_Sep_Annulment" name="Type_Action_Div_Dis_Ann_Sep" value="Annulment" <?php if(isset($drmarriageinfo->Type_Action_Div_Dis_Ann_Sep) && $drmarriageinfo->Type_Action_Div_Dis_Ann_Sep=='Annulment'){ echo "checked"; } ?>> Annulment</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are the parties currently cohabitating?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Currently_Cohabitating_With_Spouse_Y_N_Yes" name="Currently_Cohabitating_With_Spouse_Y_N" value="Yes" <?php if(isset($drmarriageinfo->Currently_Cohabitating_With_Spouse_Y_N) && $drmarriageinfo->Currently_Cohabitating_With_Spouse_Y_N=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Currently_Cohabitating_With_Spouse_Y_N_No" name="Currently_Cohabitating_With_Spouse_Y_N" value="No" <?php if(isset($drmarriageinfo->Currently_Cohabitating_With_Spouse_Y_N) && $drmarriageinfo->Currently_Cohabitating_With_Spouse_Y_N=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Who left the marital residence first?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Who_first_left_home_Client" name="Who_first_left_home" value="{{$client_name}}" <?php if(isset($drmarriageinfo->Who_first_left_home) && $drmarriageinfo->Who_first_left_home==$client_name){ echo "checked"; } ?>> {{$client_name}}</label>
                                    <label><input type="radio" id="Who_first_left_home_Op" name="Who_first_left_home" value="{{$opponent_name}}" <?php if(isset($drmarriageinfo->Who_first_left_home) && $drmarriageinfo->Who_first_left_home==$opponent_name){ echo "checked"; } ?>> {{$opponent_name}}</label>
                                    <label><input type="radio" id="Who_first_left_home_N/A" name="Who_first_left_home" value="N/A" <?php if(isset($drmarriageinfo->Who_first_left_home) && $drmarriageinfo->Who_first_left_home=='N/A'){ echo "checked"; } ?>> N/A</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6 Who_first_left_home_Separation_Div" <?php if(isset($drmarriageinfo->Who_first_left_home) && $drmarriageinfo->Who_first_left_home=='N/A'){ echo 'style="display:none"'; } ?>>
                                <label for="Date_of_Separation">When was the date of separation?</label>
                                <input type="text" class="form-control hasDatepicker" id="Date_of_Separation" name="Date_of_Separation" placeholder="MM/DD/YYYY" autocomplete="nope" value="<?php if(isset($drmarriageinfo->Date_of_Separation)){ echo date("m/d/Y", strtotime($drmarriageinfo->Date_of_Separation)); } ?>">
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

        $('#dr_MarriageInfo').validate();
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

        // who left home first input change
        $('input[type=radio][name=Who_first_left_home]').change(function() {
            if (this.value == 'N/A') {
                $('.Who_first_left_home_Separation_Div').hide();
                $('#Date_of_Separation').val('');
            }
            else {
                $('.Who_first_left_home_Separation_Div').show();
            }
        });
    });
</script>   
@endsection