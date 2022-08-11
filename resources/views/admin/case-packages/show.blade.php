@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Package Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('casepaymentpackages.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Title:</strong>

                                {{ $package->package_title }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Price:</strong>

                                ${{ $package->package_price }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Status:</strong>

                                @if($package->active=='1')
                                    <label class="badge badge-success">Active</label>
                                @else
                                    <label class="badge badge-danger">Deactivated</label>
                                @endif

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Case Types:</strong>

                                 @foreach($case_types as $value)
                                    
                                    <label class="badge badge-success">{{ $value->case_type }}</label>

                                @endforeach
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Description:</strong>

                                {!! $package->package_description !!}

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection