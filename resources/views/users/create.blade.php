@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Create New users') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                      
                        {!! Form::open(['route' => 'users.store', 'method' => 'POST', 'id' => 'user_form_create']) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {{-- {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!} --}}
                                     <input type='text' name="name" value="{{ old('name')}}" placeholder='Name'
                                            class='form-control  @error('name') is-invalid @enderror'>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {{-- {!! Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!} --}}
                                     <input type='email' value="{{ old('email') }}" name="email" placeholder='Email'
                                            class='form-control  @error('email') is-invalid @enderror'>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Username:</strong>
                                    {{-- {!! Form::text('username', null, ['placeholder' => 'Username', 'class' => 'form-control']) !!} --}}
                                     <input type='text' value="{{ old('username') }}" name="username" placeholder='username'
                                            class='form-control  @error('username') is-invalid @enderror'>
                                    @error('username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    {{-- {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control password']) !!} --}}
                                             <input type='password' name="password" placeholder='Password'
                                            class='form-control password @error('password') is-invalid @enderror'>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    {{-- {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!} --}}
                                        <input type='password' name="confirm-password" placeholder='confirm password'
                                            class='form-control @error('confirm-password') is-invalid @enderror'>
                                        @error('confirm-password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {{-- {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!} --}}
                                     <select name="roles[]" multiple
                                            class="form-control @error('roles') is-invalid @enderror">
                                            @foreach ($roles as $key)
                                                <option value="{{ $key }}">{{ $key }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Credits:</strong>
                                    {!! Form::number('credits', '0', ['placeholder' => 'Credits', 'class' => 'form-control']) !!}
                                    @error('credits')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary pull-left">Submit</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#user_form_create').validate({
            rules: {
                'name': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true
                },
                'username': {
                    required: true,
                },
                'password': {
                    required: true,
                },
                'confirm-password': {
                    required: true,
                    equalTo: '.password'
                },
                'roles[]': {
                    required: true,
                },
            },
            messages: {
                'confirm-password': {
                    equalTo: 'The password and confirm-password must same.'
                },
            },
         
        });
    </script>
@endsection
