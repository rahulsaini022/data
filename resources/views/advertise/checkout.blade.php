@extends('layouts.app')

@section('content')
<style type="text/css">
    table.formatHTML5 tr {
    /*background-color:  yellow !important;*/
    color:#000;
    vertical-align: middle;
    padding: 1.5em;
}
 

</style>
<div class="container">
    <div class="row justify-content-center attorney-registration">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Checkout') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertise.new_listing')}}">Back</a>
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
                
                    	
                    	
                        <div class="form-group row">
                            <div class="col-md-8">
                            <table id=bids border="1" style="width: 100%;" class="formatHTML5 table">
                                
                                <tbody>
                                
                                <tr>
                                    <td >Premium Bid</td>
                                    <td >$ {{ $bid_amount }}</td>
                                </tr>
                                <tr>
                                	<td>
                                		Current Listing Fee
                                	</td>
                                	<td>$ {{ $fee }}</td>
                                </tr>
                                <tr>
                                	<td>
                                		Total
                                	</td>
                                	<td>
                                		$ {{ $total_amount }}
                                	</td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
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
                      <form id="payment-form" action="{{route('advertise.payment') }}" method="POST" style="display: none;">
                                    @csrf
                                   
                                   

                    
		                    <input type="hidden" name="listing_id" value="{{ $listing_id }}" id="listing_id">
		                    <input type="hidden" name="listing_priority" value="{{ $listing_priority }}">
		                    <input type="hidden" name="bid_amount" value="{{ $bid_amount}}">
		                    <input type="hidden" name="listing_fee" value="{{ $fee }}">
		                    <input type="hidden" name="total_amount" value="{{ $total_amount }}">
		                     <input id="payment_method" type="hidden" name="payment_method"  value="">
                                    <input type="submit" id="submit_btn" name="submit" value="pay"> 
                                </form>
                   
                    
                   
                </div>
            </div>

            </div>
        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
	
    // const stripe = Stripe('');
     const stripe = Stripe('{{ env('STRIPE_KEY') }}');

    const elements = stripe.elements();
    const cardElement = elements.create('card', { hidePostalCode: true });

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    let paymentMethod = null
    cardButton.addEventListener('click', async (e) => {
       /* const { setupIntent, error } = await stripe.handleCardSetup(
            clientSecret, cardElement, {
                payment_method_data: {
                    billing_details: { name: cardHolderName.value }
                }
            }
        );*/
            if (paymentMethod) {
            return true
        }

        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: cardElement,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            console.log(result);
            if (result.error) {
                $('#stripe_message').text(result.error.message)
                //$('button.pay').removeAttr('disabled')
            } else {

                paymentMethod = result.setupIntent.payment_method
                $('#payment_method').val(paymentMethod);
                 $("#card-button").html(' <i class="fa fa-spinner fa-spin"></i>Loading ')
                    $("#card-button").prop('disabled', true);

                $('#submit_btn').click();
            }

        })  
    });
</script>    
@endsection