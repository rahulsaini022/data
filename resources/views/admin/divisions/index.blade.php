@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Divisions Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('divisions.create') }}"> Create New Division</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">

                      <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>

                    </div>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif


                    <table class="table table-bordered divisions-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Action</th> 

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $division)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <!-- <td><a class="text-primary" href="{{ route('divisions.show',$division->id) }}">{{ $division->name }}</a></td> -->

                          <td>{{ $division->name }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('divisions.edit',$division->id) }}">Edit</a>
                             
                             <!-- {!! Form::open(['method' => 'DELETE','route' => ['divisions.destroy', $division->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                              {!! Form::close() !!}
-->
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
      var x = confirm("Are you sure you want to delete this division");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.divisions-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection
