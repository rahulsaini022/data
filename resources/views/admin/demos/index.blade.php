@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Demos') }}</strong>
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


                    <table class="table table-bordered demos-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Email</th>
                          
                          <th>State of Registration</th>

                          <th>Attorney Registration #</th>

                          <th>Registered on FDD</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $demo)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <!-- <td><a class="text-primary" href="{{ route('demos.show',$demo->id) }}">{{ $demo->name }}</a></td> -->
                          <td>{{ $demo->name }}</td>

                          <td>{{ $demo->email }}</td>
                          
                          <td>{{ $demo->state_of_registration }}</td>

                          <td>{{ $demo->attorney_registration_number }}</td>

                          <td>
                            @if(strtolower($demo->fdd_user) == 'yes')
                              <label class="badge badge-success">{{ $demo->fdd_user }}</label>
                            @else
                              <label class="badge badge-danger">{{ $demo->fdd_user }}</label>
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
    $('.demos-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection