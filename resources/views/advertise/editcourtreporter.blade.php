@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-registration">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('FDD Advertiser Update') }}
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('adviserdashboard') }}">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <form role="form" id="multistep_case_form" method="POST" action="{{ route('advertise.update') }}"
                            autocomplete="off">
                            @csrf
                            <input type="hidden" name="id" value="{{ $advertiser->id }}">
                            <div class="form-group row">
                                <!--  <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                                                <label for="case_county" class="col-md-6 col-form-label text-md-left">County Listing*</label>
                                                                <div class="col-md-8">
                                                                    <input type="hidden" name="selected_case_state" class="selected_case_state" value="<?php if (isset($advertiser->listing_county)) {
    echo $advertiser->listing_county;
} ?>">
                                                                    <select id="case_county" name="listing_county" class="form-control case_county_inputs" autofocus="" required="">
                                                                        <option value="">Choose County</option>
                                                                    </select>
                                                                </div>
                                                            </div>  -->
                                
                                <div class="col-md-6 attorney_reg_1_num_label">
                                      <div class="col-md-10 form-group">
                                    <label for="Full_Name"
                                    class="col-form-label text-md-left attorney_reg_1_num_label">{{ __('Company or Your Full Name*') }}</label>
                                    <input id="Full_Name" type="text"
                                        class="form-control @error('full_name') is-invalid @enderror" name="full_name"
                                        value="{{ $advertiser->full_name ? $advertiser->full_name : '' }}"
                                        autocomplete="full_name" required="" autofocus="">
                                    @error('full_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                </div>
                         
                               
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                     <label for="contact_full_name"
                                    class=" col-form-label text-md-left">{{ __('Contact person Full Name*') }}</label>
                                    <input id="contact_full_name" type="text"
                                        class="form-control @error('contact_full_name') is-invalid @enderror"
                                        name="contact_full_name"
                                        value="{{ $advertiser->contact_full_name ? $advertiser->contact_full_name : '' }}"
                                        required autocomplete="contact_full_name" autofocus>
                                    @error('contact_full_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                </div>
                              
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                      <label for="" class=" col-form-label text-md-left">{{ __('Telephone') }}</label>
                                    <input id="Telephone" type="text" maxlength="12" class="form-control has-pattern-one" name="telephone"
                                        value="{{ $advertiser->telephone ? $advertiser->telephone : '' }}" autofocus=""
                                        placeholder="XXX-XXX-XXXX">
                                    @error('telephone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                </div>
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                     <label class=" col-form-label text-md-left">Suite/Unit, if any:</label>
                                    <input type="text" class="form-control" id="Suite_Unit" name="Suite_Unit"
                                        value="{{ $advertiser->Suite_Unit ? $advertiser->Suite_Unit : '' }}" />
                                </div>
                                </div>
                                
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                     <label class=" col-form-label text-md-left">{{ __('Street Address*') }}</label>
                                    <input type="text" class="form-control" id="Street_Address" name="street_address"
                                        autofocus="" required=""
                                        value="{{ $advertiser->street_address ? $advertiser->street_address : '' }}">
                                    @error('Street_Address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                </div>
                               
                               
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                     <label for="clzip" class=" col-form-label text-md-left">{{ __('ZIP*') }}
                                     <span class="text-danger no-state-county-cl  no-state-county-found" style="display: none;">No City, State, County
                                        found for this zipcode.</span></label>
                                    <input type="text" class="form-control" id="firm_zipcode" name="ZIP_Code" autofocus=""
                                        required="" value="{{ $advertiser->ZIP_Code ? $advertiser->ZIP_Code : '' }}">
                                
                                @error('ZIP_Code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                               </div></div>
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                   
                              
                                         <label for="clstate" class=" col-form-label text-md-left">State*</label>
                                        <input type="hidden" name="firm_state_input" id="firm_state_input"
                                            value="<?php if (isset($advertiser)) {
                                                echo $advertiser->state;
                                            } ?>">
                                        <select id="firm_state" name="state" class="form-control cl-state" autofocus=""
                                            required="">
                                            <option value="">Choose State</option>
                                        </select>
                                    </div>
                              
                                </div>
                            
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                   
                                    
                                         <label for="clcounty" class=" col-form-label text-md-left">County*</label>
                                        <input type="hidden" name="firm_county_input" id="firm_county_input"
                                            value="<?php if (isset($advertiser)) {
                                                echo $advertiser->county;
                                            } ?>">
                                        <select id="firm_county" name="county" class="form-control cl-county" autofocus=""
                                            required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                     
                                </div>
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                  
                                   
                                          <label for="clcity" class=" col-form-label text-md-left">City*</label>
                                        <input type="hidden" name="firm_city_input" id="firm_city_input"
                                            value="<?php if (isset($advertiser)) {
                                                echo $advertiser->City;
                                            } ?>">
                                        <select id="firm_city" name="City" class="form-control cl-city" required=""
                                            autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
  
                                <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                   
                                   
                                         <label for="website" class=" col-form-label text-md-left">Website</label>
                                        <input type="text" class="form-control" id="" name="website" autofocus=""
                                            value="{{ $advertiser->website ? $advertiser->website : '' }}">
                                    </div>
                                </div>
                            </div>
                             <div class="form-group col-12 text-center">
                            <button type="submit" class="btn btn-success "> Update</button>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#multistep_case_form').validate({
                rules: {
                    telephone: {
                        pattern:(/[0-9]{3}-[0-9]{3}-[0-9]{4}$/)
                    }
                }
            });
            state_id = 35;
            // to fecth counties on basis of state
            // var state_id=$(".selected_case_state").val();
            var token = $('input[name=_token]').val();
            $.ajax({
                url: "{{ route('ajax_get_counties_by_state') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    id: state_id,
                    _token: token,
                },
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('#case_county').append('<option value=' + key + '>' + val +
                                '</option>');
                        });
                        var selected_case_county = $('.selected_case_state').val();
                        if (selected_case_county) {
                            $('#case_county option[value=' + selected_case_county + ']').attr(
                                'selected', 'selected');
                        }
                    }
                }
            });
            // fetch city, state, county of client based on zipcode
            getStateCountyCityByZip();
            // $('#firm_zipcode').on('keyup', function() {
            $('#firm_zipcode').on('input', function() {
                getStateCountyCityByZip();
            });

            function getStateCountyCityByZip() {
                $('.no-state-county-found').hide();
                $('#firm_city').find('option').remove().end().append('<option value="">Choose City</option>');
                $('#firm_state').find('option').remove().end().append('<option value="">Choose State</option>');
                $('#firm_county').find('option').remove().end().append('<option value="">Choose County</option>');
                var zip = $('#firm_zipcode').val();
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
                                $('.no-state-county-found').show();
                            } else {
                                $('.no-state-county-found').hide();
                                $.each(data, function(key, val) {
                                    $('#firm_city').append('<option value="' + data[key].city +
                                        '">' + data[key].city + '</option>');
                                    $('#firm_state').append('<option value="' + data[key]
                                        .state_id + '">' + data[key].state + '</option>');
                                    $('#firm_county').append('<option value="' + data[key].id +
                                        '">' + data[key].county_name + '</option>');
                                });
                                var a = new Array();
                                $('#firm_city').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('#firm_state').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('#firm_county').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                if ($('#firm_city').children('option').length == '2') {
                                    $('#firm_city').children('option').first().remove();
                                }
                                if ($('#firm_state').children('option').length == '2') {
                                    $('#firm_state').children('option').first().remove();
                                }
                                if ($('#firm_county').children('option').length == '2') {
                                    $('#firm_county').children('option').first().remove();
                                }
                                $('.no-state-county-found').hide();
                                var selected_state = $('#firm_state_input').val();
                                var selected_county = $('#firm_county_input').val();
                                var selected_city = $('#firm_city_input').val();
                                if (selected_state) {
                                    $('#firm_state_input option:selected').removeAttr('selected');
                                    $('#firm_state option[value="' + selected_state + '"]').attr(
                                        'selected', 'selected');
                                    $('#firm_state_input').val("");
                                }
                                if (selected_county) {
                                    $('#firm_county_input option:selected').removeAttr('selected');
                                    $('#firm_county option[value="' + selected_county + '"]').attr(
                                        'selected', 'selected');
                                    $('#firm_county_input').val("");
                                }
                                if (selected_city) {
                                    $('#firm_city_input option:selected').removeAttr('selected');
                                    $('#firm_city option[value="' + selected_city + '"]').attr(
                                        'selected', 'selected');
                                    $('#firm_city_input').val("");
                                }
                            }
                        }
                    });
                }
            }
        });
        var tele = document.querySelector('#Telephone');

tele.addEventListener('keydown', function(e){
 
  if (event.key != 'Backspace' && (tele.value.length === 3  || tele.value.length === 7)){
  tele.value += '-';
  }
 
});
    </script>
@endsection
