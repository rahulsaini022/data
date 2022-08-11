@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard download-directory-listing-main">
        <div class="col-md-12">
            <?php
              $settings=\App\Setting::get()->all();
            ?>
            <div class="card">
                <div class="card-header"><strong>Orchard Search</strong>
                      <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('uploadnewdocument') }}"> Add New document</a>
                  </div>
                </div>
                <div class="card-body table-sm table-responsive">
                  <div class="pull-right" style="display:none;">
                  <form  action="{{ url('orchard-search') }}" method="POST" style="" class="form-inline">
                                  @csrf
                                 <inpuqt type="text" class="form-control" name="search" placeholder="" aria-controls="DataTables_Table_0">
                                 <input type="submit" class="btn btn-primary ml-2" placeholder="" value="submit">
                                </form>
                                 <br/>
                              </div>

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button> 
                      <p>
                        @foreach($settings as $setting)
                          @if($setting->setting_key == 'documents_ready_soon_message')
                            {{$setting->setting_value}}
                          @endif
                        @endforeach
                      </p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                               <strong>{{ $message }}</strong>
                      </div>
                    @endif

                   <!--  <iframe src="http://orchard.firstdraftdata.com" title="description" style="height:500px;width:100%;"></iframe> -->
                   <!-- For Dev server -->
                   <iframe src="http://orchard-dev.firstdraftdata.com" title="description" style="height:500px;width:100%;border:none;"></iframe> 
                    <!-- For production server -->
                    <!-- <iframe src="https://orchard.firstdraftdata.com/" title="description" style="height:500px;width:100%;border:none;"></iframe> -->


                    <table class="table table-bordered downloads-table" style="display:none;">
                      <thead>
                         <tr>

                          <th>Sno.</th>

                          <th>Document Name</th>
                          <!-- <th> Path</th> -->
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
                        $oldfilescount=count($output_array);
                      
                      ?>
                      @foreach($output_array as $file_data)
                        
                          <?php ++$i;
                          $file2 = basename($file_data, ".php");
                           ?>
                          <tr id="download-tr_{{ $i }}">
                            <td>{{ $i }}</td>
                            <td>{{ $file2 }}</td>
                            <!-- <td> {{ $file_data }}</td> -->
                              <td>
                               <a class="btn btn-primary mr-1 mb-1" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('download-form_{{ $i }}').submit(); document.getElementById('download-tr_{{ $i }}').style.display = 'none';">Download</a>
                                <form id="download-form_{{ $i }}" action="{{ route('fdd.download.file') }}" method="POST" style="display: none;">
                                  @csrf
                                  <input type="hidden" name="file_name" value="{{ $file_data->upload_document }}">
                                </form>
                                </td>
                            <!-- <td></td> -->
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