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

                    <table class="table table-bordered cases-table">
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
                            @if(isset($hascaseid) && $hascaseid=='1' && $case->state_id=='35')
                             <a class="btn btn-primary mb-2" href="{{ route('cases.edit_case_data',$case->id) }}">Edit</a>
                            @else
                             <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case->id) }}">Edit</a>
                            @endif
                            
                            @if($case->payment_status && $case->case_payment_package_id=='14')
                              <a class="btn btn-primary mb-2" href="{{route('cases.pleadings',$case->id)}}">Draft Docket</a>
                              @if(isset($case) && ($case->division_id=='7' || $case->division_id=='8'))
                                <!-- <a class="btn btn-info mb-2" href="#">Upgrade</a> -->
                                <!-- <label class="badge badge-success">Payment Done</label> -->
                              @else                        
                                <!-- <label class="badge badge-success">Payment Done</label> -->
                              @endif
                            @elseif($case->payment_status && $case->case_payment_package_id !='14')
                              <a class="btn btn-info mb-2" href="{{ route('cases.get_upgrade_package_payment_form',$case->id) }}">Upgrade</a>
                            @else
                              <a class="btn btn-primary mb-2" href="{{ route('cases.payment',$case->id) }}">Pay</a>
                            @endif

                            @if(isset($hascaseid) && $hascaseid=='1' && $case->state_id=='35')
                                <a class="btn btn-success" href="#" data-toggle="modal" data-target="#myModal" onclick="setCaseCustody('{{ $case->id }}', '{{$case->state_id}}')">Client Input Forms</a>
                                @if(isset($case['family_law_interview_done'])  && $case['family_law_interview_done']==true)
                                  <label class="badge badge-success mb-2 mt-2" style="font-weight: normal; font-size: 12px;">Family Law Interview Completed</label>
                                @endif
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
            <select id="form_custody" name="form_custody" class="form-control" required="" autofocus="">
                <option value="">Choose Custody</option>
                <option value="sole">Sole</option>
                <option value="shared">Shared</option>
                <option value="split">Split</option>
            </select>
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
        responsive: true,
        aaSorting: []
    });
  });
</script>        
@endsection