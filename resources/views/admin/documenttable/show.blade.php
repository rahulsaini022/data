@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Document Table Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('documenttable.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Doc State:</strong>

                                {{ $document->doc_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Doc Name:</strong>

                                {{ $document->doc_name }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Date 1:</strong>

                                <?php if(isset($document->textinputdate1)){ echo date("m/d/Y", strtotime($document->textinputdate1)); } ?>

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Date 2:</strong>

                                <?php if(isset($document->textinputdate2)){ echo date("m/d/Y", strtotime($document->textinputdate2)); } ?>

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Date 3:</strong>

                                <?php if(isset($document->textinputdate3)){ echo date("m/d/Y", strtotime($document->textinputdate3)); } ?>

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Date 4:</strong>

                                <?php if(isset($document->textinputdate4)){ echo date("m/d/Y", strtotime($document->textinputdate4)); } ?>

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Date 5:</strong>

                                <?php if(isset($document->textinputdate5)){ echo date("m/d/Y", strtotime($document->textinputdate5)); } ?>

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Int 1:</strong>

                                {{ $document->textinputnumint1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Int 2:</strong>

                                {{ $document->textinputnumint2 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Int 3:</strong>

                                {{ $document->textinputnumint3 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Int 4:</strong>

                                {{ $document->textinputnumint4 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Int 5:</strong>

                                {{ $document->textinputnumint5 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Dec 1:</strong>

                                {{ $document->textinputnumdec1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Dec 2:</strong>

                                {{ $document->textinputnumdec2 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Dec 3:</strong>

                                {{ $document->textinputnumdec3 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Dec 4:</strong>

                                {{ $document->textinputnumdec4 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Num Dec 5:</strong>

                                {{ $document->textinputnumdec5 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Text 1:</strong>

                                {{ $document->textinputtext1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Text 2:</strong>

                                {{ $document->textinputtext2 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Text 3:</strong>

                                {{ $document->textinputtext3 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Text 4:</strong>

                                {{ $document->textinputtext4 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Text Input Text 5:</strong>

                                {{ $document->textinputtext5 }}

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection