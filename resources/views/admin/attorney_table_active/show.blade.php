@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorney Table Active Record Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('attorneytableactive.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $attorneytableactive->id }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration State:</strong>

                                {{ $attorneytableactive->registration_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration Number:</strong>

                                {{ $attorneytableactive->registrationnumber }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Registration Number State1:</strong>

                                {{ $attorneytableactive->registrationnumber_state1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>First Name:</strong>

                                {{ $attorneytableactive->fname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Middle Name:</strong>

                                {{ $attorneytableactive->mname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Name:</strong>

                                {{ $attorneytableactive->lname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Suffix:</strong>

                                {{ $attorneytableactive->sufname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Current Status:</strong>

                                {{ $attorneytableactive->currentstatus }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Document Sign Name:</strong>

                                {{ $attorneytableactive->document_sign_name }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Gender:</strong>

                                {{ $attorneytableactive->gender }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Attorney Title:</strong>

                                {{ $attorneytableactive->attorneytitle }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Insured:</strong>

                                {{ $attorneytableactive->insured }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Admission Date:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactive->admissiondate)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>How Admitted:</strong>

                                {{ $attorneytableactive->howadmitted }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Birth Date:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactive->birthdate)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Name:</strong>

                                {{ $attorneytableactive->firm_name }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Tagline:</strong>

                                {{ $attorneytableactive->firm_tagline }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Street Address:</strong>

                                {{ $attorneytableactive->firm_street_address }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Suite Unit Mailcode:</strong>

                                {{ $attorneytableactive->firm_suite_unit_mailcode }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>PO Box:</strong>

                                {{ $attorneytableactive->po_box }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm City:</strong>

                                {{ $attorneytableactive->firm_city }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm State:</strong>

                                {{ $attorneytableactive->firm_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm State Abr:</strong>

                                {{ $attorneytableactive->firm_state_abr }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Zip:</strong>

                                {{ $attorneytableactive->firm_zip }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Telephone:</strong>

                                {{ $attorneytableactive->firm_telephone }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm Fax:</strong>

                                {{ $attorneytableactive->firm_fax }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Email:</strong>

                                {{ $attorneytableactive->email }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Lawschool:</strong>

                                {{ $attorneytableactive->lawschool }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>County Id:</strong>

                                {{ $attorneytableactive->county_id }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Firm County:</strong>

                                {{ $attorneytableactive->firm_county }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Update:</strong>

                                {{ date("m/d/Y",strtotime($attorneytableactive->last_update)) }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Last Edited By:</strong>

                                {{ $attorneytableactive->last_edited_by }}

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection