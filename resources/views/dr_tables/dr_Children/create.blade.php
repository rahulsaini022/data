@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_children_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Children Info') }}</strong>
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
                    <form role="form" id="dr_children" method="POST" action="{{route('drchildren.store')}}" autocomplete="off" onsubmit="checkMinorChildrenInfo(event);">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <div class="row form-group num_child_during_marriage">
                            <div class="col-md-12"><h4>Children born to and/or adopted by {{$client_name}} & {{$opponent_name}}.</h4>
                                <div class="col-md-6">
                                    <label for="Num_Children_ONLY_This_Marriage" class="col-form-label text-md-left">Number of children that have born and/or adopted to {{$client_name}} and {{$opponent_name}}</label>
                                    <input id="Num_Children_ONLY_This_Marriage" type="number" class="form-control" name="Num_Children_ONLY_This_Marriage" value="<?php if(isset($drcaseoverview->Num_Children_ONLY_This_Marriage)){ echo $drcaseoverview->Num_Children_Born_ONLY_These_Parties_Before_Marriage + $drcaseoverview->Num_Children_ONLY_This_Marriage; } ?>" min="0" max="8"> 
                                </div>
                               <!--  <div class="col-md-6 marriage_info_section" style="display:none;">
                                    <label for="Num_MinorDepChildren_ONLY_This_Marriage" class="col-form-label text-md-left">How many children are Minor and/or otherwise Dependent in this marriage?</label>
                                    <input id="Num_MinorDepChildren_ONLY_This_Marriage" type="number" class="form-control" name="Num_MinorDepChildren_ONLY_This_Marriage" value="<?php //if(isset($drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage)){ echo $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage; } ?>" min="0" max="8"> 
                                </div> -->
                            </div>
                        </div>
                        <!-- This Marriage Info Section -->
                        <div class="row form-group marriage_info_section" style="display: none;">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <label class="col-form-label text-md-left">Custody arrangement? </label><br>
                                    <label for="This_Marriage_Custody_Arrangement_Shared" class="radio-label">Shared
                                        <input id="This_Marriage_Custody_Arrangement_Shared" type="radio" name="This_Marriage_Custody_Arrangement" value="Shared" checked="">
                                    </label>
                                    <label for="This_Marriage_Custody_Arrangement_Sole" class="radio-label">Sole
                                        <input id="This_Marriage_Custody_Arrangement_Sole" type="radio" name="This_Marriage_Custody_Arrangement" value="Sole"> 
                                    </label>
                                    <label for="This_Marriage_Custody_Arrangement_Split" class="radio-label">Split
                                        <input id="This_Marriage_Custody_Arrangement_Split" type="radio" name="This_Marriage_Custody_Arrangement" value="Split"> 
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label text-md-left">Child Support Obligor? </label><br>
                                    <label for="This_Marriage_Child_Support_Obligor_CLient_OP_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Child_Support_Obligor_CLient_OP_ClientName" type="radio" name="This_Marriage_Child_Support_Obligor_CLient_OP" class="obligor_ClientName" value="{{$client_name}}">
                                    </label>
                                    <label for="This_Marriage_Child_Support_Obligor_CLient_OP_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Child_Support_Obligor_CLient_OP_OpName" type="radio" name="This_Marriage_Child_Support_Obligor_CLient_OP" class="obligor_OpName" value="{{$opponent_name}}" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label text-md-left">Health Insurance Obligor? </label><br>
                                    <label for="This_Marriage_Health_Ins_Obligor_CLient_OP_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Health_Ins_Obligor_CLient_OP_ClientName" type="radio" name="This_Marriage_Health_Ins_Obligor_CLient_OP" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Health_Ins_Obligor_CLient_OP_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Health_Ins_Obligor_CLient_OP_OpName" type="radio" name="This_Marriage_Health_Ins_Obligor_CLient_OP" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Health_Ins_Obligor_Neither_Party" class="radio-label">Neither Party
                                        <input id="This_Marriage_Health_Ins_Obligor_Neither_Party" type="radio" name="This_Marriage_Health_Ins_Obligor_CLient_OP" value="Neither Party"> 
                                    </label>
                                    <label for="This_Marriage_Health_Ins_Obligor_Both_Parties" class="radio-label">Both Parties
                                        <input id="This_Marriage_Health_Ins_Obligor_Both_Parties" type="radio" name="This_Marriage_Health_Ins_Obligor_CLient_OP" value="Both Parties"> 
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 1_child_info_section" style="display: none;"><h5>First Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_First_Child_FirstName" type="text" class="form-control" name="This_Marriage_First_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_First_Child_MiddleName" type="text" class="form-control" name="This_Marriage_First_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_First_Child_LastName" type="text" class="form-control" name="This_Marriage_First_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_First_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_First_Child_Gender_Male" type="radio" name="This_Marriage_First_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_First_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_First_Child_Gender_Female" type="radio" name="This_Marriage_First_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_First_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_First_Child_Gender_Other" type="radio" name="This_Marriage_First_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_First_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_First_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_First_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_First_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_First_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_First_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_First_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_First_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_First_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_First_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_First_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_First_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_First_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_First_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_First_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_First_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_First_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_First_Child_Resides_With_ClientName" type="radio" name="This_Marriage_First_Child_Resides_With" class="This_Marriage_Child_Resides_With First ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_First_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_First_Child_Resides_With_OpName" type="radio" name="This_Marriage_First_Child_Resides_With" class="This_Marriage_Child_Resides_With First OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_First_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_First_Child_Resides_With_Both" type="radio" name="This_Marriage_First_Child_Resides_With" class="This_Marriage_Child_Resides_With First Both" value="Both">
                                    <label for="This_Marriage_First_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_First_Child_Resides_With_Other" type="radio" name="This_Marriage_First_Child_Resides_With" class="This_Marriage_Child_Resides_With First Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_First_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_First_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_First_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With First ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'First');">
                                    </label>
                                    <label for="This_Marriage_First_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_First_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_First_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With First OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'First');"> 
                                    </label>
                                    <label for="This_Marriage_First_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_First_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_First_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With First Other" value="Other" onchange="willResideWithOther(this,'First');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 First_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_First_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_First_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_First_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_First_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_First_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_First_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes First ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_First_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_First_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_First_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes First OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_First_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_First_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_First_Child_School" type="text" class="form-control" name="This_Marriage_First_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_First_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_First_Child_Grade" name="This_Marriage_First_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_First_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_First_First_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_First_Child_Sub_to_Court_Order" class="This_Marriage_First_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_First_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_First_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_First_Child_Sub_to_Court_Order" class="This_Marriage_First_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_First_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_First_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_First_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_First_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_First_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_First_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 2_child_info_section" style="display: none;"><h5>Second Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Second_Child_FirstName" type="text" class="form-control" name="This_Marriage_Second_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Second_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Second_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Second_Child_LastName" type="text" class="form-control" name="This_Marriage_Second_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Second_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Second_Child_Gender_Male" type="radio" name="This_Marriage_Second_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Second_Child_Gender_Female" type="radio" name="This_Marriage_Second_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Second_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Second_Child_Gender_Other" type="radio" name="This_Marriage_Second_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Second_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Second_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Second_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Second_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Second_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Second_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Second_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Second_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Second_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Second_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Second_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Second_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Second_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Second_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Second_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Second_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Second_Child_Resides_With" class="This_Marriage_Child_Resides_With Second ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Second_Child_Resides_With_OpName" type="radio" name="This_Marriage_Second_Child_Resides_With" class="This_Marriage_Child_Resides_With Second OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Second_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Second_Child_Resides_With_Both" type="radio" name="This_Marriage_Second_Child_Resides_With" class="This_Marriage_Child_Resides_With Second Both" value="Both">
                                    <label for="This_Marriage_Second_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Second_Child_Resides_With_Other" type="radio" name="This_Marriage_Second_Child_Resides_With" class="This_Marriage_Child_Resides_With Second Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Second_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Second_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Second_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Second ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Second');">
                                    </label>
                                    <label for="This_Marriage_Second_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Second_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Second_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Second OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Second');"> 
                                    </label>
                                    <label for="This_Marriage_Second_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Second_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Second_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Second Other" value="Other" onchange="willResideWithOther(this,'Second');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Second_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Second_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Second_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Second_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Second_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Second_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Second_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Second ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Second_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Second_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Second OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Second_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Second_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Second_Child_School" type="text" class="form-control" name="This_Marriage_Second_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Second_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Second_Child_Grade" name="This_Marriage_Second_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Second_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Third_Second_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Second_Child_Sub_to_Court_Order" class="This_Marriage_Second_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Second_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Second_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Second_Child_Sub_to_Court_Order" class="This_Marriage_Second_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Second_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Second_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_Second_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Second_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Second_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Second_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 3_child_info_section" style="display: none;"><h5>Third Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Third_Child_FirstName" type="text" class="form-control" name="This_Marriage_Third_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Third_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Third_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Third_Child_LastName" type="text" class="form-control" name="This_Marriage_Third_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Third_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Third_Child_Gender_Male" type="radio" name="This_Marriage_Third_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Third_Child_Gender_Female" type="radio" name="This_Marriage_Third_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Third_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Third_Child_Gender_Other" type="radio" name="This_Marriage_Third_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Third_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Third_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves?</label><br>
                                    <label for="This_Marriage_Third_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Third_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Third_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Third_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Third_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Third_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Third_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Third_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Third_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Third_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Third_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Third_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Third_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Third_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Third_Child_Resides_With" class="This_Marriage_Child_Resides_With Third ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Third_Child_Resides_With_OpName" type="radio" name="This_Marriage_Third_Child_Resides_With" class="This_Marriage_Child_Resides_With Third OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Third_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Third_Child_Resides_With_Both" type="radio" name="This_Marriage_Third_Child_Resides_With" class="This_Marriage_Child_Resides_With Third Both" value="Both">
                                    <label for="This_Marriage_Third_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Third_Child_Resides_With_Other" type="radio" name="This_Marriage_Third_Child_Resides_With" class="This_Marriage_Child_Resides_With Third Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Third_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Third_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Third_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Third ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Third');">
                                    </label>
                                    <label for="This_Marriage_Third_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Third_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Third_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Third OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Third');"> 
                                    </label>
                                    <label for="This_Marriage_Third_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Third_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Third_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Third Other" value="Other" onchange="willResideWithOther(this,'Third');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Third_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Third_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Third_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Third_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Third_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Third_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Third_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Third ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Third_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Third_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Third OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Third_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Third_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Third_Child_School" type="text" class="form-control" name="This_Marriage_Third_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Third_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Third_Child_Grade" name="This_Marriage_Third_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Third_Child_Sub_to_Court_Order" class="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Third_Child_Sub_to_Court_Order" class="This_Marriage_Third_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Third_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Third_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_Third_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Third_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Third_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Third_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 4_child_info_section" style="display: none;"><h5>Fourth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Fourth_Child_FirstName" type="text" class="form-control" name="This_Marriage_Fourth_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Fourth_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Fourth_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Fourth_Child_LastName" type="text" class="form-control" name="This_Marriage_Fourth_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Fourth_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Fourth_Child_Gender_Male" type="radio" name="This_Marriage_Fourth_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Fourth_Child_Gender_Female" type="radio" name="This_Marriage_Fourth_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fourth_Child_Gender_Other" type="radio" name="This_Marriage_Fourth_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Fourth_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Fourth_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Fourth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Fourth_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fourth_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Fourth_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fourth_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Fourth_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Fourth_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Fourth_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Fourth_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fourth_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Fourth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fourth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fourth_Child_Resides_With_OpName" type="radio" name="This_Marriage_Fourth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fourth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Fourth_Child_Resides_With_Both" type="radio" name="This_Marriage_Fourth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fourth Both" value="Both">
                                    <label for="This_Marriage_Fourth_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fourth_Child_Resides_With_Other" type="radio" name="This_Marriage_Fourth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fourth Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Fourth_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fourth_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Fourth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fourth ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Fourth');">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fourth_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Fourth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fourth OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Fourth');"> 
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fourth_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Fourth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fourth Other" value="Other" onchange="willResideWithOther(this,'Fourth');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Fourth_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Fourth_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Fourth_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Fourth_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Fourth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Fourth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Fourth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Fourth_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Fourth_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Fourth_Child_School" type="text" class="form-control" name="This_Marriage_Fourth_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fourth_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Fourth_Child_Grade" name="This_Marriage_Fourth_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Fourth_Child_Sub_to_Court_Order" class="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Fourth_Child_Sub_to_Court_Order" class="This_Marriage_Fourth_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Fourth_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Fourth_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_Fourth_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Fourth_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Fourth_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Fourth_Child_Court_Case_Num" value=""> 
                                </div>

                            </div>

                            <div class="col-md-12 mt-4 5_child_info_section" style="display: none;"><h5>Fifth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Fifth_Child_FirstName" type="text" class="form-control" name="This_Marriage_Fifth_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Fifth_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Fifth_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Fifth_Child_LastName" type="text" class="form-control" name="This_Marriage_Fifth_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Fifth_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Fifth_Child_Gender_Male" type="radio" name="This_Marriage_Fifth_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Fifth_Child_Gender_Female" type="radio" name="This_Marriage_Fifth_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fifth_Child_Gender_Other" type="radio" name="This_Marriage_Fifth_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Fifth_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Fifth_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Fifth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Fifth_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fifth_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Fifth_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fifth_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Fifth_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Fifth_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Fifth_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Fifth_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fifth_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Fifth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fifth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fifth_Child_Resides_With_OpName" type="radio" name="This_Marriage_Fifth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fifth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Fifth_Child_Resides_With_Both" type="radio" name="This_Marriage_Fifth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fifth Both" value="Both">
                                    <label for="This_Marriage_Fifth_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fifth_Child_Resides_With_Other" type="radio" name="This_Marriage_Fifth_Child_Resides_With" class="This_Marriage_Child_Resides_With Fifth Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Fifth_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fifth_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Fifth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fifth ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Fifth');">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fifth_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Fifth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fifth OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Fifth');"> 
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Fifth_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Fifth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Fifth Other" value="Other" onchange="willResideWithOther(this,'Fifth');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Fifth_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Fifth_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Fifth_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Fifth_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Fifth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Fifth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Fifth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Fifth_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Fifth_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Fifth_Child_School" type="text" class="form-control" name="This_Marriage_Fifth_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Fifth_Child_Grade" name="This_Marriage_Fifth_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Fifth_Child_Sub_to_Court_Order" class="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Fifth_Child_Sub_to_Court_Order" class="This_Marriage_Fifth_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Fifth_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Fifth_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_Fifth_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Fifth_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Fifth_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Fifth_Child_Court_Case_Num" value=""> 
                                </div>

                            </div>

                            <div class="col-md-12 mt-4 6_child_info_section" style="display: none;"><h5>Sixth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Fifth_Child_FirstName" type="text" class="form-control" name="This_Marriage_Fifth_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Fifth_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Fifth_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Fifth_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Sixth_Child_LastName" type="text" class="form-control" name="This_Marriage_Sixth_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Sixth_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Sixth_Child_Gender_Male" type="radio" name="This_Marriage_Sixth_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Sixth_Child_Gender_Female" type="radio" name="This_Marriage_Sixth_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Sixth_Child_Gender_Other" type="radio" name="This_Marriage_Sixth_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Sixth_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Sixth_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Sixth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Sixth_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Sixth_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Sixth_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Sixth_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Sixth_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Sixth_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Sixth_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Sixth_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Sixth_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Sixth_Child_Resides_With" class="This_Marriage_Child_Resides_With Sixth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Sixth_Child_Resides_With_OpName" type="radio" name="This_Marriage_Sixth_Child_Resides_With" class="This_Marriage_Child_Resides_With Sixth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Sixth_Child_Resides_With_Both" type="radio" name="This_Marriage_Sixth_Child_Resides_With" class="This_Marriage_Child_Resides_With Sixth Both" value="Both">
                                    <label for="This_Marriage_Sixth_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Sixth_Child_Resides_With_Other" type="radio" name="This_Marriage_Sixth_Child_Resides_With" class="This_Marriage_Child_Resides_With Sixth Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Sixth_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Sixth_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Sixth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Sixth ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Sixth');">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Sixth_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Sixth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Sixth OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Sixth');"> 
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Sixth_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Sixth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Sixth Other" value="Other" onchange="willResideWithOther(this,'Sixth');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Sixth_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Sixth_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Sixth_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Sixth_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Sixth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Sixth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Sixth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Sixth_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Sixth_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Sixth_Child_School" type="text" class="form-control" name="This_Marriage_Sixth_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Sixth_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Sixth_Child_Grade" name="This_Marriage_Sixth_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Sixth_Child_Sub_to_Court_Order" class="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Sixth_Child_Sub_to_Court_Order" class="This_Marriage_Sixth_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Sixth_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Sixth_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_Sixth_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Sixth_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Sixth_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Sixth_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 7_child_info_section" style="display: none;"><h5>Seventh Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Seventh_Child_FirstName" type="text" class="form-control" name="This_Marriage_Seventh_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Seventh_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Seventh_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Seventh_Child_LastName" type="text" class="form-control" name="This_Marriage_Seventh_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Seventh_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Seventh_Child_Gender_Male" type="radio" name="This_Marriage_Seventh_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Seventh_Child_Gender_Female" type="radio" name="This_Marriage_Seventh_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Seventh_Child_Gender_Other" type="radio" name="This_Marriage_Seventh_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Seventh_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Seventh_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Seventh_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Seventh_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Seventh_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Seventh_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Seventh_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Seventh_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Seventh_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Seventh_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Seventh_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Seventh_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Seventh_Child_Resides_With" class="This_Marriage_Child_Resides_With Seventh ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Seventh_Child_Resides_With_OpName" type="radio" name="This_Marriage_Seventh_Child_Resides_With" class="This_Marriage_Child_Resides_With Seventh OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Seventh_Child_Resides_With_Both" type="radio" name="This_Marriage_Seventh_Child_Resides_With" class="This_Marriage_Child_Resides_With Seventh Both" value="Both">
                                    <label for="This_Marriage_Seventh_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Seventh_Child_Resides_With_Other" type="radio" name="This_Marriage_Seventh_Child_Resides_With" class="This_Marriage_Child_Resides_With Seventh Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Seventh_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Seventh_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Seventh_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Seventh ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Seventh');">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Seventh_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Seventh_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Seventh OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Seventh');"> 
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Seventh_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Seventh_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Seventh Other" value="Other" onchange="willResideWithOther(this,'Seventh');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Seventh_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Seventh_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Seventh_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Seventh_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Seventh ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Seventh_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Seventh OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Seventh_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Seventh_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Seventh_Child_School" type="text" class="form-control" name="This_Marriage_Seventh_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Seventh_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Seventh_Child_Grade" name="This_Marriage_Seventh_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>
                                <div class="col-md-6">
                                    <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                                    <br>
                                    <label for="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Seventh_Child_Sub_to_Court_Order" class="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Seventh_Child_Sub_to_Court_Order" class="This_Marriage_Seventh_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Seventh_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Seventh_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_First_Child_Court" value=""> 
                                </div>

                                <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Seventh_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Seventh_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Seventh_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 8_child_info_section" style="display: none;"><h5>Eighth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="This_Marriage_Eighth_Child_FirstName" type="text" class="form-control" name="This_Marriage_Eighth_Child_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="This_Marriage_Eighth_Child_MiddleName" type="text" class="form-control" name="This_Marriage_Eighth_Child_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="This_Marriage_Eighth_Child_LastName" type="text" class="form-control" name="This_Marriage_Eighth_Child_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Gender </label><br>
                                    <label for="This_Marriage_Eighth_Child_Gender_Male" class="radio-label">Male
                                        <input id="This_Marriage_Eighth_Child_Gender_Male" type="radio" name="This_Marriage_Eighth_Child_Gender" value="Male" checked="">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Gender_Female" class="radio-label">Female
                                        <input id="This_Marriage_Eighth_Child_Gender_Female" type="radio" name="This_Marriage_Eighth_Child_Gender" value="Female"> 
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Gender_Other" class="radio-label">Other
                                        <input id="This_Marriage_Eighth_Child_Gender_Other" type="radio" name="This_Marriage_Eighth_Child_Gender" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="This_Marriage_Eighth_Child_DOB" type="text" class="form-control hasDatepicker Child_DOB" autocomplete="nope" name="This_Marriage_Eighth_Child_DOB" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N_Yes" type="radio" name="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="Yes">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N_No" type="radio" name="This_Marriage_Eighth_Child_Disabled_Dependent_Y_N" class="This_Marriage_Child_Disabled_Dependent_Y_N" value="NO" checked=""> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Paternity Established </label><br>
                                    <label for="This_Marriage_Eighth_Child_Paternity_Established_Y_N_Yes" class="radio-label">YES
                                        <input id="This_Marriage_Eighth_Child_Paternity_Established_Y_N_Yes" type="radio" name="This_Marriage_Eighth_Child_Paternity_Established_Y_N" value="Yes"  checked="">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Paternity_Established_Y_N_No" class="radio-label">NO
                                        <input id="This_Marriage_Eighth_Child_Paternity_Established_Y_N_No" type="radio" name="This_Marriage_Eighth_Child_Paternity_Established_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_SSN" class="col-form-label text-md-left">SSN</label>
                                    <input id="This_Marriage_Eighth_Child_SSN" type="text" class="form-control SSN_format" placeholder="XXX-XX-XXXX" pattern="[0-9]{3}-[0-9]{2}-[0-9]{4}" name="This_Marriage_Eighth_Child_SSN" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with </label><br>
                                    <label for="This_Marriage_Eighth_Child_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Eighth_Child_Resides_With_ClientName" type="radio" name="This_Marriage_Eighth_Child_Resides_With" class="This_Marriage_Child_Resides_With Eighth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Eighth_Child_Resides_With_OpName" type="radio" name="This_Marriage_Eighth_Child_Resides_With" class="This_Marriage_Child_Resides_With Eighth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Resides_With_Both" class="radio-label">Both
                                        <input id="This_Marriage_Eighth_Child_Resides_With_Both" type="radio" name="This_Marriage_Eighth_Child_Resides_With" class="This_Marriage_Child_Resides_With EightBoth" value="Both">
                                    <label for="This_Marriage_Eighth_Child_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Eighth_Child_Resides_With_Other" type="radio" name="This_Marriage_Eighth_Child_Resides_With" class="This_Marriage_Child_Resides_With Eighth Other" value="Other"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Will Reside with </label><br>
                                    <label for="This_Marriage_Eighth_Child_WILL_Resides_With_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Eighth_Child_WILL_Resides_With_ClientName" type="radio" name="This_Marriage_Eighth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Eighth ClientName" value="{{$client_name}}" checked="" onchange="willResideWithOther(this,'Eight');">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_WILL_Resides_With_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Eighth_Child_WILL_Resides_With_OpName" type="radio" name="This_Marriage_Eighth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Eighth OpName" value="{{$opponent_name}}" onchange="willResideWithOther(this,'Eight');"> 
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_WILL_Resides_With_Other" class="radio-label">Other
                                        <input id="This_Marriage_Eighth_Child_WILL_Resides_With_Other" type="radio" name="This_Marriage_Eighth_Child_WILL_Resides_With" class="This_Marriage_Child_WILL_Resides_With Eighth Other" value="Other" onchange="willResideWithOther(this,'Eight');"> 
                                    </label>
                                </div>
                                <div class="col-md-6 Eighth_Child_WILL_Resides_With_Other_Div" style="display: none;">
                                    <label for="This_Marriage_Eighth_Child_WILL_Resides_With_Other" class="col-form-label text-md-left">Name of Person Will Reside with</label>
                                    <input id="This_Marriage_Eighth_Child_WILL_Resides_With_Other" type="text" class="form-control" name="This_Marriage_Eighth_Child_WILL_Resides_With_Other" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Residential Parent for School Purposes </label><br>
                                    <label for="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes_ClientName" class="radio-label">{{$client_name}}
                                        <input id="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes_ClientName" type="radio" name="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Eighth ClientName" value="{{$client_name}}" checked="">
                                    </label>
                                    <label for="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes_OpName" class="radio-label">{{$opponent_name}}
                                        <input id="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes_OpName" type="radio" name="This_Marriage_Eighth_Child_Residential_Parent_School_Purposes" class="This_Marriage_Child_Residential_Parent_School_Purposes Eighth OpName" value="{{$opponent_name}}"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_Emp_or_School_Related_Childcare" class="col-form-label text-md-left">Monthly Employment/School Related Childcare Amount</label>
                                    <input id="This_Marriage_Eighth_Child_Emp_or_School_Related_Childcare" type="number" class="form-control" name="This_Marriage_Eighth_Child_Emp_or_School_Related_Childcare" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_School" class="col-form-label text-md-left">School</label>
                                    <input id="This_Marriage_Eighth_Child_School" type="text" class="form-control" name="This_Marriage_Eighth_Child_School" value=""> 
                                </div>
                                <div class="col-md-6">
                                    <label for="This_Marriage_Eighth_Child_Grade" class="col-form-label text-md-left">Grade</label>
                                    <select id="This_Marriage_Eighth_Child_Grade" name="This_Marriage_Eighth_Child_Grade" class="form-control">
                                        <option value="">Select</option>
                                        <option value="K">K</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>   
                                </div>

                                <div class="col-md-6">
                            <label for="Subject to an existing order of parenting or support from another Court?">Subject to an existing order of parenting or support from another Court?</label>
                            <br>
                            <label for="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N_Yes" class="radio-label">YES
                                <input id="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N_Yes" type="radio" name="This_Marriage_Eighth_Child_Sub_to_Court_Order" class="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N" value="Yes">
                            </label>
                            <label for="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N_No" class="radio-label">NO
                                <input id="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N_No" type="radio" name="This_Marriage_Eighth_Child_Sub_to_Court_Order" class="This_Marriage_Eighth_Child_Sub_to_Court_Order_Y_N" value="NO" checked=""> 
                            </label>
                        </div>

                                 <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Eighth_Child_Court" class="col-form-label text-md-left">Which Court?</label>
                                    <input id="This_Marriage_Eighth_Child_Court" type="text" class="form-control Child_Court" name="This_Marriage_First_Child_Court" value=""> 
                                </div>

                                    <div class="col-md-6" style="display: none;">
                                    <label for="This_Marriage_Eighth_Child_Court_Case_Num" class="col-form-label text-md-left">Case Number?</label>
                                    <input id="This_Marriage_Eighth_Child_Court_Case_Num" type="text" class="form-control Case_Num" name="This_Marriage_Eighth_Child_Court_Case_Num" value=""> 
                                </div>
                            </div>


                        </div>
                        

                        <!-- End of This Marriage Info Section -->

                        <!-- Client Info Section -->
                        <div class="row form-group mt-5 client_num_child_during_marriage marriage_info_section" style="display: none;">
                            <div class="col-md-12"><h4>{{$client_name}}’s Children not born/adopted during Marriage</h4>
                                <div class="col-md-6">
                                    <label for="Num_Client_Children_NOT_this_Marris_age" class="col-form-label text-md-left">Number of {{$client_name}}’s children not born/adopted during marriage?</label>
                                    <input id="Num_Client_Children_NOT_this_Marriage" type="number" class="form-control" name="Num_Client_Children_NOT_this_Marriage" value="<?php if(isset($drcaseoverview->Num_Client_Children_NOT_this_Marriage)){ echo $drcaseoverview->Num_Client_Children_NOT_this_Marriage; } ?>" min="0" max="6"> 
                                </div>
                            </div>
                        </div>
                        <div class="row form-group client_child_info_section">
                            <div class="col-md-12 mt-4 1_client_child_info_section" style="display: none;"><h5>First Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_First_Child_NOM_FirstName" type="text" class="form-control" name="Client_First_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_First_Child_NOM_MiddleName" type="text" class="form-control" name="Client_First_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_First_Child_NOM_LastName" type="text" class="form-control" name="Client_First_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_First_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_First_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_First_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_First_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_First_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_First_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Client_First_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_First_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_First_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_First_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_First_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_First_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_First_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_First_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_First_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_First_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_First_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_First_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_First_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_First_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_First_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_First_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_First_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_First_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_First_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_First_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_First_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 2_client_child_info_section" style="display: none;"><h5>Second Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_Second_Child_NOM_FirstName" type="text" class="form-control" name="Client_Second_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_Second_Child_NOM_MiddleName" type="text" class="form-control" name="Client_Second_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_Second_Child_NOM_LastName" type="text" class="form-control" name="Client_Second_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_Second_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_Second_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_Second_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Second_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_Second_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Second_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Client_Second_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_Second_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_Second_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Second_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_Second_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Second_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_Second_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_Second_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_Second_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_Second_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_Second_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_Second_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_Second_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_Second_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_Second_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_Second_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_Second_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Second_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_Second_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_Second_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 3_client_child_info_section" style="display: none;"><h5>Third Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_Third_Child_NOM_FirstName" type="text" class="form-control" name="Client_Third_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_Third_Child_NOM_MiddleName" type="text" class="form-control" name="Client_Third_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_Third_Child_NOM_LastName" type="text" class="form-control" name="Client_Third_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_Third_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_Third_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_Third_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Third_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_Third_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Third_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Client_Third_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_Third_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_Third_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Third_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_Third_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Third_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_Third_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_Third_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_Third_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_Third_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_Third_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_Third_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_Third_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_Third_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_Third_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_Third_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_Third_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Third_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_Third_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_Third_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 4_client_child_info_section" style="display: none;"><h5>Fourth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_Fourth_Child_NOM_FirstName" type="text" class="form-control" name="Client_Fourth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_Fourth_Child_NOM_MiddleName" type="text" class="form-control" name="Client_Fourth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_Fourth_Child_NOM_LastName" type="text" class="form-control" name="Client_Fourth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_Fourth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_Fourth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N_NO class="radio-label">NO
                                        <input id="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_Fourth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_Fourth_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Fourth_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_Fourth_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Fourth_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_Fourth_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_Fourth_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_Fourth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_Fourth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_Fourth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_Fourth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_Fourth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_Fourth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_Fourth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_Fourth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fourth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_Fourth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_Fourth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 5_client_child_info_section" style="display: none;"><h5>Fifth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_Fifth_Child_NOM_FirstName" type="text" class="form-control" name="Client_Fifth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_Fifth_Child_NOM_MiddleName" type="text" class="form-control" name="Client_Fifth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_Fifth_Child_NOM_LastName" type="text" class="form-control" name="Client_Fifth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_Fifth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_Fifth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_Fifth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_Fifth_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Fifth_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_Fifth_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Fifth_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_Fifth_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_Fifth_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_Fifth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_Fifth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_Fifth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_Fifth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_Fifth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_Fifth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_Fifth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_Fifth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Fifth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_Fifth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_Fifth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 6_client_child_info_section" style="display: none;"><h5>Sixth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Client_Sixth_Child_NOM_FirstName" type="text" class="form-control" name="Client_Sixth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Client_Sixth_Child_NOM_MiddleName" type="text" class="form-control" name="Client_Sixth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Client_Sixth_Child_NOM_LastName" type="text" class="form-control" name="Client_Sixth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Client_Sixth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Client_Sixth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Client_Sixth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Client </label><br>
                                    <label for="Client_Sixth_Child_NOM_Resides_with_Client_Y_N_Yes" class="radio-label">Yes
                                        <input id="Client_Sixth_Child_NOM_Resides_with_Client_Y_N_Yes" type="radio" name="Client_Sixth_Child_NOM_Resides_with_Client_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Client_Sixth_Child_NOM_Resides_with_Client_Y_N_No" class="radio-label">NO
                                        <input id="Client_Sixth_Child_NOM_Resides_with_Client_Y_N_No" type="radio" name="Client_Sixth_Child_NOM_Resides_with_Client_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Client for this Child</label>
                                    <input id="Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Client_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Client for this Child</label>
                                    <input id="Client_Sixth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Client_Sixth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Client_Sixth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Client_Sixth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Client_Sixth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Client_Sixth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Client_Sixth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Client_Sixth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Client_Sixth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Client_Sixth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Client_Sixth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                        </div>
                        <!-- End of Client Info Section -->

                        <!-- Opponent Info Section -->
                        <div class="row form-group mt-5 opponent_num_child_during_marriage marriage_info_section" style="display: none;">
                            <div class="col-md-12"><h4>{{$opponent_name}}’s Children not born/adopted during Marriage</h4>
                                <div class="col-md-6">
                                    <label for="Num_Op_Children_NOT_this_Marriage" class="col-form-label text-md-left">Number of {{$opponent_name}}’s children not born/adopted during marriage?</label>
                                    <input id="Num_Op_Children_NOT_this_Marriage" type="number" class="form-control" name="Num_Op_Children_NOT_this_Marriage" value="<?php if(isset($drcaseoverview->Num_Op_Children_NOT_this_Marriage)){ echo $drcaseoverview->Num_Op_Children_NOT_this_Marriage; } ?>" min="0" max="6"> 
                                </div>
                            </div>
                        </div>
                        <div class="row form-group opponent_child_info_section">
                            <div class="col-md-12 mt-4 1_opponent_child_info_section" style="display: none;"><h5>First Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_First_Child_NOM_FirstName" type="text" class="form-control" name="Op_First_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_First_Child_NOM_MiddleName" type="text" class="form-control" name="Op_First_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_First_Child_NOM_LastName" type="text" class="form-control" name="Op_First_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_First_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_First_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Op_First_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_First_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_First_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_First_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_First_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_First_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_First_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_First_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_First_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_First_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_First_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_First_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_First_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_First_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_First_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_First_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_First_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_First_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_First_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_First_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_First_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_First_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_First_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_First_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_First_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 2_opponent_child_info_section" style="display: none;"><h5>Second Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_Second_Child_NOM_FirstName" type="text" class="form-control" name="Op_Second_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_Second_Child_NOM_MiddleName" type="text" class="form-control" name="Op_Second_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_Second_Child_NOM_LastName" type="text" class="form-control" name="Op_Second_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_Second_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_Second_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Op_Second_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Second_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_Second_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Second_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_Second_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_Second_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_Second_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Second_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_Second_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Second_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_Second_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_Second_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_Second_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_Second_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_Second_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_Second_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_Second_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_Second_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_Second_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_Second_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_Second_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_Second_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Second_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_Second_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_Second_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 3_opponent_child_info_section" style="display: none;"><h5>Third Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_Third_Child_NOM_FirstName" type="text" class="form-control" name="Op_Third_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_Third_Child_NOM_MiddleName" type="text" class="form-control" name="Op_Third_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_Third_Child_NOM_LastName" type="text" class="form-control" name="Op_Third_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_Third_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_Third_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Op_Third_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Third_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_Third_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Third_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_Third_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_Third_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_Third_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Third_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_Third_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Third_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_Third_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_Third_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_Third_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_Third_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_Third_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_Third_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_Third_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_Third_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_Third_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_Third_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_Third_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_Third_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Third_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_Third_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_Third_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 4_opponent_child_info_section" style="display: none;"><h5>Fourth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_Fourth_Child_NOM_FirstName" type="text" class="form-control" name="Op_Fourth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_Fourth_Child_NOM_MiddleName" type="text" class="form-control" name="Op_Fourth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_Fourth_Child_NOM_LastName" type="text" class="form-control" name="Op_Fourth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_Fourth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_Fourth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_Fourth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_Fourth_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Fourth_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_Fourth_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Fourth_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_Fourth_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_Fourth_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_Fourth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_Fourth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_Fourth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_Fourth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_Fourth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_Fourth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_Fourth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_Fourth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_Fourth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fourth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_Fourth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_Fourth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 5_opponent_child_info_section" style="display: none;"><h5>Fifth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_Fifth_Child_NOM_FirstName" type="text" class="form-control" name="Op_Fifth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_Fifth_Child_NOM_MiddleName" type="text" class="form-control" name="Op_Fifth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_Fifth_Child_NOM_LastName" type="text" class="form-control" name="Op_Fifth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_Fifth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_Fifth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves?</label><br>
                                    <label for="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_Fifth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_Fifth_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Fifth_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_Fifth_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Fifth_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_Fifth_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_Fifth_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_Fifth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_Fifth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_Fifth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_Fifth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_Fifth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_Fifth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_Fifth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_Fifth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_Fifth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Fifth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_Fifth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_Fifth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 6_opponent_child_info_section" style="display: none;"><h5>Sixth Child Info</h5>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_FirstName" class="col-form-label text-md-left">First Name</label>
                                    <input id="Op_Sixth_Child_NOM_FirstName" type="text" class="form-control" name="Op_Sixth_Child_NOM_FirstName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_MiddleName" class="col-form-label text-md-left">Middle Name</label>
                                    <input id="Op_Sixth_Child_NOM_MiddleName" type="text" class="form-control" name="Op_Sixth_Child_NOM_MiddleName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_LastName" class="col-form-label text-md-left">Last Name</label>
                                    <input id="Op_Sixth_Child_NOM_LastName" type="text" class="form-control" name="Op_Sixth_Child_NOM_LastName" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_DOB" class="col-form-label text-md-left">Date of Birth</label>
                                    <input id="Op_Sixth_Child_NOM_DOB" type="text" class="form-control hasDatepicker" autocomplete="nope" name="Op_Sixth_Child_NOM_DOB" value="">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Mentally or physically disabled and incapable of supporting/maintaining themselves? </label><br>
                                    <label for="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N_Yes" type="radio" name="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N_No" class="radio-label">NO
                                        <input id="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N_No" type="radio" name="Op_Sixth_Child_NOM_Disabled_Dependent_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label text-md-left">Resides with Opponent </label><br>
                                    <label for="Op_Sixth_Child_NOM_Resides_with_Op_Y_N_Yes" class="radio-label">Yes
                                        <input id="Op_Sixth_Child_NOM_Resides_with_Op_Y_N_Yes" type="radio" name="Op_Sixth_Child_NOM_Resides_with_Op_Y_N" value="Yes" checked="">
                                    </label>
                                    <label for="Op_Sixth_Child_NOM_Resides_with_Op_Y_N_No" class="radio-label">NO
                                        <input id="Op_Sixth_Child_NOM_Resides_with_Op_Y_N_No" type="radio" name="Op_Sixth_Child_NOM_Resides_with_Op_Y_N" value="NO"> 
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" class="col-form-label text-md-left">Amount of Child Support RECEIVED by Opponent for this Child</label>
                                    <input id="Op_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" type="number" class="form-control" name="Op_Sixth_Child_NOM_Monthly_Child_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_Monthly_Child_Support_PAID" class="col-form-label text-md-left">Amount of Child Support PAID by Opponent for this Child</label>
                                    <input id="Op_Sixth_Child_NOM_Monthly_Child_Support_PAID" type="number" class="form-control" name="Op_Sixth_Child_NOM_Monthly_Child_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_AbsentParent_Full_Name" class="col-form-label text-md-left">Absent Parent Full Name</label>
                                    <input id="Op_Sixth_Child_NOM_AbsentParent_Full_Name" type="text" class="form-control" name="Op_Sixth_Child_NOM_AbsentParent_Full_Name" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_AbsentParent_StreetAddress" class="col-form-label text-md-left">Absent Parent Street Address</label>
                                    <input id="Op_Sixth_Child_NOM_AbsentParent_StreetAddress" type="text" class="form-control" name="Op_Sixth_Child_NOM_AbsentParent_StreetAddress" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_AbsentParent_City_State_ZIP" class="col-form-label text-md-left">Absent Parent City, State ZIP</label>
                                    <input id="Op_Sixth_Child_NOM_AbsentParent_City_State_ZIP" type="text" class="form-control" name="Op_Sixth_Child_NOM_AbsentParent_City_State_ZIP" value="">
                                </div>
                                <div class="col-md-6">
                                    <label for="Op_Sixth_Child_NOM_AbsentParent_Phone" class="col-form-label text-md-left">Absent Parent Telephone Number</label>
                                    <input id="Op_Sixth_Child_NOM_AbsentParent_Phone" type="text" class="form-control telephone_format" placeholder="(XXX) XXX-XXXX" name="Op_Sixth_Child_NOM_AbsentParent_Phone" value="">
                                </div>
                            </div>
                        </div>
                        <!-- End of Opponent Info Section -->
                        <div class="col-md-12" style="text-align: center;margin-top: 20px;">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // to check number of minor/dependent children added.
    var num_minor_children_added=0;
    function checkMinorChildrenInfo(e){
        var Num_MinorDepChildren_ONLY_This_Marriage=$('#Num_MinorDepChildren_ONLY_This_Marriage').val();
        var children_this_marriage=$('#Num_Children_ONLY_This_Marriage').val();
        if(Num_MinorDepChildren_ONLY_This_Marriage > children_this_marriage){
            alert('Number of Minor/Dependent Children should be less than children born to and/or adopted in this marriage.');
            event.preventDefault();
            return true;
        }
        num_minor_children_added=0;
        $('input.Child_DOB').each(function(){
            var birthdate=this.value;
            // it will accept two types of format yyyy-mm-dd and yyyy/mm/dd
            if(birthdate){
                var optimizedBirthday = birthdate.replace(/-/g, "/");

                //set date based on birthdate at 01:00:00 hours GMT+0100 (CET)
                var myBirthday = new Date(optimizedBirthday);

                // set current day on 01:00:00 hours GMT+0100 (CET)
                var currentDate = new Date().toJSON().slice(0,10)+' 01:00:00';

                // calculate age comparing current date and borthday
                var myAge = ~~((Date.now(currentDate) - myBirthday) / (31557600000));

                if(myAge < 18) {
                    num_minor_children_added=++num_minor_children_added;
                }else{
                }
            }
        });
        $('input.This_Marriage_Child_Disabled_Dependent_Y_N').each(function(){
            if(this.checked && this.value=='Yes'){
                num_minor_children_added=++num_minor_children_added;
            }
        });

        if(Num_MinorDepChildren_ONLY_This_Marriage && (num_minor_children_added > Num_MinorDepChildren_ONLY_This_Marriage)){
            // alert('Number of Minor and/or otherwise Dependent Children added Must be equal to Number Children Minor and/or otherwise Dependent in this marriage. Currently You have Added Number Children Minor and/or otherwise Dependent in this marriage='+Num_MinorDepChildren_ONLY_This_Marriage+' and Number of Minor and/or otherwise Dependent Children added='+num_minor_children_added+'');
            alert('The number of Minor/Dependent Children is not as expected. Currently, you state there are '+num_minor_children_added+' Minor/Dependent Children but the data calculated shows '+Num_MinorDepChildren_ONLY_This_Marriage+'. Please check your inputs, especially birthdates.');
            event.preventDefault();
        } else if(Num_MinorDepChildren_ONLY_This_Marriage && (num_minor_children_added < Num_MinorDepChildren_ONLY_This_Marriage)){
            // alert('Number of Minor and/or otherwise Dependent Children added Must be equal to Number Children Minor and/or otherwise Dependent in this marriage. Currently You have Added Number Children Minor and/or otherwise Dependent in this marriage='+Num_MinorDepChildren_ONLY_This_Marriage+' and Number of Minor and/or otherwise Dependent Children added='+num_minor_children_added+'');
            alert('The number of Minor/Dependent Children is not as expected. Currently, you state there are '+num_minor_children_added+' Minor/Dependent Children but the data calculated shows '+Num_MinorDepChildren_ONLY_This_Marriage+'. Please check your inputs, especially birthdates.');
            event.preventDefault();
        } else {
            return true;
        }
        return true;
    }

    // Child will reside with
    function willResideWithOther(other, num){
        if(other.checked && other.value=='Other'){
            $('.'+num+'_Child_WILL_Resides_With_Other_Div').show();
            $('#This_Marriage_'+num+'_Child_WILL_Resides_With_Other').prop('required', true);
        } else {
            $('.'+num+'_Child_WILL_Resides_With_Other_Div').hide();
            $('#This_Marriage_'+num+'_Child_WILL_Resides_With_Other').prop('required', false);
            var custody=$('input[name="This_Marriage_Custody_Arrangement"]:checked').val();
            var obligor=$('input[name="This_Marriage_Child_Support_Obligor_CLient_OP"]:checked').val();
            var obligee=$('input[name="This_Marriage_Child_Support_Obligor_CLient_OP"]:not(:checked)').val();
            if(custody=='Shared' || custody=='Sole'){
                var all_will_reside_with_radio=$('.This_Marriage_Child_WILL_Resides_With');
                for (var i = 0; i < all_will_reside_with_radio.length; i++) {
                    // console.log(all_will_reside_with_radio[i]);
                    // $(all_will_reside_with_radio[i]).removeAttr('disabled');
                    if($(all_will_reside_with_radio[i]).val() == obligee){
                        // console.log('if='+$(all_will_reside_with_radio[i]).val());
                        $(all_will_reside_with_radio[i]).prop('checked', true);
                    } else {
                        // console.log('else='+$(all_will_reside_with_radio[i]).val());
                        $(all_will_reside_with_radio[i]).removeAttr('checked');
                        // $(all_will_reside_with_radio[i]).prop('disabled', true);
                    }
                }

            }
        }
    }

    $(document).ready(function(){

        $('#dr_children').validate({});
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        $(".telephone_format").each(function (item) {
            $(this).rules("add", { 
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)  
            });
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1900",
            endDate: '+0d',
        });

        // $('#Num_Children_ONLY_This_Marriage, #Num_Client_Children_NOT_this_Marriage, #Num_Op_Children_NOT_this_Marriage').val('0');
        $('.marriage_info_section, .1_child_info_section, .2_child_info_section, .3_child_info_section, .4_child_info_section, .5_child_info_section, .6_child_info_section, .7_child_info_section, .8_child_info_section').hide();

        $('.1_child_info_section, .2_child_info_section, .3_child_info_section, .4_child_info_section, .5_child_info_section, .6_child_info_section, .7_child_info_section, .8_child_info_section').find('input').first().prop('required', false);

        if($('#Num_Children_ONLY_This_Marriage').val() > 0 &&  $('#Num_Children_ONLY_This_Marriage').val() <= 8 ){
            $('.marriage_info_section').show();
            for (var i = 1; i <= $('#Num_Children_ONLY_This_Marriage').val(); i++) {
                $('.'+i+'_child_info_section').show();
                $('.'+i+'_child_info_section').find('input').first().prop('required', true);
            }
        }

        // on number of children born during marriage input change
        $('#Num_Children_ONLY_This_Marriage').on('change keyup', function(){
            $('.marriage_info_section, .1_child_info_section, .2_child_info_section, .3_child_info_section, .4_child_info_section, .5_child_info_section, .6_child_info_section, .7_child_info_section, .8_child_info_section').hide();
            if(this.value > 0 &&  this.value <= 8 ){
                $('.marriage_info_section').show();
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_child_info_section').show();
                }
            } else {
                $('.1_client_child_info_section, .2_client_child_info_section, .3_client_child_info_section, .4_client_child_info_section, .5_client_child_info_section, .6_client_child_info_section').hide();
                $('.1_opponent_child_info_section, .2_opponent_child_info_section, .3_opponent_child_info_section, .4_opponent_child_info_section, .5_opponent_child_info_section, .6_opponent_child_info_section').hide();
            }
        });

        // on client number of children not born during marriage input change
        $('.1_client_child_info_section, .2_client_child_info_section, .3_client_child_info_section, .4_client_child_info_section, .5_client_child_info_section, .6_client_child_info_section').hide();

        $('.1_client_child_info_section, .2_client_child_info_section, .3_client_child_info_section, .4_client_child_info_section, .5_client_child_info_section, .6_client_child_info_section').find('input').first().prop('required', false);

        if($('#Num_Client_Children_NOT_this_Marriage').val() > 0 &&  $('#Num_Client_Children_NOT_this_Marriage').val() <= 6 ){
            for (var i = 1; i <= $('#Num_Client_Children_NOT_this_Marriage').val(); i++) {
                $('.'+i+'_client_child_info_section').show();
                $('.'+i+'_client_child_info_section').find('input').first().prop('required', true);
            }
        }

        $('#Num_Client_Children_NOT_this_Marriage').on('change keyup', function(){
            $('.1_client_child_info_section, .2_client_child_info_section, .3_client_child_info_section, .4_client_child_info_section, .5_client_child_info_section, .6_client_child_info_section').hide();
            if(this.value > 0 &&  this.value <= 6 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_client_child_info_section').show();
                }
            }
        });

        // on opponent number of children not born during marriage input change
        $('.1_opponent_child_info_section, .2_opponent_child_info_section, .3_opponent_child_info_section, .4_opponent_child_info_section, .5_opponent_child_info_section, .6_opponent_child_info_section').hide();

        $('.1_opponent_child_info_section, .2_opponent_child_info_section, .3_opponent_child_info_section, .4_opponent_child_info_section, .5_opponent_child_info_section, .6_opponent_child_info_section').find('input').first().prop('required', false);

        if($('#Num_Op_Children_NOT_this_Marriage').val() > 0 &&  $('#Num_Op_Children_NOT_this_Marriage').val() <= 6 ){
            for (var i = 1; i <= $('#Num_Op_Children_NOT_this_Marriage').val(); i++) {
                $('.'+i+'_opponent_child_info_section').show();
                $('.'+i+'_opponent_child_info_section').find('input').first().prop('required', true);
            }
        }
        
        $('#Num_Op_Children_NOT_this_Marriage').on('change keyup', function(){
            $('.1_opponent_child_info_section, .2_opponent_child_info_section, .3_opponent_child_info_section, .4_opponent_child_info_section, .5_opponent_child_info_section, .6_opponent_child_info_section').hide();
            if(this.value > 0 &&  this.value <= 6 ){
                for (var i = 1; i <= this.value; i++) {
                    $('.'+i+'_opponent_child_info_section').show();
                }
            }
        });
        
        // to make upcoming field value same for during marriage child info section
        var length=['First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth'];
        $('.This_Marriage_Child_Resides_With').on('change', function(){
            var id=this.id;
            var className=$(this).attr('class').split(' ');
            var pos=jQuery.inArray(className[1], length);
            for(var i=pos+1; i<8; i++){
                var number=length[i];
                $('input[name=This_Marriage_'+number+'_Child_Resides_With]').removeAttr('checked');
                $('#This_Marriage_'+number+'_Child_Resides_With_'+className[2]+'').prop('checked', true);
            }
        });

        // $('.This_Marriage_Child_WILL_Resides_With').on('change', function(){
        //     var id=this.id;
        //     var className=$(this).attr('class').split(' ');
        //     var pos=jQuery.inArray(className[1], length);
        //     for(var i=pos+1; i<8; i++){
        //         var number=length[i];
        //         $('input[name=This_Marriage_'+number+'_Child_WILL_Resides_With]').removeAttr('checked');
        //         $('#This_Marriage_'+number+'_Child_WILL_Resides_With_'+className[2]+'').prop('checked', true);
        //     }
        // });

        $('.This_Marriage_Child_Residential_Parent_School_Purposes').on('change', function(){
            var id=this.id;
            var className=$(this).attr('class').split(' ');
            var pos=jQuery.inArray(className[1], length);
            for(var i=pos+1; i<8; i++){
                var number=length[i];
                $('input[name=This_Marriage_'+number+'_Child_Residential_Parent_School_Purposes]').removeAttr('checked');
                $('#This_Marriage_'+number+'_Child_Residential_Parent_School_Purposes_'+className[2]+'').prop('checked', true);
            }
        });

        // to make child will reside with change according to custody
        $('input[name="This_Marriage_Custody_Arrangement"]').on('change', function(){
            if(this.checked && this.value=='Split'){
            } else {
                var all_will_reside_with_radio=$('.This_Marriage_Child_WILL_Resides_With');
                var obligee=$('input[name="This_Marriage_Child_Support_Obligor_CLient_OP"]:not(:checked)').val();
                for (var i = 0; i < all_will_reside_with_radio.length; i++) {
                    if($(all_will_reside_with_radio[i]).val() == obligee){
                        $(all_will_reside_with_radio[i]).prop('checked', true);
                    } else {
                        $(all_will_reside_with_radio[i]).removeAttr('checked');
                    }
                }
            }
        });

        // to make child will reside with change according to obligor
        $('input[name="This_Marriage_Child_Support_Obligor_CLient_OP"]').on('change', function(){
            var custody=$('input[name="This_Marriage_Custody_Arrangement"]:checked').val();
            var all_will_reside_with_radio=$('.This_Marriage_Child_WILL_Resides_With');
            var obligee=$('input[name="This_Marriage_Child_Support_Obligor_CLient_OP"]:not(:checked)').val();
            if(custody=='Shared' || custody=='Sole'){
                for (var i = 0; i < all_will_reside_with_radio.length; i++) {
                    if($(all_will_reside_with_radio[i]).val() == obligee){
                        $(all_will_reside_with_radio[i]).prop('checked', true);
                    } else {
                        $(all_will_reside_with_radio[i]).removeAttr('checked');
                    }
                }
            }
            
        });

        // to check num minor/dependent children is less than children this marriage
        $('#Num_MinorDepChildren_ONLY_This_Marriage').on('change', function(){
            var children_this_marriage=$('#Num_Children_ONLY_This_Marriage').val();
            if(this.value > children_this_marriage){
                alert('Number of Minor/Dependent Children should be less than children born to and/or adopted in this marriage.');
            }
        });
        

    });
</script>   
@endsection