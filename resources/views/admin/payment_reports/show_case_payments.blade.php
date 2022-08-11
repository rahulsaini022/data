@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('All Case Payments') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('admin') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">
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

                    <div class="row mb-4 p-4">
                        <div class="col-sm-2">
                          <h5>Filter By</h5>
                        </div>
                        <div class="col-sm-10 text-right">
                            <a href="{{ route('show_case_payments') }}" class="btn btn-success mb-1">All</a>

                            <a class="btn btn-success mb-1" href="{{ route('get_current_month_case_payments') }}"> This Month
                            </a>

                            <a class="btn btn-success mb-1" href="{{ route('get_month_based_case_payments',['months'=>'3']) }}"> Last 3 Month
                            </a>

                            <a class="btn btn-success mb-1" href="{{ route('get_month_based_case_payments',['months'=>'6']) }}"> Last 6 Month
                            </a>
                        </div>
                        <div class="col-sm-12 mt-4 payment-filter-form-main">
                            <form id="custom-date-form" action="{{ route('get_date_based_case_payments') }}" method="POST" autocomplete="off">
                                <div class="row filter-form-inputs-section">
                                    @csrf
                                    <div class="col-sm-4 column-box-width">
                                      <label for="from_date" class="col-form-label text-sm-left">{{ __('From Date*') }}</label>
                                        <input type="text" name="from_date" class="form-control hasDatepicker">
                                    </div>
                                    <div class="col-sm-4 column-box-width">
                                      <label for="to_date" class="col-form-label text-sm-left">{{ __('To Date*') }}</label>
                                        <input type="text" name="to_date" class="form-control hasDatepicker">
                                    </div>

                                    <div class="col-sm-4 column-box-width">
                                      <label class="col-form-label text-sm-left">{{ __('Filter') }}</label>
                                        <button type="submit" id="filter_by_date" class="form-control btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered case-payments-table payments-history-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Date</th>

                          <th>Email</th>

                          <th>Name</th>
                          
                          <th>Transaction ID</th>

                          <th>Transaction Amount</th>

                          <th>Notes</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($allpayments as $payment)
                        <tr>

                          <td>{{ ++$i }}</td>
                          <td>{{ date('m-d-Y H:i:s',strtotime($payment->created_at)) }}</td>
                          <td>{{ $payment->email }}</td>
                          <td>{{ $payment->name }}</td>
                          <td>{{ $payment->stripe_transaction_id }}</td>
                          <td>{{ $payment->amount }}</td>
                          <td>{{ $payment->notes }}</td>

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
  // function ConfirmDelete()
  // {
  //     var x = confirm("Are you sure you want to delete this Pricing");
  //     if (x)
  //         return true;
  //     else
  //       return false;
  // }

  $(document).ready( function () {
    $('.case-payments-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );

  $(".hasDatepicker").datepicker({
      startDate: "01/01/1901",
      endDate: '+0d',
  });

</script>
@endsection