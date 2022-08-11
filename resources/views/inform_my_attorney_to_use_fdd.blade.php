@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center inform-attorney inform-attorney-page">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Inform my Attorney to use First Draft Data') }}
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('home') }}"> Back to FDD landing page</a>

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
                    <form method="POST" action="{{route('store_inform_my_attorney')}}" id="inform_attorney_form">
                        @csrf
                        @honeypot

                        <h5 class="mb-3">Your Information</h5>

                        <div class="form-group row">
                            <label for="user_fname" class="col-md-2 col-form-label text-md-left">{{ __('First Name*') }}</label>

                            <div class="col-md-4">
                                <input id="user_fname" type="text" class="form-control @error('user_fname') is-invalid @enderror" name="user_fname" value="{{ old('user_fname') }}" required="">

                                @error('user_fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_mname" class="col-md-2 col-form-label text-md-left">{{ __('Middle Name') }}</label>

                            <div class="col-md-4">
                                <input id="user_mname" type="text" class="form-control @error('user_mname') is-invalid @enderror" name="user_mname" value="{{ old('user_mname') }}">

                                @error('user_mname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="user_lname" class="col-md-2 col-form-label text-md-left">{{ __('Last Name*') }}</label>

                            <div class="col-md-4">
                                <input id="user_lname" type="text" class="form-control @error('user_lname') is-invalid @enderror" name="user_lname" value="{{ old('user_lname') }}" required="">

                                @error('user_lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>

                        <div class="form-group row"> -->
                            <label for="user_sufname" class="col-md-2 col-form-label text-md-left">{{ __('Suffix') }}</label>

                            <div class="col-md-4">
                                <select id="user_sufname" name="user_sufname" class="form-control">
                                    <option value="">Choose Suffix Type</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>

                                @error('user_sufname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="user_email" class="col-md-2 col-form-label text-md-left">{{ __('E-Mail Address*') }}</label>

                            <div class="col-md-4">
                                <input id="user_email" type="email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{ old('user_email') }}" required="">

                                @error('user_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_phone_number" class="col-md-2 col-form-label text-md-left">{{ __('Telephone*') }}</label>

                            <div class="col-md-4">
                                <input id="user_phone_number" type="text" class="form-control @error('user_phone_number') is-invalid @enderror" name="user_phone_number" value="{{ old('user_phone_number') }}" placeholder="(XXX) XXX-XXXX" required="">

                                @error('user_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            

                        </div>
                        <div class="form-group row">

                            <label for="user_zipcode" class="col-md-2 col-form-label text-md-left">{{ __('Zip Code*') }}</label>

                            <div class="col-md-4">
                                <p class="text-danger user-no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                <input id="user_zipcode" type="text" class="form-control @error('user_zipcode') is-invalid @enderror" name="user_zipcode" value="{{ old('user_zipcode') }}" required="" oninput="getCityStateCountyByZipcode(this.value, 'user');">

                                @error('user_zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_state_id" class="col-md-2 col-form-label text-md-left">{{ __('State*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="user_state_id" name="user_state_id" class="form-control" required="">
                                    <option value="">Choose State</option>
                                </select>

                                @error('user_state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="user_county_id" class="col-md-2 col-form-label text-md-left">{{ __('County*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="user_county_id" name="user_county_id" class="form-control" required="">
                                    <option value="">Choose County</option>
                                </select>

                                @error('user_county_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_city" class="col-md-2 col-form-label text-md-left">{{ __('City*') }}</label>

                            <div class="col-md-4">
                                <select id="user_city" name="user_city" class="form-control" required="">
                                    <option value="">Choose City</option>
                                </select>

                                @error('user_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            
                            <label for="user_street_address" class="col-md-2 col-form-label text-md-left">{{ __('Street Address*') }}</label>

                            <div class="col-md-4">
                                <input id="user_street_address" type="text" class="form-control @error('user_street_address') is-invalid @enderror" name="user_street_address" value="{{ old('user_street_address') }}" required="">

                                @error('user_street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <label for="user_suite_unit_mailcode" class="col-md-2 col-form-label text-md-left">{{ __('Suite/Unit/MailCode') }}</label>

                            <div class="col-md-4">
                                <input id="user_suite_unit_mailcode" type="text" class="form-control @error('user_suite_unit_mailcode') is-invalid @enderror" name="user_suite_unit_mailcode" value="{{ old('user_suite_unit_mailcode') }}">

                                @error('user_suite_unit_mailcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="form-group row">
                            
                            <label for="type_of_legal_matter" class="col-md-2 col-form-label text-md-left">{{ __('Type of Legal Matter*') }}</label>

                            <div class="col-md-4">
                                <select id="type_of_legal_matter" name="type_of_legal_matter" class="form-control" required="">
                                    <option value="">Select</option>
                                    <option value="Family Law">Family Law</option>
                                    <option value="Traffic/Minor Crime">Traffic/Minor Crime</option>
                                    <option value="Major Crime/Felony">Major Crime/Felony</option>
                                    <option value="Vehicle Crash">Vehicle Crash</option>
                                    <option value="Personal Injury">Personal Injury</option>
                                    <option value="Property Damage">Property Damage</option>
                                    <option value="Product Liability">Product Liability</option>
                                    <option value="Eviction/Landlord-Tenant">Eviction/Landlord-Tenant</option>
                                    <option value="Foreclosure">Foreclosure</option>
                                    <option value="Medical Malpractice">Medical Malpractice</option>
                                    <option value="Legal Malpractice">Legal Malpractice</option>
                                    <option value="Workers’ Compensation">Workers’ Compensation</option>
                                    <option value="Disability">Disability</option>
                                    <option value="Employment/Wrongful Termination">Employment/Wrongful Termination</option>
                                    <option value="Debt Collection">Debt Collection</option>
                                    <option value="Contract Issues">Contract Issues</option>
                                    <option value="Home Construction/Renovation/Repair">Home Construction/Renovation/Repair</option>
                                    <option value="Fraud">Fraud</option>
                                    <option value="Juvenile Law">Juvenile Law</option>
                                    <option value="Other">Other</option>
                                </select>

                                @error('type_of_legal_matter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>
                        <div class="row">
                        <h5 class="col-md-6">Your Attorney Information</h5>
                        <div class="col-md-6 text-right" id="noattorney" style="display: none;">
                            <span class="text-info">No attorney data found for this reg number.</span>
                        </div>
                        </div>
                        <div class="form-group row">

                            <label for="user_attorney_reg_state_id" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg State*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="user_attorney_reg_state_id" name="user_attorney_reg_state_id" class="form-control states_select_input" required="">
                                    <option value="">Choose Attorney Reg State*</option>
                                </select>

                                @error('user_attorney_reg_state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_registration_number" class="col-md-2 col-form-label text-md-left user_attorney_registration_number_label">{{ __('Attorney Reg #') }}</label>

                            <div class="col-md-4 user_attorney_registration_number_label">
                                <input id="user_attorney_registration_number" type="text" class="form-control @error('user_attorney_registration_number') is-invalid @enderror" name="user_attorney_registration_number" value="{{ old('user_attorney_registration_number') }}">

                                @error('user_attorney_registration_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">

                            <label for="user_attorney_fname" class="col-md-2 col-form-label text-md-left">{{ __('First Name*') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_fname" type="text" class="form-control @error('user_attorney_fname') is-invalid @enderror" name="user_attorney_fname" value="{{ old('user_attorney_fname') }}" required="">

                                @error('user_attorney_fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_mname" class="col-md-2 col-form-label text-md-left">{{ __('Middle Name') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_mname" type="text" class="form-control @error('user_attorney_mname') is-invalid @enderror" name="user_attorney_mname" value="{{ old('user_attorney_mname') }}">

                                @error('user_attorney_mname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">

                            <label for="user_attorney_lname" class="col-md-2 col-form-label text-md-left">{{ __('Last Name*') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_lname" type="text" class="form-control @error('user_attorney_lname') is-invalid @enderror" name="user_attorney_lname" value="{{ old('user_attorney_lname') }}" required="">

                                @error('user_attorney_lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_sufname" class="col-md-2 col-form-label text-md-left">{{ __('Suffix') }}</label>

                            <div class="col-md-4">
                                <select id="user_attorney_sufname" name="user_attorney_sufname" class="form-control">
                                    <option value="">Choose Suffix Type</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>

                                @error('user_attorney_sufname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="user_attorney_firm_name" class="col-md-2 col-form-label text-md-left">{{ __('Firm Name') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_firm_name" type="text" class="form-control @error('user_attorney_firm_name') is-invalid @enderror" name="user_attorney_firm_name" value="{{ old('user_attorney_firm_name') }}">

                                @error('user_attorney_firm_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_email" class="col-md-2 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_email" type="email" class="form-control @error('user_attorney_email') is-invalid @enderror" name="user_attorney_email" value="{{ old('user_attorney_email') }}">

                                @error('user_attorney_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">

                            <label for="user_attorney_phone_number" class="col-md-2 col-form-label text-md-left">{{ __('Telephone*') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_phone_number" type="text" class="form-control @error('user_attorney_phone_number') is-invalid @enderror" name="user_attorney_phone_number" value="{{ old('user_attorney_phone_number') }}" placeholder="(XXX) XXX-XXXX" required="">

                                @error('user_attorney_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_zipcode" class="col-md-2 col-form-label text-md-left">{{ __('Zip Code') }}</label>

                            <div class="col-md-4">
                                <p class="text-danger user_attorney-no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                <input id="user_attorney_zipcode" type="text" class="form-control @error('user_attorney_zipcode') is-invalid @enderror" name="user_attorney_zipcode" value="{{ old('user_attorney_zipcode') }}" oninput="getCityStateCountyByZipcode(this.value, 'user_attorney');">

                                @error('user_attorney_zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <!-- <label for="user_attorney_state_id" class="col-md-2 col-form-label text-md-left">{{ __('State*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="user_attorney_state_id" name="user_attorney_state_id" class="form-control">
                                    <option value="">Choose State</option>
                                </select>

                                @error('user_attorney_state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> -->

                            <label for="user_attorney_county_id" class="col-md-2 col-form-label text-md-left">{{ __('County') }}</label>

                            <div class="col-md-4">
                                
                                <select id="user_attorney_county_id" name="user_attorney_county_id" class="form-control">
                                    <option value="">Choose County</option>
                                </select>

                                @error('user_attorney_county_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_city" class="col-md-2 col-form-label text-md-left">{{ __('City') }}</label>

                            <div class="col-md-4">
                                <select id="user_attorney_city" name="user_attorney_city" class="form-control">
                                    <option value="">Choose City</option>
                                </select>

                                @error('user_attorney_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            
                            <label for="user_attorney_street_address" class="col-md-2 col-form-label text-md-left">{{ __('Street Address') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_street_address" type="text" class="form-control @error('user_attorney_street_address') is-invalid @enderror" name="user_attorney_street_address" value="{{ old('user_attorney_street_address') }}">

                                @error('user_attorney_street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="user_attorney_suite_unit_mailcode" class="col-md-2 col-form-label text-md-left">{{ __('Suite/Unit/MailCode') }}</label>

                            <div class="col-md-4">
                                <input id="user_attorney_suite_unit_mailcode" type="text" class="form-control @error('user_attorney_suite_unit_mailcode') is-invalid @enderror" name="user_attorney_suite_unit_mailcode" value="{{ old('user_attorney_suite_unit_mailcode') }}">

                                @error('user_attorney_suite_unit_mailcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-md-center">
                                <!-- <input type="hidden" name="recaptcha_response" id="user_recaptchaResponse"> -->
                                <button class="btn btn-primary" type='submit'>
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    // fetch user_city, state, county of client based on user_zipcode
    function getCityStateCountyByZipcode(zipcode, type){
        
        $('.'+type+'-no-state-county-found').hide();
        $('#'+type+'_city').find('option').remove().end().append('<option value="">Choose City</option>');
        $('#'+type+'_state_id').find('option').remove().end().append('<option value="">Choose State</option>');
        $('#'+type+'_county_id').find('option').remove().end().append('<option value="">Choose County</option>');
        var zip=zipcode;
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
                        $('.'+type+'-no-state-county-found').show();
                    } else {
                        $('.'+type+'-no-state-county-found').hide();
                        $.each(data, function (key, val) {
                            $('#'+type+'_city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                            $('#'+type+'_state_id').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                            $('#'+type+'_county_id').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                        });
                        var a = new Array();
                        $('#'+type+'_city').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('#'+type+'_state_id').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('#'+type+'_county_id').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        if($('#'+type+'_city').children('option').length=='2'){
                            $('#'+type+'_city').children('option').first().remove();
                        }
                        if($('#'+type+'_state_id').children('option').length=='2'){
                            $('#'+type+'_state_id').children('option').first().remove();
                        }
                        if($('#'+type+'_county_id').children('option').length=='2'){
                            $('#'+type+'_county_id').children('option').first().remove();
                        }

                    }
                }
            });        
        }

    };

    $(document).ready(function(){

        $('#inform_attorney_form').validate({
            rules: {
                user_phone_number: {
                    // phoneUS: true
                    // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                     pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
                user_attorney_phone_number: {
                    // phoneUS: true
                    // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                     pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
            }
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        
        // to fetch attorney information based on attorney registration number

        $.ajax({
            url:"{{route('ajax_get_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('.states_select_input').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#user_attorney_reg_state_id option[value=35]').attr('selected','selected');
                }
            }
        });

        $('#user_attorney_registration_number').on('input', function(){
            $('#noattorney').hide();
            var reg_num=this.value;
            $('#user_attorney_registration_number').val(reg_num);
            var state_id=$('#user_attorney_reg_state_id').val();
            if(reg_num){
                var token= $('input[name=_token]').val();
                $.ajax({
                    url:"{{route('ajax_get_attorney_by_reg_num')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        reg_num: reg_num, 
                        state_id: state_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data==null || data=='null'){
                            $('#noattorney').show();
                        } else {
                            $('#noattorney').hide();
                            //  $('#user_attorney_registration_number').val(data.registrationnumber_state1);
                            $('#user_attorney_fname').val(data.fname);
                            $('#user_attorney_mname').val(data.mname);
                            $('#user_attorney_lname').val(data.lname);
                            $('#user_attorney_email').val(data.email);
                            $('#user_attorney_firm_name').val(data.firm_name);
                            $('#user_attorney_street_address').val(data.firm_street_address);
                            $('#user_attorney_city').val(data.firm_city);
                            $('#user_attorney_zipcode').val(data.firm_zip);
                            $('#user_attorney_phone_number').val(data.firm_telephone);
                            $('#user_attorney_suite_unit_mailcode').val(data.firm_suite_unit_mailcode);
                            $('#user_attorney_sufname option[value='+data.sufname+']').attr('selected','selected');

                            var county_id=data.county_id;
                            var firm_city=data.firm_city;
                            var state_id=data.registration_state_id;


                            $('.user_attorney-no-state-county-found').hide();
                            $('#user_attorney_city').find('option').remove().end().append('<option value="">Choose City</option>');
                            // $('#user_attorney_state_id').find('option').remove().end().append('<option value="">Choose State</option>');
                            $('#user_attorney_county_id').find('option').remove().end().append('<option value="">Choose County</option>');
                            if( data.firm_zip != '' && data.firm_zip != null){
                                var token= $('input[name=_token]').val();
                                $.ajax({
                                    url:"{{route('ajax_get_city_state_county_by_zip')}}",
                                    method:"POST",
                                    dataType: 'json',
                                    data:{
                                        zip: data.firm_zip, 
                                        _token: token, 
                                    },
                                    success: function(data){
                                        // console.log(data);
                                        if(data=='null' || data==''){
                                            $('.user_attorney-no-state-county-found').show();
                                        } else {
                                            $.each(data, function (key, val) {
                                                $('#user_attorney_city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                                                // $('#user_attorney_state_id').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                                                $('#user_attorney_county_id').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                                            });
                                            var a = new Array();
                                            $('#user_attorney_city').children("option").each(function(x){
                                                test = false;
                                                b = a[x] = $(this).val();
                                                for (i=0;i<a.length-1;i++){
                                                    if (b ==a[i]) test =true;
                                                }
                                                if (test) $(this).remove();
                                            })
                                            // var a = new Array();
                                            // $('#user_attorney_state_id').children("option").each(function(x){
                                            //     test = false;
                                            //     b = a[x] = $(this).val();
                                            //     for (i=0;i<a.length-1;i++){
                                            //         if (b ==a[i]) test =true;
                                            //     }
                                            //     if (test) $(this).remove();
                                            // })
                                            var a = new Array();
                                            $('#user_attorney_county_id').children("option").each(function(x){
                                                test = false;
                                                b = a[x] = $(this).val();
                                                for (i=0;i<a.length-1;i++){
                                                    if (b ==a[i]) test =true;
                                                }
                                                if (test) $(this).remove();
                                            })
                                            if($('#user_attorney_city').children('option').length=='2'){
                                                $('#user_attorney_city').children('option').first().remove();
                                            }
                                            // if($('#user_attorney_state_id').children('option').length=='2'){
                                            //     $('#user_attorney_state_id').children('option').first().remove();
                                            // }
                                            if($('#user_attorney_county_id').children('option').length=='2'){
                                                $('#user_attorney_county_id').children('option').first().remove();
                                            }
                                            // $('#user_attorney_state_id option[value="'+state_id+'"]').attr('selected','selected');
                                            $('#user_attorney_county_id option[value="'+county_id+'"]').attr('selected','selected');
                                            $('#user_attorney_city option[value="'+firm_city+'"]').attr('selected','selected');

                                        }
                                    }
                                });        
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endsection

