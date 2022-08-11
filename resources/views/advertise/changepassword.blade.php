@extends('layouts.app')
@section('content')
    <style type="text/css">
        table.formatHTML5 tr.selected {
            background-color: #e92929 !important;
            color: #fff;
            vertical-align: middle;
            padding: 1.5em;
        }

        table.formatHTML5 tbody tr {
            cursor: pointer;
            /* add gradient */
        }
    </style>
    <div class="container">
        <div class="row justify-content-center attorney-registration">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Change Password') }}
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('adviserdashboard') }}"> Back</a>
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
                        <form method="POST" action="{{ route('advertiser.updatepassword') }}" id="attorney_reg_form">
                            @csrf
                            @honeypot
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="password"
                                        class=" col-form-label text-md-left">{{ __('Password*') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password-confirm"
                                        class=" col-form-label text-md-left">{{ __('Confirm Password*') }}</label>
                                    <input id="password-confirm" type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required autocomplete="new-password">
                                    @error('password_confirmation')
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
        $(document).ready(function() {
            $('#attorney_reg_form').validate({});
            var token = $('input[name=_token]').val();
            var id = '{{ Auth::user()->id }}';
            $.ajax({
                url: "{{ route('ajax_get_counties_by_state') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    id: id,
                    _token: token,
                },
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('#legal_aid_county').append('<option value=' + key + '>' + val +
                                '</option>');
                        });
                    }
                }
            });
        });
    </script>
@endsection
