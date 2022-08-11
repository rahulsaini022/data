@extends('layouts.app')
@section('content')
{{-- @php
    echo "<pre>";
    print_r($ads);
    die();
@endphp --}}
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12"> 
                <div class="card">
                    <div class="card-header"><strong>{{ __('Advertiser List') }}</strong>
                        <div class="pull-right">
                            {{-- <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a> --}}
                        </div>
                    </div>
                    <div class="card-body table-sm table-responsive">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        @if ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                        <table class="table table-bordered users-table">
                            <thead>
                                <tr>
                                    <th>Sno.</th>
                                    {{-- <th>User Id</th> --}}
                                    <th>Advertiser Name</th>
                                    <th>Title</th>
                                    <th>Services </th>
                                    <th style="min-width:100px!important;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; 
            
                                ?>
                                @foreach ($ads as $ad)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        {{-- <td>{{$ad->user_id}}</td> --}}
                                        <td>{{ $ad->name }}</td>
                                        <td>{{ $ad->title }}</td>
                                        <td>{{ $ad->advertiser_services }}</td>
                                        <td >
                                           
         
                                                <form class="form" id="listing-form" method="post" action="{{route('enable.disable')}}">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$ad->id}}"/>
                                                    <input type="hidden" name="status" value="{{$ad->status}}"/>
                                                    <input type="hidden" name="name" value="{{$ad->name}}"/>
                                                    <input type="hidden" name="title" value="{{ $ad->title }}"/>
                                                    <input type="hidden" name="email" value="{{$ad->email}}"/>
                                                    <input type="submit" onclick="ConfirmDelete(event)" class="btn {{($ad->status) ? 'btn-danger' : 'btn-success' }}" value="{{($ad->status)? 'Disable' : 'Enable' }}"/>
                                                   
                                                    {{-- <button type="submit" onclick="return confirm('Do you want to {{($ad->status) ? 'disable' : 'enable'}} this advertiser list ?')" class="btn {{($ad->status) ? 'btn-danger' : 'btn-success' }}" >{{($ad->status)? 'Disable' : 'Enable' }}</button> --}}
                                                  <a class="btn btn-primary "
                                                href="{{ route('advertiser.detail', $ad->id) }}">Detail</a>
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
    <script>
       
        $(document).ready(function() {
            $('.users-table').DataTable({
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endsection
