@extends('layouts.app')


@section('content')

<?php $filter = (isset($filter)) ? $filter : ''; ?>
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorney Table Active Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('attorneytableactive.create') }}"> Create New Attorney Table Active Record</a>

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

                     <form class="form-inline pull-right" action="{{ url('attorneytableactive/index-filtering')}}" method="post" enctype="multipart/form-data">
                      @csrf
                        <div class="form-group mb-2 ">
                         
                          <input type="text" class="form-control" id="filter" name="filter" placeholder="Enter keyword.." value="{{ $filter }}">
                        </div>&nbsp;&nbsp;
                        <button type="submit" class="btn btn-success mb-2">Search</button>&nbsp;&nbsp;
                        <a href="{{ route('attorneytableactive.index') }}" class="btn btn-warning mb-2">Clear </a>
                      </form>

                    <table class="table table-bordered attorneytableactive-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Registration Number</th>

                          <th>State</th>

                          <th>Document Sign Name</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        @if ($data->count() == 0)
                            <tr>
                                <td colspan="5">No data found.</td>
                            </tr>
                            @endif
                        <?php $i=0; ?>
                        @foreach ($data as $key => $attorneytableactive)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('attorneytableactive.show',$attorneytableactive->id) }}">{{ $attorneytableactive->registrationnumber }}</a></td>

                          <td>{{ $attorneytableactive->registration_state }}</td>

                          <td>{{ $attorneytableactive->document_sign_name }}</td>

                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('attorneytableactive.edit',$attorneytableactive->id) }}">Edit</a>
                             
                              <!-- {!! Form::open(['method' => 'DELETE','route' => ['attorneytableactive.destroy', $attorneytableactive->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                              {!! Form::close() !!} -->

                          </td>

                        </tr>

                        @endforeach
                      </tbody>
                    </table>
                    <div class="row">
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
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>         
<script>
  function ConfirmDelete()
  {
      var x = confirm("Are you sure you want to delete this attorney table active record.");
      if (x)
          return true;
      else
        return false;
  }

  function goToPage(){
    var page_num=$('#go_to_page').val();
    var last_page='{{ $data->lastPage() }}';
    if(parseInt(page_num) && parseInt(page_num) > 0 && parseInt(page_num) <= parseInt(last_page)){
      var redirect_url='{{Request::url()}}?page='+page_num+'';
      window.location.href=redirect_url;
    } else {
      alert('Page number does not exist.');
    }
  } 

  $(document).ready( function () {
    // $('.attorneytableactive-table').DataTable({
    //     pageLength: 50,
    //     responsive: true
    // });
  } );
</script>
@endsection