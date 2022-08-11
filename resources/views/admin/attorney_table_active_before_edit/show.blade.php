@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorney Table Active Record Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('attorneytableactivebeforeedit.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $attorneytableactivebeforeedit->id }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration State:</strong>

                                {{ $attorneytableactivebeforeedit->registration_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration Number:</strong>

                                {{ $attorneytableactivebeforeedit->registrationnumber }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration Number State1:</strong>

                                {{ $attorneytableactivebeforeedit->registrationnumber_state1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>First Name:</strong>

                                {{ $attorneytableactivebeforeedit->fname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Middle Name:</strong>

                                {{ $attorneytableactivebeforeedit->mname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Name:</strong>

                                {{ $attorneytableactivebeforeedit->lname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Suffix:</strong>

                                {{ $attorneytableactivebeforeedit->sufname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Current Status:</strong>

                                {{ $attorneytableactivebeforeedit->currentstatus }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Document Sign Name:</strong>

                                {{ $attorneytableactivebeforeedit->document_sign_name }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Gender:</strong>

                                {{ $attorneytableactivebeforeedit->gender }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Attorney Title:</strong>

                                {{ $attorneytableactivebeforeedit->attorneytitle }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Insured:</strong>

                                {{ $attorneytableactivebeforeedit->insured }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Admission Date:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactivebeforeedit->admissiondate)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>How Admitted:</strong>

                                {{ $attorneytableactivebeforeedit->howadmitted }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Birth Date:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactivebeforeedit->birthdate)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Name:</strong>

                                {{ $attorneytableactivebeforeedit->firm_name }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Tagline:</strong>

                                {{ $attorneytableactivebeforeedit->firm_tagline }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Street Address:</strong>

                                {{ $attorneytableactivebeforeedit->firm_street_address }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Suite Unit Mailcode:</strong>

                                {{ $attorneytableactivebeforeedit->firm_suite_unit_mailcode }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>PO Box:</strong>

                                {{ $attorneytableactivebeforeedit->po_box }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm City:</strong>

                                {{ $attorneytableactivebeforeedit->firm_city }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm State:</strong>

                                {{ $attorneytableactivebeforeedit->firm_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm State Abr:</strong>

                                {{ $attorneytableactivebeforeedit->firm_state_abr }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Zip:</strong>

                                {{ $attorneytableactivebeforeedit->firm_zip }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Telephone:</strong>

                                {{ $attorneytableactivebeforeedit->firm_telephone }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Fax:</strong>

                                {{ $attorneytableactivebeforeedit->firm_fax }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Email:</strong>

                                {{ $attorneytableactivebeforeedit->email }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Lawschool:</strong>

                                {{ $attorneytableactivebeforeedit->lawschool }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>County Id:</strong>

                                {{ $attorneytableactivebeforeedit->county_id }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm County:</strong>

                                {{ $attorneytableactivebeforeedit->firm_county }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Update:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactivebeforeedit->last_update)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Edited By:</strong>

                                {{ $attorneytableactivebeforeedit->last_edited_by }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Backup Created At:</strong>

                                {{ date("m/d/Y H:i:m",strtotime($attorneytableactivebeforeedit->created_at)) }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                            <div class="form-group">

                                {!! Form::open(['method' => 'POST','route' => ['attorneytableactivebeforeedit.restore'],'style'=>'display:inline']) !!}
                                  {!! Form::hidden('id', $attorneytableactivebeforeedit->id, array('placeholder' => 'Id','class' => 'form-control', 'required' => 'required')) !!}
                                  {!! Form::submit('Restore', ['class' => 'btn btn-success confirm-restore', 'onclick' => 'return ConfirmRestore();']) !!}

                              {!! Form::close() !!}

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    
<script type="text/javascript">
function ConfirmRestore()
{
    var x = confirm("Are you sure you want to restore this attorney table active record.");
    if (x)
        return true;
    else
        return false;
}
</script>
@endsection