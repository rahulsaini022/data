@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Subscription  Detail') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('advertiser.subscription_listing') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Advertiser Name: </strong>
                                    {{ $full_name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Category Name: </strong>
                                    {{ $category_name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Services: </strong>

                                    {{-- @foreach ($services as $service) --}}
                                    {{ $services }}
                                    {{-- @endforeach --}}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Amount: </strong>
                                    $ {{ $amount }}.00
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Stripe id: </strong>
                                    {{ $stripe_id }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>County Name: </strong>
                                    {{ $county_name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Start date: </strong>
                                    {{ $start }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>End date: </strong>
                                    {{ $end }}
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
