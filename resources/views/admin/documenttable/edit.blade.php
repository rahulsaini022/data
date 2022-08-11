    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Document Table Record') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('documenttable.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    @if (count($errors) > 0)

                      <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                           @foreach ($errors->all() as $error)

                             <li>{{ $error }}</li>

                           @endforeach

                        </ul>

                      </div>

                    @endif


                    {!! Form::model($document, ['method' => 'PATCH','route' => ['documenttable.update', $document->id]]) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Doc State:</strong>
                                <input id="doc_state_selected" type="hidden" class="form-control" value="<?php if(isset($document->doc_state)){ echo $document->doc_state; } ?>">
                                <select id="doc_state" name="doc_state" class="form-control" required>
                                    <option value="">Choose Firm State</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Doc Name:</strong>

                                <input id="doc_name" type="text" class="form-control" name="doc_name" value="<?php if(isset($document->doc_name)){ echo $document->doc_name; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 1:</strong>

                                <input id="textinputdate1" type="text" class="form-control hasDatepicker" name="textinputdate1" value="<?php if(isset($document->textinputdate1)){ echo date("m/d/Y", strtotime($document->textinputdate1)); } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 2:</strong>

                                <input id="textinputdate2" type="text" class="form-control hasDatepicker" name="textinputdate2" value="<?php if(isset($document->textinputdate2)){ echo date("m/d/Y", strtotime($document->textinputdate2)); } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 3:</strong>

                                <input id="textinputdate3" type="text" class="form-control hasDatepicker" name="textinputdate3" value="<?php if(isset($document->textinputdate3)){ echo date("m/d/Y", strtotime($document->textinputdate3)); } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 4:</strong>

                                <input id="textinputdate4" type="text" class="form-control hasDatepicker" name="textinputdate4" value="<?php if(isset($document->textinputdate4)){ echo date("m/d/Y", strtotime($document->textinputdate4)); } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 5:</strong>

                                <input id="textinputdate5" type="text" class="form-control hasDatepicker" name="textinputdate5" value="<?php if(isset($document->textinputdate5)){ echo date("m/d/Y", strtotime($document->textinputdate5)); } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 1:</strong>

                                <input id="textinputnumint1" type="text" class="form-control" name="textinputnumint1" value="<?php if(isset($document->textinputnumint1)){ echo $document->textinputnumint1; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 2:</strong>

                                <input id="textinputnumint2" type="text" class="form-control" name="textinputnumint2" value="<?php if(isset($document->textinputnumint2)){ echo $document->textinputnumint2; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 3:</strong>

                                <input id="textinputnumint3" type="text" class="form-control" name="textinputnumint3" value="<?php if(isset($document->textinputnumint3)){ echo $document->textinputnumint3; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 4:</strong>

                                <input id="textinputnumint4" type="text" class="form-control" name="textinputnumint4" value="<?php if(isset($document->textinputnumint4)){ echo $document->textinputnumint4; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 5:</strong>

                                <input id="textinputnumint5" type="text" class="form-control" name="textinputnumint5" value="<?php if(isset($document->textinputnumint5)){ echo $document->textinputnumint5; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 1:</strong>

                                <input id="textinputnumdec1" type="text" class="form-control" name="textinputnumdec1" value="<?php if(isset($document->textinputnumdec1)){ echo $document->textinputnumdec1; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 2:</strong>

                                <input id="textinputnumdec2" type="text" class="form-control" name="textinputnumdec2" value="<?php if(isset($document->textinputnumdec2)){ echo $document->textinputnumdec2; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 3:</strong>

                                <input id="textinputnumdec3" type="text" class="form-control" name="textinputnumdec3" value="<?php if(isset($document->textinputnumdec3)){ echo $document->textinputnumdec3; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 4:</strong>

                                <input id="textinputnumdec4" type="text" class="form-control" name="textinputnumdec4" value="<?php if(isset($document->textinputnumdec4)){ echo $document->textinputnumdec4; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 5:</strong>

                                <input id="textinputnumdec5" type="text" class="form-control" name="textinputnumdec5" value="<?php if(isset($document->textinputnumdec5)){ echo $document->textinputnumdec5; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 1:</strong>

                                <input id="textinputtext1" type="text" class="form-control" name="textinputtext1" value="<?php if(isset($document->textinputtext1)){ echo $document->textinputtext1; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 2:</strong>

                                <input id="textinputtext2" type="text" class="form-control" name="textinputtext2" value="<?php if(isset($document->textinputtext2)){ echo $document->textinputtext2; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 3:</strong>

                                <input id="textinputtext3" type="text" class="form-control" name="textinputtext3" value="<?php if(isset($document->textinputtext3)){ echo $document->textinputtext3; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 4:</strong>

                                <input id="textinputtext4" type="text" class="form-control" name="textinputtext4" value="<?php if(isset($document->textinputtext4)){ echo $document->textinputtext4; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 5:</strong>

                                <input id="textinputtext5" type="text" class="form-control" name="textinputtext5" value="<?php if(isset($document->textinputtext5)){ echo $document->textinputtext5; } ?>">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    $(document).ready(function(){          
        $.ajax({
            url:"{{route('ajax_get_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#doc_state').append('<option value='+val+'>'+val+'</option>');
                    });
                    var selected_state=$('#doc_state_selected').val();
                    if(selected_state){
                        $('#doc_state_selected option:selected').removeAttr('selected');
                        $('#doc_state option[value="'+selected_state+'"]').attr('selected','selected');
                        $('#doc_state_selected').val("");
                    }
                }
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1900",
            endDate: '+0d',
        });

    });
</script>
@endsection