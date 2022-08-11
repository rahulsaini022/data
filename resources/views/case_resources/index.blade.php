@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Resources') }}</strong></div>
                <div class="card-body">
                    

                    <div class="row"> 
                        <div class="col-md-12">
                            <ul class="list-group">
                             <li><u><b>Direct Legal Practice Support Services</b></u>
                                <ul>
                              <li >Oral Depositions
                              <ul>
                                  <li >Video Depositions</li>
                                  <li >Audio Transcriptions</li>
                                  <li >Conference Room</li>
                                  <li >Process Server</li>
                                </ul></li>
                                <li>Legal Temps
                                    <ul>
                                        <li><b>Contract Attorneys</b>
                                          <ul>
                                            <li>General Civil</li>
                                            <li>General Criminal</li>
                                            <li>Family Law</li>
                                            <li>Family Law – Collaborative</li>
                                            <li>General Administrative</li>
                                            <li>Other (Describe)</li>
                                        </li>
                                    
                                    
                                        <li><b>Paralegals</b>
                                         <ul>
                                            <li>General Civil</li>
                                            <li>General Criminal</li>
                                            <li>Family Law</li>
                                            <li>Family Law – Collaborative</li>
                                            <li>General Administrative</li>
                                            <li>Other (Describe)</li>
                                         </ul>
                                     </li>
                                   </ul></li>
                                    <li><b>Case Research</b>
                                    <ul>
                                        <li>LexisNexis</li>
                                        <li>Westlaw</li>
                                        <li>CaseMaker (included for OSBA members)</li>
                                    </ul></li>
                                    <li><b>Private Investigators</b>
                                        <ul>
                                            <li>Electronic & Skip Trace</li>
                                            <li>Surveillance & Investigation</li>
                                        </ul></li>
                                    <li><b>Expert Witnesses</b>
                                    <ul>
                                        <li>Individuals</li>
                                        <li>Organizations</li>
                                    </ul></li>
                                </ul>
                                </li>
                            </ul></li></ul>


                            <ul class="list-group archive_month">
                                <li class="months"><u><b>Facilities and Support</b></u>
                                    <ul class="">
                                        <li>Offices for Rent</li>
                                        <li>Office Space for Rent</li>
                                        <li>Temporary/Virtual Offices & Conference Rooms</li>
                                        <li>Office Products (Paper, Ink, Stationary, Furniture, Signage,</li>
                                        <li>Computers/VOIP/IT Support</li>
                                        <li>Website Design/Maintenance/Upgrading</li>
                                    </ul>
                                </li>
                            </ul>


                            <ul class="list-group archive_month">
                                <li class="months"><u><b>Insurance</b></u>
                                    <ul class="">
                                        <li>Professional Liability</li>
                                        <li>Vehicle</li>
                                        <li>Life</li>
                                        <li>Renters</li>
                                        <li>Home</li>
                                        <li>Umbrella</li>
                                    </ul>
                                </li>
                            </ul>


                            <ul class="list-group archive_month">
                                <li class="months"><u><b>Miscellany</b></u>
                                    <ul >
                                        <li>For Sale</li>
                                        <li>For Rent</li>
                                        <li>For Trade</li>
                                        <li>For Barter</li>
                                        
                                    </ul>
                                </li>
                            </ul>


                            <ul class="list-group archive_month">
                                <li class="months"><u><b>Professional Associations & Organizations</b></u>
                                    <ul >
                                        <li>Supreme Court of Ohio Membership</li>
                                        <li>Ohio State Bar Association</li>
                                        <li>Ohio County1 Bar Association</li>
                                        <li>Ohio County 2 Bar Association</li>
                                        <li>Ohio County 88 Bar Association</li>
                                        
                                    </ul>
                                </li>
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