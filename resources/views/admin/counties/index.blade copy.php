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
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $county)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('counties.show',$county->id) }}">{{ $county->county_name }}</a></td>

                          <td>{{ $county->county_designation }}</td>
                          
                          <td>{{ $county->state_abbreviation }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('counties.edit',$county->id) }}">Edit</a>
                             
                             <!-- {!! Form::open(['method' => 'DELETE','route' => ['counties.destroy', $county->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                              {!! Form::close() !!}
-->
                          </td>

                        </tr>

                        @endforeach
                      </tbody>
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
        pageLength: 25,
        responsive: true
    });
  } );
</script>
@endsection
