@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Package') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('casepaymentpackages.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                  
                    {!! Form::model($package, ['method' => 'PATCH','id'=>'case_package_form','route' => ['casepaymentpackages.update', $package->id]]) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Title:</strong>

                                {!! Form::text('package_title', null, array('placeholder' => 'Title','class' => 'form-control','required')) !!}
                                    @error('package_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Description:</strong>

                                {!! Form::textarea('package_description', null, array('placeholder' => 'Description','class' => 'form-control text-description-editor-tool', 'rows' => 10)) !!}
                                    @error('package_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Price:</strong>

                                {!! Form::number('package_price', null, array('placeholder' => 'Price($)','class' => 'form-control','onkeypress'=>'if(this.value.length==8) return false;','min'=>1,'oninput'=>"validity.valid||(value='');")) !!}
                                        @error('package_price')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group case_type_error">

                                <strong>Case Types:</strong>

                                <br/>
                                <?php $case_type_ids = explode(",",$package->case_type_ids); ?>
                                @foreach($case_types as $value)
                                    <?php if(in_array($value->id, $case_type_ids)){ $is_checked=true; } else { $is_checked=false; } ?>
                                    <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                                        <label>{{ Form::checkbox('case_type_ids[]', $value->id, $is_checked, array('class' => 'case_type')) }}

                                        {{ $value->case_type }}</label>
                                    </div>

                                @endforeach
                                    @error('case_type_ids')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Active:</strong>
                                <input type="radio" id="active-1" class="active-input" name="active" value="1" required="" <?php if($package->active!='0'){ echo "checked"; }?>>
                                <label for="active-1">Yes</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="active-0" class="active-input" name="active" value="0" <?php if($package->active=='0'){ echo "checked"; }?>>
                                <label for="active-0">No</label>&nbsp;&nbsp;&nbsp;
                            </div>
                                    @error('active')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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