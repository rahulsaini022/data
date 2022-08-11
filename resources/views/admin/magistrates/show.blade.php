@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Magistrate Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('magistrates.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $magistrate->id }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {{ $magistrate->mag_name }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Title:</strong>

                                {{ $magistrate->mag_title }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Court Name:</strong>

                                {{ $magistrate->mag_court_name }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Division:</strong>

                                {{ $magistrate->mag_div }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Court Id:</strong>

                                {{ $magistrate->court_id }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Jurisdiction:</strong>

                                {{ $magistrate->mag_jurisdiction }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Phone:</strong>

                                {{ $magistrate->mag_phone }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Fax:</strong>

                                {{ $magistrate->mag_fax }}

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection