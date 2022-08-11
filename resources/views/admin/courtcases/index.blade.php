@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Registered Cases Management') }}</strong>
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


                    <table class="table table-bordered courtcases-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>State</th>
                          
                          <th>County</th>

                          <th>Court Case Number</th>

                          <th>Customer Attorney</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $courtcases)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td>{{ $courtcases->courtcase_state_name }}</td>

                          <td>{{ $courtcases->courtcase_county_name }}</td>

                          <td>{{ $courtcases->case_number }}</td>

                          <td>{{ $courtcases->name }}</td>

                          <td>
                            @if($courtcases->payment_status=='1')
                                {!! Form::open(['method' => 'POST','route' => ['cases.change_case_payment_status',$courtcases->id],'style'=>'display:inline']) !!}

                                  {{ Form::hidden('payment_status', '0') }}

                                  {!! Form::submit('Deactivate', ['class' => 'btn btn-danger confirm-deactivate', 'onclick' => 'return ConfirmDelete(event);']) !!}

                                {!! Form::close() !!}
                            @else
                                {!! Form::open(['method' => 'POST','route' => ['cases.change_case_payment_status',$courtcases->id],'style'=>'display:inline']) !!}

                                  {{ Form::hidden('payment_status', '1') }}

                                  {!! Form::submit('Activate', ['class' => 'btn btn-success confirm-activate', 'onclick' => 'return ConfirmDelete(event);']) !!}

                                {!! Form::close() !!}
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

 

  $(document).ready( function () {
    $('.courtcases-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection