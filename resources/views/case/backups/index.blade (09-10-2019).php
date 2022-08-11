@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard case-list-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Cases List') }}</strong>
                  <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('cases.create') }}"> Create New Case</a>

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

                    <table class="table table-bordered">

                     <tr>

                       <th>No</th>

                       <th>State</th>

                       <th>County</th>

                       <th>Court</th>
                       
                       <th>Division</th>
                       
                       <th>Client</th>
                       
                       <th>Opponent</th>

                       <th>Action</th>

                     </tr>
                     @foreach ($data as $key => $case)

                      <tr>

                        <td>{{ $case->id }}</td>

                        <td>{{ $case->state_name }}</td>

                        <td>{{ $case->county_name }}</td>

                        <td>{{ $case->court_name }}</td>

                        <td>{{ $case->division_name }}</td>

                        <td>{{ $case->client_name }}</td>
                        
                        <td>{{ $case->opponent_name }}</td>
                        
                       
                        
                        <td>
                           <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case->id) }}">Edit</a>
                           @if($case->payment_status) 
                            <label class="badge badge-success">Payment Done</label>                           
                           @else
                            <a class="btn btn-primary mb-2" href="{{ route('cases.payment',$case->id) }}">Pay</a>
                           @endif
                        </td>

                      </tr>

                     @endforeach

                    </table>


                    {!! $data->render() !!}
                </div>
            </div>          
        </div>
    </div>
</div>        
@endsection