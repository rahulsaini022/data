@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_monthlyeducationexpenses_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Monthly Education Expenses Info') }}</strong>
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
                    <form role="form" id="dr_monthlyeducationexpenses" method="POST" action="{{route('drmonthlyeducationexpenses.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Monthly Education Expenses Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_School_Tuition_For_Client" class="col-form-label text-md-left">Monthly Tuition for Your Own Education</label>
                                <input id="Client_Monthly_School_Tuition_For_Client" type="number" class="form-control" name="Client_Monthly_School_Tuition_For_Client" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_School_Tuition_For_Children" class="col-form-label text-md-left">Monthly Tuition for Children</label>
                                <input id="Client_Monthly_School_Tuition_For_Children" type="number" class="form-control" name="Client_Monthly_School_Tuition_For_Children" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_School_Books_Fees_Etc" class="col-form-label text-md-left">Monthly School Books, Fees, Etc.</label>
                                <input id="Client_Monthly_School_Books_Fees_Etc" type="number" class="form-control" name="Client_Monthly_School_Books_Fees_Etc" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Student_Loan_Institution_Name1" class="col-form-label text-md-left">First Student Loan Company</label>
                                <input id="Client_Student_Loan_Institution_Name1" type="text" class="form-control" name="Client_Student_Loan_Institution_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_College_Loan_Repayment1" class="col-form-label text-md-left">Monthly Payment for First Student Loan</label>
                                <input id="Client_Monthly_College_Loan_Repayment1" type="number" class="form-control" name="Client_Monthly_College_Loan_Repayment1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Student_Loan_Institution_Name2" class="col-form-label text-md-left">Second Student Loan Company</label>
                                <input id="Client_Student_Loan_Institution_Name2" type="text" class="form-control" name="Client_Student_Loan_Institution_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_College_Loan_Repayment2" class="col-form-label text-md-left">Monthly Payment for Second Student Loan</label>
                                <input id="Client_Monthly_College_Loan_Repayment2" type="number" class="form-control" name="Client_Monthly_College_Loan_Repayment2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Student_Loan_Institution_Name3" class="col-form-label text-md-left">Third Student Loan Company</label>
                                <input id="Client_Student_Loan_Institution_Name3" type="text" class="form-control" name="Client_Student_Loan_Institution_Name3" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_College_Loan_Repayment3" class="col-form-label text-md-left">Monthly Payment for Third Student Loan</label>
                                <input id="Client_Monthly_College_Loan_Repayment3" type="number" class="form-control" name="Client_Monthly_College_Loan_Repayment3" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Education_Other_Name1" class="col-form-label text-md-left">Type of Other Monthly Education Cost</label>
                                <input id="Client_Monthly_Education_Other_Name1" type="text" class="form-control" name="Client_Monthly_Education_Other_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Education_Other_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Education Cost</label>
                                <input id="Client_Monthly_Education_Other_Amount1" type="number" class="form-control" name="Client_Monthly_Education_Other_Amount1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Education_Other_Name2" class="col-form-label text-md-left">Type of Other Monthly Education Cost</label>
                                <input id="Client_Monthly_Education_Other_Name2" type="text" class="form-control" name="Client_Monthly_Education_Other_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Education_Other_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Education Cost</label>
                                <input id="Client_Monthly_Education_Other_Amount2" type="number" class="form-control" name="Client_Monthly_Education_Other_Amount2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                        </div>
                        <!-- End of Client Monthly Education Expenses Info Section -->

                        <!-- Opponent Monthly Education Expenses Info Section -->
                        <div class="form-row mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_School_Tuition_For_Op" class="col-form-label text-md-left">Monthly Tuition for Your Own Education</label>
                                <input id="Op_Monthly_School_Tuition_For_Op" type="number" class="form-control" name="Op_Monthly_School_Tuition_For_Op" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_School_Tuition_For_Children" class="col-form-label text-md-left">Monthly Tuition for Children</label>
                                <input id="Op_Monthly_School_Tuition_For_Children" type="number" class="form-control" name="Op_Monthly_School_Tuition_For_Children" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_School_Books_Fees_Etc" class="col-form-label text-md-left">Monthly School Books, Fees, Etc.</label>
                                <input id="Op_Monthly_School_Books_Fees_Etc" type="number" class="form-control" name="Op_Monthly_School_Books_Fees_Etc" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Student_Loan_Institution_Name1" class="col-form-label text-md-left">First Student Loan Company</label>
                                <input id="Op_Student_Loan_Institution_Name1" type="text" class="form-control" name="Op_Student_Loan_Institution_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_College_Loan_Repayment1" class="col-form-label text-md-left">Monthly Payment for First Student Loan</label>
                                <input id="Op_Monthly_College_Loan_Repayment1" type="number" class="form-control" name="Op_Monthly_College_Loan_Repayment1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Student_Loan_Institution_Name2" class="col-form-label text-md-left">Second Student Loan Company</label>
                                <input id="Op_Student_Loan_Institution_Name2" type="text" class="form-control" name="Op_Student_Loan_Institution_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_College_Loan_Repayment2" class="col-form-label text-md-left">Monthly Payment for Second Student Loan</label>
                                <input id="Op_Monthly_College_Loan_Repayment2" type="number" class="form-control" name="Op_Monthly_College_Loan_Repayment2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Student_Loan_Institution_Name3" class="col-form-label text-md-left">Third Student Loan Company</label>
                                <input id="Op_Student_Loan_Institution_Name3" type="text" class="form-control" name="Op_Student_Loan_Institution_Name3" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_College_Loan_Repayment3" class="col-form-label text-md-left">Monthly Payment for Third Student Loan</label>
                                <input id="Op_Monthly_College_Loan_Repayment3" type="number" class="form-control" name="Op_Monthly_College_Loan_Repayment3" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Education_Other_Name1" class="col-form-label text-md-left">Type of Other Monthly Education Cost</label>
                                <input id="Op_Monthly_Education_Other_Name1" type="text" class="form-control" name="Op_Monthly_Education_Other_Name1" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Education_Other_Amount1" class="col-form-label text-md-left">Monthly Amount of Other Education Cost</label>
                                <input id="Op_Monthly_Education_Other_Amount1" type="number" class="form-control" name="Op_Monthly_Education_Other_Amount1" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Education_Other_Name2" class="col-form-label text-md-left">Type of Other Monthly Education Cost</label>
                                <input id="Op_Monthly_Education_Other_Name2" type="text" class="form-control" name="Op_Monthly_Education_Other_Name2" value=""> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Education_Other_Amount2" class="col-form-label text-md-left">Monthly Amount of Other Education Cost</label>
                                <input id="Op_Monthly_Education_Other_Amount2" type="number" class="form-control" name="Op_Monthly_Education_Other_Amount2" value="0.00" min="0.00" step="0.01" max="999999.99">
                            </div>
                            <div class="form-group col-sm-12 text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Education Expenses Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dr_monthlyeducationexpenses').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection