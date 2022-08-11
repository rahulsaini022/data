@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center what-we-offer-page">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Home</div> -->
                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 style="color: #147fe5">WHAT WE OFFER</h1>
                    <div class="what-we-offer-content">
                        <p>The practice of law is a paper jungle.  Vast amounts of time and energy are devoted to creating documents that conform to numerous requirements.  There may be legal professionals who enjoy creating captions and drafting frameworks for Pleading or Motion practice, inputing and calculating complex legal forms, or researching rote case law or local rules for an ad hoc purpose.  However, these tasks are often pedestrian drudgery that, though necessary, detract from the real purpose, the practice of law.  Worse yet, legal professionals often saddle their clients with the drudge.  No client enjoys an attorney handing them a substantial pile of forms requiring repeated redundant inputs so that the attorney can have that information repeatedly and redundantly transcribed for filing with a court.</p>

                        <p>First Draft Data, LLC (FDD) is dedicated to minimizing the drudge and helping make legal easier for both legal professionals and their clients.  Moreover, this optimization has the exciting potential to increase law practice profitability, improve deadline compliance, and even restore rewarding focus of actually practicing law.</p>

                        <p>Developed by attorneys, FDD provides its customers, who must be duly registered attorneys or work for a duly registered attorney, with rapid and easy case registration with no duplicate data input, a deadline-driven Pleading and Motion practice with shortcuts to Draft Responses, Draft Replies, Drafts of subordinate/collateral motions, and much, much more, all of which are downloaded in an editable format in mere seconds.  Where appropriate, the math is done by FDD and forms downloaded in PDF format, ready for signatures.</p>

                        <p>A subset of our standard Domestic Relations offerings, for example, include (above and beyond our extensive Pleading & Motion draft practice) written client interviews for obtaining the DR data, attorney web interviews for easily inputting the DR data, coverture fraction calculations, financial affidavits, Ohio child support calculations, and everything else you’ll need.  A small premium adds <u>client</u> web interviews (talk about minimizing the drudge for everyone!), case financial reports, asset division reports, and all forms required and customized for your court.  The case registration is billed by you as cost to your client who will save far more and you’ll be ready to supercharge your practice by offering cost savings using FDD technology: unbundled legal assistance, flat pricing, or straight billable hours for reviewing/editing the Drafts. </p>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-4"><a class="btn btn-info mb-1 pull-left new-back-btn" href="{{ route('home') }}">Back</a></div>
                        <div class="col-sm-4"><a class="btn btn-info mb-1 new-btn" href="{{ route('pricing') }}">Pricing</a></div>
                        <div class="col-sm-4"><a class="btn btn-info mb-1 new-btn pull-right" href="#">Demo?Try Out?Moneyback</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection