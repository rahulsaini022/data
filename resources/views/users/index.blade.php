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
                    
                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>
                                    <th>Name</th>
                                    <th style="max-width:200px!important;">Email</th>
                                    <th style="min-width:55px;">Roles</th>
                                    <th style="min-width:160px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    
          $(document).ready(function(){
          // DataTable
      var user = "@if(Request::Segment(1) == 'clients') {{'clients'}} @else {{'users'}} @endif";
      var table=  $('.users-table').dataTable({
             processing: true,
             serverSide: true,
                     columnDefs: [
    { orderable: false, targets: 0 }
  ],
  order: [[0, 'desc']],
             ajax: {
                url:"{{url('/users')}}",
             data:{
                user_type:user,
             },},
             columns: [
                            {data: 'id',orderable: false },
                            { data: 'name'  },
                            { data: 'email' },
                            { orderable: false,
                                 render: (data,type,row,val) => {
                                    // console.log(typeof row);
                           var arr=row.role;
                           var data='';
                                for(let i = 0; i < arr.length; i++){
 data+=  '<label class="badge badge-success">'+arr[i]+'</label>';
}
                 return data;       
                 }},
                            { orderable: false,
                 render: (data,type,row,val) => {
                   var url="{{ url('/users') }}";
                    $btn= "<a class='btn btn-primary mb-1 mr-1' href='"+url+"/"+row.id+"/edit'>Edit</a>";
                 if (row.active == '1'){
                      $btn+= "<a class='btn btn-danger mb-1 confirm-deactivate' onclick='return ConfirmStatus(event)' href='"+url+"/"+row.id+"/deactivate'>Deactivate</a>";
                 } else{               
                         $btn+=       "<a class='btn btn-success mb-1 confirm-activate' onclick='return ConfirmStatus(event)' href='"+url+"/"+row.id+"/activate'>Activate</a>";
                 }           
                     $btn+= "<form method='POST' action='"+url+"/"+row.id+"' accept-charset='UTF-8' style='display:inline'>";
                        $btn+= '@csrf @method("DELETE")';
                        $btn+= '<input class="btn btn-danger confirm-delete mb-1" onclick="return ConfirmDelete(event);" type="submit" value="Delete"></form>';
                    return $btn;
                 }
              },
             ],
              fnRowCallback : function(nRow, aData, iDisplayIndex){
                //  console.log(typeof aData);
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
