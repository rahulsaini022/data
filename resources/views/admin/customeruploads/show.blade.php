@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Judge Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('judges.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $judge->id }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adjudicator:</strong>

                                {{ $judge->adjudicator }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adjudicator Lname:</strong>

                                {{ $judge->adjudicator_lname }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Title:</strong>

                                {{ $judge->adj_title }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Phone:</strong>

                                {{ $judge->adj_phone }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Fax:</strong>

                                {{ $judge->adj_fax }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Court:</strong>

                                {{ $judge->adj_court }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Address 1:</strong>

                                {{ $judge->adj_address1 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Address 2:</strong>

                                {{ $judge->adj_address2 }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj City:</strong>

                                {{ $judge->adj_city }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj State:</strong>

                                {{ $judge->adj_state }}

                            </div>

                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">

                            <div class="form-group">

                                <strong>Adj Zip:</strong>

                                {{ $judge->adj_zip }}

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection