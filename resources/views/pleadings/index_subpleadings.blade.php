@foreach($subordinatepleadings as $subordinatepleading)
  <table class="table table-bordered pleadings-table">
    <caption style="font-weight: bold; color: #212529; caption-side:top;">SP #{{$subordinatepleading->pleading_level}} ({{$subordinatepleading->pleading_name}})</caption>
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
      @foreach($subordinatepleading->pleadingparties as $subordinatepleadingparty)
      @if($subordinatepleadingparty->party_type=='responsible')
        <?php
          $name=\App\User::where('id', $subordinatepleadingparty->party_id)->get()->pluck('name')->first();
          $caseuser=\App\Caseuser::where([
                        ['case_id', $case_data->id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $subordinatepleadingparty->party_id]
                    ])->get()
                    ->first();
          if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
              $party_name=$caseuser->org_comp_name;
          } else {
              if(isset($caseuser->mname) && $caseuser->mname !='') {
                  $mname=$caseuser->mname;
                  $namearray = explode(' ', $name, 2);
                  if(count($namearray) > 1) {
                      $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
                  } else {
                      $fullname=$name.' '.$mname;
                  }
              } else {
                  $fullname=$name;
              }
              $party_name=$fullname;
          }
          if(isset($caseuser->type)){ 
            $type=$caseuser->type; 
          } else {
            $type=''; 
          }
          if(isset($caseuser->party_group)){ 
            $case_party_group=$caseuser->party_group; 
          } else {
            $case_party_group=''; 
          }
          if(isset($case_data->top_party_type) && $case_data->top_party_type !=''){
              if($case_party_group=='top' || $case_party_group=='bottom'){
                  $party_group=$case_data[''.$case_party_group.'_party_type'];
              }
              if($case_party_group=='top_third'){
                  $case_party_group='top';
                  $party_group='Third-Party '.$case_data[''.$case_party_group.'_party_type'];
              } else if($case_party_group=='bottom_third'){
                  $case_party_group='bottom';
                  $party_group='Third-Party '.$case_data[''.$case_party_group.'_party_type'];
              }
          } else {
              if($case_party_group=='top' || $case_party_group=='bottom'){
                  $party_group=$case_data['original_'.$case_party_group.'_party_type'];
              }
              if($case_party_group=='top_third'){
                  $case_party_group='top';
                  $party_group='Third-Party '.$case_data['original_'.$case_party_group.'_party_type'];
              } else if($case_party_group=='bottom_third'){
                  $case_party_group='bottom';
                  $party_group='Third-Party '.$case_data['original_'.$case_party_group.'_party_type'];
              }
          }
        ?>

        <?php
          $date = new DateTime($subordinatepleadingparty->current_deadline);
          $now = new DateTime();
          $diff=$now->diff($date)->format("%R%a");

        ?>
        <form method="POST" id="select_action_form_{{$case_data->id}}_{{$subordinatepleading->id}}_{{$subordinatepleadingparty->id}}" action="{{route('cases.pleadings.subordinate.create')}}" autocomplete="off">
        <tr>
          <?php $responsibles[$subordinatepleading->id][$subordinatepleadingparty->id]=$party_name; ?>
          <td>{{$party_name}}</td>
          <!-- <td>
              <a class="btn btn-primary" href="javascript:void(0);">{{$buttontext}}</a>
          </td> -->
           <td>
            <!-- <input type="hidden" id="desired_filedate_{{$subordinatepleading->id}}_{{$subordinatepleadingparty->id}}" name="desired_filedate" class="form-control hasDatepicker desired_filedate_inputs" value="<?php //if(isset($subordinatepleading->date_filed)){ echo date("m/d/Y", strtotime($subordinatepleading->date_filed)); } else { date('m/d/Y'); } ?>" data-pleading-id="{{ $subordinatepleading->id }}" data-pleading-party-id="{{ $subordinatepleadingparty->id }}"> -->
            {{ ucwords($type) }}
           </td>
          <td><input type="text" id="deadline_to_ammend_{{$subordinatepleading->id}}_{{$subordinatepleadingparty->id}}" name="deadline_to_ammend" class="form-control hasDatepicker deadline_to_ammend_inputs" data-pleading-id="{{ $subordinatepleading->id }}" data-pleading-party-id="{{ $subordinatepleadingparty->id }}" value="<?php if(isset($subordinatepleadingparty->current_deadline)){ echo date("m/d/Y", strtotime($subordinatepleadingparty->current_deadline)); } ?>"></td>

          <td>
                @csrf
                <input type="hidden" name="case_id" value="{{ $case_data->id }}">
                <input type="hidden" name="pleading_id" value="{{ $subordinatepleading->id }}">
                <input type="hidden" name="select_party_id" value="{{ $subordinatepleadingparty->party_id }}">
                <select name="pleading_action_type" class="select_action form-control" style="width: 90%;">
                  <option>Select</option>
                  @if($subordinatepleadingparty->type !='client' && $subordinatepleadingparty->type !='ally')
                      @if($subordinatepleading->pleading_type_id == '1')
                          @foreach($select_action_data['TP_Complaints'] as $options)
                              <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                          @endforeach
                      @elseif($subordinatepleading->pleading_type_id == '3')
                          @foreach($select_action_data['TP_Answer_to_CC'] as $options)
                              <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                          @endforeach
                      @endif
                  @else
                      @if($subordinatepleading->pleading_type_id == '1')
                          @foreach($select_action_data['Resp_Complaints'] as $options)
                              <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                          @endforeach
                      @elseif($subordinatepleading->pleading_type_id == '3')
                          @foreach($select_action_data['Resp_Answer_to_CC'] as $options)
                              <option value="{{$options->package_name}}">{{$options->package_name}}</option>
                          @endforeach
                      @endif
                  @endif
                </select>
          </td>
          <td><a class="btn btn-primary" href="javascript:void(0);" style="width:90%;" onclick="event.preventDefault();
                             document.getElementById('select_action_form_{{$case_data->id}}_{{$subordinatepleading->id}}_{{$subordinatepleadingparty->id}}').submit();">Go</a></td>
        </tr>
        </form>
      @endif
      @endforeach
      <tr>
        <td colspan="6">
          <div class="pleading-buttons-main-div">
            <div class="pleading-button-div">
              <a class="btn btn-info" href="{{ route('cases.pleadings.subordinate.edit',['case_id' => $case_data->id, 'pleading_id' => $subordinatepleading->id]) }}">Pleading Log</a>
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
      @if(count($subordinatepleading->subpleadings))

        @include('pleadings.index_subpleadings',['subordinatepleadings' => $subordinatepleading->subpleadings])

      @endif
  <?php 
    //$l++; 
    //++$z; 
  ?>
  @endforeach