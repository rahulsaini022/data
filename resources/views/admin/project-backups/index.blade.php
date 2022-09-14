@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard download-directory-listing-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Project Backups Download') }}</strong>
                      <div class="pull-right">

                          <span class="text-danger"> Any file remaining for more than 4 weeks will be automatically permanently deleted.</span>

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

                    <div class="preloader-message-div"><strong>Project Backups List</strong></div>

                    <table class="table table-bordered downloads-table">
                      <thead>
                         <tr>

                          <th>Sno.</th>

                          <th>File Name</th>

                          <th>Created At</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=0; ?>
                      @foreach($files_data as $file_data)
                          <?php ++$i; ?>
                          <tr id="download-tr_{{ $i }}">
                            <td>{{ $i }}</td>
                            <td>{{ $file_data['file_name'] }}</td>
                            @if(isset($file_data['created_at']))
                              <td>{{ date('m-d-Y h:i:s A', date($file_data['created_at'])) }}</td>
                            @else
                              <td></td>
                            @endif
                            <td>
                              <a class="btn btn-primary mr-1 mb-1" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('download-form_{{ $i }}').submit();">Download</a>
                              <form id="download-form_{{ $i }}" action="{{ route('admin.download_project_backup') }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="file_name" value="{{ $file_data['file_name'] }}">
                              </form>

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
@endsection