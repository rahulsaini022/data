@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_insuranceinfo_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Insurance Info') }}</strong>
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
                    <form role="form" id="dr_insurance" method="POST" action="{{route('drinsurance.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label>Have Health Insurance at your Employer</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_Has_at_Employer_Y_N_Yes" name="Client_Health_Ins_Has_at_Employer_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_Has_at_Employer_Y_N_No" name="Client_Health_Ins_Has_at_Employer_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Have Other Group Health Insurance Plan</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_Has_Other_Group_Plan_Y_N_Yes" name="Client_Health_Ins_Has_Other_Group_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_Has_Other_Group_Plan_Y_N_No" name="Client_Health_Ins_Has_Other_Group_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Co_Name">Health Insurance Company Name</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Co_Name" name="Client_Health_Ins_Co_Name">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Co_Street_Address">Health Insurance Company Street Address</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Co_Street_Address" name="Client_Health_Ins_Co_Street_Address">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Co_City">Health Insurance Company City</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Co_City" name="Client_Health_Ins_Co_City">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Co_State">Health Insurance Company State</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Co_State" name="Client_Health_Ins_Co_State">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Co_ZIP">Health Insurance Company ZIP</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Co_ZIP" name="Client_Health_Ins_Co_ZIP">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are you a Health Insurance Obligor of a Child of THIS Marriage?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage_Yes" name="Client_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage_No" name="Client_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Elects to be Obligor for More than the Max Amount/Limit?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount_Yes" name="Client_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount_No" name="Client_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Policy_Num">Health Insurance Policy Number</label>
                                <input type="text" class="form-control" id="Client_Health_Ins_Policy_Num" name="Client_Health_Ins_Policy_Num">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Health_Insurance_Premium">Monthly Health Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Health_Insurance_Premium" name="Client_Monthly_Health_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan">Number of All Dependants Covered by this Health Insurance</label>
                                <input id="Client_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan" type="number" class="form-control" name="Client_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan">Number of Children from THIS Marriage Covered by this Health Insurance</label>
                                <input id="Client_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan" type="number" class="form-control" name="Client_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are Children from THIS Marriage Already in a Family Plan?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_Children_Already_In_Family_Plan_Y_N_Yes" name="Client_Health_Ins_Children_Already_In_Family_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_Children_Already_In_Family_Plan_Y_N_No" name="Client_Health_Ins_Children_Already_In_Family_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are Children from THIS Marriage Already in an Individual Plan?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Health_Ins_Children_Already_In_Individual_Plan_Y_N_Yes" name="Client_Health_Ins_Children_Already_In_Individual_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Client_Health_Ins_Children_Already_In_Individual_Plan_Y_N_No" name="Client_Health_Ins_Children_Already_In_Individual_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Life_Insurance_Premium">Monthly Life Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Life_Insurance_Premium" name="Client_Monthly_Life_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Auto_Insurance_Premium">Monthly Auto Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Auto_Insurance_Premium" name="Client_Monthly_Auto_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Renters_or_PersonalProperty_Insurance_Premium">Monthly Renters/Property Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Renters_or_PersonalProperty_Insurance_Premium" name="Client_Monthly_Renters_or_PersonalProperty_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Insurance_Type">Other Type of Insurance</label>
                                <input type="text" class="form-control" id="Client_Monthly_Other_Insurance_Type" name="Client_Monthly_Other_Insurance_Type">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Other_Insurance_Premium">Monthly Other Type of Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Other_Insurance_Premium" name="Client_Monthly_Other_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Disability_Insurance_Premium">Monthly Disability Insurance Premium</label>
                                <input type="number" class="form-control" id="Client_Monthly_Disability_Insurance_Premium" name="Client_Monthly_Disability_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                        </div>
                        <!-- End of Client Info Section -->

                        <!-- Opponent Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label>Have Health Insurance at your Employer</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_Has_at_Employer_Y_N_Yes" name="Op_Health_Ins_Has_at_Employer_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_Has_at_Employer_Y_N_No" name="Op_Health_Ins_Has_at_Employer_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Have Other Group Health Insurance Plan</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_Has_Other_Group_Plan_Y_N_Yes" name="Op_Health_Ins_Has_Other_Group_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_Has_Other_Group_Plan_Y_N_No" name="Op_Health_Ins_Has_Other_Group_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Co_Name">Health Insurance Company Name</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Co_Name" name="Op_Health_Ins_Co_Name">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Co_Street_Address">Health Insurance Company Street Address</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Co_Street_Address" name="Op_Health_Ins_Co_Street_Address">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Co_City">Health Insurance Company City</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Co_City" name="Op_Health_Ins_Co_City">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Co_State">Health Insurance Company State</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Co_State" name="Op_Health_Ins_Co_State">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Co_ZIP">Health Insurance Company ZIP</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Co_ZIP" name="Op_Health_Ins_Co_ZIP">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are you a Health Insurance Obligor of a Child of THIS Marriage?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage_Yes" name="Op_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage_No" name="Op_Health_Ins_a_Health_Ins_Obligor_For_Child_This_Marriage" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Elects to be Obligor for More than the Max Amount/Limit?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount_Yes" name="Op_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount_No" name="Op_Health_Ins_Elects_To_Be_Obligor_More_Than_Max_Amount" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Policy_Num">Health Insurance Policy Number</label>
                                <input type="text" class="form-control" id="Op_Health_Ins_Policy_Num" name="Op_Health_Ins_Policy_Num">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Health_Insurance_Premium">Monthly Health Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Health_Insurance_Premium" name="Op_Monthly_Health_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan">Number of All Dependants Covered by this Health Insurance</label>
                                <input id="Op_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan" type="number" class="form-control" name="Op_Health_Ins_Number_Of_All_Dependants_Covered_Family_Plan" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan">Number of Children from THIS Marriage Covered by this Health Insurance</label>
                                <input id="Op_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan" type="number" class="form-control" name="Op_Health_Ins_Num_Children_This_Marriage_Covered_Fam_Plan" value="0" min="0">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are Children from THIS Marriage Already in a Family Plan?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_Children_Already_In_Family_Plan_Y_N_Yes" name="Op_Health_Ins_Children_Already_In_Family_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_Children_Already_In_Family_Plan_Y_N_No" name="Op_Health_Ins_Children_Already_In_Family_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Are Children from THIS Marriage Already in an Individual Plan?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Health_Ins_Children_Already_In_Individual_Plan_Y_N_Yes" name="Op_Health_Ins_Children_Already_In_Individual_Plan_Y_N" value="Yes"> Yes</label>
                                    <label><input type="radio" id="Op_Health_Ins_Children_Already_In_Individual_Plan_Y_N_No" name="Op_Health_Ins_Children_Already_In_Individual_Plan_Y_N" value="No" checked=""> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Life_Insurance_Premium">Monthly Life Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Life_Insurance_Premium" name="Op_Monthly_Life_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Auto_Insurance_Premium">Monthly Auto Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Auto_Insurance_Premium" name="Op_Monthly_Auto_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Renters_or_PersonalProperty_Insurance_Premium">Monthly Renters/Property Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Renters_or_PersonalProperty_Insurance_Premium" name="Op_Monthly_Renters_or_PersonalProperty_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Insurance_Type">Other Type of Insurance</label>
                                <input type="text" class="form-control" id="Op_Monthly_Other_Insurance_Type" name="Op_Monthly_Other_Insurance_Type">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Other_Insurance_Premium">Monthly Other Type of Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Other_Insurance_Premium" name="Op_Monthly_Other_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Disability_Insurance_Premium">Monthly Disability Insurance Premium</label>
                                <input type="number" class="form-control" id="Op_Monthly_Disability_Insurance_Premium" name="Op_Monthly_Disability_Insurance_Premium" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <!-- End of Opponent Info Section -->

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
    $(document).ready(function(){

        $('#dr_insurance').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection