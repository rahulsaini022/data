@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center pleadings-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Draft Docket') }}</strong>
                    <?php
                      $case_type_ids=$case_data->case_type_ids;
                      $case_type_ids=explode(",",$case_type_ids);
                      $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                      $hascaseid = !empty(array_intersect($array, $case_type_ids));
                    ?>
                    <div class="pull-right">
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

                    <div class="col-sm-12">
                      <table class="table table-bordered">
                        <tbody>
                          <tr>
                            @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
                                <td>
                                    <form method="POST" action="{{route('cases.computations_sheet')}}">
                                      @csrf
                                      <input type="hidden" name="case_id" value="{{$case_data->id}}">
                                      <input type="hidden" name="form_state" value="{{$case_data->state_id}}">
                                      <input type="hidden" name="form_custody" value="{{$case_data->custody}}">
                                      <input type="submit" class="btn btn-success" name="submit" value="FDD Quick Child Comp Sheet">
                                    </form>
                                </td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                  Case Practice Aids
                                </button>
                            </td>
                            <td>
                                <a class="btn btn-success" href="javascript:void(0);"> Draft New Motion</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('cases.motions.create',['case_id' => $case_data->id]) }}"> Register New Motion</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="javascript:void(0);"> Draft New Pleading</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ route('cases.pleadings.create',['case_id' => $case_data->id]) }}"> Register New Pleading</a>
                            </td>
                          </tr>
                          <tr>
                            @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
                                <td>
                                  <button type="button" class="btn btn-success notices-famlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('notices-famlaw');"> Notices </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success correspondence-famlaw-nonfamlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('correspondence-famlaw-nonfamlaw');"> Correspondence </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success discovery-famlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('discovery-famlaw');"> Discovery </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success forms-and-affidavits-famlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('forms-and-affidavits-famlaw');"> Forms & Affidavits </button>
                                </td>
                            @else
                                <td>
                                  <button type="button" class="btn btn-success notices-nonfamlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('notices-nonfamlaw');"> Notices </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success correspondence-famlaw-nonfamlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('correspondence-famlaw-nonfamlaw');"> Correspondence </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success discovery-nonfamlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('discovery-nonfamlaw');"> Discovery </button>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-success forms-and-affidavits-nonfamlaw" data-toggle="modal" data-target="#myNewDynamicModal" onclick="getPopupSelectOptions('forms-and-affidavits-nonfamlaw');"> Forms & Affidavits </button>
                                </td>
                            @endif
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <table class="table table-bordered pleadings-table">
                      <caption style="font-weight: bold; color: #212529; caption-side:top;"></caption>
                      <thead>
                         <tr>
                           <th>Pleadings Practice</th>
                           @if(!$already_has_complaint_pleading)
                           <th></th>
                           @endif
                           <!-- <th>Filedate</th> -->
                           @if($case_data->filing_type == 'to_be_filed_new')
                            <th>Reg Date</th>
                           @else
                            <th>Desired Filing Date</th>
                           @endif
                           @if($case_data->filing_type == 'to_be_filed_new')
                            <th>Desired Filing Date</th>
                           @else
                            <th>Deadline to Amend</th>
                           @endif
                           <th>Select Action</th>
                           <th>Draft It/Do It</th>
                         </tr>
                      </thead>
                      <tbody>
                        <?php
                        $date=date('m/d/Y');
                        $date = new DateTime($date);
                        $date->add(new DateInterval('P28D'));
                        $now = new DateTime();
                        $diff=$now->diff($date)->format("%R%a");

                        $buttontext='N/A';
                        $buttonclass='dynamic_button';
                        $dropdown='<option value="Answer">Answer</option><option value="Extension">Extension</option><option value="Dismiss Rule12b6">Dismiss Rule12b6</option><option value="More Definite Statement">More Definite Statement</option><option value="OTHER">OTHER</option>';
                        // if($diff < 0){
                        //   $dropdown='<option value="Answer">Answer</option><option value="Answer Instanter">Answer Instanter</option><option value="Dismiss Rule12b6">Dismiss Rule12b6</option><option value="More Definite Statement">More Definite Statement</option><option value="OTHER">OTHER</option>';
                        // }
                        if($case_data->filing_type=='to_be_filed_new' && $case_data->division_id!='8')
                        {
                          $buttontext='Draft Complaint Package';
                          if($already_has_complaint_pleading){
                            $buttonclass='dynamic_button_draft_complaint d-none';
                          } else {
                            $buttonclass='dynamic_button_draft_complaint';
                          }
                          $dropdown='<option value="N/A">N/A</option>';
                        }

                        if($case_data->filing_type=='to_be_filed_new' && $case_data->division_id=='8' && isset($casefamlawdata) && $casefamlawdata==false)
                        {
                          $buttontext='Complete Family Law Interview';
                          $dropdown='<option value="N/A">N/A</option>';
                        }

                        // if($case_data->filing_type!='to_be_filed_new' && $case_data->division_id!='8')
                        // {
                        //   $buttontext='N/A';
                        //   $dropdown='<option value="Register Answer">Register Answer</option><option value="Amend Complaint/Petition">Amend Complaint/Petition</option><option value="Dismissal – Rule 41">Dismissal – Rule 41</option><option value="Agreed Judgment">Agreed Judgment</option><option value="OTHER">OTHER</option>';
                        // }

                        // if($case_data->filing_type!='to_be_filed_new' && $case_data->division_id=='8')
                        // {
                        //   $buttontext='N/A';
                        //   if(isset($casefamlawdata) && $casefamlawdata==false)
                        //   {
                        //     $dropdown='<option value="Complete Family Law Interview">Complete Family Law Interview</option><option value="Register Answer">Register Answer</option><option value="Amend Complaint/Petition">Amend Complaint/Petition</option><option value="Dismissal – Rule 41">Dismissal – Rule 41</option><option value="Agreed Judgment">Agreed Judgment</option><option value="OTHER">OTHER</option>';
                        //   } else {
                        //     $dropdown='<option value="Register Answer">Register Answer</option><option value="Amend Complaint/Petition">Amend Complaint/Petition</option><option value="Dismissal – Rule 41">Dismissal – Rule 41</option><option value="Agreed Judgment">Agreed Judgment</option><option value="OTHER">OTHER</option>';
                        //   }
                        // }
                        if(isset($casefamlawdata) && $casefamlawdata==true && $case_data->division_id=='8')
                        {
                          $buttontext='Edit Family Law Interview';
                          //$dropdown='<option value="Register Answer">Register Answer</option><option value="Amend Complaint/Petition">Amend Complaint/Petition</option><option value="Dismissal – Rule 41">Dismissal – Rule 41</option><option value="Agreed Judgment">Agreed Judgment</option><option value="OTHER">OTHER</option>';
                        }


                      ?>
                        @foreach($top_party_data as $topparties)
                        <tr class="top_party_data_tr">
                          <td>{{$topparties->name}}</td>
                          <!-- @if($buttontext=='Complete Family Law Interview' || $buttontext=='Edit Family Law Interview')
                            <td><a class="btn btn-primary" href="{{route('cases.pleadings.completefamlawinterview', ['case_id' => $case_data->id])}}">{{$buttontext}}</a></td>
                          @else
                            <td><a class="btn btn-primary {{ $buttonclass }}" href="javascript:void(0);">{{$buttontext}}</a></td>
                          @endif -->
                          @if(!$already_has_complaint_pleading)
                            @if($buttontext=='Complete Family Law Interview' || $buttontext=='Edit Family Law Interview')
                              <td><a class="btn btn-primary" href="{{route('cases.pleadings.completefamlawinterview', ['case_id' => $case_data->id])}}">{{$buttontext}}</a></td>
                            @else
                              <td><a class="btn btn-primary {{ $buttonclass }}" href="javascript:void(0);">{{$buttontext}}</a></td>
                            @endif
                          @endif
                          @if($case_data->filing_type == 'to_be_filed_new')
                              <td>{{ date('m/d/Y') }}</td>
                              <td class="desired_filing_date_td"><input type="text" class="form-control desired_filing_date_td_input" name=""></td>
                              <td>
                                <select name="pleading_practiceaction_type" class="select_action form-control" style="width: 90%;">
                                  <!-- {!! $dropdown !!} -->
                                  <option>Select</option>
                                  @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
                                    @foreach($case_complaints_FamLaw as $options)
                                        <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                    @endforeach
                                  @else
                                    @foreach($case_complaints_Not_FamLaw as $options)
                                        <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </td>
                              <td><button type="button" class="btn btn-primary">Draft It/Do It</button></td>
                          @else
                              <td class="desired_filing_date_td"><input type="text" class="form-control desired_filing_date_td_input" name=""></td>
                              <td class="deadline_to_ammend_td">N/A</td>
                              <td>
                                <select name="pleading_practiceaction_type" class="select_action form-control" style="width: 90%;">
                                  <!-- {!! $dropdown !!} -->
                                  <option>Select</option>
                                  @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
                                    @if($case_data->filing_type == 'prev_filed_post_decree')
                                        @foreach($PostDecreeMotions_FamLaw as $options)
                                            <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                        @endforeach
                                    @else
                                        @foreach($PostComplaintPleadings_FamLaw as $options)
                                            <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                        @endforeach
                                    @endif
                                  @else
                                    @foreach($PostComplaintPleadings_NOT_FamLaw as $options)
                                        <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                    @endforeach
                                  @endif
                                </select>
                              </td>
                              <td><button type="button" class="btn btn-primary">Draft It/Do It</button></td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>

                    </table>
                    @if(isset($pleadings) && count($pleadings) > 0 )
                    <?php $filings=array();$responsibles=array(); $j=0; //$i=0; $z=0;  ?>
                    @foreach($pleadings as $pleading)
                      <table class="table table-bordered pleadings-table">
                        <caption style="font-weight: bold; color: #212529; caption-side:top;">CP #{{$pleading->pleading_level}} ({{$pleading->pleading_name}})</caption>
                        <thead>
                           <tr>
                             <th>Responsible Party</th>
                             <!-- <th></th> -->
                             <th>Type</th>
                             <th>Deadline</th>
                             <th>Select Action</th>
                             <th>Draft It/Do It</th>
                           </tr>
                        </thead>
                        <tbody>
                          @foreach($pleading->pleadingparties as $pleadingparty)
                          @if($pleadingparty->party_type=='responsible')
                            <?php
                              $date = new DateTime($pleadingparty->current_deadline);
                              $now = new DateTime();
                              $diff=$now->diff($date)->format("%R%a");

                            ?>
                            <form method="POST" id="select_action_form_{{$case_data->id}}_{{$pleading->id}}_{{$pleadingparty->id}}" action="{{route('cases.pleadings.subordinate.create')}}" autocomplete="off">
                            <tr>
                              <?php $responsibles[$pleading->id][$pleadingparty->id]=$pleadingparty->name; ?>
                              <td>{{$pleadingparty->name}}</td>
                              <!-- <td>
                                  <a class="btn btn-primary" href="javascript:void(0);">{{$buttontext}}</a>
                              </td> -->
                              <td>
                                <!-- <input type="hidden" id="desired_filedate_{{$pleading->id}}_{{$pleadingparty->id}}" name="desired_filedate" class="form-control hasDatepicker desired_filedate_inputs" value="<?php //if(isset($pleading->date_filed)){ echo date("m/d/Y", strtotime($pleading->date_filed)); } else { date('m/d/Y'); } ?>" data-pleading-id="{{ $pleading->id }}" data-pleading-party-id="{{ $pleadingparty->id }}"> -->
                                {{ ucwords($pleadingparty->type) }}
                              </td>
                              <td><input type="text" id="deadline_to_ammend_{{$pleading->id}}_{{$pleadingparty->id}}" name="deadline_to_ammend" class="form-control hasDatepicker deadline_to_ammend_inputs" data-pleading-id="{{ $pleading->id }}" data-pleading-party-id="{{ $pleadingparty->id }}" value="<?php if(isset($pleadingparty->current_deadline)){ echo date("m/d/Y", strtotime($pleadingparty->current_deadline)); } ?>"></td>

                              <td>
                                    @csrf
                                    <input type="hidden" name="case_id" value="{{ $case_data->id }}">
                                    <input type="hidden" name="pleading_id" value="{{ $pleading->id }}">
                                    <input type="hidden" name="select_party_id" value="{{ $pleadingparty->party_id }}">
                                    <select name="pleading_action_type" class="select_action form-control" style="width: 90%;">
                                      <option>Select</option>
                                      @if($pleadingparty->type !='client' && $pleadingparty->type !='ally')
                                          @if($pleading->pleading_type_id == '1')
                                              @foreach($select_action_data['TP_Complaints'] as $options)
                                                  <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                              @endforeach
                                          @elseif($pleading->pleading_type_id == '3')
                                              @foreach($select_action_data['TP_Answer_to_CC'] as $options)
                                                  <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                              @endforeach
                                          @endif
                                      @else
                                          @if($pleading->pleading_type_id == '1')
                                              @foreach($select_action_data['Resp_Complaints'] as $options)
                                                  <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                              @endforeach
                                          @elseif($pleading->pleading_type_id == '3')
                                              @foreach($select_action_data['Resp_Answer_to_CC'] as $options)
                                                  <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                                              @endforeach
                                          @endif
                                      @endif
                                    </select>
                              </td>
                              <td><a class="btn btn-primary" href="javascript:void(0);" style="width:90%;" onclick="event.preventDefault();
                                                 document.getElementById('select_action_form_{{$case_data->id}}_{{$pleading->id}}_{{$pleadingparty->id}}').submit();">Go</a></td>
                            </tr>
                            </form>
                          @endif
                          @endforeach
                          <tr>
                            <td colspan="6">
                              <div class="pleading-buttons-main-div">
                                <div class="pleading-button-div">
                                  <a class="btn btn-info" href="{{ route('cases.pleadings.edit',['case_id' => $case_data->id, 'pleading_id' => $pleading->id]) }}">Pleading Log</a>
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
                          @if(count($pleading->subpleadings))

                            @include('pleadings.index_subpleadings',['subordinatepleadings' => $pleading->subpleadings])

                          @endif
                      <?php 
                        //$l++; 
                        //++$z; 
                      ?>
                      @endforeach
                      @else
                      <p>No Pleading found for this case.</p>
                      @endif

                </div>
            </div>          
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Draft/Download Case Practice Aids</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        @if(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35')
        <form method="POST" action="{{ route('draft_case_practice_aids') }}">
            @csrf
            <input type="hidden" name="case_practice_aid_type" value="fam_law" style="display: none;">
            <input type="hidden" name="case_id" value="{{$case_data->id}}" style="display: none;">
            <div class="">
                <select id="select_case_practice_aid" name="select_case_practice_aid" class="form-control col-md-5 custom-select letter_dropdown mb-2" required="">
                    <option value="">Select</option>
                    @foreach($case_practice_aids_FamLaw as $case_practice_aid)
                        <option value="{{$case_practice_aid->package_name}}">{{$case_practice_aid->package_name}}</option>

                    @endforeach
                </select>
                <input type="submit" class="btn btn-success mb-2" name="submit" value="Draft/Download">
            </div>
        </form>
      @else
        <form method="POST" action="{{ route('draft_case_practice_aids') }}">
            @csrf
            <input type="hidden" name="case_practice_aid_type" value="non_fam_law" style="display: none;">
            <input type="hidden" name="case_id" value="{{$case_data->id}}" style="display: none;">
            <div class="">
                <select id="select_case_practice_aid" name="select_case_practice_aid" class="form-control col-md-5 custom-select letter_dropdown mb-2" required="">
                    <option value="">Select</option>
                    @foreach($case_practice_aids_NFL as $case_practice_aid)
                        <option value="{{$case_practice_aid->package_name}}">{{$case_practice_aid->package_name}}</option>

                    @endforeach
                </select>
                <input type="submit" class="btn btn-success mb-2" name="submit" value="Draft/Download">
            </div>
        </form>
      @endif
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- end Modal -->

<!-- The Dynamic Modal -->
<div class="modal" id="myDynamicModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Draft Complaint Package</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center {{ $buttonclass }}_modal_content"">
        <form method="POST" action="{{route('draft_complaint_package')}}">
            @csrf
            <input type="hidden" name="case_id" value="{{$case_data->id}}" style="display: none;">
            @if(!(isset($hascaseid) && $hascaseid=='1' && $case_data->state_id=='35'))
            <div class="col-sm-12 d-inline-flex mb-2">
              <label class="col-sm-6"> Choose Complaint </label>
              <div class="col-sm-6">
                <select id="select_complaint_type" name="select_complaint_type" class="form-control" required="">
                    <option value="">Select</option>
                    @foreach($case_complaints_Not_FamLaw as $options)
                        <option value="{{$options->package_name}}">{{$options->package_name}}</option>

                    @endforeach
                </select>
              </div>
            </div>
            @endif
            <div class="col-sm-12 d-inline-flex mb-2">
              <label class="col-sm-6"> Verified Complaint? </label>
              <div class="col-sm-6">
                <label><input type="radio" name="verified_complaint" value="Yes" required=""> Yes</label>
                <label><input type="radio" name="verified_complaint" value="No" checked=""> No</label>
              </div>
            </div>
            <div class="col-sm-12 d-inline-flex">
              <label class="col-sm-6"> Number of exhibits </label>
              <div class="col-sm-6">
                <input type="number" id="number_of_exhibits" class="form-control" name="number_of_exhibits" required="">
              </div>
            </div>
            <div class="col-sm-12 mt-4">
                <input type="submit" class="btn btn-success mb-2" name="submit" value="Draft">
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- end dynamic modal -->

<!-- The New Dynamic Modal -->
<div class="modal" id="myNewDynamicModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body text-center">
        <form method="POST" action="">
            @csrf
            <input type="hidden" name="case_id" value="{{$case_data->id}}" style="display: none;">
            <input id="type" type="hidden" name="type" value="" style="display: none;" required="">
            <div class="col-sm-12 d-inline-flex mb-2">
              <label class="col-sm-6"> Choose Type </label>
              <div class="col-sm-6">
                <select id="select_type" name="select_type" class="form-control" required="">
                    <option value="">Select</option>
                </select>
              </div>
            </div>
            
            <div class="col-sm-12 mt-4">
                <input type="submit" class="btn btn-success mb-2" name="submit" value="Submit">
            </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<!-- end new dynamic modal -->
<script>

  function getPopupSelectOptions(type){
      $('#myNewDynamicModal #type').val('');
      $('#myNewDynamicModal #type').val(type);
      $('#myNewDynamicModal #select_type').find('option:not(:first)').remove();
      var token= $('input[name=_token]').val();
      $.ajax({
          url:"{{route('ajax_get_pleading_popup_select_options')}}",
          method:"POST",
          // dataType: 'json',
          data:{
              type: type, 
              _token: token, 
          },
          success: function(data){
              if(data=='null' || data==''){
                  
              } else {
                  $.each(data, function (key, val) {
                      $('#myNewDynamicModal #select_type').append('<option value='+key+'>'+val+'</option>');
                  });
              }
          }
      });
  } 

  $(document).ready( function () {
    // $('.pleadings-table').DataTable({
    //     pageLength: 50,
    //     responsive: true,
    //     aaSorting: [],
    //     searching: false,
    //     bPaginate: false,
    //     bInfo: false,
    // });

    var start_date="{{date('m/d/Y')}}";
    if(start_date){
        var token= $('input[name=_token]').val();
        $.ajax({
            url:"{{route('ajax_get_pleading_deadlines')}}",
            method:"POST",
            // dataType: 'json',
            data:{
                start_date: start_date, 
                _token: token, 
            },
            success: function(data){
                if(data=='null' || data==''){
                    //$('.deadline_to_ammend_inputs').val('');
                } else {
                    $('.deadline_to_ammend_inputs').each(function(){
                        //$(this).datepicker("setDate", data);
                    });
                }
            }
        });   
    }

    // $('.desired_filedate_inputs').datepicker( {
    //         startDate: "01/01/1901",
    //     }).on('changeDate',function(ev){
    //         // console.log(ev);
    //     var start_date=this.value;
    //     var pleading_id=$(this).data('pleading-id');
    //     var pleading_party_id=$(this).data('pleading-party-id');
    //     if(start_date){
    //         var token= $('input[name=_token]').val();
    //         $.ajax({
    //             url:"{{route('ajax_get_pleading_deadlines')}}",
    //             method:"POST",
    //             // dataType: 'json',
    //             data:{
    //                 start_date: start_date, 
    //                 _token: token, 
    //             },
    //             success: function(data){
    //                 if(data=='null' || data==''){
    //                     $('#deadline_to_ammend_'+pleading_id+'_'+pleading_party_id+'').val('');
    //                 } else {
    //                     $('#deadline_to_ammend_'+pleading_id+'_'+pleading_party_id+'').datepicker("setDate", data);
    //                 }
    //             }
    //         });   
    //     }
    // });
    // var start_date="{{date('m/d/Y')}}";
    // if(start_date){
    //     var token= $('input[name=_token]').val();
    //     $.ajax({
    //         url:"{{route('ajax_get_pleading_deadlines')}}",
    //         method:"POST",
    //         // dataType: 'json',
    //         data:{
    //             start_date: start_date, 
    //             _token: token, 
    //         },
    //         success: function(data){
    //             if(data=='null' || data==''){
    //                 $('.deadline_to_ammend_td').text('');
    //             } else {
    //                 $('.deadline_to_ammend_td').text(data);
    //             }
    //         }
    //     });   
    // }

    $('.desired_filing_date_td_input').each(function(){
         $(this).datepicker({
        }).datepicker("setDate", new Date());
        var test = this;

        $(this).datepicker({
            startDate: '+0d',
        }).on('changeDate',function(ev){
                // console.log(ev);
            var start_date=this.value;
            if(start_date){
                var token= $('input[name=_token]').val();
                $.ajax({
                    url:"{{route('ajax_get_pleading_deadlines')}}",
                    method:"POST",
                    // dataType: 'json',
                    data:{
                        start_date: start_date, 
                        _token: token, 
                    },
                    success: function(data){
                        if(data=='null' || data==''){
                            $(test).closest('.top_party_data_tr').find('.deadline_to_ammend_td_input').val('');
                        } else {
                            $(test).closest('.top_party_data_tr').find('.deadline_to_ammend_td_input').datepicker("setDate", data);
                        }
                        // console.log($(test).closest('.top_party_data_tr'));
                    }
                });   
            }
        });
    });

    $('.deadline_to_ammend_td_input').each(function(){
         $(this).datepicker({
            startDate: '+0d',
        }).datepicker("setDate", new Date());
    });

    $('.dynamic_button_draft_complaint').click( function(){
      $('#myDynamicModal').modal('show');
    })

  });
</script>
@endsection