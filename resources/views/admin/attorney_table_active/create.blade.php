@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Attorney Table Active Record') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('attorneytableactive.index') }}"> Back</a>

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


                    {!! Form::open(array('route' => 'attorneytableactive.store','method'=>'POST', 'id'=>'create_attorneytableactive_form', 'autocomplete'=>'off')) !!}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Registration State:</strong>

                                {!! Form::select('registration_state_id', [null=>'Select State'], null, ['class' => 'form-control attorneytableactive-reg-state-select', 'id' => 'registration_state_id', 'required' => 'required']) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Registration Number:</strong>

                                {!! Form::number('registrationnumber', null, array('placeholder' => 'Registration Number','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Registration Number State1:</strong>

                                {!! Form::number('registrationnumber_state1', null, array('placeholder' => 'Registration Number State1','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>First Name:</strong>

                                {!! Form::text('fname', null, array('placeholder' => 'First Name','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Middle Name:</strong>

                                {!! Form::text('mname', null, array('placeholder' => 'Middle Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Last Name:</strong>

                                <!-- {!! Form::number('court_id', null, array('placeholder' => 'attorneytableactive Court Id','class' => 'form-control', 'readonly')) !!} -->
                                {!! Form::text('lname', null, array('placeholder' => 'Last Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Suffix:</strong>

                                <select id="sufname" name="sufname" class="form-control">
                                    <option value="">Choose Suffix Type</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                </select>

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Current Status:</strong>

                                {!! Form::text('currentstatus', null, array('placeholder' => 'Current Status','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Document Sign Name:</strong>

                                {!! Form::text('document_sign_name', null, array('placeholder' => 'Document Sign Name','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Gender:</strong>
                                <input type="radio" id="atgen-m" class="gender-input" name="gender" value="M" required="">
                                <label for="atgen-m">M</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="atgen-f" class="gender-input" name="gender" value="F">
                                <label for="atgen-f">F</label>&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="atgen-n" class="gender-input" name="gender" value="N">
                                <label  for="atgen-n">N</label>
                                <span class="gender-error-11"></span>
                                

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Attorney Title:</strong>

                                {!! Form::text('attorneytitle', null, array('placeholder' => 'Attorney Title','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Insured:</strong>

                                {!! Form::text('insured', null, array('placeholder' => 'Insured','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Admission Date:</strong>

                                {!! Form::text('admissiondate', null, array('placeholder' => 'Admission Date','class' => 'form-control hasDatepicker', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>How Admitted:</strong>

                                {!! Form::text('howadmitted', null, array('placeholder' => 'How Admitted','class' => 'form-control', 'required' => 'required')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Birth Date:</strong>

                                {!! Form::text('birthdate', null, array('placeholder' => 'Birth Date','class' => 'form-control hasDatepicker')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Name:</strong>

                                {!! Form::text('firm_name', null, array('placeholder' => 'Firm Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Tagline:</strong>

                                {!! Form::text('firm_tagline', null, array('placeholder' => 'Firm Tagline','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Street Address:</strong>

                                {!! Form::text('firm_street_address', null, array('placeholder' => 'Firm Street Address','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Suite Unit Mailcode:</strong>

                                {!! Form::text('firm_suite_unit_mailcode', null, array('placeholder' => 'Firm Suite Unit Mailcode','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>PO Box:</strong>

                                {!! Form::text('po_box', null, array('placeholder' => 'PO Box','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Zip:</strong>
                                <p class="text-danger no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                {!! Form::text('firm_zip', null, array('placeholder' => 'Firm Zip','class' => 'form-control', 'id' => 'firm_zip')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm State:</strong>

                                {!! Form::select('firm_state', [null=>'Select State'], null, ['class' => 'form-control attorneytableactive-state-select', 'id' => 'firm_state']) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm City:</strong>

                                {!! Form::select('firm_city', [null=>'Select City'], null, ['class' => 'form-control attorneytableactive-county-select', 'id' => 'firm_city']) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Telephone:</strong>

                                {!! Form::text('firm_telephone', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm Fax:</strong>

                                {!! Form::text('firm_fax', null, array('placeholder' => '(XXX) XXX-XXXX','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Email:</strong>

                                {!! Form::email('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Lawschool:</strong>

                                {!! Form::text('lawschool', null, array('placeholder' => 'Lawschool','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Firm County:</strong>

                                {!! Form::select('firm_county', [null=>'Select County'], null, ['class' => 'form-control attorneytableactive-county-select', 'id' => 'firm_county', 'required' => 'required']) !!}

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

    $('#create_attorneytableactive_form').validate({
        rules: {
            firm_telephone: {
                // pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/) // old it allows more than 3 characters inside braces
                pattern:(/\([\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
            firm_fax: {
                pattern:(/\([\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
            },
        },
         
      errorPlacement: function(error, element) {
            if (element.attr("name") === "registration_state_id") {
             var elem = $(element);
       if (elem.hasClass("select2-hidden-accessible")) {
           element = $("#select2-" + elem.attr("id") + "-container").parent(); 
           error.insertAfter(element);
       } else {
           error.insertAfter(element);
       }
            }
             if (element.attr("name") === "gender") {
             error.appendTo('.gender-error-11');
             }
               else {
               
                error.insertAfter(element);
            }
        }

    });

    $('.attorneytableactive-reg-state-select').select2({ width: '100%' });
  

    $('.hasDatepicker').datepicker();

    $.ajax({
        url:"{{route('ajax_get_states')}}",
        method:"GET",
        dataType: 'json',
        success: function(data){
            // console.log(data);
            if(data==null || data=='null'){
            } else {
                $.each(data, function (key, val) {
                    $('.attorneytableactive-reg-state-select').append('<option value='+key+'>'+val+'</option>');
                });
                // var selected_state=$('#selected_state').val();
                // $('#registration_state_id option[value="'+selected_state+'"]').prop('selected', true);
            }
        }
    });

    // $('#firm_zip').on('keyup', function() {
    $('#firm_zip').on('input', function() {
        $('.no-state-county-found').hide();
        $('#firm_city').find('option').remove().end().append('<option value="">Choose City</option>');
        $('#firm_state').find('option').remove().end().append('<option value="">Choose State</option>');
        $('#firm_county').find('option').remove().end().append('<option value="">Choose County</option>');
        var zip=$('#firm_zip').val();
        if( zip != '' && zip != null && zip.length >= '3'){
            var token= $('input[name=_token]').val();
            $.ajax({
                url:"{{route('ajax_get_city_state_county_by_zip')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    zip: zip, 
                    _token: token, 
                },
                success: function(data){
                    // console.log(data);
                    if(data=='null' || data==''){
                        $('.no-state-county-found').show();
                    } else {
                        $('.no-state-county-found').hide();
                        $.each(data, function (key, val) {
                            $('#firm_city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                            $('#firm_state').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                            $('#firm_county').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                        });
                        var a = new Array();
                        $('#firm_city').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('#firm_state').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('#firm_county').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        if($('#firm_city').children('option').length=='2'){
                            $('#firm_city').children('option').first().remove();
                        }
                        if($('#firm_state').children('option').length=='2'){
                            $('#firm_state').children('option').first().remove();
                        }
                        if($('#firm_county').children('option').length=='2'){
                            $('#firm_county').children('option').first().remove();
                        }
                        $('.no-state-county-found').hide();
                    }
                }
            });        
        }
    });
});

</script>
@endsection