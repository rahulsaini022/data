@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Create New Role') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => 'roles.store', 'method' => 'POST','id'=>'role_form']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" placeholder="Name"
                                        class="form-control @error('name') is-invalid @endif"  required> 
                                {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}
               @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
                            </div>
                        </div>
                        <div class="col-xs-12
                                        col-sm-12 col-md-12">
                                    <div class="form-group permission_error">
                                       <strong>Permission:</strong>
                                        <br />
                                        @foreach ($permission as $value)
                                            <label>
                                                {{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name','required'=>'true']) }}
                                                {{ $value->name }}</label>
                                            <br />
                                        @endforeach

                                        @error('permission')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    @endsection
