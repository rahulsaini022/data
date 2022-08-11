@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_temporaryorders_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Test Slider Tool') }}</strong>
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
                    <?php $joint_balance=1284; $client_balance=$joint_balance/2; $op_balance=$joint_balance/2; ?>
                    <form role="form" id="dr_temporaryorders" method="POST" action="">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}">
                        <input id="joint_balance_hidden" type="hidden" class="form-control" name="joint_balance_hidden" value="{{$joint_balance}}">
                        <input id="client_balance_hidden" type="hidden" class="form-control" name="client_balance_hidden" value="{{$client_balance}}">
                        <input id="op_balance_hidden" type="hidden" class="form-control" name="op_balance_hidden" value="{{$op_balance}}">
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label></label>
                                <input id="balance_range_selector" type="range" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="50.00" min="0.00" step="0.01" max="100" onchange="updateBalanceInput(this.value);">
                            </div>
                        </div> 
                        <div class="form-row">
                            <h5 class="col-sm-12">To ClientName</h5>
                            <div class="form-group col-sm-6">
                                <label></label>
                                <input id="client_balance_amount" type="number" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="{{ $client_balance }}" min="0.00" step="0.01" max="999999.99" readonly="">
                            </div>
                            <div class="form-group col-sm-6">
                                <label></label>
                                <input id="client_balance_percentage" type="number" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                            </div>
                        </div>
                        <div class="form-row">
                            <h5 class="col-sm-12">To OpponentName</h5>
                            <div class="form-group col-sm-6">
                                <label></label>
                                <input id="op_balance_amount" type="number" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="{{ $op_balance }}" min="0.00" step="0.01" max="999999.99" readonly="">
                            </div>
                            <div class="form-group col-sm-6">
                                <label></label>
                                <input id="op_balance_percentage" type="number" class="form-control" name="Client_Amount_of_Help_with_Monthly_Expenses" value="50.00" min="0.00" step="0.01" max="100" readonly="">
                            </div>
                            <div class="form-group col-sm-6">
                                <label></label>
                                <div class="w-100">
                                    <label><input type="radio" id="Currently_Cohabitating_With_Spouse_Y_N_Yes" name="Currently_Cohabitating_With_Spouse_Y_N" value="Yes"> Save this Distribution of Deposit Account #1</label>
                                    <label><input type="radio" id="Currently_Cohabitating_With_Spouse_Y_N_No" name="Currently_Cohabitating_With_Spouse_Y_N" value="No" onclick="resetBalanceInput(this);"> Reset to Default (50%)</label>
                                </div>
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

    function resetBalanceInput(reset){

        $('#balance_range_selector, #client_balance_percentage, #op_balance_percentage').val('50.00');
        var client_balance=$('#client_balance_hidden').val();
        var op_balance=$('#op_balance_hidden').val();
        $('#client_balance_amount').val(client_balance);
        $('#op_balance_amount').val(op_balance);

    }
    function updateBalanceInput(value){
        var value=parseFloat(value).toFixed(2);
        $('#client_balance_percentage').val(value);
        var op_balance_percentage=100-value;
        op_balance_percentage=parseFloat(op_balance_percentage).toFixed(2);
        $('#op_balance_percentage').val(op_balance_percentage);
        var joint_balance=$('#joint_balance_hidden').val();
        joint_balance=parseFloat(joint_balance);
        var opponent_balance_amount = joint_balance - (joint_balance * value/100);
        var client_balance_amount = joint_balance - (joint_balance * op_balance_percentage/100);
        client_balance_amount=parseFloat(client_balance_amount).toFixed(2);
        opponent_balance_amount=parseFloat(opponent_balance_amount).toFixed(2);
        $('#client_balance_amount').val(client_balance_amount);
        $('#op_balance_amount').val(opponent_balance_amount);

    }
    $(document).ready(function(){

        $('#dr_temporaryorders').validate();
    });
</script>   
@endsection