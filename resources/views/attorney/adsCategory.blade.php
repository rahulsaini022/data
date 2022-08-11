@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertiser  Categories') }}</strong>
                    <div class="pull-right">

                       

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


                    <table class="table table-bordered users-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                       

                          <th >Descriptions</th>

                          <th >Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($ads_categories as $service )

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('ads_details',$service->id) }}">{{ $service->name }}</a></td>
                        
                          <td >{{ $service->description,100}}</a></td>

                          

                          <td style="width: 20%">

                             <a class="btn btn-primary mb-1" href="{{ route('ads_details',$service->id) }}">View Ads</a>
                            
                          
                             
                           
                              

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
        responsive: true
    });
  } );
</script>
@endsection