@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Stripe Plans Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('stripeplans.create') }}"> Create New Stripe Plan</a>

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


                    <table class="table table-bordered stripeplans-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Plan ID</th>

                          <th>Plan Name</th>
                          
                          <th>Plan Title</th>
                          
                          <!-- <th>Plan Description</th> -->

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $stripeplans)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('stripeplans.show',$stripeplans->id) }}">{{ $stripeplans->plan_id }}</a></td>

                          <td>{{ $stripeplans->plan_name }}</td>
                          
                          <td>{{ $stripeplans->plan_title }}</td>
                          
                          <!-- <td>{{ $stripeplans->plan_description }}</td> -->

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('stripeplans.edit',$stripeplans->id) }}">Edit</a>
                             
                              <!-- {!! Form::open(['method' => 'DELETE','route' => ['stripeplans.destroy', $stripeplans->id],'style'=>'display:inline']) !!}

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
      var x = confirm("Are you sure you want to delete this stipe plan record.");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    // $('.stripeplans-table').DataTable({
    //     pageLength: 50,
    //     responsive: true
    // });
  } );
</script>
@endsection