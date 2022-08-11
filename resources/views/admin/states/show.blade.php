@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('State Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('states.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>State:</strong>

                                {{ $state->state }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>State Abbreviation:</strong>

                                {{ $state->state_abbreviation }}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Active:</strong>

                                @if($state->active=='1') 
                                  <label class="badge badge-success"> Yes </label>
                                @else
                                  <label class="badge badge-danger"> No </label>
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