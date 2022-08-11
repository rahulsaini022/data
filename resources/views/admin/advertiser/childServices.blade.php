@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Advertiser Sevices Management') }}</strong>
                        <div class="pull-right">

                            
                                <a class="btn btn-primary" href="{{route('advertiser-services.index')}}"> Back</a>

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

                                   

                                    <th >Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($childServices as $service)
                                    <tr>

                                        <td>{{ ++$i }}</td>

                                        <td>{{ $service->name }}
                                        </td>
                                      


                                        <td style="width: 20%">

                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('advertiser-services.edit', $service->id) }}">Edit</a>
                                        
                                            @if ($service->has_child)
                                                <a class="btn btn-secondary mb-1"
                                                    href="{{ route('child.services', $service->id) }}">Child Services</a>
                                            @else
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['advertiser-services.destroy', $service->id], 'style' => 'display:inline']) !!}

                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete(event);']) !!}

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
     

        $(document).ready(function() {
            $('.users-table').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endsection
