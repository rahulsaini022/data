@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Package') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('casepaymentpackages.index') }}"> Back</a>

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



                    {!! Form::open(array('route' => 'casepaymentpackages.store','method'=>'POST')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Title:</strong>

                                {!! Form::text('package_title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Description:</strong>

                                {!! Form::textarea('package_description', null, array('placeholder' => 'Description','class' => 'form-control text-description-editor-tool', 'rows' => 10)) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Price:</strong>

                                {!! Form::number('package_price', null, array('placeholder' => 'Price($)','class' => 'form-control')) !!}
    
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Case Types:</strong>

                                <br/>

                                @foreach($case_types as $value)

                                    <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                                        <label>{{ Form::checkbox('case_type_ids[]', $value->id, false, array('class' => 'case_type')) }}

                                        {{ $value->case_type }}</label>
                                    </div>

                                @endforeach

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Active:</strong>
                                <input type="radio" id="active-1" class="active-input" name="active" value="1" required="" checked="">
                                <label for="active-1">Yes</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="active-0" class="active-input" name="active" value="0">
                                <label for="active-0">No</label>&nbsp;&nbsp;&nbsp;
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
<!-- <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script> -->
<script src="https://cdn.tiny.cloud/1/2x5u268fo03ee79da7sdsyo8s9d6u9zl6ipa620id8n04u10/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
    tinymce.init({
        selector : "textarea",
        // plugins : ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste jbimages"],
        // toolbar : "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
        plugins : ["lists"],
        toolbar : "undo redo | bold italic | bullist numlist |",
    });
</script>


@endsection