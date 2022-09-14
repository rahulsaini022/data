    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit PDF Credit') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('pdfcredits.index') }}"> Back</a>

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


                    {!! Form::model($pdfcredit, ['method' => 'PATCH','route' => ['pdfcredits.update', $pdfcredit->id]]) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Number of Credits:</strong>

                                {!! Form::number('number_of_credits', null, array('placeholder' => 'Number of Credits','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Purchase Price($):</strong>

                                {!! Form::number('purchase_price', null, array('placeholder' => 'Purchase Price($)','class' => 'form-control','min' => '0.00','max' => '999999.99')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Discount($):</strong>

                                {!! Form::number('discount', null, array('placeholder' => 'Discount($)','class' => 'form-control','min' => '0.00','max' => '999999.99')) !!}

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