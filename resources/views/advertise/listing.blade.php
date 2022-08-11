@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center fdd-tools-main">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>{{ __('Manage Listings') }}</strong>
                        <div class="pull-right">
                            <a class="btn btn-primary" href="{{ route('adviserdashboard') }}"> Back</a>
                        </div>
                    </div>
                    <div class="card-body">
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
                        <div class="row">
                            <div class="col-sm-12 fdd-quick-child-support-section">
                                <form method="POST" action="{{ route('advertiser.listfilter') }}"
                                    id="computation_sheet_form">
                                    @csrf
                                    <input type="hidden" name="sheet_state" value="35">
                                    <div class="row">
                                        <div class="col-sm-3 column-box-width">
                                            <select id="sheet_state" name="county" class="form-control" autofocus="">
                                                <option value="">Choose County</option>
                                                @foreach ($counties as $key => $val)
                                                    <option value="{{ $val->id }}" <?php if (isset($county) && $county != '' && $county == $val->id) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $val->county_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-3 column-box-width">
                                            <select id="sheet_custody" name="category" class="form-control" autofocus="">
                                                <option value=""> Choose Category</option>
                                                @foreach ($categories as $key => $val)
                                                    <option value="{{ $val->id }}" <?php if (isset($category) && $category != '' && $category == $val->id) {
                                                        echo 'selected';
                                                    } ?>>
                                                        {{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- <div class="col-sm-3 column-box-width prefill-check">
                                            <input type="checkbox" name="chk_prefill" id="chk_prefill" value="1" checked=""><label for="chk_prefill" class="chk_prefill" >Prefill with my last submission.</label>
                                        </div>  -->
                                        <input type="hidden" name="chk_prefill" value="0">
                                        <div class="col-sm-3 column-box-width">
                                            <input type="submit" id="computation-btn"
                                                class="btn btn-success btn-computation new-btn new-btn-green"
                                                value="Submit">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive fdd-computations-list-table">
                            <thead>
                                <tr>
                                    <!-- <th>Sno.</th> -->
                                    <th>Listing Priority</th>
                                    <th>Premium Bid</th>
                                    <th> County</th>
                                    <th> Title</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <!-- to show sole/shared sheet data -->
                                @foreach ($listing_data as $key => $val)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td><span>&#36;</span> {{ $val->premium_bid_amount ?? '0' }}
                                        </td>
                                        <td> {{ $val->county_name }}</td>
                                        <td class="wid"> {{ $val->title }}</td>
                                        <td class="wid"> {{ $val->catgory_name }}</td>
                                        <td style="min-width: 230px">
                                            @if ($val->advertiser_id == $advertise_id)
                                                <a class="btn btn-primary mb-1"
                                                    href="{{ route('listing.edit', $val->id) }}">Edit</a>
                                                @if ($val->premium_bid_amount == '')
                                                    <a class="btn btn-success mb-1"
                                                        href="{{ route('advertiser.createbid', $val->id) }}">Bid</a>
                                                @endif
                                                @if ($val->status == 1)
                                                    <a class="btn btn-danger mb-1"
                                                        onclick="return confirm('Do you want to deactivate')"
                                                        href="{{ route('advertise.status', ['id' => $val->id, 'status' => 0]) }}">Deactivate</a>
                                                @else
                                                    <a class="btn btn-success mb-1"
                                                        onclick="return confirm('Do you want to activate')"
                                                        href="{{ route('advertise.status', ['id' => $val->id, 'status' => 1]) }}">Activate</a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/polyfiller.js') }}"></script>
    <script type="text/javascript">
        $('.fdd-computations-list-table').dataTable({
            bFilter: false,
            bInfo: true
        });

        function ConfirmDeActivate() {
            var x = confirm("Are you sure you want to deactivate this record?");
            if (x)
                return true;
            else
                return false;
        }

        function ConfirmActivate() {
            var x = confirm("Are you sure you want to activate this record?");
            if (x)
                return true;
            else
                return false;
        }
    </script>
@endsection
