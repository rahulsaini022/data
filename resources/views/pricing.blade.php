@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pricing-page">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Home</div> -->
                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 style="color: #147fe5">PRICING</h1>
                    <h3 style="color: #000000">Annual Seat License (1 attorney): $150</h3>
                    <div class="pricing-content">
                        <div class="table-responsive">
                            <table class="table table-bordered pricing-table">
                                <caption style="caption-side: top; background: #000000;"><span class="pricing-table-caption">Per Case Fees:</span></caption>
                                <thead>
                                  <tr>
                                    <?php $i=1; ?>
                                    @foreach($data as $pricedata)
                                        @if($i==1)
                                            <th width="110px">{{$pricedata->title}}</th>
                                        @else
                                            <th>{{$pricedata->title}}</th>
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    @foreach($data as $pricedata)
                                        <th>${{$pricedata->price}}</th>
                                    @endforeach
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                        <p>This includes a comprehensive pleading and motion drafting docket complete with deadline tracking, new motions, and responsive motions, forms required for filing cases, forms for family law (including child support calculations, affidavits, etc., where FDD does the math), a simplified web interview for attorneys (or their assistants) to input data required in family law cases which, at the premium level, the attorney can invite the client to complete.</p>

                        <p class="text-left" style="color: #147fe5; font-size: 20px;">Includes Discounts!!</p>
                        <p><u>Annual Seat Licenses</u> are discounted for an Attorney/Legal Profession who works for Legal Aid, the VLP, a Law Clinic, or is an adjudicator serving as a full-time employee of an Ohio court of law.  Any Attorney/Legal Professional who obtains a discounted Annual Seat License due working for Legal Aid, the VLP, a Law Clinic, or as an adjudicator serving as a full-time employee of an Ohio court of law, is <u>WELCOME</u> to use it for their <u>other</u> cases outside those capacities.</p>

                        <p><u>Per Case Fees</u> are discounted <u>ONLY</u> for cases where an Attorney/Legal Professional from Legal Aid, the VLP, or a Law Clinic appears as counsel on behalf of their indigent or disabled client(s).  Otherwise, there is no Per Case Fees discount for that case.</p>

                        <p>If an Annual Seat License is expired and/or unpaid, the registered cases will be allowed to complete but there will be no ability to register new cases nor use FDD Quick Forms.</p>

                        <p>If a Per Case Fee payment fails for any reason, the associated case will be disabled and not allowed to complete until the Per Case Fee is paid, along with a reinstatement fee of $100.</p>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-4"><a class="btn btn-info new-back-btn mb-1 pull-left" href="{{ route('home') }}">Back</a></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"><a class="btn btn-info new-btn mb-1 pull-right" href="#">Demo?Try Out?Moneyback</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection