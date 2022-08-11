@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center Admin-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Bids List') }}</strong>
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
                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>

                                    <th>Advertiser Name</th>

                                    <th>Transaction Id</th>
                                    <th>Bid Amount</th>
                                    <th>Bid Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($bids as $bid)
                                    <tr>
                                        <td>{{ ++$i }}</td>

                                        <td>{{ $bid->full_name }}</td>
                                        <td>{{ $bid->txn_id }}</td>
                                        <td>${{ $bid->listing_bid_amount }}</td>
                                        <td>{{ date('m/d/Y ', strtotime($bid->listing_bid_date)) }}</td>

                                        <td style="width: 20%">
                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('bids.detail', $bid->id) }}">Detail</a>
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
        $(document).ready(function() {
            $('.users-table').DataTable({
                pageLength: 10,
                responsive: false
            });
        });
    </script>
@endsection
