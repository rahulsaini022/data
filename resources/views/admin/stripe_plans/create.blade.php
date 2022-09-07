@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create Stripe Plan') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('stripeplans.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                  {!! Form::open(array('route' => 'stripeplans.store','method'=>'POST', 'id'=>'stripeplans_form', 'autocomplete'=>'off')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan ID:</strong>

                                {!! Form::text('plan_id', null, array('placeholder' => 'Plan ID','required','class' => 'form-control '.$errors->first('plan_id','error'))) !!}
                              @error('plan_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Name:</strong>

                                {!! Form::text('plan_name', null, array('placeholder' => 'Plan Name','required','class' => 'form-control '.$errors->first('plan_name','error'))) !!}
                              @error('plan_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Title:</strong>

                                {!! Form::text('plan_title', null, array('placeholder' => 'Plan Title','class' => 'form-control '.$errors->first('plan_title','error'))) !!}
                              @error('plan_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Plan Description:</strong>

                                {!! Form::text('plan_description', null, array('placeholder' => 'Plan Description','class' => 'form-control '.$errors->first('plan_description','error'))) !!}
                              @error('plan_description')
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