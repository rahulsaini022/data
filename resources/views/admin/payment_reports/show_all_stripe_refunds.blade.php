@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('All Stripe Refunds') }}</strong>
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

                    <table class="table table-bordered all-payments-table payments-history-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Date</th>

                          <th>Refund ID</th>

                          <th>Refund Amount</th>

                          <th>Refund Status</th>
                          
                          <th>Reason</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($allstriperefunds->data as $refund)
                        <tr>

                          <td>{{ ++$i }}</td>
                          <td>{{ date('m-d-Y H:i:s',$refund->created) }}</td>
                          <td>{{ $refund->id }}</td>
                          <td>${{ $refund->amount/100 }}</td>
                          <td>{{ ucwords($refund->status) }}</td>
                          <td>{{ $refund->reason }}</td>

                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    @if($allstriperefunds->has_more)
                      <a class="btn btn-info pull-right" href="{{route('show_all_stripe_payments', ['last_id' => $refund->id])}}"> Next</a>
                    @else
                      @if(isset($_GET['last_id']))
                        <a class="btn btn-info pull-right" href="{{route('show_all_stripe_payments')}}"> Back</a>
                      @endif
                    @endif
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
    $('.all-payments-table').DataTable({
        pageLength: 50,
        responsive: true,
        paging:   false,
    });

    // var href = window.location.href;
    // $('#admin_main #sidebar a[href="' + href + '"]').addClass('active');
    // $('#admin_main #sidebar a[href="' + href + '"]').closest('.submenu_outerbox').addClass('show');
    
  } );

  $(".hasDatepicker").datepicker({
      startDate: "01/01/1901",
      endDate: '+0d',
  });

  // function filterByMonths(months){
  //   var token= $('input[name=_token]').val();
  //     $.ajax({
  //         url:"{{route('get_current_month_all_payments')}}",
  //         method:"POST",
  //         dataType: 'json',
  //         data:{
  //             months: months, 
  //             _token: token, 
  //         },
  //         success: function(data){
  //           // console.log(data);
  //           if(data=='null' || data==''){
  //               alert('No data found');
  //           } else {
  //               var i=1;
  //               var html='';
  //               for(j=0; j < data.length; j++){
  //                   var html=html+"<tr>";
  //                   html=html+"<td>"+i+"</td>";
  //                   html=html+"<td>"+data[j]['created_at']+"</td>";
  //                   html=html+"<td>"+data[j]['email']+"</td>";
  //                   html=html+"<td>"+data[j]['name']+"</td>";
  //                   html=html+"<td>"+data[j]['stripe_transaction_id']+"</td>";
  //                   html=html+"<td>"+data[j]['amount']+"</td>";
  //                   html=html+"<td>"+data[j]['notes']+"</td>";
  //                   ++i;
  //               }
  //               $('.all-payments-table tbody').html(html);
  //           }
            
  //         }
  //     });
  // }
</script>
@endsection