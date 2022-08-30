@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Advertiser Subscription List') }}</strong>
                        <div class="pull-right">
                            {{-- <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a> --}}
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
                        <table class="table table-bordered table-responsive table-sm users-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>
                                    <th>Name</th>
                                    <th>Subscription id</th>
                                    <th>Category </th>
                                    <th>Amount </th>
                                    {{-- <th>Start Date </th> --}}
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
                                        {{-- <td>{{ $val->start }}</td> --}}
                                        <td >
                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('advertiser.subscriptiondetail', $val->id) }}">Detail</a>
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
                responsive: false
            });
        });
    </script>
@endsection
