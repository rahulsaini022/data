@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Clerk Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('clerks.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>ID:</strong>

                                {{ $clerk->id }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {{ $clerk->clerkname }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Clerk Title:</strong>

                                {{ $clerk->clerktitle }}

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

@endsection