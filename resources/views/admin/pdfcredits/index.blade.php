@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Pdf Credits Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('pdfcredits.create') }}"> Create New Pdf Credit</a>

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


                    <table class="table table-bordered pdfcredits-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Number of Credits</th>

                          <th>Purchase Price</th>

                          <th>Discount</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $pdfcredit)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('pdfcredits.show',$pdfcredit->id) }}">{{ $pdfcredit->number_of_credits }}</a></td>
                          
                          <td>${{ $pdfcredit->purchase_price }}</td>

                          <td>${{ $pdfcredit->discount }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('pdfcredits.edit',$pdfcredit->id) }}">Edit</a>

                            {!! Form::open(['method' => 'DELETE','route' => ['pdfcredits.destroy', $pdfcredit->id],'style'=>'display:inline']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                            {!! Form::close() !!}

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
  function ConfirmDelete()
  {
      var x = confirm("Are you sure you want to delete this Pdf Credit");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.pdfcredits-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection