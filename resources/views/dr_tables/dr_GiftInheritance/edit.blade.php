@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_giftinheritance_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update Gift Inheritance Info') }}</strong>
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
                    <form role="form" id="dr_giftinheritance" method="POST" action="{{route('drgiftinheritance.update',['id'=>$drgiftinheritance->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <div class="form-row">
                            <div class="form-group col-sm-6">
                                <label>Does {{$client_name}} expect any gift or inheritance in next 6 months?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Client_Gift_Inheritance_Expectation_Yes" name="Client_Gift_Inheritance_Expectation" value="Yes" <?php if(isset($drgiftinheritance->Client_Gift_Inheritance_Expectation) && $drgiftinheritance->Client_Gift_Inheritance_Expectation=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Client_Gift_Inheritance_Expectation_No" name="Client_Gift_Inheritance_Expectation" value="No" <?php if(isset($drgiftinheritance->Client_Gift_Inheritance_Expectation) && $drgiftinheritance->Client_Gift_Inheritance_Expectation=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Does {{$opponent_name}} expect any gift or inheritance in next 6 months?</label>
                                <div class="w-100">
                                    <label><input type="radio" id="Op_Gift_Inheritance_Expectation_Yes" name="Op_Gift_Inheritance_Expectation" value="Yes" <?php if(isset($drgiftinheritance->Op_Gift_Inheritance_Expectation) && $drgiftinheritance->Op_Gift_Inheritance_Expectation=='Yes'){ echo "checked"; } ?>> Yes</label>
                                    <label><input type="radio" id="Op_Gift_Inheritance_Expectation_No" name="Op_Gift_Inheritance_Expectation" value="No" <?php if(isset($drgiftinheritance->Op_Gift_Inheritance_Expectation) && $drgiftinheritance->Op_Gift_Inheritance_Expectation=='No'){ echo "checked"; } ?>> No</label>
                                </div>
                            </div>
                        <!-- Client Gift Inheritance Info Section -->
                            <h4 class="col-sm-12">{{$client_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name1" class="col-form-label text-md-left">First Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name1" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name1" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name1)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name1; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt1" class="col-form-label text-md-left">Amount of First Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt1" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt1" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt1)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name2" class="col-form-label text-md-left">Second Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name2" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name2" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name2)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name2; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt2" class="col-form-label text-md-left">Amount of Second Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt2" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt2" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt2)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name3" class="col-form-label text-md-left">Third Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name3" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name3" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name3)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name3; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt3" class="col-form-label text-md-left">Amount of Third Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt3" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt3" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt3)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name4" class="col-form-label text-md-left">Fourth Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name4" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name4" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name4)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name4; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt4" class="col-form-label text-md-left">Amount of Fourth Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt4" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt4" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt4)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name5" class="col-form-label text-md-left">Fifth Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name5" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name5" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name5)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name5; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt5" class="col-form-label text-md-left">Amount of Fifth Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt5" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt5" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt5)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Name6" class="col-form-label text-md-left">Sixth Source of Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Name6" type="text" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Name6" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name6)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Name6; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Client_Exp_Gift_Inheritance_Source_Amt6" class="col-form-label text-md-left">Amount of Sixth Expected Gift or Inheritance?</label>
                                <input id="Client_Exp_Gift_Inheritance_Source_Amt6" type="number" class="form-control" name="Client_Exp_Gift_Inheritance_Source_Amt6" value="<?php if(isset($drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt6)){ echo $drgiftinheritance->Client_Exp_Gift_Inheritance_Source_Amt6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            
                        </div>
                        <!-- End of Client Gift Inheritance Info Section -->

                        <!-- Opponent Gift Inheritance Info Section -->
                        <div class="form-row mt-4">
                            <h4 class="col-sm-12">{{$opponent_name}} Info Section</h4>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name1" class="col-form-label text-md-left">First Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name1" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name1" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name1)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name1; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt1" class="col-form-label text-md-left">Amount of First Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt1" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt1" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt1)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt1; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name2" class="col-form-label text-md-left">Second Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name2" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name2" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name2)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name2; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt2" class="col-form-label text-md-left">Amount of Second Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt2" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt2" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt2)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt2; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name3" class="col-form-label text-md-left">Third Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name3" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name3" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name3)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name3; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt3" class="col-form-label text-md-left">Amount of Third Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt3" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt3" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt3)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt3; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name4" class="col-form-label text-md-left">Fourth Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name4" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name4" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name4)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name4; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt4" class="col-form-label text-md-left">Amount of Fourth Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt4" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt4" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt4)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt4; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name5" class="col-form-label text-md-left">Fifth Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name5" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name5" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name5)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name5; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt5" class="col-form-label text-md-left">Amount of Fifth Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt5" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt5" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt5)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt5; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Name6" class="col-form-label text-md-left">Sixth Source of Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Name6" type="text" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Name6" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name6)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Name6; } ?>"> 
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="Op_Exp_Gift_Inheritance_Source_Amt6" class="col-form-label text-md-left">Amount of Sixth Expected Gift or Inheritance?</label>
                                <input id="Op_Exp_Gift_Inheritance_Source_Amt6" type="number" class="form-control" name="Op_Exp_Gift_Inheritance_Source_Amt6" value="<?php if(isset($drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt6)){ echo $drgiftinheritance->Op_Exp_Gift_Inheritance_Source_Amt6; } ?>" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="form-group col-sm-12 text-center mt-4">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Gift Inheritance Info Section -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#dr_giftinheritance').validate();
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
    });
</script>   
@endsection