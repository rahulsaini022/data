@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('States Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('states.create') }}"> Create New State</a>

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


                    <table class="table table-bordered states-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>State</th>

                          <th>State Abbreviation</th>

                          <th>Is Active</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $state)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('states.show',$state->id) }}">{{ $state->state }}</a></td>

                          <td>{{ $state->state_abbreviation }}</td>
                          
                          <td>
                            @if($state->active=='1') 
                              <label class="badge badge-success"> Yes </label>
                            @else
                              <label class="badge badge-danger"> No </label>
                            @endif
                            </td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('states.edit',$state->id) }}">Edit</a>

                             @if($state->active=='1')
                                <a class="btn btn-danger mb-1 confirm-deactivate"  onclick="return ConfirmDeActivate();" href="{{ route('states.deactivate',$state->id) }}">Deactivate</a>
                             @else
                                <a class="btn btn-success mb-1 confirm-activate"  onclick="return ConfirmActivate();" href="{{ route('states.activate',$state->id) }}">Activate</a>
                             @endif
                              <!-- {!! Form::open(['method' => 'DELETE','route' => ['states.destroy', $state->id],'style'=>'display:inline']) !!}

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
      var x = confirm("Are you sure you want to delete this state?");
      if (x)
          return true;
      else
        return false;
  }

  function ConfirmDeActivate()
  {
      var x = confirm("Are you sure you want to deactivate this state?");
      if (x)
          return true;
      else
        return false;
  }

  function ConfirmActivate()
  {
      var x = confirm("Are you sure you want to activate this state?");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.states-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection