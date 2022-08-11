@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center home-page">
        <div class="col-md-12">
            <div class="card">
                <!-- <div class="card-header">Home</div> -->

                <!-- <div class="card-body jumbotron" align="center"> -->
                <div class="card-body" align="center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-sm-6 SignIn-left">
                            <h2>WELCOME <span>TO FIRST DRAFT DATA </span></h2>
                            <p>Providing Data Services To Lawyers </br> And Legal Professionals.</p>  
                            <a class="btn btn-info new-btn mr-2" href="{{url('/page/pricing')}}">Pricing</a>
                            <a class="btn btn-info new-btn new-btn-green" href="{{url('/page/what-we-offer')}}">What We Offer</a>
                            @if(count($data) > 0)                   
                                <p class="testimonial-title" style=""><strong><u>Our Client Experiences</u></strong></p>
                                <div class="owl-carousel owl-theme">
                                    @foreach($data as $testimonial)
                                        <div class="item">
                                            <p>"{{$testimonial->description}}"</p>
                                            <h4 class="text-center author-name">-{{$testimonial->author_name}}</h4>
                                            <h4 class="text-center author-position">({{$testimonial->author_position}})</h4>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @guest
                        <div class="col-sm-6 SignIn-form">
                            <h2 style="">Sign in</h2>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address or Username') }}</label> -->
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Address or Username" style="border-radius: 0px;">

                                        @error('email')
                                            @if($errors->has('user_id')  )
                                                <span class="invalid-feedback" role="alert">
                                                    
                                                        @if(($errors->first('role') === 'attorney'))
                                                       <strong>{{ $message }} <a class="btn btn-link text-primary" href="{{ route('attorneys.subscription', ['id' => $errors->first('user_id')]) }}">Click here</a>to Subscribe.</strong>
                                                        @elseif (($errors->first('role') === 'Advertise'))
                                                        <strong>Your Advertiser account not active.Please contact admin or register as advertiser.</strong>
                                                      @else
                                                       <strong>Your  account not active yet.Please contact admin </strong>
                                                        @endif
                                                        
                                                        
                                                </span>
                                            @else
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @endif
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <!-- <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label> -->
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" style="border-radius: 0px;">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form__links">
                                        <label class="rememberpassword">
                                            <input class="" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>{{ __('Remember Me') }}
                                        </label>

                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}" style="color: #044481">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                        <button type="submit" class="btn btn-primary new-btn" style="width: 100%;">
                                            {{ __('Login') }}
                                        </button>

                                        <p class="mt-3">Registered Attorneys Get Unlimited Quick Child Support Computation Sheets!</p>

                                        <a class="btn btn-info new-btn new-btn-green" href="{{ route('register') }}" style="width:100%;">Attorney Registration</a>

                                </div>
                            </form>

                            <div class="col-sm-12 mt-5">
                                <p>Not an Attorney/Legal Professional? <br> <a href="{{url('/page/how-fdd-can-save-you-money')}}">Click here</a> to see how <br> FDD can save you money.</p>
                            </div>
                            <a href="{{ route('advertise') }}" class="btn btn-primary nextBtn">Advertise to Ohio Attorneys on FDD</a> 
                        </div>
                        @else
                        <div class="col-sm-6 SignIn-form">
                            <h2 style="">{{Auth::user()->name}}</h2>
                            @hasrole('attorney')

                                <a class="btn btn-info new-btn mb-2" style="width: 100%;" href="{{route('attorneys.show', ['id' => Auth::user()->id])}}">
                                {{ __('Manage Attorney Account »') }}

                                </a>
                            @endhasrole
                                <p class="mt-3">Registered Attorneys Get Unlimited Quick Child Support Computation Sheets!</p>
                                <a class="btn btn-danger new-btn new-btn-danger" style="width: 100%;" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- owl-carousel -->
    <link href="{{ asset('owl-carousel/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('owl-carousel/css/owl.theme.default.min.css') }}" rel="stylesheet">
    <script src="{{ asset('owl-carousel/js/owl.carousel.js') }}"></script>
    
    <script type="text/javascript">
        $('.owl-carousel').owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            autoplay:true,
            autoplayTimeout:3000,
            autoplayHoverPause:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        })
    </script>
</div>
@endsection
