@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard case-list-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Cases List') }}</strong>
                  <div class="pull-right">
                       
                       
                        <a class="btn btn-primary" href="{{route('attorneys.show',['id' => Auth::user()->id])}}">Back</a>
                      </div>
                </div>
                
                <div class="card-body table-sm table-responsive">
                  
<div class="filter-btn pb-3 pull-right">
 <a class="btn my-1 btn-info" href="{{ route('cases.index',['show' => 'active']) }}">Show Active cases</a>
                        <a class="btn my-1 btn-info " href="{{ route('cases.index',['show' => 'deactivated']) }}">Show Deactivated cases</a>
                        <a class="btn my-1 btn-info" href="{{ route('cases.index',['show' => 'non-hidden']) }}">Show non-hidden cases</a>
                        <a class="btn my-1 btn-info" href="{{ route('cases.index',['show' => 'all']) }}">Show all cases</a>
                         <a class="btn my-1 btn-success" href="{{ route('cases.create') }}"> Create New Case</a>
                </div>
                    <table class="table table-bordered cases-table table-responsive" style="min-width: 100%">
                      <thead>
                       <tr>

                         <!-- <th>No</th> -->

                         <th>Short Caption</th>

                         <!-- <th>Court State</th> -->

                         <th>Court County</th>

                         <th>Court Name</th>
                         
                         <!-- <th>Court Division</th> -->
                         
                         <th>Court Case Number</th>
                         
                         <th>GroupConcat Client</th>
                         
                         <!-- <th>GroupConcat Ops</th> -->

                         <th>Judge</th>
                        
                         <th style="min-width: 200px;">Action</th>

                       </tr>
                      </thead>
                      <tbody>  
                       <?php $i=1; ?>
                       @foreach ($data as $key => $case)

                        <tr>

                          <!-- <td>{{ $i }}</td><?php ++$i; ?> -->

                          <td>{{ $case->short_caption }}</td>
                          
                          <!-- <td>{{ $case->state_name }}</td> -->

                          <td>{{ $case->county_name }}</td>

                          <td>{{ $case->court_name }}</td>

                          <!-- <td>{{ $case->division_name }}</td> -->
                          
                          <td>{{ $case->case_number }}</td>

                          <td>{{ $case->client_name }}</td>
                          
                          <!-- <td>{{ $case->opponent_name }}</td> -->

                          <td>{{ $case->judge_name }}</td>
                         
                          <td>
                            <?php
                              $case_type_ids=$case->case_type_ids;
                              $case_type_ids=explode(",",$case_type_ids);
                              $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                              $hascaseid = !empty(array_intersect($array, $case_type_ids));
                            ?>
                            @if(isset($hascaseid) && $hascaseid=='1' && $case->state_id=='35' && !$case->deactivated_at)
                             <a class="btn btn-primary mb-2" href="{{ route('cases.edit_case_data',$case->id) }}">Edit</a>
                            @elseif(!$case->deactivated_at)
                             <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case->id) }}">Edit</a>
                            @endif
                            
                            @if($case->payment_status=='1' && !$case->deactivated_at)
                              <a class="btn btn-primary mb-2" href="{{route('cases.pleadings',$case->id)}}">Draft Docket</a>

                              @if($case->payment_status=='1' && $case->is_package_upgrade_available===TRUE)                            
                                  <a class="btn btn-info mb-2" href="{{ route('cases.get_upgrade_package_payment_form',$case->id) }}">Upgrade</a>
                              @else
                                    <!-- <a class="btn btn-primary mb-2" href="{{ route('cases.payment',$case->id) }}">Upgrade</a> -->
                              @endif
                            @else
                              @if($case->deactivated_at)
                                <label class="badge badge-danger mb-2" style="font-weight: normal; font-size: 12px;">Deactivated</label>
                              @endif
                              <a class="btn btn-primary mb-2" href="{{ route('cases.payment',$case->id) }}">Pay</a>
                            @endif

                            @if(isset($hascaseid) && $hascaseid=='1' && $case->state_id=='35' && !$case->deactivated_at)
                                <a class="btn btn-success mb-2" href="#" data-toggle="modal" data-target="#myModal" onclick="setCaseCustody('{{ $case->id }}', '{{$case->state_id}}')">Child Support Cases</a>
                                @if(isset($case['family_law_interview_done'])  && $case['family_law_interview_done']==true)
                                  <label class="badge badge-success mb-2" style="font-weight: normal; font-size: 12px;">Family Law Interview Completed</label>
                                @endif
                            @endif

                            <!-- {!! Form::open(['method' => 'DELETE','route' => ['cases.destroy', $case->id],'style'=>'display:inline']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger confirm-delete mb-2', 'onclick' => 'return ConfirmDelete(event);']) !!}

                            {!! Form::close() !!} -->
                            @if($case->hidden_at && !$case->deactivated_at)
                                {!! Form::open(['method' => 'POST','route' => ['cases.show_hide',$case->id],'style'=>'display:inline']) !!}

                                  {{ Form::hidden('show_hide', 'show') }}

                                  {!! Form::submit('Show', ['class' => 'btn btn-success confirm-activate mb-2', 'onclick' => 'return ConfirmDelete(event);']) !!}

                                {!! Form::close() !!}
                            @elseif(!$case->hidden_at && !$case->deactivated_at)
                                {!! Form::open(['method' => 'POST','route' => ['cases.show_hide',$case->id],'style'=>'display:inline']) !!}

                                  {{ Form::hidden('show_hide', 'hide') }}
            
                                  {!! Form::submit('Hide', ['class' => 'btn btn-danger confirm-deactivate mb-2','data-text'=>'Hidden cases with no activity for 6 months will automatically be Deactivated and will require a case Registration fee to be reactivated and that, when a case is Deactivated for 6 months(Not Family Law) and 36 months(Family Law), it will be automatically Deleted. Are you sure you want to hide this case?', 'onclick' => 'return ConfirmHide(event);']) !!}

                                {!! Form::close() !!}
                            @endif

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
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog" tabindex="-1">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Choose Form Custody</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body text-center">
          <form id="modal-form" class="modal-form" method="POST" action="{{route('cases.computations_sheet')}}" autocomplete="off">
            @csrf
            <input type="hidden" name="case_id" id="modal_case_id" value="" required="">
            <input type="hidden" name="form_state" id="modal_state_id" value="" required="">

            <label for="computed_from_database" style="float: left;">Computed from Database
              <input type="radio" id="computed_from_database" class="" name="computation_sheet_version" value="Computed from Database" onclick="document.getElementById('form_custody').style.display='none'; document.getElementById('form_custody').required = false;">
            </label>
            <label for="working">Working
              <input type="radio" id="working" class="" name="computation_sheet_version" value="Working" required="" onclick="document.getElementById('form_custody').style.display=''; document.getElementById('form_custody').required = true;">
            </label>

            <select id="form_custody" name="form_custody" class="form-control" autofocus="" style="display:none;">
                <option value="">Choose Custody</option>
                <option value="sole">Sole</option>
                <option value="shared">Shared</option>
                <option value="split">Split</option>
            </select>
            <br>
            <input type="submit" id="modal_submit_btn" class="btn btn-success mt-2" value="Submit">       
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <!-- Modal End-->
<script>
 

  function setCaseCustody(case_id, state_id)
  {
    $('#modal_case_id').val(case_id);
    $('#modal_state_id').val(state_id);
  }

  $(document).ready( function () {
    $('.cases-table').DataTable({
        pageLength: 50,
       
        aaSorting: []
    });
  });
</script>        
@endsection