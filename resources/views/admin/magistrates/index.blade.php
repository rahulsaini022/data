@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Magistrates Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('magistrates.create') }}"> Create New Magistrate</a>

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


                    <table class="table table-bordered magistrates-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Mag Title</th>

                          <th>Mag Court</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $magistrate)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('magistrates.show',$magistrate->id) }}">{{ $magistrate->mag_name }}</a></td>

                          <td>{{ $magistrate->mag_title }}</td>

                          <td>{{ $magistrate->mag_court_name }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('magistrates.edit',$magistrate->id) }}">Edit</a>
                             
                              <!-- {!! Form::open(['method' => 'DELETE','route' => ['magistrates.destroy', $magistrate->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                              {!! Form::close() !!} -->

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
      var x = confirm("Are you sure you want to delete this magistrate");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.magistrates-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection