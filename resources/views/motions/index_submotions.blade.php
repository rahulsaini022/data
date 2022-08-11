@foreach($subordinatemotions as $subordinatemotion)
<table class="table table-bordered motions-table">
  <caption style="font-weight: bold; color: #212529; caption-side:top;">SM #{{$subordinatemotion->motion_level}} ({{$subordinatemotion->motion_name}})</caption>
    <thead>
       <tr>
         <!-- <th></th> -->
         <!-- <th>Name</th> -->
         <th>Respondent</th>
         <th>Role</th>
         <th>Type</th>
         <th>Deadline</th>

         <!-- <th>Reply Deadline</th> -->
         <!-- <th>Filed</th> -->
         <th>Select Action</th>
         <th>Draft It/Do It</th>
       </tr>
    </thead>
    <tbody>
      @foreach($subordinatemotion->motionparties as $subordinatemotion_party)
      @if($subordinatemotion_party->party_type=='respondent')
      <tr>
        <?php
          $name=\App\User::where('id', $subordinatemotion_party->party_id)->get()->pluck('name')->first();
          $caseuser=\App\Caseuser::where([
                        ['case_id', $case_data->id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $subordinatemotion_party->party_id]
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
        <?php $respondents[$subordinatemotion->id][$subordinatemotion_party->id]=$party_name; ?>
        <td>{{$party_name}}</td>
        <td>Respondent/{{$party_group}}</td>
        <td>{{ucfirst($type)}}</td>
        <!-- <td>{{$subordinatemotion->response_deadline}}</td> -->
        <?php
          $date = new DateTime($subordinatemotion_party->response_deadline);
          $now = new DateTime();
          $diff=$now->diff($date)->format("%R%a");
        ?>
        @if($diff > 6)
          <td><span style="background-color: #72BF44;">{{date("m-d-Y", strtotime($subordinatemotion_party->response_deadline))}}</span></td>
        @elseif($diff <= 6 && $diff >=0)
          <td><span style="background-color: #FFF200;">{{date("m-d-Y", strtotime($subordinatemotion_party->response_deadline))}}</span></td>
        @elseif($diff < 0)
          <td><span style="background-color: red;">{{date("m-d-Y", strtotime($subordinatemotion_party->response_deadline))}}</span></td>
        @endif

        <td>
            <!-- <a class="btn btn-primary" href="{{ route('cases.motions.subordinate.edit',['case_id' => $case_data->id, 'motion_id' => $subordinatemotion->id]) }}">Edit</a> -->
          <form method="POST" id="select_action_form_{{$case_data->id}}_{{$subordinatemotion->id}}_{{$subordinatemotion_party->id}}" action="{{ route('cases.motions.subordinate.create') }}" autocomplete="off">
            @csrf
            <input type="hidden" name="case_id" value="{{ $case_data->id }}">
            <input type="hidden" name="motion_id" value="{{ $subordinatemotion->id }}">
            <input type="hidden" name="select_party_id" value="{{ $subordinatemotion_party->party_id }}">
            <select name="motion_action_type" class="select_action select_action_subordinate form-control" style="width: 90%;">
              @if($type=='client' )
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
        <td><a class="btn btn-primary" href="#" style="width:90%;" onclick="event.preventDefault(); document.getElementById('select_action_form_{{$case_data->id}}_{{$subordinatemotion->id}}_{{$subordinatemotion_party->id}}').submit();">Go</a></td>
      </tr>
      @endif
      @endforeach
      <tr class="motion_buttons motion_button_<?php echo $subordinatemotion->id; ?> mainmotionid_<?php echo $k-1; ?>" style="/* display: none; */">
        <td colspan="6">
          <div class="motion-buttons-main-div">
            <div class="motion-button-div">
              <a class="btn btn-info" href="{{ route('cases.motions.subordinate.edit',['case_id' => $case_data->id, 'motion_id' => $subordinatemotion->id]) }}">Motion Log</a>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td colspan="6" style="padding: 18px 0"></td>
      </tr>
    </tbody>
</table>
@if(count($subordinatemotion->submotions))

  @include('motions.index_submotions',['subordinatemotions' => $subordinatemotion->submotions])

@endif

@endforeach