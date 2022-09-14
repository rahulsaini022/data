@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertise to Ohio Attorneys on FDD') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('/') }}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                     @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif

                    <div class="row"> 
                        <div class="col-md-12">
                            <p>
                                When you advertise on FDD, you’re directing your products and services to bonafide legal professionals
                                on a premium paid platform, not the general public, or mere "looki loos". Moreover, your brand is not
                                tarnished by annoying pop-ups cluttering the workspace or interfering with a legal professional’s
                                deadlines. Instead, your advertisement is presented on a list in response to a specific request by those legal
                                professionals looking specifically for your products and/or services.
                                Our fee structure makes listing your product or service extremely competitive to print media which is
                                reported to charge upwards of $200 for just one column inch of black/white ad space. After that, you just
                                have to hope a potential customer buys the newspaper and reads your one column inch advertisement and
                                remembers it when they’re ready to buy. Good luck with that.
                                Better yet, your FDD advertiser registration is free with your first paid listing fee!

                            </p>
                          
                            <a href="{{ route('advertisenow') }}" class="btn btn-info new-btn">Let's Start !</a>

                                
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dashloader"></div>


<script type="text/javascript">
var spinner = $('#dashloader');
// function showDelayMessage(){
//     if($('#select_practice_aid').val()){
//         var modal = document.getElementById("delay-message-myModal");
//         modal.style.display = "block";

//         // Get the <span> element that closes the modal
//         var span = document.getElementsByClassName("delay-message-close")[0];

//         // When the user clicks on <span> (x), close the modal
//         span.onclick = function() {
//             modal.style.display = "none";
//         }

//         // Get the <span> element that closes the modal
//         var btn = document.getElementsByClassName("delay-message-close-btn")[0];

//         // When the user clicks on <span> (x), close the modal
//         btn.onclick = function() {
//             modal.style.display = "none";
//         }
//     }
//   return true;
// }


$('.archive_month ul').hide();

$('.months').click(function() {
    $(this).find('ul').slideToggle();
});

$(document).on('change','.custom-select',function(){
    console.log($(this).val());
    var doctype = $(this).find(':selected').data('id');
    $(".doctype").val(doctype);
});
 $('form').submit(function(e) {
    var selectbox = $('.custom-select').val();
    if(selectbox != ''){
        //$(this).attr('disabled','disabled');
       
     // $('#dashloader').show();
    }
});
</script>
@endsection