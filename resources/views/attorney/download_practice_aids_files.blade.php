@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard download-directory-listing-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Practice Aids Downloads') }}</strong>
                    <div class="pull-right">

                          <span class="text-danger"> Any file remaining for more than 5 days will be automatically permanently deleted.</span>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive">

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">

                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    <table class="table table-bordered downloads-table">
                      <thead>
                         <tr>

                          <th>Sno.</th>

                          <th>File Name</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=0; ?>
                      @foreach($files_data as $file_data)
                        @if(strpos($file_data->getFilename(), 'FDDPA') == true)
                            @if(file_exists( public_path().'/uiodirs/'.Auth::user()->id.'/download/'.$file_data->getFilename().'' ))
                              <?php ++$i; ?>
                              <tr id="download-tr_{{ $i }}">
                                <td>{{ $i }}</td>
                                <!-- <td>{{ ucwords($file_data->getFilename()) }}</td> -->
                                <td>{{ $file_data->getFilename() }}</td>
                                  <td>
                                    <a class="btn btn-primary mr-1 mb-1" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('download-form_{{ $i }}').submit(); document.getElementById('download-tr_{{ $i }}').style.display = 'none';">Download</a>
                                    <form id="download-form_{{ $i }}" action="{{ route('attorney.download.file') }}" method="POST" style="display: none;">
                                      @csrf
                                      <input type="hidden" name="file_name" value="{{ $file_data->getFilename() }}">
                                    </form>

                                    {!! Form::open(['method' => 'POST','route' => ['attorney.delete_download_file', Auth::user()->id],'style'=>'display:inline']) !!}

                                      {!! Form::hidden('file_name', $file_data->getFilename() , array('class' => 'form-control')) !!}
                                      {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                                  {!! Form::close() !!}

                                  </td>
                                <!-- <td></td> -->
                              </tr>
                          
                            @endif    
                        @endif    
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
      var x = confirm("Are you sure you want to delete this file.");
      if (x)
          return true;
      else
        return false;
  }

  $(window).on('load', function(){
    $('.downloads-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  });

</script>        
@endsection