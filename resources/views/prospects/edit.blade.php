@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Edit Prospects') }}</strong>
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


                        {!! Form::model($prospects, ['method' => 'PATCH', 'route' => ['prospects.update', $prospects->id], 'id' => 'prospect_form']) !!}

                        <div class="row">

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>First Name*:</strong>

                                    <input id="prosp_fname" type="text" class="form-control" name="prosp_fname"
                                        value="<?php if (isset($prospects->prosp_fname)) {
                                            echo $prospects->prosp_fname;
                                        } ?>" required>

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Middle Name:</strong>

                                    <input id="prosp_mname" type="text" class="form-control" name="prosp_mname"
                                        value="<?php if (isset($prospects->prosp_mname)) {
                                            echo $prospects->prosp_mname;
                                        } ?>">

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Last Name*:</strong>

                                    <input id="prosp_lname" type="text" class="form-control" name="prosp_lname"
                                        value="<?php if (isset($prospects->prosp_lname)) {
                                            echo $prospects->prosp_lname;
                                        } ?>" required>

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Suffix:</strong>

                                    <select id="prosp_sufname" name="prosp_sufname" class="form-control">
                                        <option value="">None</option>
                                        <option value="Sr." <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'Sr.') {
                                            echo 'selected';
                                        } ?>>Sr.</option>
                                        <option value="Jr." <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'Jr.') {
                                            echo 'selected';
                                        } ?>>Jr.</option>
                                        <option value="I" <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'I') {
                                            echo 'selected';
                                        } ?>>I</option>
                                        <option value="II" <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'II') {
                                            echo 'selected';
                                        } ?>>II</option>
                                        <option value="III" <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'III') {
                                            echo 'selected';
                                        } ?>>III</option>
                                        <option value="IV" <?php if (isset($prospects->prosp_sufname) && $prospects->prosp_sufname == 'IV') {
                                            echo 'selected';
                                        } ?>>IV</option>
                                    </select>

                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Zipcode:</strong><span class="text-danger no-state-county-cl"
                                        style="display: none;">No City, State, County found for this zipcode.</span>

                                    <input id="prosp_zip" type="text" class="form-control" name="prosp_zip"
                                        value="<?php if (isset($prospects->prosp_zip)) {
                                            echo $prospects->prosp_zip;
                                        } ?>" onkeyup="getStateCityByZip(this);">

                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Street Address:</strong>

                                    <input id="prosp_street_ad" type="text" class="form-control" name="prosp_street_ad"
                                        value="<?php if (isset($prospects->prosp_street_ad)) {
                                            echo $prospects->prosp_street_ad;
                                        } ?>">

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Unit:</strong>

                                    <input id="prosp_unit" type="text" class="form-control" name="prosp_unit"
                                        value="<?php if (isset($prospects->prosp_unit)) {
                                            echo $prospects->prosp_unit;
                                        } ?>">

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>PO Box:</strong>

                                    <input id="prosp_pobox" type="text" class="form-control" name="prosp_pobox"
                                        value="<?php if (isset($prospects->prosp_pobox)) {
                                            echo $prospects->prosp_pobox;
                                        } ?>">

                                </div>

                            </div>



                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>State:</strong>
                                    <input type="hidden" value="<?php if (isset($prospects->prosp_state_id)) {
                                        echo $prospects->prosp_state_id;
                                    } ?>" class="selected-state-cl">
                                    <select id="prosp_state_id" name="prosp_state_id" class="form-control cl-state">
                                        <option value="">Choose State</option>
                                    </select>

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>City:</strong>
                                    <input type="hidden" value="<?php if (isset($prospects->prosp_city)) {
                                        echo $prospects->prosp_city;
                                    } ?>" class="selected-city-cl">
                                    <select id="prosp_city" name="prosp_city" class="form-control cl-city">
                                        <option value="">Choose City</option>
                                    </select>

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Email:</strong>

                                    <input id="prosp_email" type="email" class="form-control" name="prosp_email"
                                        value="<?php if (isset($prospects->prosp_email)) {
                                            echo $prospects->prosp_email;
                                        } ?>">

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-6">

                                <div class="form-group">

                                    <strong>Phone:</strong>

                                    <input id="prosp_phone" type="text" class="form-control" name="prosp_phone"
                                        value="<?php if (isset($prospects->prosp_phone)) {
                                            echo $prospects->prosp_phone;
                                        } ?>" placeholder="XXX-XXX-XXXX">

                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <strong>Court/Admin Matters:</strong>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault1" value="Domestic Relations" <?php echo $prospects->court_admin_matters == 'Domestic Relations' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Domestic Relations
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault2" value="Juvenile/Probate (Family Law)" <?php echo $prospects->court_admin_matters == 'Juvenile/Probate (Family Law)' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Juvenile/Probate (Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault3" value="Civil (NOT Family Law)" <?php echo $prospects->court_admin_matters == 'Civil (NOT Family Law)' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Civil (NOT Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault4" value="Juvenile (NOT Family Law)" <?php echo $prospects->court_admin_matters == 'Juvenile (NOT Family Law)' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Juvenile (NOT Family Law)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault15" value="Criminal - Traffic/Misdemeanor"
                                        <?php echo $prospects->court_admin_matters == 'Criminal - Traffic/Misdemeanor' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault15">
                                        Criminal - Traffic/Misdemeanor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault16" value="Criminal - Felony" <?php echo $prospects->court_admin_matters == 'Criminal - Felony' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault16">
                                        Criminal - Felony
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault14" value="Probate (Estate)" <?php echo $prospects->court_admin_matters == 'Probate (Estate)' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault14">
                                        Probate (Estate)
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefault7" value="Bankruptcy" <?php echo $prospects->court_admin_matters == 'Bankruptcy' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault7">
                                        Bankruptcy
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefaul4" value="Disability" <?php echo $prospects->court_admin_matters == 'Disability' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefaul4">
                                        Disability
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="court_admin_matters"
                                        id="flexRadioDefaul41" value="Workers’ Compensation" <?php echo $prospects->court_admin_matters == 'Workers’ Compensation' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefaul41">
                                        Workers’ Compensation
                                    </label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <strong>Recordable Document Matter:</strong>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefaul45" value=" Estate/Trust" <?php echo $prospects->recordable_document_matter == 'Estate/Trust' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefaul45">
                                        Estate/Trust
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefaul32" value="Real Estate" <?php echo $prospects->recordable_document_matter == 'Real Estate' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefaul32">
                                        Real Estate
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault18" value="Contracts" <?php echo $prospects->recordable_document_matter == 'Contracts' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault18">
                                        Contracts
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="recordable_document_matter"
                                        id="flexRadioDefault98" value="Notes" <?php echo $prospects->recordable_document_matter == 'Notes' ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="flexRadioDefault98">
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
                        pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                    },
                }
            });
        });

        function getStateCityByZip(t) {
            var type = 'cl';
            $('.no-state-county-' + type + '').hide();
            $('.' + type + '-city').find('option').remove().end().append('<option value="">Choose City</option>');
            $('.' + type + '-state').find('option').remove().end().append('<option value="">Choose State</option>');
            var zip = t.value;
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
                            // $('.cl_no_zip').hide();
                            $.each(data, function(key, val) {
                                $('.' + type + '-city').append('<option value="' + data[key].city +
                                    '">' + data[key].city + '</option>');
                                $('.' + type + '-state').append('<option value="' + data[key].state_id +
                                    '">' + data[key].state + '</option>');
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
                                $('.' + type + '-state').children('option').first().remove();
                            }
                            $('.no-state-county-cl').hide();
                        }

                        var selected_city = $('.selected-city-' + type + '').val();
                        var selected_state = $('.selected-state-' + type + '').val();
                        $('.' + type + '-city option:selected').removeAttr('selected');
                        $('.' + type + '-state option:selected').removeAttr('selected');
                        $('.' + type + '-city option[value="' + selected_city + '"]').attr('selected',
                            'selected');
                        $('.' + type + '-state option[value="' + selected_state + '"]').attr('selected',
                            'selected');
                    }
                });
            }
        }
        var cl = document.getElementById('prosp_zip');
        getStateCityByZip(cl);
    </script>
@endsection
