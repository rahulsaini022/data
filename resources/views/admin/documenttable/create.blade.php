@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Document Table Record') }}</strong>
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



                    {!! Form::open(array('route' => 'documenttable.store','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Doc State:</strong>

                                <select id="doc_state" name="doc_state" class="form-control" required>
                                    <option value="">Choose Firm State</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Doc Name:</strong>

                                <input id="doc_name" type="text" class="form-control" name="doc_name" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 1:</strong>

                                <input id="textinputdate1" type="text" class="form-control hasDatepicker" name="textinputdate1" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 2:</strong>

                                <input id="textinputdate2" type="text" class="form-control hasDatepicker" name="textinputdate2" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 3:</strong>

                                <input id="textinputdate3" type="text" class="form-control hasDatepicker" name="textinputdate3" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 4:</strong>

                                <input id="textinputdate4" type="text" class="form-control hasDatepicker" name="textinputdate4" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Date 5:</strong>

                                <input id="textinputdate5" type="text" class="form-control hasDatepicker" name="textinputdate5" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 1:</strong>

                                <input id="textinputnumint1" type="text" class="form-control" name="textinputnumint1" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 2:</strong>

                                <input id="textinputnumint2" type="text" class="form-control" name="textinputnumint2" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 3:</strong>

                                <input id="textinputnumint3" type="text" class="form-control" name="textinputnumint3" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 4:</strong>

                                <input id="textinputnumint4" type="text" class="form-control" name="textinputnumint4" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Int 5:</strong>

                                <input id="textinputnumint5" type="text" class="form-control" name="textinputnumint5" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 1:</strong>

                                <input id="textinputnumdec1" type="text" class="form-control" name="textinputnumdec1" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 2:</strong>

                                <input id="textinputnumdec2" type="text" class="form-control" name="textinputnumdec2" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 3:</strong>

                                <input id="textinputnumdec3" type="text" class="form-control" name="textinputnumdec3" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 4:</strong>

                                <input id="textinputnumdec4" type="text" class="form-control" name="textinputnumdec4" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Num Dec 5:</strong>

                                <input id="textinputnumdec5" type="text" class="form-control" name="textinputnumdec5" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 1:</strong>

                                <input id="textinputtext1" type="text" class="form-control" name="textinputtext1" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 2:</strong>

                                <input id="textinputtext2" type="text" class="form-control" name="textinputtext2" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 3:</strong>

                                <input id="textinputtext3" type="text" class="form-control" name="textinputtext3" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 4:</strong>

                                <input id="textinputtext4" type="text" class="form-control" name="textinputtext4" value="">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Text Input Text 5:</strong>

                                <input id="textinputtext5" type="text" class="form-control" name="textinputtext5" value="">

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