@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center email-us-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('Popup Interview Form') }}</strong>
                    <div style="float: right;">
                        <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
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
                    <div class="col-sm-12">
                        <label>Document Id* <input type="number" id="document_id" name="document_id" class="form-control"></label>
                       <button onclick="getFormFields();" class="btn btn-info ml-2">Get Form Fields</button>
                    </div>

                    <div class="col-sm-12">
                        <form id="dynamic_popup_form" style="display: none;" method="POST" action="{{ route('store_dynamic_popup_form_data') }}" autocomplete="off">
                            @csrf
                            <input type="hidden" name="case_id" value="12">
                            <input type="hidden" id="popup_form_document_id" name="document_id" value="" required="">
                            <div class="row">
                                <div class="col-sm-12 append_dynamic_fields">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-md-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function getFormFields() {
        if($('#max_fields').val()=='' || $('#document_id').val()==''){
            alert('Please fill all required fields');
            e.preventDefault();
        }
        var document_id=$('#document_id').val();
        $('#popup_form_document_id').val(document_id);
        var token=$('input[name="_token"]').val();
        $.ajax({
            url:'{{route("get_popup_form_fields")}}',
            method:'POST',
             dataType: 'json',
            data:{
                _token:token,
                document_id:document_id,
            },
            success:function(response){
                if(response==null || response=='null'){
                    alert('No data found');
                } else {
                    i=1;
                    var html='';
                    for(i=1; i<=response["max_fields"]; i++){
                        if(response["question"+i+""] !=null){
                            if(response["answer"+i+"_input_type"]=='datepicker'){
                                html+='<div class="form-group"><label for="">'+response["question"+i+""]+'</label><input id="name" type="text" class="form-control has-'+response["answer"+i+"_input_type"]+'" name="'+response["dest_answer"+i+""]+'" value=""></div>';
                            } else {
                                html+='<div class="form-group"><label for="">'+response["question"+i+""]+'</label><input id="name" type="'+response["answer"+i+"_input_type"]+'" class="form-control" name="'+response["dest_answer"+i+""]+'" value=""></div>';
                            }
                        }
                    }
                    $('.append_dynamic_fields').html(html);
                    $('#dynamic_popup_form').show();
                }
            }
        });

    }

    $(document).ready( function(){
        $('#dynamic_popup_form').keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        $(document).on('focus',".has-datepicker", function(){
            $(this).datepicker({
                startDate: "01/01/1900",
                endDate: '+0d',
            });
        });

    });

</script> 
@endsection