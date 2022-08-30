    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Judge') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('judges.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    @if (count($errors) > 0)

                        <div class="alert-error alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                           @foreach ($errors->all() as $error)

                             <li>{{ $error }}</li>

                           @endforeach

                        </ul>

                      </div>

                    @endif


                    {!! Form::model($judge, ['method' => 'PATCH','route' => ['judges.update', $judge->id], 'id'=>'edit_judge_form']) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator First Name:</strong>

                                {!! Form::text('adjudicator', null, array('placeholder' => 'Adjudicator First Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Last Name:</strong>

                                {!! Form::text('adjudicator_lname', null, array('placeholder' => 'Adjudicator Last Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Title:</strong>

                                {!! Form::text('adj_title', null, array('placeholder' => 'Adjudicator Title','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Phone:</strong>

                                {!! Form::text('adj_phone', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Fax:</strong>

                                {!! Form::text('adj_fax', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Court:</strong>

                                {!! Form::text('adj_court', null, array('placeholder' => 'Adjudicator Court','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Address 1:</strong>

                                {!! Form::text('adj_address1', null, array('placeholder' => 'Adjudicator Address 1','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Address 2:</strong>

                                {!! Form::text('adj_address2', null, array('placeholder' => 'Adjudicator Address 2','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator City:</strong>

                                {!! Form::text('adj_city', null, array('placeholder' => 'Adjudicator City','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator State:</strong>

                                {!! Form::text('adj_state', null, array('placeholder' => 'Adjudicator City','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Adjudicator Zip:</strong>

                                {!! Form::text('adj_zip', null, array('placeholder' => 'Adjudicator City','class' => 'form-control')) !!}

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

    $('#edit_judge_form').validate({
        rules: {
            adj_phone: {
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
            adj_fax: {
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
        }
    });
});

</script>
@endsection