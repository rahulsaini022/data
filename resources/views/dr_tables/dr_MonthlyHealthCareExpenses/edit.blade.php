@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_monthlyhealthcareexpenses_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Monthly Health Care Expenses Info') }}</strong>
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
                    <form role="form" id="dr_monthlyhealthcareexpenses" method="POST" action="{{route('drmonthlyhealthcareexpenses.update',['id'=>$drmonthlyhealthcareexpenses->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Monthly Health Care Expenses Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Physicians_NOT_COVERED" class="col-form-label text-md-left">Monthly Physician Expenses Not Covered by Insurance</label>
                                <input id="Client_Monthly_Physicians_NOT_COVERED" type="number" class="form-control" name="Client_Monthly_Physicians_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Physicians_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Physicians_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Dentists_NOT_COVERED" class="col-form-label text-md-left">Monthly Dental Expenses Not Covered by Insurance</label>
                                <input id="Client_Monthly_Dentists_NOT_COVERED" type="number" class="form-control" name="Client_Monthly_Dentists_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Dentists_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Dentists_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Optometrists_Opticians_NOT_COVERED" class="col-form-label text-md-left">Monthly Optometrist and/or Optician Expenses Not Covered by Insurance</label>
                                <input id="Client_Monthly_Optometrists_Opticians_NOT_COVERED" type="number" class="form-control" name="Client_Monthly_Optometrists_Opticians_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Optometrists_Opticians_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Optometrists_Opticians_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Prescriptions_NOT_COVERED" class="col-form-label text-md-left">Monthly Prescriptions Expenses Not Covered by Insurance</label>
                                <input id="Client_Monthly_Prescriptions_NOT_COVERED" type="number" class="form-control" name="Client_Monthly_Prescriptions_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Prescriptions_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Prescriptions_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Health_Care_Other_NOT_COVERED_Name1" class="col-form-label text-md-left">Other Monthly Health Care Expenses Type (Not Covered by Insurance)</label>
                                <input id="Client_Monthly_Health_Care_Other_NOT_COVERED_Name1" type="text" class="form-control" name="Client_Monthly_Health_Care_Other_NOT_COVERED_Name1" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Name1)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Name1; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Health Care Expenses (Not Covered by Insurance)</label>
                                <input id="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount1" type="number" class="form-control" name="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount1" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Amount1)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Amount1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Health_Care_Other_NOT_COVERED_Name2" class="col-form-label text-md-left">Other Monthly Health Care Expenses Type (Not Covered by Insurance)</label>
                                <input id="Client_Monthly_Health_Care_Other_NOT_COVERED_Name2" type="text" class="form-control" name="Client_Monthly_Health_Care_Other_NOT_COVERED_Name2" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Name2)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Name2; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Health Care Expenses (Not Covered by Insurance)</label>
                                <input id="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount2" type="number" class="form-control" name="Client_Monthly_Health_Care_Other_NOT_COVERED_Amount2" value="<?php if(isset($drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Amount2)){ echo $drmonthlyhealthcareexpenses->Client_Monthly_Health_Care_Other_NOT_COVERED_Amount2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            
                        </div>
                        <!-- End of Client Monthly Health Care Expenses Info Section -->

                        <!-- Opponent Monthly Health Care Expenses Info Section -->
                        <div class="form-row mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Physicians_NOT_COVERED" class="col-form-label text-md-left">Monthly Physician Expenses Not Covered by Insurance</label>
                                <input id="Op_Monthly_Physicians_NOT_COVERED" type="number" class="form-control" name="Op_Monthly_Physicians_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Physicians_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Physicians_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Dentists_NOT_COVERED" class="col-form-label text-md-left">Monthly Dental Expenses Not Covered by Insurance</label>
                                <input id="Op_Monthly_Dentists_NOT_COVERED" type="number" class="form-control" name="Op_Monthly_Dentists_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Dentists_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Dentists_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Optometrists_Opticians_NOT_COVERED" class="col-form-label text-md-left">Monthly Optometrist and/or Optician Expenses Not Covered by Insurance</label>
                                <input id="Op_Monthly_Optometrists_Opticians_NOT_COVERED" type="number" class="form-control" name="Op_Monthly_Optometrists_Opticians_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Optometrists_Opticians_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Optometrists_Opticians_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Prescriptions_NOT_COVERED" class="col-form-label text-md-left">Monthly Prescriptions Expenses Not Covered by Insurance</label>
                                <input id="Op_Monthly_Prescriptions_NOT_COVERED" type="number" class="form-control" name="Op_Monthly_Prescriptions_NOT_COVERED" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Prescriptions_NOT_COVERED)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Prescriptions_NOT_COVERED; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Health_Care_Other_NOT_COVERED_Name1" class="col-form-label text-md-left">Other Monthly Health Care Expenses Type (Not Covered by Insurance)</label>
                                <input id="Op_Monthly_Health_Care_Other_NOT_COVERED_Name1" type="text" class="form-control" name="Op_Monthly_Health_Care_Other_NOT_COVERED_Name1" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Name1)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Name1; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Health Care Expenses (Not Covered by Insurance)</label>
                                <input id="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount1" type="number" class="form-control" name="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount1" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Amount1)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Amount1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Health_Care_Other_NOT_COVERED_Name2" class="col-form-label text-md-left">Other Monthly Health Care Expenses Type (Not Covered by Insurance)</label>
                                <input id="Op_Monthly_Health_Care_Other_NOT_COVERED_Name2" type="text" class="form-control" name="Op_Monthly_Health_Care_Other_NOT_COVERED_Name2" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Name2)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Name2; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Health Care Expenses (Not Covered by Insurance)</label>
                                <input id="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount2" type="number" class="form-control" name="Op_Monthly_Health_Care_Other_NOT_COVERED_Amount2" value="<?php if(isset($drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Amount2)){ echo $drmonthlyhealthcareexpenses->Op_Monthly_Health_Care_Other_NOT_COVERED_Amount2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-12 text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Health Care Expenses Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dr_monthlyhealthcareexpenses').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection