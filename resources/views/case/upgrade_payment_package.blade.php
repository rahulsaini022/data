@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center casepage_payment_outer">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Upgrade Package') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('cases.index') }}">Back</a>
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
                            <h2>Welcome {{Auth::user()->name}}</h2>
                            <p>To Upgrade your Package please complete the Payment Process. You only need to pay the difference in Price.</p>
                        </div>
                        <?php 



                         // echo "<pre>"; print_r($case_packages);print_r(count($case_packages));die;
                        $i=0; $j=0; $total_packages=count($case_packages); $old_package=false; ?>  
                        @foreach($case_packages as $case_package)
                            @if($i==0)
                            <div class="col-sm-12 payment-content-box packages-grid">
                            @endif    
                                @if (count($case_packages) > 2)
                                <div class="col-sm-4 package-div">
                                @else
                                <div class="col-sm-6 package-div">
                                @endif
                                    <div class="package-title-div">
                                        <h4>{{ $case_package->package_title}} (${{ $case_package->package_price }}) @if($old_package_details->id == $case_package->id) <br><span class="text-success">Current Package.</span>@endif</h4>
                                    </div>
                                    <div class="case-package-description">
                                         <?php echo $case_package->package_description; ?>
                                    </div>
                                    <div class="package-select-button">
                                        <!-- <button class="btn btn-primary" type="button" class="package-button" onclick="selectPackage('<?php //echo $case_package->package_title.','.$case_package->package_price; ?>')">Select</button> -->

                                        <?php
                                        if($old_package==true || $old_package_details->active == '0'){
                                            $package_title= preg_replace('/[^A-Za-z0-9\-]/', ' ', $case_package->package_title); // Removes special chars.
                                            echo '<button class="btn btn-primary package-button" onclick="selectPackage(\'' . $package_title . '\',\'' . $case_package->package_price . '\',\'' . $case_package->id . '\')">Select</button>';
                                        } else {
                                        }
                                        if($old_package_details->id == $case_package->id){
                                            $old_package=true;
                                        }
                                        ?>

                                    </div>
                                </div>    
                            <?php if($i==2 || $total_packages-1 == $j ){ ?>
                            </div>
                            <?php } ?>
                            <?php ++$i; ++$j; if($i>2){$i=0;} ?>  
                        @endforeach
                       
                        <!-- payment form -->
                        <div class="cc-payment-outer payment-cc-main" style="display: none;">
                            <!-- stripe -->                            
                            <div class="cc-name-outer">
                                <div class="cc-package-box">
                                    <label for="package_name_input" class="col-form-label text-md-left">Package Name</label>
                                    <input id="package_name_input" type="text" placeholder="" value="" readonly="">
                                </div>

                                <div class="cc-package-box">
                                    <label for="package_price_input" class="col-form-label text-md-left">Price $</label>
                                    <input id="package_price_input" type="text" placeholder="Name" value="" readonly="">
                                </div>

                               <div class="cc-package-box"> 
                                 <label for="cc-name" class="col-form-label text-md-left">Name</label>
                                 <input id="card-holder-name" type="text" placeholder="Name" value="{{Auth::user()->name}}">
                                </div>
                            </div>
                            <div id="card-element"></div>
                            <div id="stripe_message" class="text-danger"></div>
                            <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                            <form id="payment-form" action="{{route('cases.make_upgrade_package_payment') }}" method="POST" style="display: none;">
                                @csrf
                                <input id="case_id" name="case_id" type="hidden"  value="{{$case_details->id}}" readonly="">
                                <input id="case_type" name="case_type" type="hidden"  value="{{$case_details->case_types}}" readonly="">
                                <input id="payment_method" type="hidden" name="payment_method"  value="" required="" readonly="">
                                <input id="package_id" type="hidden" name="package_id"  value="" required="" readonly="">
                                <input id="package_name" type="hidden" name="package_name"  value="" required="" readonly="">
                                <input id="package_price" type="hidden" name="package_price"  value="" required="" readonly="">
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
<script src="https://js.stripe.com/v3/"></script>

<script>

    function selectPackage(package_name, package_price, id) {
        $('#package_name, #package_name_input').val(package_name);
        var old_package_price='{{ $old_package_details->package_price }}';
        var new_package_price=package_price;
        var final_package_price=(new_package_price)-(old_package_price);
        $('#package_price, #package_price_input').val(final_package_price);
        $('#package_id').val(id);
        // $('#package_price_input').val('$'+package_price);
        $('.payment-cc-main').show();
        $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
    }

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

