
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertiser Dashboard') }}</strong></div>
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
                            <h2>{{$advertiser->Full_Name}}</h2>
                          
                                <a class="btn btn-info register-case-btn pull-right" href="">
                                    {{ __('Create New Listing »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info" href="{{ route('advertise.edit',['id' => $advertiser->AD_CR_Id] )}}">
                                    {{ __('Edit Advertise Account Info »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info register-case-btn pull-right" href="">
                                    {{ __('Mandatory Listing Agreement  »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info register-case-btn" href="">
                                    {{ __(' Manage Listings »') }}
                                </a>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dashloader"></div>
</div>
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