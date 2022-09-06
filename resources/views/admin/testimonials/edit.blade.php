    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row justify-content-center attorney-dashboard">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>{{ __('Edit Testimonial') }}</strong>
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('testimonials.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Form::model($testimonial, [
                                'method' => 'PATCH',
                                'id' => 'testimonial_form',
                                'route' => ['testimonials.update', $testimonial->id],
                            ]) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Author Name:</strong>
                                        {!! Form::text('author_name', null, [
                                            'placeholder' => 'Author Name',
                                            'required' => 'true',
                                            'class' => 'form-control',
                                        ]) !!}
                                        @error('author_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Author Position:</strong>
                                        {!! Form::text('author_position', null, [
                                            'placeholder' => 'Author Position',
                                            'required' => 'true',
                                            'class' => 'form-control',
                                        ]) !!}
                                        @error('author_position')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        {!! Form::textarea('description', null, [
                                            'placeholder' => 'Description',
                                            'required' => 'true',
                                            'class' => 'form-control',
                                        ]) !!}
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
