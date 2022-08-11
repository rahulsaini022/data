@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>
                            @if (Request::Segment(1) == 'clients')
                                {{ __('Clients Management') }} @else{{ __('Users Management') }}
                            @endif
                        </strong>
                        <div class="pull-right">
                            @if (Request::Segment(1) == 'users')
                                <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
                            @endif
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

                                    <th>Email</th>

                                    <th>Roles</th>

                                    <th style="min-width:160px">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($data as $key => $user)
                                    <tr>

                                        <td>{{ ++$i }}</td>

                                        <td><a class="text-primary"
                                                href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>

                                        <td>{{ $user->email }}</td>

                                        <td>

                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif

                                        </td>

                                        <td>

                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('users.edit', $user->id) }}">Edit</a>

                                            @if ($user->active == '1')
                                                <a class="btn btn-danger mb-1 confirm-deactivate"
                                                    onclick="return ConfirmDeActivate();"
                                                    href="{{ route('users.deactivate', $user->id) }}">Deactivate</a>
                                            @else
                                                <a class="btn btn-success mb-1 confirm-activate"
                                                    onclick="return ConfirmActivate();"
                                                    href="{{ route('users.activate', $user->id) }}">Activate</a>
                                            @endif
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}

                                            {!! Form::submit('Delete', [
                                                'class' => 'btn btn-danger confirm-delete mb-1',
                                                'onclick' => 'return ConfirmDelete();',
                                            ]) !!}

                                            {!! Form::close() !!}

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
        function ConfirmDelete() {
            var x = confirm("Are you sure you want to delete this user? All data related to this user will be deleted.");
            if (x)
                return true;
            else
                return false;
        }

        function ConfirmDeActivate() {
            var x = confirm("Are you sure you want to deactivate this user?");
            if (x)
                return true;
            else
                return false;
        }

        function ConfirmActivate() {
            var x = confirm("Are you sure you want to activate this user?");
            if (x)
                return true;
            else
                return false;
        }

        // $(document).ready(function() {
        //     $('.users-table').DataTable({
        //         pageLength: 10,
        //         responsive: true,
        //         pagingType: 'full_numbers',
        //     });
        // });
          $(document).ready(function(){
  
          // DataTable
      
        $('.users-table').dataTable({
             processing: true,
             serverSide: true,
                     columnDefs: [
    { orderable: false, targets: 0 }
  ],
  order: [[1, 'desc']],
 
             ajax: "{{url('/users')}}",
             columns: [
                            {data: 'id',orderable: false },
                            { data: 'name'  },
                            { data: 'email' },
                            { data: 'role' },
                            { orderable: false,
               
                 render: (data,type,row,val) => {
                   
                    return "<a class='btn btn-primary' href='{{url('/attorneytableactive')}}/"+row.id+"/edit'>Edit</a>";
                 }
              },
                         
                           
             ],

  
          
            
              fnRowCallback : function(nRow, aData, iDisplayIndex){
                // console.log(aData  );
                $("td:first", nRow).html(aData.no);
               return nRow;
            },
             oLanguage: {sProcessing: "<i  class='spinner-border'></i> Loading...."},
     
          });
          $(".dataTables_filter label input[type=search]").attr('placeholder',' Enter keyword....');
           var table = $('.attorneytableactive-table').DataTable();
       
    
        });
    </script>
@endsection
