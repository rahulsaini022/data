@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Update minimum wage') }}</strong>
                    <!-- <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('pdfcredits.index') }}"> Back</a>

                    </div> -->
                </div>
                <div class="card-body">
                     @if ($message = Session::get('success'))

                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif

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



                    {!! Form::open(array('route' => 'minmumwage.store','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Effective Date:</strong>

                                
                                <input placeholder="Effective date" class="form-control hasDatepicker" name="effective_date" type="text" value="{{ $minwage->effective_date }}">

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Minimum wage($):</strong>

                            

                                <input placeholder="Minimum wage($)" class="form-control"   value="{{ $minwage->hourly_minimum_wage }}" name="hourly_minimum_wage" type="number">

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




<script type="text/javascript">
$(document).ready(function () {
    $('.hasDatepicker').datepicker();

});
</script>

@endsection