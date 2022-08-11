@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Stripe Plan Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('stripeplans.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $stripeplans->id }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan ID:</strong>

                                {{ $stripeplans->plan_id }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Name:</strong>

                                {{ $stripeplans->plan_name }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Title:</strong>

                                {{ $stripeplans->plan_title }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Description:</strong>

                                {{ $stripeplans->plan_description }}

                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection