@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard download-directory-listing-main">
        <div class="col-md-12">
            <?php
              $settings=\App\Setting::get()->all();
            ?>
            <div class="card">
                <div class="card-header"><strong>{{ __('Downloads') }}</strong>
                      <div class="pull-right">

                          <span class="text-danger">
                            @foreach($settings as $setting)
                              @if($setting->setting_key == 'download_page_delete_warning')
                                {{$setting->setting_value}}
                              @endif
                              <!-- Any file remaining for more than 5 days will be automatically permanently deleted. -->
                            @endforeach
                          </span>

                      </div>
                </div>
                <div class="card-body table-sm table-responsive">

                    @if ($message = Session::get('success'))
                         @if($message)
                         <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>{{$message}}
                      </p>

                    </div>
                    @else
                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>
                        @foreach($settings as $setting)
                          @if($setting->setting_key == 'documents_ready_soon_message')
                            {{$setting->setting_value}}
                            @else
                           
                          @endif
                        @endforeach
                      </p>

                    </div>
                  @endif
                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif

                    <table class="table table-bordered downloads-table">
                      <thead>
                         <tr>

                          <th>Sno.</th>

                          <th>Document Name</th>

                          <!-- <th>Obligee Name</th>

                          <th>Obligor Name</th>
                          
                          <th>Custody</th>

                          <th>Created At</th> -->

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        $i=0; 
                        $oldfilescount=count($files_data);
                        if($files_data->first()){
                          $last_created_file=$files_data->first()->getFilename();
                        } else {
                          $last_created_file='';
                        }
                      ?>
                      @foreach($files_data as $file_data)
                        @if(file_exists( public_path().'/uiodirs/'.Auth::user()->id.'/download/'.$file_data->getFilename().'' ))
                          <?php ++$i; ?>
                          <tr id="download-tr_{{ $i }}">
                            <td>{{ $i }}</td>
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
                        @else
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
      var x = confirm("Are you sure you want to delete this file?");
      if (x)
          return true;
      else
        return false;
  }

  $(window).on('load', function(){

    $('.downloads-table').DataTable({
        pageLength: 50,
        responsive: false
    });

    checkNewDownloads();
  });

  function checkNewDownloads(){
    var delay=5;
    delay= parseInt(delay)*1000;
    setTimeout(function(){
        // $('.preloader-message-div').hide();
        
        //$('.downloads-table').show();

      // check new downloads
      var token= $('input[name=_token]').val();
      $.ajax({
          url:"{{route('check_new_downloads')}}",
          method:"POST",
          dataType: 'json',
          data:{
            oldfilescount: '{{$oldfilescount}}', 
            last_created_file: '{{$last_created_file}}', 
            _token: token, 
          },
          success: function(data){
              if(data.newfilesavailable===true){
                //alert('New documents are ready now. Your documents list will be refreshed now.');
                location.reload();
              } else {
                checkNewDownloads();
              }
          }
      });


    },delay); // set the time here
  }
</script>        
@endsection