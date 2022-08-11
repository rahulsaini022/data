@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Permissions') }}</strong>
                    <div class="pull-right">

                        @can('permission-create')

                        <a class="btn btn-success" href="{{ route('permissions.create') }}"> Create New Permission</a>

                        @endcan

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">


                    @if ($message = Session::get('success'))

                        <div class="alert alert-success">

                            <p>{{ $message }}</p>

                        </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif


                    <table class="table table-bordered">

                        <tr>

                            <th>No</th>

                            <th>Name</th>

                            <th width="280px">Action</th>

                        </tr>

                        @foreach ($permissions as $permission)

                        <tr>

                            <td>{{ ++$i }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>

                                <form action="{{ route('permissions.destroy',$permission->id) }}" method="POST">

                                    <a class="btn btn-info" href="{{ route('permissions.show',$permission->id) }}">Show</a>

                                    @can('permission-edit')

                                    <a class="btn btn-primary" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>

                                    @endcan


                                    @csrf

                                    @method('DELETE')

                                    @can('permission-delete')

                                    <button type="submit" class="btn btn-danger">Delete</button>

                                    @endcan

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </table>


                    {!! $permissions->links() !!}


                </div>    
            </div>   
        </div>
    </div>
</div>            

@endsection