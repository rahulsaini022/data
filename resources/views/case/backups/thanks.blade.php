@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Thanks') }}</strong></div>
                <div class="card-body">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="row"> 
                        <div class="col-md-12" align="center">
                            <h2>Welcome {{Auth::user()->name}}</h2>
                            @if ($success)
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button> 
                                        <strong>{{ $success }}</strong>
                                </div>
                            @endif
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

