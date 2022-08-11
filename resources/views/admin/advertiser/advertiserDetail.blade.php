@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Advertiser  Detail') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('advertiser.all') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name: </strong>
                                        {{ $advertiser->full_name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email: </strong>
                                        {{ $advertiser->email }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Telephone: </strong>
                                        {{ $advertiser->telephone }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>county: </strong>
                                        {{ $advertiser_county->county_name }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>City: </strong>
                                        {{ $advertiser->City }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>State: </strong>
                                        {{ $advertiser_state->state }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Category Name</th>
                                            <th>Services</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($listing as $key=>$val)
                                        <tr>
                                            <td>{{ $val->category_name}}</td>
                                            <td>{{ $val->service}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                               
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
