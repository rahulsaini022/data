@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Edit Page') }}</strong>
                        <div class="pull-right">

                            <a class="btn btn-primary" href="{{ route('pages.index') }}"> Back</a>

                        </div>
                    </div>
                    <div class="card-body">

                        {!! Form::model($page, ['method' => 'PATCH', 'id'=>'page_form','route' => ['pages.update', $page->id]]) !!}

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Title:</strong>

                                    {!! Form::text('title', null, ['placeholder' => 'Title','required', 'class' => 'form-control']) !!}
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Slug:</strong>

                                    {!! Form::text('slug', null, ['placeholder' => 'Slug','required', 'class' => 'form-control', 'readonly' => 'readonly']) !!}
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>


                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Content:</strong>

                                    {!! Form::textarea('content', null, [
                                        'placeholder' => 'Content','required',
                                        'class' => 'form-control text-content-editor-tool',
                                        'rows' => 10,
                                        'cols' => 50,
                                    ]) !!}
                                    @error('content')
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
    <!-- html editor -->
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

    <script type="text/javascript">
        CKEDITOR.replace('content');
        // var filter = new CKEDITOR.filter( 'button' );
    </script>

@endsection
