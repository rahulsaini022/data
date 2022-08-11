@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Orchard Submissions') }}</strong>
                    </div>
                    <div class="card-body table-sm table-responsive">
                         @if ($message = Session::get('success'))
                        <script> Swal.fire({toast:true,position:'top-end',icon: 'success',title: "{{$message}}",showConfirmButton: false, timer: 1500});</script>
                        @elseif($message = Session::get('error'))
                             <script> Swal.fire({toast:true,position:'top-end',icon: 'error',title: "{{$message}}",showConfirmButton: false, timer: 1500});</script>
                        @endif
                        <table class="table table-bordered judges-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>
                                    <th>Documnent Title</th>
                                    <th> User</th>
                                    <th> Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $value->document_title }}</a></td>
                                        <td>{{ $value->username }}</td>
                                        <td>{{ $value->create_date }}</td>
                                        <td>
                                            @if ($value->status == 0)
                                                Pending
                                            @else
                                                Approved
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value->status == 0)
                                                <a class="btn btn-primary mb-1"
                                                    href="{{ route('customeruploads.show', ['id' => $value->id]) }}">Approve</a>
                                            @endif
                                            <a class="btn btn-primary mr-1 mb-1" href="javascript:void(0)"
                                                onclick="event.preventDefault(); document.getElementById('download-form_{{ $i }}').submit(); document.getElementById('download-tr_{{ $i }}').style.display = 'none';">Download</a>
                                            <form id="download-form_{{ $i }}"
                                                action="{{ route('customer.download.file') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="file_name"
                                                    value="{{ $value->upload_document }}">
                                            </form>
                                            {!! Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['customeruploads.destroy', $value->id],
                                                'style' => 'display:inline',
                                            ]) !!}
                                            {!! Form::submit('Delete', [
                                                'class' => 'btn btn-danger 
                                                                                                                          confirm-delete',
                                                'onclick' => 'return ConfirmDelete(event);',
                                            ]) !!}
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
        $(document).ready(function() {
            $('.judges-table').DataTable({
                pageLength: 50,
                responsive: true
            });
        });
    </script>
@endsection
