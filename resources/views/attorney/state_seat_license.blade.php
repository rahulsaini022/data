@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center state-seat-license-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('State Seat Licenses') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('attorneys.show',['id'=>Auth::user()->id]) }}"> Back</a>
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

                    @if ($attorney->subscribed('main')) 
                    <?php
                        $main_state_name=\App\State::where('id', $attorney_data->attorney_reg_1_state_id)->get()->pluck('state')->first();
                        if(!$main_state_name){
                            $main_state_name='';
                        }
                    ?>
                        <h5> First State License (Main) Subscription details.</h5>
                        <table class="table table-bordered main-state-subscription-table table-responsive">
                            <thead>
                                <tr>
                                    <th><div style="width: 130px;">State Name</div></th>
                                    <th><div style="width: 150px;">State Reg Num</div></th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>{{ $main_state_name }}({{ $attorney_data->attorney_reg_1_state_id }})</td>
                                    <td>{{ $attorney_data->attorney_reg_1_num }}</td>
                            
                                    @if ($attorney->subscription('main')->onGracePeriod())
                                    <td>
                                        You have cancelled the first state seat (main) license plan subscription. You subscription will end on {{ $attorney->subscription('main')->ends_at->format('m-d-Y H:i:s') }}. <br/><span class="text-primary"> Note:
                                            You will not be able to use our services after your subscription expires.</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('resume-main-form').submit();">
                                            {{ __('Resume') }}
                                        </a>
                                        <form id="resume-main-form" action="{{ route('attorney.resume_cancelled_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="license_type" value="main">
                                        </form>
                                    </td>
                                    @else
                                        <td class="col-sm-3">
                                            You have subscribed to first state seat (main) license plan. <br/><span class="text-primary"> Note:
                                            If you cancel your subscription then you will not be able to use our services after your subscription expires.</span>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('cancel-main-form').submit();">
                                                {{ __('Cancel') }}
                                            </a>
                                            <form id="cancel-main-form" action="{{ route('attorney.cancel_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="license_type" value="main">
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <!-- for second state seat license purchase -->
                    @if ($attorney->subscribed('second_state_seat_license_plan')) 
                    <?php
                        $second_state_name=\App\State::where('id', $attorney_data->attorney_reg_2_state_id)->get()->pluck('state')->first();
                        if(!$second_state_name){
                            $second_state_name='';
                        }
                    ?>
                    <h5> Second State License Subscription details.</h5>
                        <table class="table table-bordered second-state-subscription-table table-responsive">
                            <thead>
                                <tr>
                                    <th><div style="width: 130px;">State Name</div></th>
                                    <th><div style="width: 150px;">State Reg Num</div></th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td>{{ $second_state_name }}({{ $attorney_data->attorney_reg_2_state_id }})</td>
                                    <td>{{ $attorney_data->attorney_reg_2_num }}</td>
                            
                                    @if ($attorney->subscription('second_state_seat_license_plan')->onGracePeriod())
                                    <td>
                                        You have cancelled the second state seat license plan subscription. You subscription will end on {{ $attorney->subscription('second_state_seat_license_plan')->ends_at->format('m-d-Y H:i:s') }}.
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('resume-second-form').submit();">
                                            {{ __('Resume') }}
                                        </a>
                                        <form id="resume-second-form" action="{{ route('attorney.resume_cancelled_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="license_type" value="second_state_seat_license_plan">
                                        </form>
                                    </td>
                                    @else
                                        <td class="col-sm-3">
                                            You have subscribed to second state seat license plan.
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('cancel-second-form').submit();">
                                                {{ __('Cancel') }}
                                            </a>
                                            <form id="cancel-second-form" action="{{ route('attorney.cancel_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="license_type" value="second_state_seat_license_plan">
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    @else
                    <!-- payment form -->
                    <?php
                        // if ($attorney->subscription('second_state_seat_license_plan')->ended()){
                        //      echo '<p>Your second state seat license plan subscription is expired. To renew please complete the payment below.</p>';
                        // }
                    ?>
                    <div class="row mb-5">
                        <p> Purchase Second State Seat License Subscription Plan to Add Second State and State Attorney Number For $150. It will be an <strong>Annual Recurring Subscription.</strong> You can cancel it anytime. </p>
                        <div class="cc-payment-outer payment-cc-main state-seat-license-payment-div">
                            <!-- stripe -->                            
                            <div class="cc-name-outer" style="float: none;">
                                <div class="cc-package-box">
                                    <label for="payment_attorney_reg_2_state_id" class="col-form-label text-md-left">Attorney Reg # State*</label>
                                    <select id="payment_attorney_reg_2_state_id" name="payment_attorney_reg_2_state_id" class="form-control states_select_input" required="">
                                        <option value="">Choose Attorney Reg # State</option>
                                    </select>
                                </div>
                                <div class="cc-package-box">
                                    <label for="payment_attorney_reg_2_num" class="col-form-label text-md-left">Attorney Reg #*</label>
                                    <input id="payment_attorney_reg_2_num" type="text" class="form-control" name="payment_attorney_reg_2_num" value="" required="">
                                </div>
                                
                                <div class="cc-package-box">
                                    <label for="purchase_price_payment_input" class="col-form-label text-md-left">Seat License Price($)</label>
                                    <input id="seat_license_price" name="seat_license_price" type="text" placeholder="" value="150" readonly="">
                                </div>

                               <div class="cc-package-box" style="display: none;"> 
                                 <label for="cc-name" class="col-form-label text-md-left">Name</label>
                                 <input id="card-holder-name" type="text" placeholder="Name" value="{{Auth::user()->name}}" readonly="">
                                </div>
                            </div>
                            <div id="card-element"></div>
                            <div id="stripe_message" class="text-danger"></div>
                            <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                        </div>
                        <form id="payment-form" action="{{ route('attorney.purchase_state_seat_license') }}" method="POST">
                            @csrf
                            <input id="user_id" name="user_id" type="hidden"  value="{{Auth::user()->id}}">
                            <input id="payment_method" type="hidden" name="payment_method"  value="">
                            <input id="hidden_seat_license_price" name="hidden_seat_license_price" type="hidden" placeholder="" value="150" readonly="">
                            <input id="hidden_attorney_reg_2_state_id" type="hidden" class="form-control" name="attorney_reg_2_state_id" value="">
                            <input id="hidden_attorney_reg_2_num" type="hidden" class="form-control" name="attorney_reg_2_num" value="">
                            <input type="submit" id="submit_btn" name="submit" value="Submit" style="display: none;"> 
                            <!-- stripe -->
                        </form>
                    </div>
                    @endif
                    <!-- end for second state seat license purchase -->
                    
                    <!-- for third state seat license purchase -->
                        @if ($attorney->subscribed('third_state_seat_license_plan')) 
                            <?php
                                $third_state_name=\App\State::where('id', $attorney_data->attorney_reg_3_state_id)->get()->pluck('state')->first();
                                if(!$third_state_name){
                                    $third_state_name='';
                                }
                            ?>
                            <h5> Third State License Subscription details.</h5>
                            <table class="table table-bordered third-state-subscription-table table-responsive">
                                <thead>
                                    <tr>
                                        <th><div style="width: 130px;">State Name</div></th>
                                        <th><div style="width: 150px;">State Reg Num</div></th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <tr>
                                        <td>{{ $third_state_name }}({{ $attorney_data->attorney_reg_3_state_id }})</td>
                                        <td>{{ $attorney_data->attorney_reg_3_num }}</td>
                                
                                        @if ($attorney->subscription('third_state_seat_license_plan')->onGracePeriod())
                                        <td>
                                            You have cancelled the third state seat license plan subscription. You subscription will end on {{ $attorney->subscription('third_state_seat_license_plan')->ends_at->format('m-d-Y H:i:s') }}.
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('resume-third-form').submit();">
                                                {{ __('Resume') }}
                                            </a>
                                            <form id="resume-third-form" action="{{ route('attorney.resume_cancelled_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                                @csrf
                                                <input type="hidden" name="license_type" value="third_state_seat_license_plan">
                                            </form>
                                        </td>
                                        @else
                                            <td class="col-sm-3">
                                                You have subscribed to third state seat license plan.
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('cancel-third-form').submit();">
                                                    {{ __('Cancel') }}
                                                </a>
                                                <form id="cancel-third-form" action="{{ route('attorney.cancel_state_seat_license_subscription') }}" method="POST" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" name="license_type" value="third_state_seat_license_plan">
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>                        
                        @else
                            @if (Auth::user()->subscribed('second_state_seat_license_plan'))
                                <!-- payment form -->
                                <?php
                                    // if ($attorney->subscription('third_state_seat_license_plan')->ended()){
                                    //      echo '<p>Your third state seat license plan subscription is expired. To renew please complete the payment below.</p>';
                                    // }
                                ?>
                                <div class="row mb-5">
                                    <p> Purchase Third State Seat License Subscription Plan to Add Third State and State Attorney Number For $150. It will be an <strong>Annual Recurring Subscription.</strong> You can cancel it anytime. </p>
                                    <div class="cc-payment-outer payment-cc-main state-seat-license-payment-div">
                                        <!-- stripe -->                            
                                        <div class="cc-name-outer" style="float: none;">
                                            <div class="cc-package-box">
                                                <label for="payment_attorney_reg_3_state_id" class="col-form-label text-md-left">Attorney Reg #3 State*</label>
                                                <select id="payment_attorney_reg_3_state_id" name="payment_attorney_reg_3_state_id" class="form-control states_select_input" required="">
                                                    <option value="">Choose Attorney Reg #3 State</option>
                                                </select>
                                            </div>
                                            <div class="cc-package-box">
                                                <label for="payment_attorney_reg_3_num" class="col-form-label text-md-left">Attorney Reg #3*</label>
                                                <input id="payment_attorney_reg_3_num" type="text" class="form-control" name="payment_attorney_reg_3_num" value="" required="">
                                            </div>
                                            
                                            <div class="cc-package-box">
                                                <label for="purchase_price_payment_input" class="col-form-label text-md-left">Seat License Price($)</label>
                                                <input id="seat_license_price" name="seat_license_price" type="text" placeholder="" value="150" readonly="">
                                            </div>

                                           <div class="cc-package-box" style="display: none;"> 
                                             <label for="cc-name" class="col-form-label text-md-left">Name</label>
                                             <input id="card-holder-name" type="text" placeholder="Name" value="{{Auth::user()->name}}" readonly="">
                                            </div>
                                        </div>
                                        <div id="card-element"></div>
                                        <div id="stripe_message" class="text-danger"></div>
                                        <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                                    </div>
                                    <form id="payment-form" action="{{ route('attorney.purchase_state_seat_license') }}" method="POST">
                                        @csrf
                                        <input id="user_id" name="user_id" type="hidden"  value="{{Auth::user()->id}}">
                                        <input id="payment_method" type="hidden" name="payment_method"  value="">
                                        <input id="hidden_seat_license_price" name="hidden_seat_license_price" type="hidden" placeholder="" value="150" readonly="">
                                        <input id="hidden_attorney_reg_3_state_id" type="hidden" class="form-control" name="attorney_reg_3_state_id" value="">
                                        <input id="hidden_attorney_reg_3_num" type="hidden" class="form-control" name="attorney_reg_3_num" value="">
                                        <input type="submit" id="submit_btn" name="submit" value="Submit" style="display: none;"> 
                                        <!-- stripe -->
                                    </form>
                                </div>
                            @endif
                        @endif
                    <!-- end for third state seat license purchase -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    // function selectPdfCreditPackage(pdf_credit, purchase_price, id) {
    //     $('#pdf_credits_payment_input').val(pdf_credit);
    //     $('#purchase_price_payment_input').val(purchase_price);
    //     $('#pdf_credit_package_id').val(id);
    //     // $('#package_price_input').val('$'+package_price);
    //     $('.payment-cc-main').show();
    //     $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
    // }

    // const stripe = Stripe('');
    var card_element=$('#card-element');
    if(card_element.length){
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
                $('#stripe_message').text(error.message);
            } else {
                // console.log(setupIntent.payment_method);
                $('#payment_method').val(setupIntent.payment_method);
                $('#stripe_message').text('');
                var attorney_reg_2_state_id=$('#payment_attorney_reg_2_state_id');
                if(attorney_reg_2_state_id.length){
                    var attorney_reg_2_state_id=$('#payment_attorney_reg_2_state_id');
                    var attorney_reg_2_num=$('#payment_attorney_reg_2_num');
                    if(attorney_reg_2_state_id && attorney_reg_2_num){
                        $('#hidden_attorney_reg_2_state_id').val($(attorney_reg_2_state_id).val());
                        $('#hidden_attorney_reg_2_num').val($(attorney_reg_2_num).val());
                        $("#submit_btn").click();
                    } else {
                        alert('Fill all required fields.');
                    }
                }
                var attorney_reg_3_state_id=$('#payment_attorney_reg_3_state_id');
                if(attorney_reg_3_state_id.length){
                    var attorney_reg_3_state_id=$('#payment_attorney_reg_3_state_id');
                    var attorney_reg_3_num=$('#payment_attorney_reg_3_num');
                    if(attorney_reg_3_state_id && attorney_reg_3_num){
                        $('#hidden_attorney_reg_3_state_id').val($(attorney_reg_3_state_id).val());
                        $('#hidden_attorney_reg_3_num').val($(attorney_reg_3_num).val());
                        $("#submit_btn").click();
                    } else {
                        alert('Fill all required fields.');
                    }
                }

            }
        });
    }

$(document).ready(function(){
    // To fetch state list
    $.ajax({
        url:"{{route('ajax_get_states')}}",
        method:"GET",
        dataType: 'json',
        success: function(data){
            // console.log(data);
            if(data==null || data=='null'){
            } else {
                $.each(data, function (key, val) {
                     if(key == 35){
                    $('.states_select_input').append('<option value='+key+'>'+val+'</option>');
                }
                });
                //var sel_reg_2_state=$('#attorney_reg_2_state_id_input').val();
                 var sel_reg_2_state= 35;
                if(sel_reg_2_state){
                    $('#attorney_reg_2_state_id option[value='+sel_reg_2_state+']').attr('selected','selected');
                }
                var sel_reg_3_state=$('#attorney_reg_3_state_id_input').val();
                if(sel_reg_3_state){
                    $('#attorney_reg_3_state_id option[value='+sel_reg_3_state+']').attr('selected','selected');
                }
            }
        }
    });
});
</script>
@endsection