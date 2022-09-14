@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Prospects') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('prospects.create') }}"> Add New Prospect</a>

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

                    <table class="table table-bordered prospects-table">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th>Name</th>

                          <th>Manage</th>
                          
                          <th>Documents</th>

                          <th>Intake Actions</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $prospects)

                        <tr>

                          <td>{{ ++$i }}</td>

                          <td>{{ $prospects->prosp_fname.' '.$prospects->prosp_lname.' '.$prospects->prosp_sufname }}</td>
                          
                          <td>

                             <a class="btn btn-primary mb-1" href="{{ route('prospects.edit',$prospects->id) }}">Edit</a>

                            {!! Form::open(['method' => 'DELETE','route' => ['prospects.destroy', $prospects->id],'style'=>'display:inline']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete();']) !!}

                            {!! Form::close() !!}

                          </td>

                          <td>
                            <form method="POST" action="{{ route('draft_prospect') }}">
                              @csrf
                              <input type="hidden" name="prospect_id" value="{{ $prospects->id }}" required="" readonly="">
                              <div class="input-group mb-3">
                                <select id="letter_intake_dropdown_{{ $prospects->id }}" name="letter_intake_dropdown" class="form-control mb-1 custom-select letter_dropdown" required="">
                                    <option value="">Select</option>
                                </select>
                                <div class="input-group-append">
                                    <input type="submit" class="btn btn-success mb-1" name="submit" value="Draft">
                                </div>
                              </div>
                          </form>

                          </td>

                          <td>
                            <!-- <form method="POST" action="{{ route('draft_prospect') }}">
                              @csrf
                              <input type="hidden" name="prospect_id" value="{{ $prospects->id }}" required="" readonly="">
                              <div class="input-group mb-3">
                                <select id="" name="letter_intake_dropdown" class="form-control mb-1 custom-select intake_dropdown" required="">
                                    <option value="">Select</option>
                                </select>
                                <div class="input-group-append">
                                    <input type="submit" class="btn btn-success mb-1" name="submit" value="Draft">
                                </div>
                              </div>
                          </form> -->

                            <a class="btn btn-primary mb-1" href="{{ route('prospect_create_case',['prospect_id' => $prospects->id]) }}">Create New Case</a></td>
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
      var x = confirm("Are you sure you want to delete this Prospect Record.");
      if (x)
          return true;
      else
        return false;
  }

  $(document).ready( function () {
    $('.prospects-table').DataTable({
        pageLength: 50,
        responsive: true
    });

    var token= $('input[name=_token]').val();
        var state='35';
        var button_ref='Letter';
        var view_needed='attorneyself_triggered';
        $.ajax({
            url:"{{route('ajax_get_prospect_letter_dropdown')}}",
            method:"POST",
            dataType: 'json',
            data:{
                state: state, 
                button_ref: button_ref, 
                view_needed: view_needed, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('.letter_dropdown').append('<option value="'+data[key].package_name+'">'+data[key].package_name+'</option>');
                    });
                }
            }
        });     

        // var state='35';
        // var button_ref='Intake';
        // var view_needed='attorneyself_triggered';
        
        // $.ajax({
        //     url:"{{route('ajax_get_prospect_intake_dropdown')}}",
        //     method:"POST",
        //     dataType: 'json',
        //     data:{
        //         state: state, 
        //         button_ref: button_ref, 
        //         view_needed: view_needed, 
        //         _token: token, 
        //     },
        //     success: function(data){
        //         // console.log(data);
        //         if(data==null || data=='null'){
        //         } else {
        //             $.each(data, function (key, val) {
        //                 $('.intake_dropdown').append('<option value='+data[key].doc_number+'>'+data[key].doc_dropdown_name+'</option>');
        //             });
        //         }
        //     }
        // }); 

  } );
</script>
@endsection