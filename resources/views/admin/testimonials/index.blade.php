@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Testimonial Management') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('testimonials.create') }}"> Create New Testimonial</a>
                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    <table class="table table-bordered testimonials-table">
                      <thead>
                        <tr>
                          <th>Sno.</th>
                          <th>Author Name</th>
                          <th>Author Position</th>
                          <th>Description</th>
                          <th style="min-width: 80px">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($data as $key => $testimonial)
                        <tr>
                          <td>{{ ++$i }}</td>
                          <td><a class="text-primary" href="{{ route('testimonials.show',$testimonial->id) }}">{{ $testimonial->author_name }}</a></td>
                          <td>{{ $testimonial->author_position }}</td>
                          <td>{{ Str::limit($testimonial->description,60) }}</td>
                          <td>
                             <a class="btn btn-primary mb-1" href="{{ route('testimonials.edit',$testimonial->id) }}">Edit</a>
                            {!! Form::open(['method' => 'DELETE','route' => ['testimonials.destroy', $testimonial->id],'style'=>'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger mb-1 confirm-delete', 'onclick' => 'return ConfirmDelete(event);']) !!}
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
  $(document).ready( function () {
    $('.testimonials-table').DataTable({
        pageLength: 50,
        responsive: true
    });
  } );
</script>
@endsection