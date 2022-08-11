@extends('layouts.app')


@section('content')


<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Users Subscriptions') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-success" href="{{ route('admin') }}"> Back</a>

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

                    <table class="table table-bordered all-payments-table payments-history-table"  id="user-subs">
                      <thead>
                        <tr>

                          <th>Sno.</th>

                          <th style="min-width:70px;">Purchase Date</th>

                          <th>User Id</th>
                          
                          <th>Name</th>

                          <th>Stripe Id</th>

                          <th>Subscription Status</th>
                          
                          <th>Expire Date</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=0; ?>
                        @foreach ($users as $user)
                          <tr>

                            <td>{{ ++$i }}</td>
                            <td>{{ Carbon\Carbon::parse($user->subscription_created_at)->format('Y-m-d') }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->stripe_id }}</td>
                            <td>
                              @if($user->subscribed($user->subscription_name))
                                @if($user->subscription($user->subscription_name)->onGracePeriod())
                                  Cancelled (On Grace Period)
                                @else
                                  Active
                                @endif
                              @else
                               Cancelled
                              @endif

                            </td>
                            <td>
                              @if(isset($user->ends_at)) 
                                {{ Carbon\Carbon::parse($user->ends_at)->format('Y-m-d') }}
                              @endif
                            </td>

                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                    {{-- <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12">{{ $users->links() }}
                      </div>
                    </div> --}}
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
  $('#user-subs').dataTable();
</script>
@endsection