@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Create New Prospect') }}</strong>
                        <div class="pull-right">

                            <a class="btn btn-primary" href="{{ route('prospects.index') }}"> Back</a>

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



                        {!! Form::open(['route' => 'prospects.store', 'method' => 'POST', 'id' => 'prospect_form']) !!}

                        <input id="attorney_id" type="hidden" class="form-control" name="attorney_id"
                            value="{{ Auth::user()->id }}" readonly>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>First Name*:</strong>
                                    <input id="prosp_fname" type="text" class="form-control" name="prosp_fname"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Middle Name:</strong>
                                    <input id="prosp_mname" type="text" class="form-control" name="prosp_mname"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Last Name*:</strong>
                                    <input id="prosp_lname" type="text" class="form-control" name="prosp_lname"
                                        value="" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Suffix:</strong>
                                    <select id="prosp_sufname" name="prosp_sufname" class="form-control">
                                        <option value="">None</option>
                                        <option value="Sr.">Sr.</option>
                                        <option value="Jr.">Jr.</option>
                                        <option value="I">I</option>
                                        <option value="II">II</option>
                                        <option value="III">III</option>
                                        <option value="IV">IV</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Zipcode:</strong><span class="text-danger no-state-county-cl"
                                        style="display: none;">No City, State, County found for this zipcode.</span>
                                    <input id="prosp_zip" type="text" class="form-control" name="prosp_zip"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Street Address:</strong>
                                    <input id="prosp_street_ad" type="text" class="form-control" name="prosp_street_ad"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Unit:</strong>
                                    <input id="prosp_unit" type="text" class="form-control" name="prosp_unit"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>PO Box:</strong>
                                    <input id="prosp_pobox" type="text" class="form-control" name="prosp_pobox"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>State:</strong>
                                    <select id="prosp_state_id" name="prosp_state_id" class="form-control cl-state">
                                        <option value="">Choose State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>City:</strong>
                                    <select id="prosp_city" name="prosp_city" class="form-control cl-city">
                                        <option value="">Choose City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    <input id="prosp_email" type="email" class="form-control" name="prosp_email"
                                        value="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <strong>Phone:</strong>
                                    <input id="prosp_phone" type="text" class="form-control" name="prosp_phone"
                                        onkeypress="return onlyNumber(event);" value=""  placeholder="XXX-XXX-XXXX">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <strong>Court/Admin Matters:</strong>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault1" value="Domestic Relations">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Domestic Relations
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault2" value="Juvenile/Probate (Family Law)">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Juvenile/Probate (Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault3" value="Civil (NOT Family Law)">
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Civil (NOT Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault4" value="Juvenile (NOT Family Law)">
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Juvenile (NOT Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault5" value="Criminal - Traffic/Misdemeanor">
                                    <label class="form-check-label" for="flexRadioDefault5">
                                        Criminal - Traffic/Misdemeanor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault6" value="Criminal - Felony">
                                    <label class="form-check-label" for="flexRadioDefault6">
                                        Criminal - Felony
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault87" value="Probate (Estate)">
                                    <label class="form-check-label" for="flexRadioDefault87">
                                        Probate (Estate)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault8" value="Bankruptcy">
                                    <label class="form-check-label" for="flexRadioDefault8">
                                        Bankruptcy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault9" value="Disability">
                                    <label class="form-check-label" for="flexRadioDefault9">
                                        Disability
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault10" value="Workers’ Compensation">
                                    <label class="form-check-label" for="flexRadioDefault10">
                                        Workers’ Compensation
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <strong>Recordable Document Matter:</strong>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault11" value=" Estate/Trust">
                                    <label class="form-check-label" for="flexRadioDefault11">
                                        Estate/Trust
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault12" value="Real Estate">
                                    <label class="form-check-label" for="flexRadioDefault12">
                                        Real Estate
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault13" value="Contracts">
                                    <label class="form-check-label" for="flexRadioDefault13">
                                        Contracts
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault16" value="Notes">
                                    <label class="form-check-label" for="flexRadioDefault16">
                                        Notes
                                    </label>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#prospect_form').validate({
                rules: {
                    prosp_phone: {
                        maxlength: 12,
                        minlength: 12,
                    },
                },
                messages: {
                    prosp_phone: {
                        maxlength: "Phone Number cannot be more than 10 digit",
                        minlength: "Phone Number should be of 10 digit miniumum",
                    },
                }
            });

            // $('#prosp_zip').on('keyup', function() {
            $('#prosp_zip').on('input', function() {
                var type = 'cl';
                $('.no-state-county-' + type + '').hide();
                $('.' + type + '-city').find('option').remove().end().append(
                    '<option value="">Choose City</option>');
                $('.' + type + '-state').find('option').remove().end().append(
                    '<option value="">Choose State</option>');
                var zip = this.value;
                if (zip != '' && zip != null && zip.length >= '3') {
                    var token = $('input[name=_token]').val();
                    $.ajax({
                        url: "{{ route('ajax_get_city_state_county_by_zip') }}",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            zip: zip,
                            _token: token,
                        },
                        success: function(data) {
                            // console.log(data);
                            if (data == 'null' || data == '') {
                                $('.no-state-county-' + type + '').show();
                                // $('.cl_no_zip').show();
                            } else {
                                $.each(data, function(key, val) {
                                    $('.' + type + '-city').append('<option value="' +
                                        data[key].city + '">' + data[key].city +
                                        '</option>');
                                    $('.' + type + '-state').append('<option value="' +
                                        data[key].state_id + '">' + data[key]
                                        .state + '</option>');
                                });
                                var a = new Array();
                                $('.' + type + '-city').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('.' + type + '-state').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                if ($('.' + type + '-city').children('option').length == '2') {
                                    $('.' + type + '-city').children('option').first().remove();
                                }
                                if ($('.' + type + '-state').children('option').length == '2') {
                                    $('.' + type + '-state').children('option').first()
                                .remove();
                                }

                                $('.no-state-county-cl').hide();
                            }
                        }
                    });
                }

            });


            var faxing = document.querySelector('#prosp_phone');
            // console.log(fax);
            faxing.addEventListener('keydown', function(e) {

                if (event.key != 'Backspace' && (faxing.value.length === 3)) {
                    faxing.value += '-';
                }
                if (event.key != 'Backspace' && (faxing.value.length === 7)) {
                    faxing.value += '-';
                }
if(faxing.value.length === 12) {return false;}
            });

        });
    </script>
@endsection