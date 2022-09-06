    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Setting') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('settings.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">


                    {!! Form::model($setting, ['method' => 'PATCH','route' => ['settings.update', $setting->id]]) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {!! Form::text('setting_label', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                    @error('setting_label')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Key:</strong>

                                {!! Form::text('setting_key', null, array('placeholder' => 'Key','class' => 'form-control', 'readonly' => 'readonly')) !!}
                                    @error('setting_key')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Value:</strong>

                                {!! Form::text('setting_value', null, array('placeholder' => 'Value','class' => 'form-control')) !!}
                                    @error('setting_value')
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