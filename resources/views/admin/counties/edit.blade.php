    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit County') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('counties.index') }}"> Back</a>

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


                    {!! Form::model($county, ['method' => 'PATCH','route' => ['counties.update', $county->id], 'id'=>'edit_county_form']) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>State:</strong>
                                <input type="hidden" id="selected_state" name="" value="{{$county->state_id}}" style="display: none;">
                                {!! Form::select('state_id', [null=>'Select State'], null, ['class' => 'form-control county-state-select', 'id' => 'state_id', 'required' => 'required']) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>County Name:</strong>

                                {!! Form::text('county_name', null, array('placeholder' => 'County Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>County Designation:</strong>

                                {!! Form::text('county_designation', null, array('placeholder' => 'County Designation','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>County Active:</strong>

                                <label> <input type="radio" name="county_active" value="Y"> Yes</label>
                                <label> <input type="radio" name="county_active" value="N" checked=""> No</label>

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

    $('#edit_county_form').validate({
        rules: {
            firm_telephone: {
                // pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/) // old it allows more than 3 characters inside braces
                pattern:(/\([\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
            firm_fax: {
                pattern:(/\([\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
        }
    });

    $('.county-state-select').select2();

    $.ajax({
        url:"{{route('ajax_get_states')}}",
        method:"GET",
        dataType: 'json',
        success: function(data){
            // console.log(data);
            if(data==null || data=='null'){
            } else {
                $.each(data, function (key, val) {
                    $('.county-state-select').append('<option value='+key+'>'+val+'</option>');
                });
                var selected_state=$('#selected_state').val();
                $('#state_id option[value="'+selected_state+'"]').prop('selected', true);
            }
        }
    });

});

</script>
@endsection