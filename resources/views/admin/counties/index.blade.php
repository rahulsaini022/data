@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Counties Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('counties.create') }}"> Create New County</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">

                      <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>

                    </div>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif


                    <table class="table table-bordered counties-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Designation</th>

                          <th>State Abbreviation</th>

                          <th>Action</th> 

                        </tr>
                      </thead>
                      
                    </table>
                    {{-- <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">{{ $data->links() }}
                      </div>
                      <div class="col-xs-12 col-sm-12 col-md-12 table-sm table-responsive">
                        <table>
                          <tr>
                            <td>
                              <label>Go to Page:</label>
                            </td>
                            <td>
                              <input type="number" class="form-control" name="go_to_page" id="go_to_page" value="{{ $data->currentPage() }}" min="1" max="{{ $data->lastPage() }}" placeholder="Go to Page">
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary pl-5 pr-5" onclick="goToPage();">Go</button>
                            </td>
                          </tr>
                        </table>
                      </div>
                    </div> --}}
                </div>
            </div>
        </div> 
    </div>
</div>         
<script>
  function ConfirmDelete()
  {
      var x = confirm("Are you sure you want to delete this county");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.counties-table').DataTable({
          processing: true,
        serverSide: true,
               
        ajax: "{{url('/counties') }}",
        columns: [
            // {data: 'id'},
            {data: 'id'},
            { data: 'county_name'  },
               { data: 'state_abbreviation' },
              { data: 'county_designation' },
            {orderable: false,
               render: (data,type,row,val) => {
                // console.log(row);
                   return "<a class='btn btn-primary' href='{{url('/counties')}}/"+row.id+"/edit'>Edit</a>";
                 }
            },
            
        ],
  
     oLanguage: {sProcessing: "<i  class='spinner-border'></i> Loading...."},
          });
          $(".dataTables_filter label input[type=search]").attr('placeholder',' Enter keyword....');
           var table = $('.attorneytableactive-table').DataTable();
       
    });
 
</script>
@endsection
