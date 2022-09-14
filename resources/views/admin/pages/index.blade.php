@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Page Management') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('pages.create') }}"> Create New Page</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif


                    <table class="table table-bordered pages-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Title</th>

                          <th>Slug</th>
                          
                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $page)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('dynamic_page',$page->slug) }}">{{ $page->title }}</a></td>

                          <td>{{ $page->slug }}</td>
                          
                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('pages.edit',$page->id) }}">Edit</a>

                            {!! Form::open(['method' => 'DELETE','route' => ['pages.destroy', $page->id],'style'=>'display:inline']) !!}

                            {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

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
  function ConfirmDelete()
  {
      var x = confirm("Are you sure you want to delete this page");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.pages-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection