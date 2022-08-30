<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,minimum-scale=1,user-scale=0">
    <!-- meta icon -->
    <link rel="shortcut icon" class="bg-primary" href="{{ asset('images/favicon.ico') }}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.62/jquery.inputmask.bundle.js"></script>
    <!-- jquery validation plugin -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/additional-methods.min.js"></script>
    <!-- jquery Datables plugin -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
     <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/date-1.1.2/sb-1.3.3/sp-2.0.1/sl-1.4.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/b-2.2.3/date-1.1.2/sb-1.3.3/sp-2.0.1/sl-1.4.0/datatables.min.js"></script> --}}

    <!-- Bootstrap Date-Picker Plugin -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}?v=2.0" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Google recaptcha -->
    <!-- <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_SITEKEY') }}"></script> -->
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-dark bg-white shadow-sm header-navbar-outer">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <img src="{{ asset('images/logo.png') }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"  data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li> <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i>
                            {{ __('Home') }}</a></li>
                        @guest
                            <li style="display:none;"><a class="nav-link" href="{{ route('advetiserlogin') }}"><i
                                        class="fa fa-plus"></i> {{ __('Advertiser Login') }}</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i
                                        class="fa fa-plus"></i> {{ __('Advertiser Login') }}</a></li>
                        @endguest
                        {{-- @hasrole('Advertise')
                            <li><a class="nav-link" href="{{ route('adviserdashboard') }}"><i
                                        class="fa fa-plus"></i> {{ __('Advertiser') }}</a></li>
                        @endhasrole --}}

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item" style="display: none;">
                                <a class="nav-link" href="{{ route('login') }}"><i class="fa fa-sign-in"></i>
                                    {{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"><i
                                            class="fa fa-user-plus"></i> {{ __('Attorney Registration') }}</a>
                                </li>
                            @endif
                        @else
                            {{-- @hasrole('attorney')
                            <li>
                                <a class="nav-link" href="{{route('attorneys.show', ['id' => Auth::user()->id])}}"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                            </li>
                        @endhasrole --}}
                            {{-- @hasrole('admin|super admin')
                                <li>
                                    <a class="nav-link" href="{{ route('admin') }}"><i class="fa fa-dashboard"></i>
                                        {{ __('Dashboard') }}</a>
                                </li>
                            @endhasrole
                            @hasrole('client')
                                <li>
                                    <a class="nav-link" href="{{ route('client.cases') }}"><i class="fa fa-book"></i>
                                        {{ __('Cases') }}</a>
                                </li>
                            @endhasrole --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user"></i> {{ Auth::user()->name }} <span
                                        class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @hasrole('admin|super admin')

                                    <a class="dropdown-item" href="{{ route('admin') }}"><i class="fa fa-dashboard"></i>
                                        {{ __('Dashboard') }}</a>
                                        <hr class="m-0">
                            @endhasrole
                            @hasrole('Advertise')
                            <a class="dropdown-item" href="{{ route('adviserdashboard') }}"><i
                                        class="fa fa-plus"></i> {{ __('Advertiser') }}</a>
                                        <hr class="m-0">
                            @endhasrole
                            @hasrole('client')

                                    <a class="dropdown-item" href="{{ route('client.cases') }}"><i class="fa fa-book"></i>
                                        {{ __('Cases') }}</a>
                                        <hr class="m-0">
                            @endhasrole

                                    @hasrole('attorney')
                                        <a class="dropdown-item"
                                            href="{{ route('attorneys.show', ['id' => Auth::user()->id]) }}">
                                            <i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</a>
                                            <hr class="m-0">
                                        <a class="dropdown-item" href="{{ route('cases.index') }}">
                                            <i class="fa fa-book" aria-hidden="true"></i> {{ __('Cases') }}
                                        </a>
                                        <hr class="m-0">
                                        <a class="dropdown-item" href="{{ route('fdd_tools') }}"><i
                                                class="fa fa-wrench"></i> {{ __('FDD Tools') }}</a>
                                                <hr class="m-0">
                                        <a class="dropdown-item" href="{{ route('ads_listing') }}"><i
                                                class="fa fa-gear"></i> {{ __('Services/Products') }}</a>
                                                <hr class="m-0">
                                        <a class="dropdown-item" href="{{ route('attorney.downloads') }}"><i
                                                class="fa fa-download"></i> {{ __('Downloads') }}</a>
                                                <hr class="m-0">
                                    @endhasrole
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        {{-- @hasrole('attorney')
                            <li>
                                <a class="nav-link" href="{{route('fdd_tools')}}"><i class="fa fa-wrench"></i> {{ __('FDD Tools') }}</a>
                            </li>
                             <!-- <li>
                                <a class="nav-link" href="{{route('resources')}}"><i class="fa fa-wrench"></i> {{ __('Resources') }}</a>
                            </li> -->
                           <li>
                                <a class="nav-link" href="{{route('ads_details')}}"><i class="fa fa-gear"></i> {{ __('Services/Products') }}</a>
                            </li>
                        @endhasrole --}}
                        <?php
                        $admin_email = $settings[0]->setting_value;
                        if (!$admin_email) {
                            $admin_email = env('APP_EMAIL');
                        }
                        ?>
                        {{-- @hasrole('attorney')
                            <li> <a class="nav-link" href="{{ route('attorney.downloads') }}"><i class="fa fa-download"></i> {{ __('Downloads') }}</a></li>
                            <!-- <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-download"></i> Downloads <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('attorney.downloads') }}">
                                        <i class="fa fa-download" aria-hidden="true"></i> {{ __('Draft Document Downloads') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('fdd_tools.pdf_tools_downloads') }}">
                                        <i class="fa fa-download" aria-hidden="true"></i> {{ __('FDD Tools Downloads') }}
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="fa fa-download" aria-hidden="true"></i> {{ __('Branded Office Downloads') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('get_practice_aids_downloads') }}">
                                        <i class="fa fa-download" aria-hidden="true"></i> {{ __('Branded Practice Downloads') }}
                                    </a>
                                </div>
                            </li> -->
                        @endhasrole --}}
                        <!-- <li> <a class="nav-link" href="mailto:{{ $admin_email }}"><i class="fa fa-envelope"></i> {{ __('Email Us') }}</a></li> -->
                        <li> <a class="nav-link" href="{{ route('email_us') }}"><i class="fa fa-envelope"></i>
                                {{ __('Email Us') }}</a></li>
                        @hasrole('admin|super admin|attorney')
                            <li> <a class="nav-link" href="{{ url('/forums') }}"
                                    target="_blank">{{ __('Forums') }}</a></li>
                        @endhasrole
                    </ul>
                </div>
            </div>
        </nav>
        <!-- super admin sidebar -->
        @hasanyrole('super admin|admin')
            @if (request()->is('/') || request()->is('home'))
                <main class="py-4">
                @else
                    <main class="py-4 container" id="admin_main">
                        <!-- add id to main for admin|super admin -->
                        <div class="collapse d-md-flex  min-vh-100 main_sidebar_outer mb-3" id="sidebar">
                            <ul class="nav main-nav flex-column flex-nowrap ">
                                <li class="nav-item">
                                    <h2 class="sidebar-title">{{ Auth::user()->name }}</h2>
                                </li>
                                <li class="nav-item submenu1">
                                    <a class="nav-link" href="{{ route('admin') }}"><i class="fa fa-dashboard"></i>
                                        {{ __('Dashboard') }}</a>
                                    <a class="nav-link collapsed main-menu-item submenu1" href="#submenu1" data-toggle="collapse" 
                                        data-target="#submenu1" > <i class="fa fa-cogs" aria-hidden="true" ></i> <span
                                            class="icon-name">Manage</span></a>
                                            @php
                                                $manage=['clients','page','users','attorneys','roles','testimonials','pages','settings','pdfcredits','minmumwage','judges','customeruploads','magistrates','clerks','counties','courts','divisions','attorneytableactive','attorneytableactivebeforeedit'];
                                            @endphp
                                    {{-- <div class="collapse submenu_outerbox @if( Request::is($manage)) {{ 'show' }}  @endif" id="submenu1" aria-expanded="false"> --}}
                                    <div class="collapse submenu_outerbox @if(in_array(Request::segment(1), $manage)) {{ 'show' }}  @endif" id="submenu1" aria-expanded="false">
                                       <ul class="flex-column nav sidebar_submenu">
                                            @hasrole('super admin')
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('users.index') }}">
                                                        <i class="fa fa-users"></i>Users</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('all.clients') }}">
                                                        <i class="fa fa-users"></i> Clients</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('attorneys.index') }}">
                                                        <i class="fa fa-users"></i> Attorneys</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                                        <i class="fa fa-universal-access "></i> Roles</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('prices.index') }}">
                                                    <i class="fa fa-dollar"></i> Pricing</a>
                                            </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('testimonials.index') }}">
                                                        <i class="fa fa-quote-left"></i> Testimonial</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link  @if( in_array(Request::segment(1), ['pages','page']) ) {{'active'}} @endif" href="{{ route('pages.index') }}">
                                                        <i class="fa fa-file-text"></i> Pages</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('settings.index') }}">
                                                        <i class="fa fa-cog"></i> Settings</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('pdfcredits.index') }}">
                                                        <i class="fa fa-credit-card"></i> PDF Credits</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('minmumwage.index') }}">
                                                        <i class="fa fa-money"></i> Minimum wage</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('documenttable.index') }}">
                                                    <i class="fa fa-file-text"></i> Document Table</a>
                                            </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('judges.index') }}">
                                                        <i class="fa fa-users"></i> Judges</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('customeruploads.index') }}">
                                                        <i class="fa fa-file"></i> Orchard Submissions</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('magistrates.index') }}">
                                                        <i class="fa fa-users"></i> Magistrates</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('clerks.index') }}">
                                                        <i class="fa fa-users"></i> Clerks</a>
                                                </li>
                                                <!--  <li class="nav-item">
                                                <a class="nav-link" href="{{ route('states.index') }}">
                                                    <i class="fa fa-flag"></i> States</a>
                                            </li> -->
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('counties.index') }}">
                                                        <i class="fa fa-flag"></i> Counties</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('courts.index') }}">
                                                        <i class="fa fa-map"></i> Courts</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('divisions.index') }}">
                                                        <i class="fa fa-map"></i> Divisions</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link {{ Request::segment(1) === 'attorneytableactive' || Request::segment(1) === 'attorneytableactive-filtering' ? 'active' : '' }}"
                                                        href="{{ route('attorneytableactive.index') }}">
                                                        <i class="fa fa-table"></i> Attorney Table Active</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('attorneytableactivebeforeedit.index') }}">
                                                        <i class="fa fa-undo"></i> Restore Attorney Table Active
                                                        Records</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('stripeplans.index') }}">
                                                        <i class="fa fa-cc-stripe"></i> Stripe Plans</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('demos.index') }}">
                                                        <i class="fa fa-info-circle"></i> Demos</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('cases.all') }}">
                                                        <i class="fa fa-book" aria-hidden="true"></i> Registered Cases</a>
                                                </li>
                                                <!-- <li class="nav-item">
                                                <a class="nav-link" href="{{ route('permissions.index') }}">
                                                    <i class="fa fa-product-hunt"></i> Permissions</a>
                                            </li> -->
                                            @endhasrole
                                            @hasrole('admin')
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('attorneys.index') }}">
                                                        <i class="fa fa-users"></i> Attorneys</a>
                                                </li>
                                            @endhasrole
                                        </ul>
                                    </div>
                                </li>
                                @hasrole('super admin')
                                    {{-- Advertiser link start --}}
                                    <li class="nav-item advertiser">
                                        <a class="nav-link collapsed main-menu-item advertiser"  href="#advertiser" data-toggle="collapse" 
                                            data-target="#advertiser"> <i class="fa fa fa-bullhorn " aria-hidden="true"></i>
                                            <span class="icon-name">Advertiser</span></a>
                                            @php
                                                $advertiser=['advertiser-services','service' , 'advertisers','advertise','subscription-listing','advertiser-bids'];
                                            @endphp
                                        <div class="collapse submenu_outerbox @if( in_array(Request::segment(1), $advertiser)) {{ 'show' }}  @endif"
                                            id="advertiser" aria-expanded="false">
                                            <ul class="flex-column nav sidebar_submenu">
                                                <li class="nav-item  ">
                                                    <a class="nav-link {{ Request::segment(1) === 'advertisers' ? 'active' : '' }}"
                                                        href="{{ route('advertiser.all') }}">
                                                        <i class="fa fa-list"></i>Advertiser List</a>
                                                </li>
                                                <li class="nav-item  ">
                                                    <a class="nav-link {{ (in_array(Request::segment(1),['advertiser-services','service'])) ? 'active' : '' }}"
                                                        href="{{ route('advertiser-services.index') }}">
                                                        <i class="fa fa-file-text"></i> Services</a>
                                                </li>
                                                <li class="nav-item  ">
                                                    <a class="nav-link {{ Request::segment(1) === 'subscription-listing' ? 'active' : '' }}"
                                                        href="{{ route('advertiser.subscription_listing') }}">
                                                        <i class="fa fa-cc-stripe"></i> Subscription</a>
                                                </li>
                                                <li class="nav-item  ">
                                                    <a class="nav-link {{ Request::segment(1) === 'advertiser-bids' ? 'active' : '' }}"
                                                        href="{{ route('advertiser.bids') }}">
                                                        <i class="fa fa-gavel"></i> Bids</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    {{-- Advertiser link end --}}
                                @endhasrole
                                @hasrole('super admin')
                                    <li class="nav-item submenu2">
                                         @php
                                             $report=['show-user-reports','show-attorney-reports','show-advertiser-reports','show-client-reports','show-case-reports','show-user-login-reports','show-failed-user-login-reports'];
                                         @endphp
                                        <a class="nav-link collapsed main-menu-item submenu2" href="#submenu2" data-toggle="collapse" 
                                            data-target="#submenu2"> <i class="fa fa-line-chart" aria-hidden="true"></i> <span
                                                class="icon-name">Reports</span></a>
                                        <div class="collapse submenu_outerbox @if( in_array(Request::segment(1), $report) ) {{'show'}} @endif" id="submenu2" aria-expanded="false">
                                            <ul class="flex-column nav sidebar_submenu">
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('get_user_reports') }}"><i
                                                            class="fa fa-users"></i>User Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('get_attorney_reports') }}"><i
                                                            class="fa fa-users"></i>Attorney Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('get_advertiser_reports') }}"><i
                                                            class="fa fa-users"></i>Advertiser Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('get_client_reports') }}"><i
                                                            class="fa fa-users"></i>Client Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ route('get_case_reports') }}"><i
                                                            class="fa fa-book" aria-hidden="true"></i>Case Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('get_user_login_reports') }}"><i
                                                            class="fa fa-check-circle"></i>Success Login Reports</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('get_failed_user_login_reports') }}"><i
                                                            class="fa fa-exclamation-triangle"></i>Failed Login Reports</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item submenu4">
                                        <a class="nav-link collapsed main-menu-item submenu4" href="#submenu4" data-toggle="collapse" 
                                            data-target="#submenu4"> <i class="fa fa-cc-stripe" aria-hidden="true"></i> <span
                                                class="icon-name">Stripe</span></a>
                                        <div class="collapse submenu_outerbox @if(Request::is(['show-all-stripe-payments','show-all-stripe-refunds']) ) {{'show'}} @endif" id="submenu4" aria-expanded="false">
                                            <ul class="flex-column nav sidebar_submenu">
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('show_all_stripe_payments') }}"><i
                                                            class="fa fa-cc-stripe"></i> Payments</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('show_all_stripe_refunds') }}"><i
                                                            class="fa fa-undo"></i> Refunds</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('admin.show_users_subscriptions') }}"><i class="fa fa-cc-stripe"
                                                aria-hidden="true"></i> {{ __('Users Subscriptions') }}</a></li>
                                    <!-- <li class="nav-item">
                                <a class="nav-link collapsed main-menu-item" href="#submenu3" data-toggle="collapse"  data-target="#submenu3"> <i class="fa fa-cc-stripe" aria-hidden="true"></i> <span class="icon-name">Payments</span></a>
                                <div class="collapse submenu_outerbox" id="submenu3" aria-expanded="false">
                                    <ul class="flex-column nav sidebar_submenu">
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('show_all_payments') }}"><i class="fa fa-cc-stripe" aria-hidden="true"></i>All Payments</a>
                                            <a class="nav-link" href="{{ route('show_all_stripe_payments') }}"><i class="fa fa-cc-stripe" aria-hidden="true"></i>All Stripe Payments</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('show_case_payments') }}"><i class="fa fa-cc-stripe" aria-hidden="true"></i>Case Payments</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('show_user_credits_payments') }}"><i class="fa fa-cc-stripe" aria-hidden="true"></i>User Credits Payments</a>
                                        </li>
                                    </ul>
                                </div>
                            </li> -->
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('casepaymentpackages.index') }}"><i class="fa fa-product-hunt"
                                                aria-hidden="true"></i> {{ __('Case Packages') }}</a></li>
                                    <li class="nav-item"><a class="nav-link"
                                            href="{{ route('admin.get_project_backups') }}"><i class="fa fa-file-archive-o"
                                                aria-hidden="true"></i> {{ __('Project Backups') }}</a></li>
                                @endhasrole
                                <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                             document.getElementById('logout-form-sidebar').submit();"><i
                                            class="fa fa-sign-out"></i><span class="icon-name">Logout</span></a></li>
                                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                        <!-- end of super admin sidebar -->
            @endif
        @else
            <main class="py-4">
            @endhasrole
            @include('layouts.message')
            @yield('content')
        </main>
        <!-- custom footer goes here -->
        <div class="col-sm-12 custom-footer">© {{ date('Y') }} First Draft Data LLC</div>
    </div>
    <script>
      var menuId=  $('div.submenu_outerbox.show').attr('id');
    
      if(menuId){
         $('#sidebar ul.nav.main-nav li.nav-item.'+menuId+' a.'+menuId+'').removeClass('collapsed').attr('aria-expanded','true');
      }

//         		
                // $("document").ready(function() {
                //      $('.dataTables_filter input[type="search"]').addClass('form-control ');
                // });
         var el =$("input:text:visible:first")[0];

  if (typeof el.selectionStart == "number") {
      el.selectionStart = el.selectionEnd = el.value.length;
  } else if (typeof el.createTextRange != "undefined") {           
      var range = el.createTextRange();
      range.collapse(false);
      range.select();
  }





	
    </script>
</body>
</html>
