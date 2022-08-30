    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Magistrate') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('magistrates.index') }}"> Back</a>

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

                    {!! Form::model($magistrate, ['method' => 'PATCH','route' => ['magistrates.update', $magistrate->id], 'id'=>'edit_magistrate_form', 'autocomplete'=>'off']) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {!! Form::text('mag_name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Last Name:</strong>

                                {!! Form::text('mag_last_name', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Title:</strong>

                                {!! Form::text('mag_title', null, array('placeholder' => 'Magistrate Title','class' => 'form-control')) !!}

                            </div>

                        </div>  

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Division:</strong>

                                {!! Form::text('mag_div', null, array('placeholder' => 'Magistrate Division','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate jurisdiction:</strong>

                                {!! Form::text('mag_jurisdiction', null, array('placeholder' => 'Magistrate Jurisdiction','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Court:</strong>

                                {!! Form::select('court_id', $courts, null, ['class' => 'form-control magistrate-court-select']) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Phone:</strong>

                                {!! Form::text('mag_phone', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Magistrate Fax:</strong>

                                {!! Form::text('mag_fax', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css"; rel="stylesheet" />
<style type="text/css">
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 37.033px;
    }
    .select2-container--default .select2-selection--single{
        border: 1px solid #ced4da;
    }
    .select2-container .select2-selection--single{
        height: 37.033px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow{
        height: 36px;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js";></script>
<script type="text/javascript">
$(document).ready(function () {

    $('#edit_magistrate_form').validate({
        rules: {
            mag_phone: {
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
            mag_fax: {
                pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
        }
    });

    $('.magistrate-court-select').select2();
});

</script>
@endsection