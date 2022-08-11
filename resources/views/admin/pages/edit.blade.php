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


                    {!! Form::model($page, ['method' => 'PATCH','route' => ['pages.update', $page->id]]) !!}

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

                                {!! Form::text('slug', null, array('placeholder' => 'Slug','class' => 'form-control',  'readonly' => 'readonly')) !!}

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
// var filter = new CKEDITOR.filter( 'button' );
</script>

@endsection
