@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Pricing') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('prices.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                    @if (count($errors) > 0)

                      <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                           @foreach ($errors->all() as $error)

                             <li>{{ $error }}</li>

                           @endforeach

                        </ul>

                      </div>

                    @endif



                    {!! Form::open(array('route' => 'prices.store','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Title:</strong>

                                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Full Price($):</strong>

                                {!! Form::number('full_price', null, array('placeholder' => 'Full Price($)','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Price($):</strong>

                                {!! Form::number('adjudicator_price', null, array('placeholder' => 'Adjudicator Price($)','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Law Clinic Price($):</strong>

                                {!! Form::number('law_clinic_price', null, array('placeholder' => 'Law Clinic Price($)','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Legal Aid Price($):</strong>

                                {!! Form::number('legal_aid_price', null, array('placeholder' => 'Legal Aid Price($)','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Discount($):</strong>

                                {!! Form::number('discount', null, array('placeholder' => 'Discount($)','class' => 'form-control')) !!}

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