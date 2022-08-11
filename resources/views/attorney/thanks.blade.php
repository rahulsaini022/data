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
                            <h2>Welcome {{$user->name}}</h2>  
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button> 
                                        <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <p><a class="btn btn-primary" href="{{ route('login') }}">{{ __('Log In »') }}</a></p>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

