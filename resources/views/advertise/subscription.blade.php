@extends('layouts.app')

@section('content')
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
                            <p>This is payment page. To use our services you need to pay <strong>$150</strong> as subscription fee. This will be an annual subscription. You can cancel it anytime.</p>
                        </div>  
                        <div class="col-md-12" align="center">
                            <div class="cc-payment-outer">
                                <!-- stripe -->                            
                                <div class="cc-name-outer">
                                    <label for="cc-name" class="col-form-label text-md-left">Name</label>
                                    <input id="card-holder-name" type="text" placeholder="Name" value="{{$user->name}}">
                                </div>
                                <div id="card-element"></div>
                                <div id="stripe_message" class="text-danger"></div>
                                <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                                <form id="payment-form" action="{{route('advertise.subscribe') }}" method="POST" style="display: none;">
                                    @csrf
                                    <input id="user_id" name="user_id" type="hidden"  value="{{$user->id}}">
                                    <input id="payment_method" type="hidden" name="payment_method"  value="">
                                    <input type="submit" id="submit_btn" name="submit" value="Submit"> 
                                </form>
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
            $('#stripe_message').text(error.message);
        } else {
            // console.log(setupIntent.payment_method);
            $('#payment_method').val(setupIntent.payment_method);
            $('#stripe_message').text('');
            $("#submit_btn").click();  

        }
    });
</script>
@endsection

