@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Case Packages Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('casepaymentpackages.create') }}"> Create New Package</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">
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


                    <table class="table table-bordered casepaymentpackages-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Title</th>
                          
                          <th>Price</th>
                          
                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $package)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('casepaymentpackages.show',$package->id) }}">{{ $package->package_title }}</a></td>
                          
                          <td>${{ $package->package_price }}</td>
                          
                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('casepaymentpackages.edit',$package->id) }}">Edit</a>

                            <!-- {!! Form::open(['method' => 'DELETE','route' => ['casepaymentpackages.destroy', $package->id],'style'=>'display:inline']) !!}

                            {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete(event);']) !!}

                            {!! Form::close() !!} -->

                            @if($package->active=='1')
                              <a class="btn btn-danger mb-1 confirm-deactivate"  onclick="return ConfirmStatus(event);" href="{{ route('casepaymentpackages.deactivate',$package->id) }}">Deactivate</a>
                            @else
                              <a class="btn btn-success mb-1 confirm-activate"  onclick="return ConfirmStatus(event);" href="{{ route('casepaymentpackages.activate',$package->id) }}">Activate</a>
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
    $('.casepaymentpackages-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection