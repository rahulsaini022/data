    @extends('layouts.app')
    @section('content')
        <div class="container">
            <div class="row justify-content-center attorney-dashboard">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>{{ __('Edit User') }}</strong>
                            <div class="pull-right">
                                @php
                                    preg_match("/[^\/]+$/", url()->previous(), $matches);
                                    $last_word = $matches[0]; // test
                                @endphp
                                @if ($last_word == 'users')
                                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                @elseif($last_word == 'clients')
                                    <a class="btn btn-primary" href="{{ route('all.clients') }}"> Back</a>
                                @else
                                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['users.update', $user->id], 'id' => 'user_form_edit']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control ')) !!} --}}
                                        <input type='text' name="name" value="{{ $user->name }}" placeholder='Name'
                                            class='form-control  @error('name') is-invalid @enderror'>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="pre_url" value="{{ $last_word }}" />
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        {{-- {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control  @error('email') is-invalid @enderror')) !!} --}}
                                        <input type='email' value="{{ $user->email }}" name="email" placeholder='Email'
                                            class='form-control  @error('email') is-invalid @enderror'>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Password:</strong>
                                        {{-- {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control @error('password') is-invalid @enderror')) !!} --}}
                                        <input type='password' name="password" placeholder='Password'
                                            class='form-control @error('password') is-invalid @enderror'>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Confirm Password:</strong>
                                        {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                                        @error('confirm-password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Role:</strong>
                                        <select name="roles[]" multiple
                                            class="form-control @error('roles') is-invalid @enderror">
                                            @foreach ($roles as $key)
                                                <option value="{{ $key }}"
                                                    @if ($key == in_array($key, $userRole)) selected @endif>{{ $key }}
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
                                        {!! Form::number('credits', null, ['placeholder' => 'Credits', 'class' => 'form-control']) !!}
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
            $('#user_form_edit').validate({
                        rules:{
                            name:{required:true},
                            email:{required:true,email:true},
                              username:{required:true},
                            'roles[]':{required:true},
                        },
                    });
        </script>
    @endsection
