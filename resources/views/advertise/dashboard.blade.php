
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
                    @if($advertiser)
                    <div class="row"> 
                        <div class="col-md-12 dash-btn">
                            <h2>{{$advertiser->full_name}}</h2>
                            <div class="row advertiser-dash">
                                <div class="col-sm-6 ">
                                <a class="btn btn-info pull-md-right my-2 text-center" href="{{ route('advertise.edit',['id' => $advertiser->id] )}}">
                                    {{ __('Edit Advertise Account Info »') }}
                                </a>
                            </div>
                              <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn float-sm-right " href="{{ route('advertise.createnew')}}">
                                    {{ __('Create New Listing »') }}
                                </a>
                           
                         </div>
                              <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn " href="{{ route('advertise.new_listing') }}">
                                    {{ __(' Manage Listings »') }}
                                </a>
                           </div>
                            <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn float-sm-right " href="">
                                    {{ __('Mandatory Listing Agreement  »') }}
                                </a>
                          </div>
                           <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn " href="{{ route('advertise.subscriptions') }}">
                                    {{ __(' Subscriptions »') }}
                                </a>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn float-sm-right" href="{{ route('advertiser.changepassword') }}">
                                    {{ __(' Change Password »') }}
                                </a>
                           </div>
                           
                            </div>

                        </div>
                        @else
                        <p> Please register as a advertiser. </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dashloader " ></div>
 <div id="loader" class="center"></div>
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
 document.onreadystatechange = function() {
            if (document.readyState !== "complete") {
                document.querySelector(
                  "body").style.visibility = "hidden";
                document.querySelector(
                  "#loader").style.visibility = "visible";
            } else {
                document.querySelector(
                  "#loader").style.display = "none";
                document.querySelector(
                  "body").style.visibility = "visible";
            }
        };
</script>
@endsection