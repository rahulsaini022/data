@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertise Now') }}</strong>
                     <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertise') }}">Back</a>
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
                            Because your FDD advertiser registration is free with your first paid listing fee, let’s start here. Don’t
                            worry, at the end of this process you can decline to pay the listing fee, the transaction will stop, your
                            registration will be cancelled and your won’t be charged anything. In other words, you won’t have to pay
                            until you know the total cost of the listing fee.
                            In which category would you like your advertisement to appear?</p>
                            <ul>
                            <li><a href="{{route('courtreporter')}}" >Court Reporters</li></a>
                            <li>Case Research</li>
                            <li>Office and Conference Facilities</li>
                            <li>Insurance</li>
                            <li>IT Support 
                            <li>Legal Temps </li>
                            <li>Private Investigation</li>
                            <li>For Sale</li>
                            <li>For Rent</li>
                            <li>For Barter/Trade</li>
                          </ul>
                         
                                
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