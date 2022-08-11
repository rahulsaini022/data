@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center motions-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Case Motions') }}</strong>
                    <div class="d-inline-block mb-1 ml-5">
                        <?php
                          $case_type_ids=$case_data->case_type_ids;
                          $case_type_ids=explode(",",$case_type_ids);
                          $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                          $hascaseid = !empty(array_intersect($array, $case_type_ids));
                        ?>
                        @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
                          <form method="POST" action="{{route('cases.computations_sheet')}}">
                            @csrf
                            <input type="hidden" name="case_id" value="{{$case_data->id}}">
                            <input type="hidden" name="form_state" value="{{$case_data->state_id}}">
                            <input type="hidden" name="form_custody" value="{{$case_data->custody}}">
                            <input type="submit" class="btn btn-success" name="submit" value="FDD Child Comp Sheet">
                          </form>
                        @endif
                    </div>
                    <div class="pull-right">
                      <a class="btn btn-success" href="{{ route('cases.motions.create',['case_id' => $case_data->id]) }}"> Register New Motion</a>
                        <!-- <a class="btn btn-info view-all-motions" title="View All Motions List along with Overruled Motions."> View All</a> -->
                        <a class="btn btn-primary" href="{{ route('cases.index') }}"> Back</a>

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
                    @if(isset($motions) && count($motions) > 0 ) 
                    <?php $respondents=array(); $j=0; //$i=0; $z=0;  ?>
                    @foreach($motions as $motion)
                      <table class="table table-bordered motions-table">
                        <caption style="font-weight: bold; color: #212529; caption-side:top;">CM #{{$motion->motion_level}} ({{$motion->motion_name}})</caption>
                        <thead>
                           <tr>
                             <th>Respondent</th>
                             <th>Role</th>
                             <th>Type</th>
                             <th>Deadline</th>
                             <th>Select Action</th>
                             <th>Draft It/Do It</th>
                           </tr>
                        </thead>
                        <tbody>
                          @foreach($motion->motionparties as $motionparty)
                          @if($motionparty->party_type=='respondent')
                            <tr>
                              <?php $respondents[$motion->id][$motionparty->id]=$motionparty->name; ?>
                              <td>{{$motionparty->name}}</td>
                              <td>Respondent/{{$motionparty->party_group}}</td>
                              <td>{{ucfirst($motionparty->type)}}</td>
                              <?php
                                $date = new DateTime($motionparty->response_deadline);
                                $now = new DateTime();
                                $diff=$now->diff($date)->format("%R%a");
                              ?>
                              @if($diff > 6)
                                <td><span style="background-color: #72BF44;">{{date("m-d-Y", strtotime($motionparty->response_deadline))}}</span></td>
                              @elseif($diff <= 6 && $diff >=0)
                                <td><span style="background-color: #FFF200;">{{date("m-d-Y", strtotime($motionparty->response_deadline))}}</span></td>
                              @elseif($diff < 0)
                                <td><span style="background-color: red;">{{date("m-d-Y", strtotime($motionparty->response_deadline))}}</span></td>
                              @endif

                              <td>
                                  <form method="POST" id="select_action_form_{{$case_data->id}}_{{$motion->id}}_{{$motionparty->id}}" action="{{ route('cases.motions.subordinate.create') }}" autocomplete="off">
                                    @csrf
                                    <input type="hidden" name="case_id" value="{{ $case_data->id }}">
                                    <input type="hidden" name="motion_id" value="{{ $motion->id }}">
                                    <input type="hidden" name="select_party_id" value="{{ $motionparty->party_id }}">
                                    <select name="motion_action_type" class="select_action form-control" style="width: 90%;">
                                      @if($motionparty->type=='client' )
                                        <option value="Draft Response">Draft Response</option>
                                      @else
                                        <option value="Register Response">Register Response</option>
                                      @endif
                                      @if($diff < 0)
                                        <option value="Instanter">Instanter</option>
                                      @else
                                        <option value="Extension">Extension</option>
                                      @endif
                                      
                                      <option value="Agreed Entry">Agreed Entry</option>
                                      <option value="OTHER">OTHER</option>
                                    </select>
                                  </form>
                              </td>
                              <td><a class="btn btn-primary" href="#" style="width:90%;" onclick="event.preventDefault();
                                                 document.getElementById('select_action_form_{{$case_data->id}}_{{$motion->id}}_{{$motionparty->id}}').submit();">Go</a></td>
                            </tr>
                          @endif
                          @endforeach
                          <tr class="motion_buttons motion_button_<?php echo $motion->id; ?> mainmotionid_<?php echo $j; ?>">
                            <td colspan="6">
                              <div class="motion-buttons-main-div">
                                <div class="motion-button-div">
                                  <a class="btn btn-info" href="{{ route('cases.motions.edit',['case_id' => $case_data->id, 'motion_id' => $motion->id]) }}">Motion Log</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6" style="padding: 18px 0"></td>
                          </tr>
                        </tbody>
                      </table>
                      <?php //$i++; ?>
                          <?php $k=1; //$l=$j.'.'.$k; $mr=35;?>
                          @if(count($motion->submotions))

                            @include('motions.index_submotions',['subordinatemotions' => $motion->submotions])

                          @endif
                      <?php 
                        //$l++; 
                        //++$z; 
                      ?>

                      @endforeach
                      @else
                      <p>No Motion found for this case.</p>
                      @endif

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
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="modal-form" class="modal-form" method="POST" action="" autocomplete="off">
            @csrf
            <input type="hidden" name="case_id" value="{{$case_data->id}}">
            <input type="hidden" class="motion_id" name="motion_id" value="">
            <div id="append-fields">
              
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    <!-- Modal End-->
</div>
<script>
  function showMotionButtons(motionbutton, mainmotionid){
    // $('.mainmotionid_'+mainmotionid+'').hide();
    // $('.motion_button_'+motionbutton.value+'').show();
  }

  // to change motion status
  // function changeStatus(motion_id, motion_status, type){
  //   var action="{{route('cases.motions.changestatus')}}";
  //   $(".motion_id").val(motion_id);
  //   $("#modal-form").attr('action', action);
  //   $(".modal-title").text('Change Status');
  //   if(type=='core'){
  //     var statusfield='<div><label for="motion_status" class="col-form-label text-md-left">Motion Status</label><select id="motion_status" name="motion_status" class="form-control" required=""><option value="Pending">Pending</option><option value="Granted">Granted</option></select><div class="mt-2 text-center"><button type="submit" name="save" class="btn btn-primary">Save</button></div></div>';
  //   } else {
  //     var statusfield='<div><label for="motion_status" class="col-form-label text-md-left">Motion Status</label><select id="motion_status" name="motion_status" class="form-control" required=""><option value="Pending">Pending</option><option value="Granted">Granted</option><option value="Overruled">Overruled</option></select><div class="mt-2 text-center"><button type="submit" name="save" class="btn btn-primary">Save</button></div></div>';
  //   }

  //   $('#append-fields').html(statusfield);
  //   $("#motion_status option[value='"+motion_status+"']").attr("selected","selected");
  // }

  // to extend response deadline for all/perticular party
  // function extendDeadline(motion_id, type){
  //   var action="{{route('cases.motions.extenddeadline')}}";
  //   var respondents='<?php if(isset($respondents) && count($respondents) > 0) { echo json_encode($respondents);} ?>';
  //   var motionparties='';
  //   if(respondents){
  //     var respondents= JSON.parse(respondents);
  //     var allmotionparties=respondents[''+motion_id+''];
  //     for (var key of Object.keys(allmotionparties)) {
  //       // console.log(key + "=" + allmotionparties[key]);
  //       motionparties=motionparties+'<label class="col-sm-4 col-form-label text-md-left"> <input type="radio" name="motionparty_id" value="'+key+'"> '+allmotionparties[key]+'</label>';
  //     }
  //   }
  //   $(".motion_id").val(motion_id);
  //   $("#modal-form").attr('action', action);
  //   $(".modal-title").text('Extend Response Deadline');
  //   var extenddeadlinefield='<div><div><label for="motion_status" class="col-form-label text-md-left">Extend For</label><label class="col-sm-4 col-form-label text-md-left"> <input type="radio" name="motionparty_id" value="all" required> All Respondents</label>'+motionparties+'</div><div><label for="motion_status" class="col-form-label text-md-left">New Response Deadline</label> <input id="response_deadline" type="text" class="form-control hasDatepicker" name="response_deadline" value="" autocomplete="nope" required></div><div class="mt-2 text-center"><button type="submit" name="save" class="btn btn-primary">Save</button></div></div>';
  //     $('#append-fields').html(extenddeadlinefield);
  //     $('#response_deadline').datepicker({
  //         startDate: "01/01/1901",
  //         // endDate: '+0d',
  //     });
  // }

  // to add agreed entry
  // function agreedEntry(motion_id, agreed_entry){
  //   var action="{{route('cases.motions.agreedentry')}}";
  //   $(".motion_id").val(motion_id);
  //   $("#modal-form").attr('action', action);
  //   $(".modal-title").text('Enter Agreed Entry');
  //   var agreedentryfield='<div><label for="motion_status" class="col-form-label text-md-left">Agreed Entry</label><textarea class="form-control" name="agreed_entry" rows="4">'+agreed_entry+'</textarea><div class="mt-2 text-center"><button type="submit" name="save" class="btn btn-primary">Save</button></div></div>';
  //     $('#append-fields').html(agreedentryfield);
  // }

  $(document).ready( function () {
    // $('.motions-table').DataTable({
    //     pageLength: 50,
    //     responsive: true,
    //     aaSorting: [],
    //     searching: false,
    //     bPaginate: false,
    //     bInfo: false,
    // });

    // $('.view-all-motions').on('click', function(){
    //   $('.motion-overruled').show();
    // });
  });
</script>
@endsection