@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Court') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('courts.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(array('route' => 'courts.store','method'=>'POST', 'id'=>'court_form')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {!! Form::text('name', null, array('placeholder' => 'Name','required','class' => 'form-control '.$errors->first('name','error'))) !!}
                              @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection