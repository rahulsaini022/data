@extends('layouts.app')


@section('content')
    <style>
        .select-wrapper input.select-dropdown {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            -o-user-select: none; // latest Opera versions support -webkit-
            user-select: none;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Prospects') }}</strong>
                        <div class="pull-right">

                            <a class="btn btn-success" href="{{ route('prospects.create') }}"> Add New Prospect</a>
                            <a class="btn btn-primary"
                                href="{{ route('attorneys.show', ['id' => Auth::user()->id]) }}">Back</a>
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

                        <table class="table table-bordered table-responsive prospects-table">
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
                                <?php $i = 0; ?>
                                @foreach ($data as $key => $prospects)
                                    <tr>

                                        <td >{{ ++$i }}</td>

                                        <td class="wid" >{{ $prospects->prosp_fname . ' ' . $prospects->prosp_lname . ' ' . $prospects->prosp_sufname }}
                                        </td>

                                        <td class="wid" >

                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('prospects.edit', $prospects->id) }}">Edit</a>

                                            {!! Form::open(['method' => 'DELETE', 'route' => ['prospects.destroy', $prospects->id], 'style' => 'display:inline']) !!}

                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete(event);']) !!}

                                            {!! Form::close() !!}

                                        </td>

                                        <td class="wid" >
                                            <form role="form" method="POST" action="{{ route('draft_prospect') }}">
                                                @csrf
                                                <input type="hidden" name="prospect_id" value="{{ $prospects->id }}"
                                                    required="" readonly="">
                                                <div class="input-group input-group-sm">

                                                    <select id="letter_intake_dropdown_{{ $prospects->id }}"
                                                        name="letter_intake_dropdown"
                                                        class="form-control custom-select mb-1 letter_dropdown doptop-letter-dropdown"
                                                        required>
                                                        <option value="">Select</option>
                                                        <script>
                                                            var token = $('input[name=_token]').val();
                                                            var state = '35';
                                                            var button_ref = 'Letter';
                                                            var view_needed = 'attorneyself_triggered';
                                                            $.ajax({
                                                                url: "{{ route('ajax_get_prospect_letter_dropdown') }}",
                                                                method: "POST",
                                                                dataType: 'json',
                                                                data: {
                                                                    state: state,
                                                                    button_ref: button_ref,
                                                                    view_needed: view_needed,
                                                                    _token: token,
                                                                },
                                                                success: function(data) {

                                                                    if (data == null || data == 'null') {

                                                                    } else {
                                                                        $.each(data, function(key, val) {

                                                                            console.log(val.package_name);
                                                                            $('.letter_dropdown').append('<option value="' + val.package_name +
                                                                                '" data-id = "' + val.document_out_format + '">' + val.package_name +
                                                                                '</option>');



                                                                        });
                                                                    }
                                                                }

                                                            });
                                                        </script>
                                                    </select>
                                                    <input type="hidden" name="doctype" class="doctype">
                                                    <div class="input-group-append">
                                                        <input type="submit" class="btn btn-success mb-1" name="submit"
                                                            value="Draft">
                                                    </div>
                                                </div>
                                            </form>

                                        </td>

                                        <td class="wid" >
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

                                            <a class="btn btn-primary mb-1"
                                                href="{{ route('prospect_create_case', ['prospect_id' => $prospects->id]) }}">Create
                                                New Case</a>
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
      

        $(document).ready(function() {

            // $('.letter_dropdown').on('touchend', function (e) {
            //   e.stopPropagation();
            // }); 

            $('.prospects-table').DataTable({
                pageLength: 50,
              
            });

            var token = $('input[name=_token]').val();
            var state = '35';
            var button_ref = 'Letter';
            var view_needed = 'attorneyself_triggered';
            $.ajax({
                url: "{{ route('ajax_get_prospect_letter_dropdown') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    state: state,
                    button_ref: button_ref,
                    view_needed: view_needed,
                    _token: token,
                },
                success: function(data) {

                    if (data == null || data == 'null') {

                    } else {
                        $.each(data, function(key, val) {

                            console.log(val.package_name);
                            //  $('.test-id').append('<option value="'+val.package_name+'" data-id = "'+val.document_out_format+'">'+val.package_name+'</option>');

                            $('.test-id').append('<option >tesdf</option>');

                        });
                    }
                }

            });

            // var state='35';
            // var button_ref='Intake';
            // var view_needed='attorneyself_triggered';

            // $.ajax({
            //     url:"{{ route('ajax_get_prospect_intake_dropdown') }}",
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
            //                 $('.intake_dropdown').append('<option value='+val.doc_number+'>'+val.doc_dropdown_name+'</option>');
            //             });
            //         }
            //     }
            // }); 

        });
        $(document).on('change', '.custom-select', function() {
            console.log($(this).val());
            var doctype = $(this).find(':selected').data('id');
            $(".doctype").val(doctype);
        });
    </script>
@endsection
