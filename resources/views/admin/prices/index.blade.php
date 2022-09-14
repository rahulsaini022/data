@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Pricing Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('prices.create') }}"> Create New Pricing</a>

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


                    <table class="table table-bordered prices-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Title</th>

                          <th>Full Price</th>
                          
                          <th>Adjudicator Price</th>

                          <th>Law Clinic Price</th>

                          <th>Legal Aid Price</th>

                          <th>Discount</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $price)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('prices.show',$price->id) }}">{{ $price->title }}</a></td>

                          <td>${{ $price->full_price }}</td>
                          
                          <td>${{ $price->adjudicator_price }}</td>

                          <td>${{ $price->law_clinic_price }}</td>

                          <td>${{ $price->legal_aid_price }}</td>

                          <td>${{ $price->discount }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('prices.edit',$price->id) }}">Edit</a>

                            {!! Form::open(['method' => 'DELETE','route' => ['prices.destroy', $price->id],'style'=>'display:inline']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

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
      var x = confirm("Are you sure you want to delete this Pricing");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.prices-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection