@extends('layouts.app')

@section('content')
<div class="loader"></div>
<script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Subscription New Listing') }}</strong>
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
                        <div class="row">

                            <div class="col-md-12" align="center">
                                <h2>Welcome {{ $user->name }}</h2>
                                <!--   <p>This is payment page. To use our services you need to pay <strong>$150</strong> as subscription fee. This will be an annual subscription. You can cancel it anytime.</p> -->
                            </div>

                            <div class="col-md-12">
                               
                                <br />

                                    <p class="text-danger no-case-types" style="display: none;">No Service Found.</p>
                                    <select id ="sub_cat" name = "advertiser_services_id[]" class = "form-control col-md-3" autofocus = ""required = ""  >
                                        <option value = "" > Choose sub category </option>
                                    </select>
                                    <div class="form" >
                                        <form id="payment-form" action="{{ route('advertise.afterloginsubscribe') }}"
                                        method="POST" enctype="multipart/form-data" >
                                        @csrf
                                         <div class="row form-group">
                                    <div class="col-md-6">
                                       
                                        <div class="col-md-12">
                                             <label for="case_county" class="col-form-label text-md-left">Listing
                                            County*</label>
                                            <select id="case_county" name="listing_county"
                                                class="form-control advertiser_county_inputs" autofocus="" required>
                                                <option value="">Choose County</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       
                                        <div class="col-md-12">
                                             <label for="advertiser_category_inputs" class=" col-form-label text-md-left">Choose
                                            Catgory*</label>
                                            <select id="advertiser_category_inputs" name="advertising_catgory"
                                                class="form-control " autofocus="" required>
                                               <option value="">Choose Category</option>
                                                @foreach ($category_data as $key => $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                </div>
                                        <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}">
                                        <input id="advertise_id" name="advertise_id" type="hidden"
                                            value="{{ $advertise_id }}">
                                        <input id="advertise_id" name="advertise_id" type="hidden"
                                            value="{{ $advertise_id }}">
                                        <input type="hidden" id="category_id" name="category_id" value="">
                                        <input type="hidden" name="county_id" id="county_id">
                                        <input type="hidden" name="title" id="title">
                                        <input type="hidden" name="description" id="description">
 
                                        <input type="hidden" name="service_id" id="service_id">
                                        <input id="payment_method" type="hidden" name="payment_method" value="">
                                          <div class="row" id="sub_cat_form"></div>
                                        <input type="submit" id="submit_btn" name="submit" value="pay" style="display: none">
                                    <div class="services" style="display:none;">
                                    </form>
                                    </div>
                                   

                                    </div>



                                <br />

                                <p class="cat_description" style="display:none">

                                </p>

                            </div>
                            <div class="col-md-12" align="center">
                                <div class="cc-payment-outer" id="card-payment">
                                    <!-- stripe -->
                                    <div class="cc-name-outer">
                                        <!--  <label for="cc-name" class="col-form-label text-md-left">Name</label> -->
                                        <input id="card-holder-name" type="text" placeholder="Name"
                                            value="{{ $user->advertiser->contact_full_name }}" disabled>
                                    </div>
                                    <div id="card-element"></div>
                                    <div id="card-element-1"></div>
                                    <div id="stripe_message" class="text-danger"></div>
                                    <button id="card-button" data-secret="{{ $intent->client_secret }}"
                                        class="btn btn-primary">Pay</button>
                                    {{-- <form id="payment-form" action="{{ route('advertise.afterloginsubscribe') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}">
                                        <input id="advertise_id" name="advertise_id" type="hidden"
                                            value="{{ $advertise_id }}">
                                        <input id="advertise_id" name="advertise_id" type="hidden"
                                            value="{$counties = County::all()->orderBy('county_name','asc');"file" name="images" id="images">
                                        <input type="hidden" name="service_id" id="service_id">
                                        <input id="payment_method" type="hidden" name="payment_method" value="">

                                        <input type="submit" id="submit_btn" name="submit" value="pay">
                                    </form> --}}
                                    <!-- stripe -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="loader"></div>
    <script src="https://js.stripe.com/v3/"></script>

    <script>
$('#sub_cat').hide();
      state_id = 35;
        // to fecth counties on basis of state
        // var state_id=$(".selected_case_state").val();
        var token = $('input[name=_token]').val();
        if (state_id) {
            $.ajax({
                url: "{{ route('ajax_get_counties_by_state') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    id: state_id,
                    _token: token,
                    advertise_id: ''
                },
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('#case_county').append('<option value=' + key + '>' + val + '</option>');
                        });
                        var selected_case_county = $('.selected_case_county').val();
                        $("#case_county").val(selected_case_county);
                    }
                }
            });
        }
       $('#case_county').on('change' , function(){
           var county_id = $("#case_county :selected ").val();

            $.ajax({
                url: "{{ route('advertise.getCategory') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    county_id: county_id,
                    _token: token,
                    advertise_id: {{ $advertise_id }}
                },
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $('#advertiser_category_inputs').empty();
                        $('#advertiser_category_inputs').append('  <option value="">Choose Category</option>');
                        $.each(data, function(key, val) {
                            // console.log(val);
                            $('#advertiser_category_inputs').append('<option value=' + val.id + '>' + val.name + '</option>');

                        });
                        // var selected_case_county = $('.selected_case_county').val();
                        // $("#case_county").val(selected_case_county);
                    }
                }
            });

        })
  $('#card-button').prop('disabled', true);
     $(document).on('mouseover',function(){ 
        $('#payment-form').validate({

            rules:{
                title:{required:true},
                AD_price:{required:true},
                  advertiser_services_id:{required:true},
                  listing_county:{required:true},
                  advertising_catgory:{required:true},
            },
             errorPlacement: function(error, element) {
            if (element.attr("name") === "advertiser_services_id[]") {
          
             error.appendTo('.advertiser_services_22');
             }
             else if (element.attr("name") === "images[]") {
          
             error.appendTo('#spanFileName');
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
        const cardElement = elements.create('card', {
            hidePostalCode: true
        });

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {
                setupIntent,
                error
            } = await stripe.handleCardSetup(
                clientSecret, cardElement, {
                    payment_method_data: {
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
           
                // $('#stripe_message').text('Error in card verification. Please try again.');
                $('#stripe_message').text(error.message);
                if(error.message === 'A processing error occure'){
                       cardElement.unmount('#card-element');         
  $('#card-element').load(location.href + ' #card-element', function(){
 cardElement.mount('#card-element');
  });
  
                }
                    
       

            } else {
                // console.log(setupIntent.payment_method);
                var ids = [];
                $('#payment_method').val(setupIntent.payment_method);
                var inps = document.getElementsByName('advertiser_services_id[]');
                /*for (var i = 0; i <inps.length; i++) {
                    var inp=inps[i];
                        //alert("pname["+i+"].value="+inp.value);
                       ids.push(inp.value);
                    }*/

                $('input[name="advertiser_services_id[]"]:checked').each(function() {
                    ids.push(this.value);
                });
                var county = $("#case_county option:selected").val();
                var category_id = $("#advertiser_category_inputs option:selected").val();
                var title=$('#title').val();
                var desc=$('#desc').val();
                // var image=$('#image').val();
                // console.log(image);

                if (county.length && category_id.length && ids.length ) {
                    $("#county_id").val(county);
                    // $("#title").val(title);
                    // $("#description").val(desc);
                    // // $("#image").val(image);

                    $("#service_id").val(ids);
                    $('#stripe_message').text('');
                    if(imageValidate())
                {
                    $("#submit_btn").click();
     $('.loader').addClass("page-loader");
                            //   $('#card-button').addClass('spinner');
                              $("#card-button").html(' <i class="fa fa-spinner fa-spin"></i>Loading ')
                    $("#card-button").prop('disabled', true);


                }


                }


                else {
                    alert('Fill all required fields.');
                     $('.loader').removeClass("page-loader");
                    $('#mySpinner').removeClass('spinner');
                    $("#card-button").prop('disabled', false);
                }
            }
        });

        $("#advertiser_category_inputs").on('change', function() {
            var category_id = this.value;
            $('#sub_cat_form').empty();
            $('.services').empty();
            var category_name = $(":selected", this).text();
            var county_id = $("#case_county :selected ").val()
            // alert(category_name);
            $("#category_id").val(category_id);
            $.ajax({
                url: "{{ route('ajax_get_advertiser_service_div') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    _token: token,
                    category_id: category_id,
                    county_id:county_id
                },
                success: function(data) {
                // console.log(data);
                    if (data == null || data == 'null'   ) {
                        $('.services').empty();
                        $('.services').hide();
                        $('.no-case-types').show();
                    }

                    else {
                         if (category_name !== '' ) {
                            $('#sub_cat_form').append(`<div class="form-group col-md-6"><div class="col-md-12" ><label for='title'>Title:*</label><input id='title' type="text" required name="title" class="form-control"></div></div>
                            <div class="form-group col-md-6"><div class="col-md-12" ><label for='price'>Price:*</label><input min="1" oninput="validity.valid||(value='');" onkeypress="if(this.value.length==8) return false;" id="price" type="number" required="" name="AD_price" class="form-control"></div></div>
                             <div class="form-group col-md-6    "><div class="col-md-12" ><label for='desc'>Description</label><textarea id='desc' rows=4 class="form-control"  required name="description" ></textarea></div></div>
                             <div class="form-group col-md-6 "><div class="col-md-12" > <label for='image'>Image</label><br><input type="file" id='image' name="images[]"   onchange="imageValidate()" class="form-custom-file" " multiple><span id='spanFileName' class="text-danger d-block"></span><div id="dvPreview"></div></div></div>`);
            //                  ClassicEditor
            // .create( document.querySelector( '#desc' ) )
            // .catch( error => {
            //     console.error( error );
            // } );

                            }


                        $('.services').empty();
                        /*$('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left">Case Type(s)*</label>');*/

                        $('.services').append(
                            '<label class="col-md-12 case-type-main-label col-form-label text-md-left">Check which services you provide:* <span class="advertiser_services_22" ></span></label>'
                        );


                        $.each(data, function(key, val) {
                            /* $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_types[]" value="'+key+'"><label for="case_type_'+key+'" class="col-form-label text-md-left">'+val+'</label></div>');*/

                                if (key != 'description') {
                                    $('.services').append(
                                        '<div class="case-type-input-div col-md-12"><input type="checkbox" id="case_type_' +
                                val + '" name="advertiser_services_id[]" required value="' +
                                        val + '"><label for="case_type_' + val +
                                        '" class="col-form-label text-md-left ml-2"> ' +
                                        key +
                                        '</label></div>');
                                }


                            if (key == 'description') {
                                $('.services').append('<p class="col-md-12">' + val + '</p>');
                            }
                        });

                        $('.no-case-types').hide();

                        $('.services').show();
                        $('.case-action-div').hide();



                    }
                },
                error: function(data) {

                }
            });


        })
        $.validator.addMethod('filesize', function(value, element, param) {
   return this.optional(element) || (element.files[0].size <= param)
});



function imageValidate() {
    var total_file=document.getElementById("image").files.length;
 
 for(var i=0;i<total_file;i++)
 {
  $('#dvPreview').append("<div class='d-inline ' > <img  width='40' class='img-thumbnail'  src='"+URL.createObjectURL(event.target.files[i])+"'></div>");
 }
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
