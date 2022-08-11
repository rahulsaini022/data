@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Advertiser Subscription List') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('adviserdashboard') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body table-sm table-responsive">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>
                                    <th>Name</th>

                                    <th>Subscription id</th>
                                    <th>Category </th>
                                    <th>Amount </th>
                                    <th> Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($subscriptions as $key => $val)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $val->name }}</td>

                                        <td>{{ $val->stripe_id }}</td>
                                        <td>{{ $val->category_name }}</td>
                                        <td>$ {{ $val->amount }}.00</td>
                                        <td> {{ $val->start }}</td>
                                        <td> {{ $val->end }}</td>
                                        <td style="width: 20%">
                                            <!-- <a class="btn btn-primary mb-1"
                                                 href="{{ route('advertiser.subscriptiondetail', $val->id) }}">Detail</a> -->
                                            @if ($user->subscription($val->plan_name)->onGracePeriod())
                                                <!-- <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('resume-main-form').submit();">
                                                    {{ __('Resume') }}
                                                </a> -->
                                                <form id="resume-main-form"
                                                    action="{{ route('advertiser.resume_subscription') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="license_type"
                                                        value="{{ $val->plan_name }}">
                                                    <button onclick="return confirm('Do you wand to resume your Subscription')" class="btn btn-primary"
                                                        type="submit">{{ __('Resume') }}</button>
                                                </form>
                                            @else
                                                <!-- <a class="btn btn-primary" href="" onclick="event.preventDefault(); document.getElementById('cancel-main-form').submit();">
                                                        {{ __('Cancel') }}
                                                    </a> -->

                                                <form id="cancel-main-form"
                                                    action="{{ route('advertiser.cancel_subscription') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="license_type"
                                                        value="{{ $val->plan_name }}">
                                                    <button  onclick="return confirm('Do you wand to cancel your Subscription')" class="btn btn-primary"
                                                        type="submit">{{ __('Cancel') }}</button>
                                                </form>
                                            @endif
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete this user? All data related to this user will be deleted.");
            if (x)
                return true;
            else
                return false;
        }
        $(document).ready(function() {
            $('.users-table').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endsection
