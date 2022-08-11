@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Role Management') }}</strong>
                    <div class="pull-right">

                    @can('role-create')

                        <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>

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

                        @foreach ($roles as $key => $role)

                        <tr>

                            <td>{{ ++$i }}</td>

                            <td>{{ $role->name }}</td>

                            <td>

                                <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>

                                @can('role-edit')

                                    <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>

                                @endcan

                                <!-- @can('role-delete')

                                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}

                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                    {!! Form::close() !!}

                                @endcan -->

                            </td>

                        </tr>

                        @endforeach

                    </table>


                    {!! $roles->render() !!}
                </div>    
            </div>   
        </div>
    </div>
</div>   
@endsection