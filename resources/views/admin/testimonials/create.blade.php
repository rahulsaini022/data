@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Testimonial') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('testimonials.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">


                    {!! Form::open(array('route' => 'testimonials.store','id'=>'testimonial_form','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Author Name:</strong>

                                {!! Form::text('author_name', null, array('placeholder' => 'Author Name','class' => 'form-control','required'=>'true')) !!}
 @error('author_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Author Position:</strong>

                                {!! Form::text('author_position', null, array('placeholder' => 'Author Position','class' => 'form-control','required'=>'true')) !!}
@error('author_position')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Description:</strong>

                                {!! Form::textarea('description', null, array('placeholder' => 'Description','class' => 'form-control','required'=>'true')) !!}
                         @error('description')
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