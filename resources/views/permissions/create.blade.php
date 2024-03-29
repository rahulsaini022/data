@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Add New Permission') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('permissions.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <strong>Whoops!</strong> There were some problems with your input.<br><br>

                            <ul>

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    <form action="{{ route('permissions.store') }}" method="POST">

                        @csrf


                         <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group">

                                    <strong>Name:</strong>

                                    <input type="text" name="name" class="form-control" placeholder="Name">

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                                    <button type="submit" class="btn btn-primary">Submit</button>

                            </div>

                        </div>


                    </form>


                </div>    
            </div>   
        </div>
    </div>
</div>            

@endsection