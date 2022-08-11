@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertiser Services Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('advertiser-services.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name: </strong>

                                {{ $service->name }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Fees: </strong>

                               ${{ $service->service_list_fee }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Service Terms: </strong>

                                {{ $service->service_list_term }}

                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Descriptions: </strong>

                                {{ $service->description}}

                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                @if ($service->has_child)
                                <a class="btn btn-secondary mb-1" href="{{ route('child.services',$service->id) }}"> View Child Service</a>
    
                                @endif
                            </div>

                        </div>

                       

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection