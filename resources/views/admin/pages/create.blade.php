@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Page') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('pages.index') }}"> Back</a>

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



                    {!! Form::open(array('route' => 'pages.store','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Title:</strong>

                                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Slug:</strong>

                                {!! Form::text('slug', null, array('placeholder' => 'Slug','class' => 'form-control', 'style' => 'text-transform:lowercase')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Content:</strong>

                                {!! Form::textarea('content', null, array('placeholder' => 'Content','class' => 'form-control text-content-editor-tool', 'rows' => 10, 'cols' => 50)) !!}
    
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
    CKEDITOR.replace( 'content' );

</script>


@endsection