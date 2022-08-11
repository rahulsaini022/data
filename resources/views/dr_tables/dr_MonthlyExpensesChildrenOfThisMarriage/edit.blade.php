@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_MonthlyExpensesChildrenOfThisMarriage_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Monthly Expenses Children Of This Marriage Info') }}</strong>
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
                    <form role="form" id="dr_MonthlyExpensesChildrenOfThisMarriage" method="POST" action="{{route('drmonthlyexpenseschildrenofthismarriage.update',['id'=>$drmonthlyexpenseschildrenofthismarriage->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Monthly Expenses Children Of This Marriage Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Work_Education_Related_Child_Care">Children’s monthly work/education-related child care expenses?</label>
                                <input id="Client_Monthly_Childrens_Work_Education_Related_Child_Care" type="number" class="form-control" name="Client_Monthly_Childrens_Work_Education_Related_Child_Care" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Work_Education_Related_Child_Care)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Work_Education_Related_Child_Care; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Other_Child_Care">Children’s monthly other child care expenses?</label>
                                <input id="Client_Monthly_Childrens_Other_Child_Care" type="number" class="form-control" name="Client_Monthly_Childrens_Other_Child_Care" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Child_Care)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Child_Care; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Unusual_Parenting_Time_Travel">Children’s monthly expenses for unusual parenting time travel?</label>
                                <input id="Client_Monthly_Childrens_Unusual_Parenting_Time_Travel" type="number" class="form-control" name="Client_Monthly_Childrens_Unusual_Parenting_Time_Travel" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Unusual_Parenting_Time_Travel)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Unusual_Parenting_Time_Travel; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Special_Unusual_Needs">Children’s monthly expenses for unusual/special needs?</label>
                                <input id="Client_Monthly_Childrens_Special_Unusual_Needs" type="number" class="form-control" name="Client_Monthly_Childrens_Special_Unusual_Needs" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Special_Unusual_Needs)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Special_Unusual_Needs; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Clothes">Children’s monthly clothing expenses?</label>
                                <input id="Client_Monthly_Childrens_Clothes" type="number" class="form-control" name="Client_Monthly_Childrens_Clothes" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Clothes)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Clothes; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_School_Supplies">Children’s monthly school supply expenses?</label>
                                <input id="Client_Monthly_Childrens_School_Supplies" type="number" class="form-control" name="Client_Monthly_Childrens_School_Supplies" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_School_Supplies)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_School_Supplies; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Allowances">Children’s monthly allowances amount?</label>
                                <input id="Client_Monthly_Childrens_Allowances" type="number" class="form-control" name="Client_Monthly_Childrens_Allowances" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Allowances)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Allowances; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Extracurricular_Activities">Children’s monthly extracurricular activities expenses?</label>
                                <input id="Client_Monthly_Childrens_Extracurricular_Activities" type="number" class="form-control" name="Client_Monthly_Childrens_Extracurricular_Activities" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Extracurricular_Activities)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Extracurricular_Activities; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_School_Lunches">Children’s monthly school lunches expense?</label>
                                <input id="Client_Monthly_Childrens_School_Lunches" type="number" class="form-control" name="Client_Monthly_Childrens_School_Lunches" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_School_Lunches)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_School_Lunches; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Others_Name1">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Client_Monthly_Childrens_Others_Name1" name="Client_Monthly_Childrens_Others_Name1" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name1)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name1; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Other_Amount1">Monthly amount of the first identified expense?</label>
                                <input id="Client_Monthly_Childrens_Other_Amount1" type="number" class="form-control" name="Client_Monthly_Childrens_Other_Amount1" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount1)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Others_Name2">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Client_Monthly_Childrens_Others_Name2" name="Client_Monthly_Childrens_Others_Name2" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name2)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name2; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Other_Amount2">Monthly amount of the second identified expense?</label>
                                <input id="Client_Monthly_Childrens_Other_Amount2" type="number" class="form-control" name="Client_Monthly_Childrens_Other_Amount2" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount2)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Others_Name3">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Client_Monthly_Childrens_Others_Name3" name="Client_Monthly_Childrens_Others_Name3" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name3)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Others_Name3; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Monthly_Childrens_Other_Amount3">Monthly amount of the third identified expense?</label>
                                <input id="Client_Monthly_Childrens_Other_Amount3" type="number" class="form-control" name="Client_Monthly_Childrens_Other_Amount3" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount3)){ echo $drmonthlyexpenseschildrenofthismarriage->Client_Monthly_Childrens_Other_Amount3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                        </div>
                        <!-- End of Client Monthly Expenses Children Of This Marriage Info Section -->

                        <!-- Opponent Monthly Expenses Children Of This Marriage Info Section -->
                        <div class="form-row">
                            <h4 class="col-sm-12 mt-4">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Work_Education_Related_Child_Care">Children’s monthly work/education-related child care expenses?</label>
                                <input id="Op_Monthly_Childrens_Work_Education_Related_Child_Care" type="number" class="form-control" name="Op_Monthly_Childrens_Work_Education_Related_Child_Care" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Work_Education_Related_Child_Care)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Work_Education_Related_Child_Care; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Other_Child_Care">Children’s monthly other child care expenses?</label>
                                <input id="Op_Monthly_Childrens_Other_Child_Care" type="number" class="form-control" name="Op_Monthly_Childrens_Other_Child_Care" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Child_Care)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Child_Care; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Unusual_Parenting_Time_Travel">Children’s monthly expenses for unusual parenting time travel?</label>
                                <input id="Op_Monthly_Childrens_Unusual_Parenting_Time_Travel" type="number" class="form-control" name="Op_Monthly_Childrens_Unusual_Parenting_Time_Travel" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Unusual_Parenting_Time_Travel)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Unusual_Parenting_Time_Travel; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Special_Unusual_Needs">Children’s monthly expenses for unusual/special needs?</label>
                                <input id="Op_Monthly_Childrens_Special_Unusual_Needs" type="number" class="form-control" name="Op_Monthly_Childrens_Special_Unusual_Needs" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Special_Unusual_Needs)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Special_Unusual_Needs; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Clothes">Children’s monthly clothing expenses?</label>
                                <input id="Op_Monthly_Childrens_Clothes" type="number" class="form-control" name="Op_Monthly_Childrens_Clothes" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Clothes)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Clothes; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_School_Supplies">Children’s monthly school supply expenses?</label>
                                <input id="Op_Monthly_Childrens_School_Supplies" type="number" class="form-control" name="Op_Monthly_Childrens_School_Supplies" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_School_Supplies)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_School_Supplies; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Allowances">Children’s monthly allowances amount?</label>
                                <input id="Op_Monthly_Childrens_Allowances" type="number" class="form-control" name="Op_Monthly_Childrens_Allowances" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Allowances)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Allowances; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Extracurricular_Activities">Children’s monthly extracurricular activities expenses?</label>
                                <input id="Op_Monthly_Childrens_Extracurricular_Activities" type="number" class="form-control" name="Op_Monthly_Childrens_Extracurricular_Activities" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Extracurricular_Activities)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Extracurricular_Activities; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_School_Lunches">Children’s monthly school lunches expense?</label>
                                <input id="Op_Monthly_Childrens_School_Lunches" type="number" class="form-control" name="Op_Monthly_Childrens_School_Lunches" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_School_Lunches)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_School_Lunches; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Others_Name1">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Op_Monthly_Childrens_Others_Name1" name="Op_Monthly_Childrens_Others_Name1" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name1)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name1; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Other_Amount1">Monthly amount of the first identified expense?</label>
                                <input id="Op_Monthly_Childrens_Other_Amount1" type="number" class="form-control" name="Op_Monthly_Childrens_Other_Amount1" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount1)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Others_Name2">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Op_Monthly_Childrens_Others_Name2" name="Op_Monthly_Childrens_Others_Name2" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name2)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name2; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Other_Amount2">Monthly amount of the second identified expense?</label>
                                <input id="Op_Monthly_Childrens_Other_Amount2" type="number" class="form-control" name="Op_Monthly_Childrens_Other_Amount2" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount2)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Others_Name3">Identify any other month expense for children of this marriage?</label>
                                <input type="text" class="form-control" id="Op_Monthly_Childrens_Others_Name3" name="Op_Monthly_Childrens_Others_Name3" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name3)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Others_Name3; } ?>">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Monthly_Childrens_Other_Amount3">Monthly amount of the third identified expense?</label>
                                <input id="Op_Monthly_Childrens_Other_Amount3" type="number" class="form-control" name="Op_Monthly_Childrens_Other_Amount3" value="<?php if(isset($drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount3)){ echo $drmonthlyexpenseschildrenofthismarriage->Op_Monthly_Childrens_Other_Amount3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-12 text-center">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Monthly Expenses Children Of This Marriage Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    
    // show/hide divs based on radio value
    function onRadioChange(value,cls){
        if(value=='Yes'){
            $('.'+cls+'_Div').show();
        } else{
            $('.'+cls+'_Div').hide();
        }

    }
    $(document).ready(function(){

        $('#dr_MonthlyExpensesChildrenOfThisMarriage').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection