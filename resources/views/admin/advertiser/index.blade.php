@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertiser Sevices Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('advertiser-services.create') }}"> Create New Service</a>

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


                    <table style="min-width:600px" class="table table-bordered table responsive services-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Fees</th>

                          <th >Descriptions</th>

                          <th style="min-width:200px!important;">Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($advertiser_services as $service )

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('advertiser-services.show',$service->id) }}">{{ $service->name }}</a></td>
                          <td>${{ $service->service_list_fee ?? 0 }}</a></td>
                          <td >{{ Str::limit($service->description,40) }}</a></td>

                          

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('advertiser-services.edit',$service->id) }}">Edit</a>
                             <a class="btn btn-info mb-1" href="{{ route('advertiser-services.show',$service->id) }}">Show</a>
                            @if ($service->has_child)
                            <a class="btn btn-secondary mb-1" href="{{ route('child.services',$service->id) }}">Child Services</a>
                             @else
                             {!! Form::open(['method' => 'DELETE','route' => ['advertiser-services.destroy', $service->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger  mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete(event);']) !!}

                              {!! Form::close() !!}
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
    $('.users-table').DataTable({
        pageLength: 10,
        responsive: false
    });
  } );
</script>
@endsection