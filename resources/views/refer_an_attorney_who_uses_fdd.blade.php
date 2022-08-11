@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center refer-attorney">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Refer an Attorney who uses First Draft Data') }}
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
                    <form method="POST" action="{{route('store_refer_an_attorney')}}" id="refer_attorney_form">
                        @csrf
                        @honeypot

                        <h5 class="mb-3">Your Information</h5>

                        <div class="form-group row">
                            <label for="fname" class="col-md-2 col-form-label text-md-left">{{ __('First Name*') }}</label>

                            <div class="col-md-4">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{ old('fname') }}" required="">

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="mname" class="col-md-2 col-form-label text-md-left">{{ __('Middle Name') }}</label>

                            <div class="col-md-4">
                                <input id="mname" type="text" class="form-control @error('mname') is-invalid @enderror" name="mname" value="{{ old('mname') }}">

                                @error('mname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-md-2 col-form-label text-md-left">{{ __('Last Name*') }}</label>

                            <div class="col-md-4">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{ old('lname') }}" required="">

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>

                        <div class="form-group row"> -->
                            <label for="sufname" class="col-md-2 col-form-label text-md-left">{{ __('Suffix') }}</label>

                            <div class="col-md-4">
                                <select id="sufname" name="sufname" class="form-control">
                                    <option value="">Choose Suffix Type</option>
                                    <option value="Sr.">Sr.</option>
                                    <option value="Jr.">Jr.</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                </select>

                                @error('sufname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-left">{{ __('E-Mail Address*') }}</label>

                            <div class="col-md-4">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required="">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="phone_number" class="col-md-2 col-form-label text-md-left">{{ __('Telephone*') }}</label>

                            <div class="col-md-4">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" placeholder="(XXX) XXX-XXXX" required="">

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            

                        </div>
                        <div class="form-group row">

                            <label for="zipcode" class="col-md-2 col-form-label text-md-left">{{ __('Zip Code*') }}</label>

                            <div class="col-md-4">
                                <p class="text-danger no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" required="">

                                @error('zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="state_id" class="col-md-2 col-form-label text-md-left">{{ __('State*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="state_id" name="state_id" class="form-control" required="">
                                    <option value="">Choose State</option>
                                </select>

                                @error('state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">

                            <label for="county_id" class="col-md-2 col-form-label text-md-left">{{ __('County*') }}</label>

                            <div class="col-md-4">
                                
                                <select id="county_id" name="county_id" class="form-control" required="">
                                    <option value="">Choose County</option>
                                </select>

                                @error('county_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="city" class="col-md-2 col-form-label text-md-left">{{ __('City*') }}</label>

                            <div class="col-md-4">
                                <select id="city" name="city" class="form-control" required="">
                                    <option value="">Choose City</option>
                                </select>

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            
                            <label for="street_address" class="col-md-2 col-form-label text-md-left">{{ __('Street Address*') }}</label>

                            <div class="col-md-4">
                                <input id="street_address" type="text" class="form-control @error('street_address') is-invalid @enderror" name="street_address" value="{{ old('street_address') }}" required="">

                                @error('street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <label for="suite_unit_mailcode" class="col-md-2 col-form-label text-md-left">{{ __('Suite/Unit/MailCode') }}</label>

                            <div class="col-md-4">
                                <input id="suite_unit_mailcode" type="text" class="form-control @error('suite_unit_mailcode') is-invalid @enderror" name="suite_unit_mailcode" value="{{ old('suite_unit_mailcode') }}">

                                @error('suite_unit_mailcode')
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

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-md-center">
                                <!-- <input type="hidden" name="recaptcha_response" id="recaptchaResponse"> -->
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

    $(document).ready(function(){

        $('#refer_attorney_form').validate({
            rules: {
                phone_number: {
                    // phoneUS: true
                    // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                     pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                }
            }
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });
        
        // fetch city, state, county of client based on zipcode
        $('#zipcode').on('input', function() {
            
            $('.no-state-county-found').hide();
            $('#city').find('option').remove().end().append('<option value="">Choose City</option>');
            $('#state_id').find('option').remove().end().append('<option value="">Choose State</option>');
            $('#county_id').find('option').remove().end().append('<option value="">Choose County</option>');
            var zip=this.value;
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
                                $('#city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                                $('#state_id').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                                $('#county_id').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                            });
                            var a = new Array();
                            $('#city').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('#state_id').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('#county_id').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            if($('#city').children('option').length=='2'){
                                $('#city').children('option').first().remove();
                            }
                            if($('#state_id').children('option').length=='2'){
                                $('#state_id').children('option').first().remove();
                            }
                            if($('#county_id').children('option').length=='2'){
                                $('#county_id').children('option').first().remove();
                            }

                        }
                    }
                });        
            }

        });
    });
</script>
@endsection

