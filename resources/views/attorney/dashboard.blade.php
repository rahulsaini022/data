@extends('layouts.app')

@section('content')
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
                            <p>
                                <a class="btn btn-info register-case-btn pull-right" href="{{route('prospects.index')}}">
                                    {{ __('Prospects »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info" href="{{route('attorneys.edit', ['id' => Auth::user()->id])}}">
                                    {{ __('Edit Account Info »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info register-case-btn pull-right" href="{{route('cases.index')}}">
                                    {{ __('Cases »') }}
                                </a>
                            </p>
                            <p>
                                <a class="btn btn-info register-case-btn" href="{{route('attorneys.state_seat_license')}}">
                                    {{ __('Seat Licenses »') }}
                                </a>
                            </p>
                        </div>
                        <div class="col-md-12 text-center">
                            <h5 class="colmd-12">Practice Aids</h5>
                            <div class="col-md-3"></div>
                            <div class="col-md-6" style="display: contents;">
                                <form method="POST" action="{{ route('draft_practice_aids') }}">
                                    @csrf
                                    <div class="">
                                        <select id="select_practice_aid" name="select_practice_aid" class="form-control col-md-3 custom-select letter_dropdown mb-2" required="">
                                            <option value="">Select</option>
                                            @foreach($practice_aids as $practice_aid)
                                                <option value="{{$practice_aid->package_name}}">{{$practice_aid->package_name}}</option>

                                            @endforeach
                                        </select>
                                        <input type="submit" class="btn btn-success mb-2" name="submit" value="Draft/Download">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3"></div>
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

// function showDelayMessage(){
//     if($('#select_practice_aid').val()){
//         var modal = document.getElementById("delay-message-myModal");
//         modal.style.display = "block";

//         // Get the <span> element that closes the modal
//         var span = document.getElementsByClassName("delay-message-close")[0];

//         // When the user clicks on <span> (x), close the modal
//         span.onclick = function() {
//             modal.style.display = "none";
//         }

//         // Get the <span> element that closes the modal
//         var btn = document.getElementsByClassName("delay-message-close-btn")[0];

//         // When the user clicks on <span> (x), close the modal
//         btn.onclick = function() {
//             modal.style.display = "none";
//         }
//     }
//   return true;
// }
</script>
@endsection