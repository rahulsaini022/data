@extends('layouts.app')

@section('content')
{{-- @foreach (auth()->user()->attorney_county as $county)
     
@endforeach
  {{ $county->county_name}} --}}
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Dashboard') }}</strong></div>
                <div class="card-body">
                     @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif

                    <div class="row"> 
                        <div class="col-md-12">
                            <h2>{{$attorney->name}}</h2>
                            <p>This is your dashboard at First Draft Data. From here, you manage your account, your client information, use tools, etc. Here is where you register your clients because clients are not allowed to register themselves.</p>
                           <div class="row advertiser-dash">
                            <div class="col-sm-6 ">
                                <a class="btn btn-info  my-2 register-case-btn " href="{{route('prospects.index')}}">
                                    {{ __('Prospects »') }}
                                </a>
                            </div>
                            <div class="col-sm-6 ">
                                <a class="btn btn-info  my-2  float-sm-right" href="{{route('attorneys.edit', ['id' => Auth::user()->id])}}">
                                    {{ __('Edit Account Info »') }}
                                </a>
                            </div>
                            <div class="col-sm-6 ">
                                <a class="btn btn-info  my-2 register-case-btn " href="{{route('cases.index')}}">
                                    {{ __('Cases »') }}
                                </a>
                            </div>
                            <div class="col-sm-6 ">
                                <a class="btn btn-info  my-2 register-case-btn  float-sm-right" href="{{route('attorneys.state_seat_license')}}">
                                    {{ __('State Seat Licenses »') }}
                                </a>
                            </div>
                              <div class="col-sm-6">
                                <a class="btn btn-info my-2 text-center register-case-btn " href="{{ route('change.password') }}">
                                    {{ __(' Change Password »') }}
                                </a>
                           </div>
                           </div>
                        </div>
                        <div class="col-md-8 offset-md-4 ">
                            <h5 class="text-left">Practice Aids</h5>
                            
                           
                                <form method="POST" action="{{ route('draft_practice_aids') }}">
                                    @csrf
                                   <div class="input-group mb-3">
                                        <select id="select_practice_aid" name="select_practice_aid" class="form-control col-md-4 custom-select letter_dropdown"  style=" white-space: nowrap;overflow: hidden;text-overflow: ellipsis;" required="">
                                            <option value="">Select</option>
                                            @foreach($practice_aids as $practice_aid)
                                                <option value="{{$practice_aid->package_name}}">{{$practice_aid->package_name}}</option>

                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                        <input type="submit" class="btn btn-success mb-2" name="submit" value="Draft/Download">
                                    </div>
                                    </div>
                                </form>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="delay-message-myModal" class="delay-message-modal"><div class="delay-message-modal-content"><span class="delay-message-close">&times;</span><p>Your drafts will be available in your download directory soon.</p><div><a class="btn btn-danger delay-message-close-btn"> Close</a><a class="btn btn-info ml-2" href="{{ route('attorney.downloads') }}"> Go to Downloads</a></div></div></div>
</div>
<script type="text/javascript">

</script>
@endsection