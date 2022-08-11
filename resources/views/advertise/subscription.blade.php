@extends('layouts.app')

@section('content')
<div class="loader"></div>
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Subscription') }}</strong></div>
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
                    <div class="row"> 

                        <div class="col-md-12" align="center">
                            <h2>Welcome {{$user->name}}</h2>
                          <!--   <p>This is payment page. To use our services you need to pay <strong>$150</strong> as subscription fee. This will be an annual subscription. You can cancel it anytime.</p> -->
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                             <div class="col-md-6">
                                  <div class="form-group col-md-8">
                                    <label for="case_county" class=" col-form-label text-md-left">Listing County*</label>
                                   
                                        <select id="case_county" disabled name="listing_county" class="form-control case_county_inputs" autofocus="" required="">
                                            <option value="{{$listing_county->id}}" selected>{{$listing_county->county_name}}</option>
                                        </select>    
                                  </div>
                                    
                                </div>
                        
                         <div class="col-md-6">
                               <div class="form-group col-md-8">
                             <label for="Category" class="col-form-label text-md-left"> Category </label>
                               <input  type="text" disabled  class="form-control" value="{{$category_name}}">
                             {{-- <p><b> {{ $category_name }}</b></p> --}}
                            </div>
                         </div>

                    </div>
                     <form id="payment-form"   action="{{route('advertise.subscribe') }}" method="POST" enctype="multipart/form-data" >
                                    @csrf
                                     <div class="row" id="sub_cat_form">
                                    <div class="form-group col-md-6"><div class="col-md-8" ><label for='title'>Title *</label><input id='title' type="text" required name="title" class="form-control"></div></div>
                            <div class="form-group col-md-6"><div class="col-md-8" ><label for='price'>Price *</label><input min="1" oninput="validity.valid||(value='');" onKeyPress="if(this.value.length==8) return false;" id='price' type="number" required name="AD_price" class="form-control"></div>
                        </div>
                            
                         <div class="form-group col-md-6 "><label for='desc'>Description</label><textarea id='desc' rows=4 class="form-control"   name="description" ></textarea></div> 
                              
                             <div class="form-group col-md-6 "><div class="col-md-8" > <label for='image'>Image</label><br><input type="file" id='image' name="images[]"  accept="image/*" onchange="imageValidate()" class="form-custom-file"  multiple><div id="dvPreview"></div></div><span id='spanFileName' class="text-danger"></span></div>
                             
                            <div class="form-group col-md-6">
                             <div class="col-md-8">
                         <label class="advertiser_services_22"> Check which services you provide:* </label>
                        @foreach($services as $k=> $v)

                        <div class="form-check">
                            
                                    <input type="checkbox" class="form-check-input" required id="advertiser_services_id" name="advertiser_services_id[]" value="{{ $v->id }}"><label for="Oral_Depositions"  class="form-check-label">{{ $v->name }}</label><br/>

                                   

                                </div>
                      
                        @endforeach

                        </div>
                            </div> 
                     </div>
                            <input id="user_id" name="user_id" type="hidden"  value="{{$user->id}}">
                                    <input id="advertise_id" name="advertise_id" type="hidden"  value="{{ $advertise_id }}">
                                    <input id="advertise_id" name="advertise_id" type="hidden"  value="{{ $advertise_id }}">
                                    <input type="hidden" name="advertise_category_id" value="{{ $category_id }}">
                                    <input type="hidden" name="county_id" id="county_id">
                                    <input type="hidden" name="service_id" id="service_id" >
                                    <input id="payment_method" type="hidden" name="payment_method"  value="">
               
                                    <input type="submit" id="submit_btn" name="submit" value="pay" style="display: none"> 
                                </form>
                    <br/> 
                       
                       
                        
                        <br/>
                     <div class="col-12">
                        <p class="text-justify">
                       {!! $description !!}
                    </p>
                    </div>  
                    
        </div>  
                        <div class="col-md-12" align="center">
                            <div class="cc-payment-outer">
                                <!-- stripe -->                            
                                <div class="cc-name-outer">
                                    
                                    <input id="card-holder-name" type="text" placeholder="Name" value="{{ $user->advertiser->contact_full_name }}">
                                </div>
                                <div id="card-element"></div>
                                <div id="stripe_message" class="text-danger"></div>
                                <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                               
                                <!-- stripe -->
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>

<script>

    // $('#payment-form').on('change',function(){
    //    $('#payment-form').validate({
    //     rules:{
    //         title:{required:true},
    //         AD_price:{required:true},
    //     }
    //    });
    // })
    state_id = 35;
  
    // to fecth counties on basis of state
    // var state_id=$(".selected_case_state").val();
    var token= $('input[name=_token]').val();
    if(state_id) {
        $.ajax({
            url:"{{route('ajax_get_counties_by_state')}}",
            method:"POST",
            dataType: 'json', 
            data:{
                id: state_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#case_county').append('<option value='+key+'>'+val+'</option>');
                    });
                    
                }
            }
        });
    }
    $('#card-button').prop('disabled', true);
     $(document).on('mouseover',function(){ 
        $('#payment-form').validate({

            rules:{
                title:{required:true},
                AD_price:{required:true},
                advertiser_services_id:{required:true},
            },
             errorPlacement: function(error, element) {
            if (element.attr("name") === "advertiser_services_id[]") {
          
             error.appendTo('.advertiser_services_22');
             }
           else if (element.attr("name") === "images[]") {
          
             error.prepend('#spanFileName');
             }
               else {
               
                error.insertAfter(element);
            }
        }
        });
          if($('#payment-form').valid() && imageValidate())
    {
      
           $('#card-button').prop('disabled', false);
    }
    else{
       $('#card-button').prop('disabled', true);
    }
        })
    
  
    // const stripe = Stripe('');
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card', { hidePostalCode: true });

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;

    cardButton.addEventListener('click', async (e) => {
        const { setupIntent, error } = await stripe.handleCardSetup(
            clientSecret, cardElement, {
                payment_method_data: {
                    billing_details: { name: cardHolderName.value }
                }
            }
        );

        if (error) {
            // $('#stripe_message').text('Error in card verification. Please try again.');
            $('#stripe_message').text(error.message+'Please refresh page and try again');
        } else {
            
            // console.log(setupIntent.payment_method);
            var ids = [];
            $('#payment_method').val(setupIntent.payment_method);
            var inps = document.getElementsByName('advertiser_services_id[]');
          
            $('input[name="advertiser_services_id[]"]:checked').each(function() {
               ids.push(this.value);
            });
            var county =$( "#case_county option:selected" ).val();
            var title=$('#title').val();
            var price=$('#price').val();
            if(title.length && price.length && ids.length)
            {
 $("#county_id").val(county);
            $("#service_id").val(ids);
            $('#stripe_message').text('');
            if(imageValidate())
                {
                    $("#submit_btn").click();

                            //   $('#card-button').addClass('spinner');
                           $('.loader').addClass("page-loader");
                              $("#card-button").html(' <i class="fa fa-spinner fa-spin"></i>Loading ')
                    $("#card-button").prop('disabled', true);


                } 
            }

           else{
            alert('Please fill all required(*) field');
           }

        }
    });


    function imageValidate() {
//     var total_file=document.getElementById("image").files.length;
//  for(var i=0;i<total_file;i++)
//  {
//   $('#dvPreview').append("<div class='d-inline ' > <img  width='40' class='img-thumbnail'  src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
//  }
  var s=$('#image').val();
  function stringEndsWithValidExtension(stringToCheck, acceptableExtensionsArray, required) {
    if (required == false && stringToCheck.length == 0) { return true; }
    for (var i = 0; i < acceptableExtensionsArray.length; i++) {
        if (stringToCheck.toLowerCase().endsWith(acceptableExtensionsArray[i].toLowerCase())) {$('#spanFileName').html(""); return true; }
    }
    return false;
}

String.prototype.startsWith = function (str) { return (this.match("^" + str) == str) }

String.prototype.endsWith = function (str) { return (this.match(str + "$") == str) }

   
   if (!stringEndsWithValidExtension($("[id*='image']").val(), [".png", ".jpeg", ".jpg",".ico",".gif" ], false)) {
    $('#spanFileName').html("Image only allows file types of .png, .jpg , .ico , .gif and .jpeg ");
        return false;
    }
    $('#spanFileName').html("");
    return true;
}
</script>
@endsection

