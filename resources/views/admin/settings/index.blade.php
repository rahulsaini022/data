@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Setting Management') }}</strong>
                    <div class="pull-right">

                        <!-- <a class="btn btn-success" href="{{ route('settings.create') }}"> Create New Setting</a> -->

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


                    <table class="table table-bordered settings-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Value</th>

                          <th>Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $setting)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td><a class="text-primary" href="{{ route('settings.show',$setting->id) }}">{{ $setting->setting_label }}</a></td>

                          <td>{{ $setting->setting_value }}</td>

                          <td>

                             <a class="btn btn-primary" href="{{ route('settings.edit',$setting->id) }}">Edit</a>

                            <!-- {!! Form::open(['method' => 'DELETE','route' => ['settings.destroy', $setting->id],'style'=>'display:inline']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                            {!! Form::close() !!} -->

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
      var x = confirm("Are you sure you want to delete this Setting");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.settings-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection