@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New PDF Credit') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('pdfcredits.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

      {!! Form::open(array('route' => 'pdfcredits.store','method'=>'POST','id'=>'pdfcredit_form')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Number of Credits:</strong>

                                {!! Form::number('number_of_credits', null, array('placeholder' => 'Number of Credits','required','class' => 'form-control','onkeypress'=>"if(this.value.length==8) return false;")) !!}
                                    @error('number_of_credits')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Purchase Price($):</strong>

                                {!! Form::number('purchase_price', '0.00', array('placeholder' => 'Purchase Price($)','required','class' => 'form-control','min' => '0.00','max' => '999999.99')) !!}
                                    @error('purchase_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Discount($):</strong>

                                {!! Form::number('discount', '0.00', array('placeholder' => 'Discount($)','class' => 'form-control','min' => '0.00','max' => '999999.99')) !!}
                                    @error('discount')
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