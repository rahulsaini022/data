@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD PDF Tools') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('fdd_tools') }}"> Back</a>
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

                    <h5 class="text-center">{{$attorney->name}} PDF Credit Balance: {{ $attorney->credits }}</h5>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <p>
                                FDD PDF Tools are premium tools where document submission size is nominally limited to 1GB and each use of a PDF Tool, except the FDD OCR Ripper – EDiscovery tool, will expend the listed amount of PDF credits.  A seat license gains 5 PDF credits for each case registration – yes, they add up and only expire if and when the seat license is not timely renewed).  Need more PDF credits?
                            </p>
                            <span class="pull-right"><button class="btn btn-info buy-pdf-credits-btn">Buy PDF Credits</button></span>
                        </div>
                        <table class="table table-bordered pdf-tools-table dark-border table-responsive">
                            <tbody>
                               <tr class="text-center">
                                    <td colspan="2">
                                        <strong>FDD PDF Squeezer</strong> <br>PDF File Limit Submission Size: 1GB
                                    </td>
                                    <td rowspan="2">
                                        PDF documents too big for efiling, emailing, etc.?  FDD PDF Squeezer is a proprietary tool that does what it says and does it well. Better yet, the resulting compressed files exhibit visual quality that is virtually indistinguishable from the original pdf.
                                    </td>
                               </tr>
                               <tr class="text-center">
                                    <td width="25%">
                                        <!-- <a class="btn btn-info new-btn" href="#">Start Right Now</a> -->
                                        @if($attorney->credits < 1)
                                            <button class="btn btn-info new-btn" onclick="noCreditBalance();">Start Right Now</button>
                                        @else
                                            <form method="POST" action="{{ route('squeez_pdf') }}" id="squeez_pdf_form" enctype="multipart/form-data">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-sm-12 column-box-width">
                                                        <input type="file" name="file_to_compress" id="file_to_compress" accept="application/pdf" required="">
                                                    </div>
                                                    <div class="col-sm-12 mt-2 column-box-width">
                                                        <input type="submit" class="btn btn-info new-btn" id="squeeze_download_file" name="squeeze_download_file" value="Start Right Now">
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <br>Credit Cost: 2/PDF file
                                    </td>
                                    <td width="25%">
                                        <a class="btn btn-info new-btn" href="#" style="margin-top: 38px;">Start Today/Tomorrow</a>
                                        <br>Credit Cost: 1/PDF file
                                    </td>
                               </tr>
                               <!-- <tr class="text-center">
                                    <td colspan="2">
                                        <strong>FDD OCR Ripper</strong> <br>PDF File Limit Submission Size: 1GB
                                    </td>
                                    <td rowspan="2">
                                            Documents speak for themselves but many time pdf documents included invisible layers of questionable quality OCR text and other spurious data that could mislead.  Clean it away with the FDD OCR Ripper.  Have a lot of PDFs to clean?  See our FDD OCR Ripper – Bulk/EDiscovery, below.
                                    </td>
                               </tr>
                               <tr class="text-center">
                                    <td width="25%">
                                        @if($attorney->credits < 1)
                                            <button class="btn btn-info new-btn" onclick="noCreditBalance();">Start Right Now</button>
                                        @else
                                            <form method="POST" action="" id="pdf_ocr_rip_form" enctype="multipart/form-data">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-sm-12 column-box-width">
                                                        <input type="file" name="file_to_ocrrip" id="file_to_ocrrip" accept="application/pdf" required="">
                                                    </div>
                                                    <div class="col-sm-12 mt-2 column-box-width">
                                                        <input type="submit" class="btn btn-info new-btn" id="ocrip_download_file" name="ocrip_download_file" value="Start Right Now">
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <br>Credit Cost: 2/PDF file
                                    </td>
                                    <td width="25%">
                                        <a class="btn btn-info new-btn" href="#" style="margin-top: 38px;">Start Today/Tomorrow</a>
                                        <br>Credit Cost: 1/PDF file
                                    </td>
                               </tr> -->
                               <tr class="text-center">
                                    <td colspan="2">
                                        <strong>FDD Scrubber</strong>
                                        <br>PDF File Limit Submission Size: 1GB
                                        @if($attorney->credits < 1)
                                            <button class="btn btn-info new-btn" onclick="noCreditBalance();">Start Right Now</button>
                                        @else
                                            <form method="POST" action="{{ route('pdf_scrubber') }}" id="pdf_super_scrubber_form" enctype="multipart/form-data">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-sm-12 column-box-width">
                                                        <input type="file" name="file_to_super_scrub" id="file_to_super_scrub" accept="application/pdf" required="">
                                                    </div>
                                                    <div class="col-sm-12 mt-2 column-box-width">
                                                        <input type="submit" class="btn btn-info new-btn" id="super_scrubber_download_file" name="super_scrubber_download_file" value="Start Right Now">
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <br>Credit Cost: 1/PDF file
                                    </td>
                                    <td>
                                        Documents speak for themselves but many time pdf documents include invisible layers of questionable quality OCR text and other spurious data that could mislead.  Clean it away with the FDD PDF Scrubber.
                                    </td>
                               </tr>
                               <tr class="text-center">
                                    <td colspan="2">
                                        <strong>FDD Fixer</strong>
                                        <br>PDF File Limit Submission Size: 1GB
                                        @if($attorney->credits < 1)
                                            <button class="btn btn-info new-btn" onclick="noCreditBalance();">Start Right Now</button>
                                        @else
                                            <form method="POST" action="{{ route('pdf_fixer') }}" id="pdf_fixer_form" enctype="multipart/form-data">
                                                <div class="row">
                                                    @csrf
                                                    <div class="col-sm-12 column-box-width">
                                                        <input type="file" name="file_to_fix" id="file_to_fix" accept="application/pdf" required="">
                                                    </div>
                                                    <div class="col-sm-12 mt-2 column-box-width">
                                                        <input type="submit" class="btn btn-info new-btn" id="fixer_download_file" name="fixer_download_file" value="Start Right Now">
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                        <br>Credit Cost: 1/PDF file
                                    </td>
                                    <td>
                                        Things happens, sometimes bad things to PDF files. If you can’t get another copy of that file, we can give it our best try to fix it. Don’t panic! We make no guarantee of success but what have you got to lose? (Actually, FDD’s proprietary PDF algorithms are pretty good.)
                                    </td>
                               </tr>
                            </tbody>
                        </table>

                        <h5 class="text-center mt-5" style="width: 100%">Buy PDF Credits</h5>
                        <table class="table table-bordered pdf-tools-credits-table dark-border text-center" style="width: 70%; margin: auto;">
                            <thead>
                                <tr>
                                    <th>Number of PDF Credits</th>
                                    <th>Purchase Price</th>
                                    <th>Discount/Savings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pdf_credits as $pdf_credit)
                                    <tr>
                                        <td>{{$pdf_credit->number_of_credits}} <button class="btn btn-info pull-right pdf-credits-package-btn" onclick="selectPdfCreditPackage('{{$pdf_credit->number_of_credits}}', '{{$pdf_credit->purchase_price}}', '{{$pdf_credit->id}}');">Buy Now</button></td>
                                        <td>${{$pdf_credit->purchase_price}}</td>
                                        <td>${{$pdf_credit->discount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- payment form -->
                        <div class="cc-payment-outer payment-cc-main pdf-credits-package-payment-div mt-5" style="display: none;">
                            <!-- stripe -->                            
                            <div class="cc-name-outer" style="float: none;">
                                <div class="cc-package-box">
                                    <label for="pdf_credits_payment_input" class="col-form-label text-md-left">PDF Credits</label>
                                    <input id="pdf_credits_payment_input" type="text" placeholder="" value="" readonly="">
                                </div>

                                <div class="cc-package-box">
                                    <label for="purchase_price_payment_input" class="col-form-label text-md-left">Purchase Price($)</label>
                                    <input id="purchase_price_payment_input" type="text" placeholder="Name" value="" readonly="">
                                </div>

                               <div class="cc-package-box"> 
                                 <label for="cc-name" class="col-form-label text-md-left">Name</label>
                                 <input id="card-holder-name" type="text" placeholder="Name" value="{{Auth::user()->name}}" readonly="">
                                </div>
                            </div>
                            <div id="card-element"></div>
                            <div id="stripe_message" class="text-danger"></div>
                            <button id="card-button" data-secret="{{ $intent->client_secret }}" class="btn btn-primary">Pay</button>
                            <form id="payment-form" action="{{route('fdd_tools.buy_pdf_credits') }}" method="POST" style="display: none;">
                                @csrf
                                <input id="pdf_credit_package_id" type="hidden" name="pdf_credit_package_id"  value="" required="" readonly="">
                                <input id="user_id" name="user_id" type="hidden"  value="{{$attorney->id}}">
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

<div id="delay-message-myModal" class="delay-message-modal"><div class="delay-message-modal-content"><span class="delay-message-close">&times;</span><p>Your drafts will be available in your download directory soon.</p><div><a class="btn btn-danger delay-message-close-btn"> Close</a><a class="btn btn-info ml-2" href="{{ route('attorney.downloads') }}"> Go to Downloads</a></div></div></div>

<script src="https://js.stripe.com/v3/"></script>

<script>
    // function showDelayMessage(file_input_id){
    //     if( document.getElementById(file_input_id).files.length > 0){
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
    //     return true;
    // }

    function noCreditBalance(){
        alert('Your Credit Balance is Insufficient. Please buy PDF Credits to use FDD Tools.');
    }
    function selectPdfCreditPackage(pdf_credit, purchase_price, id) {
        $('#pdf_credits_payment_input').val(pdf_credit);
        $('#purchase_price_payment_input').val(purchase_price);
        $('#pdf_credit_package_id').val(id);
        // $('#package_price_input').val('$'+package_price);
        $('.payment-cc-main').show();
        $("html, body").animate({ scrollTop: document.body.scrollHeight }, "slow");
    }

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

$(document).ready(function () {
    $('.buy-pdf-credits-btn').on('click', function() {
        $('html, body').animate({
            scrollTop: $(".pdf-tools-credits-table").offset().top
        }, 1000);
        return false;
    });
});
</script>
@endsection