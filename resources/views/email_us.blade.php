@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center email-us-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('Email Us') }}</strong>
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

                    <form id="email_us_form" method="POST" action="{{ route('send_email_to_admin') }}">
                        @csrf
                        @honeypot
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Name*</label>
                                    <input id="name" type="text" class="form-control " name="name" value="" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">Phone*</label>
                                    <input id="phone" type="text" maxlength="12" class="form-control " name="phone" value="" placeholder="XXX-XXX-XXXX" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">Subject*</label>
                                    <input id="subject" type="text" class="form-control " name="subject" value="" required="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Email*</label>
                                    <input id="email" type="email" class="form-control " name="email" value="" required="">
                                </div>
                                <div class="form-group">
                                    <label for="">Message*</label>
                                    <textarea class="form-control" name="message" required="" style="height: 120px;"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-md-center">
                                <!-- <input type="hidden" name="recaptcha_response" id="recaptchaResponse"> -->
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
    // grecaptcha.ready(function() {
    //     grecaptcha.execute('{{ env('GOOGLE_RECAPTCHA_SITEKEY') }}', {action: 'contact'}).then(function(token) {
    //       // Add your logic to submit to your backend server here.
    //         if(token){
    //             var recaptchaResponse = document.getElementById('recaptchaResponse');
    //             recaptchaResponse.value = token;
    //         }
    //     });
    // });
    
    $(document).ready(function(){
        // $(window).keydown(function(event){
        //     if(event.keyCode == 13) {
        //       event.preventDefault();
        //       return false;
        //     }
        // });
        $('#email_us_form').validate({
            rules: {
                phone: {
                    // phoneUS: true
                    // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                    
                     pattern:(/[\d\s]{3}-[\d\s]{3}-[\d\s]{4}$/)
                },
            }
        });
    
    });
//         document.querySelector('#phone').addEventListener('input', function(e) {
//   var foo = this.value.split("-").join("");
//   if (foo.length > 0) {
//     foo = foo.match(new RegExp('.{1,3}', 'g')).join("-");
//   }
//   this.value = foo;
// });
var tele = document.querySelector('#phone');

tele.addEventListener('keydown', function(e){

  if (event.key != 'Backspace' && (tele.value.length === 7 || tele.value.length === 3)){
  tele.value += '-';
  }
});
        
</script>    
@endsection