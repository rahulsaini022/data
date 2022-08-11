@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorneys List') }}</strong>
                  <!-- @can('attorney-create')
                      <div class="pull-right">

                          <a class="btn btn-success" href="{{ route('attorneys.create') }}"> Create New User</a>

                      </div>
                  @endcan   -->
                </div>
                <div class="card-body table-sm table-responsive">

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">

                      <p>{{ $message }}</p>

                    </div>

                    @endif


                    <table class="table table-bordered attorneys-table">
                      <thead>
                         <tr>

                           <th>Sno.</th>
                           <th>User Id</th>
                           <th>Name</th>

                           <th>Email</th>

                           <th>Action</th>

                         </tr>
                      </thead>
                      <tbody>
                         <?php $i=0; ?>
                         @foreach ($data as $key => $user)

                          <tr>

                            <td>{{ ++$i }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                               <a class="btn btn-info" href="{{ route('attorneys.show',$user->id) }}">Show</a>
                               <a class="btn btn-primary" href="{{ route('attorneys.edit',$user->id) }}">Edit</a>
                                <!-- @can('attorney-delete')

                                  {!! Form::open(['method' => 'DELETE','route' => ['attorneys.destroy', $user->id],'style'=>'display:inline']) !!}

                                      {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                                  {!! Form::close() !!}
                                @endcan   -->
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
  // function ConfirmDelete()
  // {
  //     var x = confirm("Are you sure you want to delete this attorney");
  //     if (x)
  //         return true;
  //     else
  //       return false;
  // }
  $(document).ready( function () {
    $('.attorneys-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  });
</script>        
@endsection