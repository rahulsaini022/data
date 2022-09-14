@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center what-we-offer-page">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Demo') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>

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

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="demo_form" method="POST" action="{{ route('store_demo') }}">
                        @csrf
                        @honeypot
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Your State of Registration*</label><br/>
                                    <label><b>Ohio</b></label>
                                    <select id="state_of_registration" name="state_of_registration" class="form-control" required="" autofocus="" style="display:none;">
                                        <option value="">Choose State</option>
                                    </select>
                                     <input type="hidden" name="state_of_registration" value="OH">
                                    @error('state_of_registration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Your Attorney Registration #*</label>
                                    <input id="phone" type="text" class="form-control " name="attorney_registration_number" required="">
                                    @error('attorney_registration_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Your First Name*</label>
                                    <input id="name" type="text" class="form-control " name="name" required="" style="text-transform: capitalize;">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Your Email Address*</label>
                                    <input id="email" type="email" class="form-control " name="email" required="">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-md-center">
                                <!-- <input type="hidden" name="recaptcha_response" id="recaptchaResponse"> -->
                                <p>Email me my FDD Quick Report, a Customized Editable Letterhead, and Return Address Sheet for printing 4X20 labels (#8167).</p>
                                <button type="submit" class="btn btn-primary">
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
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $.ajax({
            url:"{{route('ajax_get_db_active_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#state_of_registration').append('<option selected value='+key+'>'+val+'</option>');
                    });
                }
            }
        });  
    });
</script>
@endsection