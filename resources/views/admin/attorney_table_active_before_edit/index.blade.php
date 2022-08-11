@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Restore Attorney Table Active Records') }}</strong>
                  <div class="row  mt-3">
                    <div class="col-md-7">

                        <!-- <a class="btn btn-success" href="{{ route('attorneytableactivebeforeedit.create') }}"> Create New Attorney Table Active Record</a> -->
                        <form method="POST"class="form-inline"  autocomplete="off" action="{{ route('attorneytableactivebeforeedit.get_records_by_reg_number') }}">
                         
                          <div class="input-group">
                              
                            
                                @csrf
                                <input type="number" class="form-control" name="reg_num" id="reg_num" value="" min="1" placeholder="Enter Reg Num" required="">
                          
                              <div class="input-group-append">
                                <input type="submit"  class="btn btn-primary mb-2" value="Search">
                              </div>
                          </div>
                              
                        </form>
                    </div>
                    <div class="col-md-5 ">
                      <div class="form-group mb-2">
                                 <a  class="btn btn-primary mb-2" href="{{ route('attorneytableactivebeforeedit.index') }}"> View All Records</a>
                               </div>
                    </div>
                  </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    

                    @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
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


                    <table class="table table-bordered attorneytableactivebeforeedit-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Registration Number</th>

                          <th>State</th>

                          <th>Document Sign Name</th>

                          <th>Backup Created At</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $attorneytableactivebeforeedit)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('attorneytableactivebeforeedit.show',$attorneytableactivebeforeedit->id) }}">{{ $attorneytableactivebeforeedit->registrationnumber }}</a></td>

                          <td>{{ $attorneytableactivebeforeedit->registration_state }}</td>

                          <td>{{ $attorneytableactivebeforeedit->document_sign_name }}</td>
                          
                          <td>{{ date("m/d/Y H:i:m",strtotime($attorneytableactivebeforeedit->created_at)) }}</td>

                          <td>
       
                             {!! Form::open(['method' => 'POST','route' => ['attorneytableactivebeforeedit.restore'],'style'=>'display:inline']) !!}
                                  {!! Form::hidden('id', $attorneytableactivebeforeedit->id, array('placeholder' => 'Id','class' => 'form-control', 'required' => 'required')) !!}
                                  {!! Form::submit('Restore', ['class' => 'btn btn-success confirm-restore mb-1 ', 'onclick' => 'ConfirmDelete(event);']) !!}

                              {!! Form::close() !!}

                             <!-- <a class="btn btn-primary mb-1" href="{{ route('attorneytableactivebeforeedit.edit',$attorneytableactivebeforeedit->id) }}">Edit</a> -->
                             
                              {!! Form::open(['method' => 'DELETE','route' => ['attorneytableactivebeforeedit.destroy', $attorneytableactivebeforeedit->id],'style'=>'display:inline']) !!}

                                  {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete mb-1 ', 'onclick' => 'return ConfirmDelete(event);']) !!}

                              {!! Form::close() !!}
      
                          </td>

                        </tr>

                        @endforeach
                      </tbody>
                    </table>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">{{ $data->links() }}
                      </div>
                      @if( $data->lastPage() > 1)
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
                      @endif
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>         
<script>
  // function ConfirmDelete()
  // {
  //     var x = confirm("Are you sure you want to delete this attorney table active record?");
  //     if (x)
  //         return true;
  //     else
  //       return false;
  // }
  // function ConfirmRestore()
  // {
  //     var x = confirm("Are you sure you want to restore this attorney table active record?");
  //     if (x)
  //         return true;
  //     else
  //       return false;
  // }

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
    // $('.attorneytableactivebeforeedit-table').DataTable({
    //     pageLength: 50,
    //     responsive: true
    // });
  } );
</script>
@endsection