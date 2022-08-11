@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertiser Bid  Detail') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertiser.bids') }}"> Back</a>
                    </div>
                </div>
                <div class="card-body">
 @forelse($bid_details as  $data)
                  
                
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Advertiser Name: </strong>
                                  {{$data->full_name}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Advertiser Email: </strong>
                                  {{$data->email}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>County: </strong>
                                  {{$data->county_name}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>List fee Amount: </strong>
                                  ${{$data->list_fee_amount}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Premium Bid fees: </strong>
                                  ${{$data->premium_bid_amount}}
                            </div>
                        </div>
                      
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Fee date: </strong>
                                {{date('d-M-Y', strtotime($data->list_fee_date))}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Expire Date: </strong>
                                  {{date('d-M-Y', strtotime($data->renew_expiration_date))}}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Transaction Id: </strong>
                                  {{$bid->txn_id}}
                            </div>
                        </div>
                       
                    </div>
                    @empty
                    <p class="text-center">No data found</p>
                    @endforelse
                    
                </div>
            </div>
        </div>
    </div>
</div>                    
@endsection