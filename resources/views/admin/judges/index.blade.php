@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Judges Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('judges.create') }}"> Create New Judge</a>

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


                    <table class="table table-bordered judges-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Adjudicator</th>

                          <th>Adj Title</th>

                          <th>Adj Court</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $judge)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('judges.show',$judge->id) }}">{{ $judge->adjudicator }}</a></td>

                          <td>{{ $judge->adj_title }}</td>

                          <td>{{ $judge->adj_court }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('judges.edit',$judge->id) }}">Edit</a>
                             
                              <!-- {!! Form::open(['method' => 'DELETE','route' => ['judges.destroy', $judge->id],'style'=>'display:inline']) !!}

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
      var x = confirm("Are you sure you want to delete this judge");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.judges-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection