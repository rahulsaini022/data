@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center what-we-offer-page">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Home</div> -->
                <div class="card-body" align="center">
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

                    <h1 style="color: #147fe5">How FDD Can Save You Money</h1>
                    <div class="what-we-offer-content fdd-save-money-page">
                        <p> The biggest expense in most legal cases is the time spent draft legal documents.  And you’re paying the bill!  First Draft Data provides attorneys/legal professionals with solid draft documents at a fraction of what it would cost an attorney or legal professional to draft them from scratch.  Why reinvent the wheel?  Why waste your money on that?  Instead, smart attorneys use First Draft Data as an efficient, cost-effective head-start.  We provide draft legal documents to attorneys who review, and if necessary, edit the documents for your particular needs.  This way, your cost is minimized and the money you do spend is put to better use by your attorney in tailoring our draft documents to actually further your case. </p>

                        <p> But how do you find such smart attorneys?  Just ask us!  Or, if you already have an attorney, tell them to register your case with First Draft Data so you can start saving money! </p>

                        <p> <strong>Example:</strong> One divorce complaint from scratch can cost $1,500 and up!  Our cost for a divorce case, for <u>all</u> draft documents needed for the <u>entire</u> case?  $250 and that includes the complaint with all your specific information. </p>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-6"><a class="btn btn-info mb-1 new-btn pull-left" href="{{ route('refer_an_attorney_who_uses_fdd') }}">Please refer an Attorney to me <br> who uses First Draft Data</a></div>
                        <div class="col-sm-6"><a class="btn btn-info mb-1 new-btn pull-right" href="{{ route('inform_my_attorney_to_use_fdd') }}">Please inform my Attorney <br> I want them to start using First Draft Data</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection