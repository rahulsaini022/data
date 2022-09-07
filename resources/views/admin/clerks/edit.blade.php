    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Clerk') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('clerks.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    {!! Form::model($clerk, ['method' => 'PATCH','route' => ['clerks.update', $clerk->id], 'id'=>'clerk_form']) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {!! Form::text('clerkname', null, array('placeholder' => 'Name','required','class' => 'form-control '.$errors->first('clerkname', 'error'))) !!}
                                  @error('clerkname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Clerk Title:</strong>

                                {!! Form::text('clerktitle', null, array('placeholder' => 'Clerk Title','required','class' => 'form-control '.$errors->first('clerktitle', 'error'))) !!}
                                  @error('clerktitle')
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