@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center motions-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Register Subordinate Motion') }}{{$motion_level}}</strong>
                  <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.motions',['case_id' => $case_data->id]) }}"> Back</a>

                    </div>
                </div>
                <?php 
                    $top_party_type='';
                    $bottom_party_type='';
                    if(isset($case_data->top_party_type) && $case_data->top_party_type!=''){
                        $top_party_type=$case_data->top_party_type;
                    } else{
                        $top_party_type=$case_data->original_top_party_type;
                    }

                    if(isset($case_data->bottom_party_type) && $case_data->bottom_party_type!=''){
                        $bottom_party_type=$case_data->bottom_party_type;
                    } else{
                        $bottom_party_type=$case_data->original_bottom_party_type;
                    }

                ?>
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
                    <div id="motion-drafting-section" class="col-sm-12">
                      <form id="motion_form" method="POST" action="{{route('cases.motions.subordinate.store')}}" autocomplete="off">
                          @csrf
                          <input type="hidden" name="case_id" value="{{$case_data->id}}">
                          <input type="hidden" name="parent_motion_id" value="{{$motion->id}}">
                          <input type="hidden" name="motion_category" value="New Subordinate Motion">
                          <input type="hidden" name="motion_action_type" value="{{ $motion_action_type }}">
                          <input type="hidden" name="motion_status" value="Pending">
                          <input type="hidden" name="motion_level" value="{{$motion_level}}">
                          <input type="hidden" name="" id="top_party_type" value="{{$top_party_type}}">
                          <input type="hidden" name="" id="parent_motion_name" value="{{$motion->motion_name}}">
                        <div class="form-group col-sm-12">
                            <h4 class="tableHeading">Choose Movant(s)</h4>
                             @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                <div class="check-box-options check-box-options-heading"><strong>Name</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 1</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 2</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 3</strong></div>
                                @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                <div class="check-box-options check-box-options-heading"><strong>Designation 4</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 5</strong></div>
                                @endif
                            </div>
                            <div class="check_all_movant_top_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_movant_top" id="check_all_movant_top" name="check_all_movant_top" value="" onchange="checkUncheckAllMovant(this, 'check','top');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_movant_top" id="uncheck_all_movant_top" name="uncheck_all_movant_top" value=""  onchange="checkUncheckAllMovant(this, 'uncheck','top');"> Clear All</label></div>
                                </div>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                      @foreach ($top_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="movant_clients left_movants all_movant_top all_movant_top_party" id="left_movant_{{ $party->id }}" name="movants[]" value="{{ $party->id }}" onchange="onMovantChange(this);" required="" data-user-name="{{ $party->name }}" data-user-type="top" data-user-party="{{$top_party_type}}" data-onload="onMovantChange(this);" <?php if(isset($select_party_id) && $select_party_id==$party->id){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_top <?php if(isset($party->designation1) && $party->designation1==$top_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des1_{{ $party->id }}" name="movant_{{ $party->id }}_designation1" value="{{ $top_party_type }}" readonly="" onclick="return false;" style="display:none;"> {{ $top_party_type }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_top <?php if(isset($party->designation2) && $party->designation2=='Cross-claimant'){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des2_{{ $party->id }}" name="movant_{{ $party->id }}_designation2" value="Cross-claimant"> Cross-claimant</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_top <?php if(isset($party->designation3) && $party->designation3=='Cross-claim Defendant'){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des3_{{ $party->id }}" name="movant_{{ $party->id }}_designation3" value="Cross-claim Defendant"> Cross-claim Defendant</label>
                                        </div>
                                        @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_top <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des4_{{ $party->id }}" name="movant_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_top <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des5_{{ $party->id }}" name="movant_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                        @else
                                        <!-- <div class="check-box-options"></div> -->
                                        <!-- <div class="check-box-options"></div> -->
                                        @endif
                                      @endforeach

                                </div>
                            </div>
                            <div class="check_all_movant_bottom_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_movant_bottom" id="check_all_movant_bottom" name="check_all_movant_bottom" value=""  onchange="checkUncheckAllMovant(this, 'check','bottom');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_movant_bottom" id="uncheck_all_movant_bottom" name="uncheck_all_movant_bottom" value=""  onchange="checkUncheckAllMovant(this, 'uncheck','bottom');"> Clear All</label></div>
                                </div>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                    @foreach ($bottom_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="right_movant all_movant_bottom all_movant_bottom_party" id="left_movant_{{ $party->id }}" name="movants[]" value="{{ $party->id }}" onchange="onMovantChange(this);" data-user-name="{{ $party->name }}" data-user-type="bottom" data-user-party="{{$bottom_party_type}}" data-onload="onMovantChange(this);" <?php if(isset($select_party_id) && $select_party_id==$party->id){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_bottom <?php if(isset($party->designation1) && $party->designation1==$bottom_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des1_{{ $party->id }}" name="movant_{{ $party->id }}_designation1" value="{{ $bottom_party_type }}" readonly="" onclick="return false;" style="display:none;"> {{ $bottom_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_bottom <?php if(isset($party->designation2) && $party->designation2=='Cross-claimant'){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des2_{{ $party->id }}" name="movant_{{ $party->id }}_designation2" value="Cross-claimant"> Cross-claimant</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_bottom <?php if(isset($party->designation3) && $party->designation3=='Cross-claim Defendant'){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des3_{{ $party->id }}" name="movant_{{ $party->id }}_designation3" value="Cross-claim Defendant"> Cross-claim Defendant</label>
                                        </div>
                                        @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_bottom <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des4_{{ $party->id }}" name="movant_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_bottom <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des5_{{ $party->id }}" name="movant_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                        @else
                                        <!-- <div class="check-box-options"></div> -->
                                        <!-- <div class="check-box-options"></div> -->
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @if(isset($top_third_party_data) && count($top_third_party_data) > 0 || isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                            <!-- for third parties -->
                            <div class="check_all_movant_third_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_movant_third" id="check_all_movant_third" name="check_all_movant_third" value="" onchange="checkUncheckAllMovant(this, 'check','third');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_movant_third" id="uncheck_all_movant_third" name="uncheck_all_movant_third" value="" onchange="checkUncheckAllMovant(this, 'uncheck','third');"> Clear All</label></div>
                                </div>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                    <!-- for top third party movant -->
                                    @foreach ($top_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="right_movant all_movant_third all_movant_third_party" id="left_movant_{{ $party->id }}" name="movants[]" value="{{ $party->id }}" onchange="onMovantChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$top_party_type}}" data-onload="onMovantChange(this);" <?php if(isset($select_party_id) && $select_party_id==$party->id){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_third <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des4_{{ $party->id }}" name="movant_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_third <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des5_{{ $party->id }}" name="movant_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                    @endforeach
                                    <!-- for bottom third party movant -->
                                    @foreach ($bottom_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="right_movant all_movant_third all_movant_third_party" id="left_movant_{{ $party->id }}" name="movants[]" value="{{ $party->id }}" onchange="onMovantChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$bottom_party_type}}" data-onload="onMovantChange(this);" <?php if(isset($select_party_id) && $select_party_id==$party->id){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_third <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des4_{{ $party->id }}" name="movant_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_movants_{{ $party->id }}"><input type="checkbox" class="left_des all_movant_third <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "movant_initially_checked movant_initially_checked_".$party->id."";} ?>" id="left_des5_{{ $party->id }}" name="movant_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group col-sm-12">
                            <h4 class="tableHeading">Choose Respondent(s)</h4>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                <div class="check-box-options check-box-options-heading"><strong>Name</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 1</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 2</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 3</strong></div>
                                @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                <div class="check-box-options check-box-options-heading"><strong>Designation 4</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Designation 5</strong></div>
                                @endif
                            </div>
                            <div class="check_all_respondent_top_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_respondent_top" id="check_all_respondent_top" name="check_all_respondent_top" value="" onchange="checkUncheckAllRespondent(this, 'check','top');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_respondent_top" id="uncheck_all_respondent_top" name="uncheck_all_respondent_top" value="" onchange="checkUncheckAllRespondent(this, 'uncheck','top');"> Clear All</label></div>
                                </div>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                      @foreach ($top_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="respondent_clients left_respondents all_respondent_top all_respondent_top_party" id="left_respondent_{{ $party->id }}" name="respondents[]" value="{{ $party->id }}" onchange="onRespondentChange(this);" required="" data-user-name="{{ $party->name }}" data-user-type="top" data-user-party="{{$top_party_type}}"> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_top <?php if(isset($party->designation1) && $party->designation1==$top_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des1_{{ $party->id }}" name="respondent_{{ $party->id }}_designation1" value="{{ $top_party_type }}" readonly="" onclick="return false;" style="display:none;"> {{ $top_party_type }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_top <?php if(isset($party->designation2) && $party->designation2=='Cross-claimant'){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des2_{{ $party->id }}" name="respondent_{{ $party->id }}_designation2" value="Cross-claimant"> Cross-claimant</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_top <?php if(isset($party->designation3) && $party->designation3=='Cross-claim Defendant'){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des3_{{ $party->id }}" name="respondent_{{ $party->id }}_designation3" value="Cross-claim Defendant"> Cross-claim Defendant</label>
                                        </div>
                                        @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_top <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des4_{{ $party->id }}" name="respondent_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_top <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des5_{{ $party->id }}" name="respondent_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                        @else
                                        <!-- <div class="check-box-options"></div> -->
                                        <!-- <div class="check-box-options"></div> -->
                                        @endif
                                      @endforeach

                                </div>
                            </div>
                            <div class="check_all_respondent_bottom_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_respondent_bottom" id="check_all_respondent_bottom" name="check_all_respondent_bottom" value="" onchange="checkUncheckAllRespondent(this, 'check','bottom');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_respondent_bottom" id="uncheck_all_respondent_bottom" name="uncheck_all_respondent_bottom" value="" onchange="checkUncheckAllRespondent(this, 'uncheck','bottom');"> Clear All</label></div>
                                </div>
                            @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                    @foreach ($bottom_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_respondent all_respondent_bottom all_respondent_bottom_party" id="right_respondent_{{ $party->id }}" name="respondents[]" value="{{ $party->id }}" onchange="onRespondentChange(this);" data-user-name="{{ $party->name }}" data-user-type="bottom" data-user-party="{{$bottom_party_type}}"> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_bottom <?php if(isset($party->designation1) && $party->designation1==$bottom_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des1_{{ $party->id }}" name="respondent_{{ $party->id }}_designation1" value="{{ $bottom_party_type }}" readonly="" onclick="return false;" style="display:none;"> {{ $bottom_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_bottom <?php if(isset($party->designation2) && $party->designation2=='Cross-claimant'){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des2_{{ $party->id }}" name="respondent_{{ $party->id }}_designation2" value="Cross-claimant"> Cross-claimant</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_bottom <?php if(isset($party->designation3) && $party->designation3=='Cross-claim Defendant'){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des3_{{ $party->id }}" name="respondent_{{ $party->id }}_designation3" value="Cross-claim Defendant"> Cross-claim Defendant</label>
                                        </div>
                                        @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_bottom <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des4_{{ $party->id }}" name="respondent_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_bottom <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des5_{{ $party->id }}" name="respondent_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                        @else
                                        <!-- <div class="check-box-options"></div> -->
                                        <!-- <div class="check-box-options"></div> -->
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <!-- for third parties -->
                            @if(isset($top_third_party_data) && count($top_third_party_data) > 0 || isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                            <div class="check_all_respondent_third_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_respondent_third" id="check_all_respondent_third" name="check_all_respondent_third" value="" onchange="checkUncheckAllRespondent(this, 'check','third');"> Check All</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_respondent_third" id="uncheck_all_respondent_third" name="uncheck_all_respondent_third" value="" onchange="checkUncheckAllRespondent(this, 'uncheck','third');"> Clear All</label></div>
                                </div>
                                 @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                            <div class="checkbox-options-outer six-option">
                            @else
                            <div class="checkbox-options-outer four-option">
                            @endif
                                    <!-- for top third party respondent -->
                                    @foreach ($top_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_respondent all_respondent_third all_respondent_third_party" id="right_respondent_{{ $party->id }}" name="respondents[]" value="{{ $party->id }}" onchange="onRespondentChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$top_party_type}}"> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_third <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des4_{{ $party->id }}" name="respondent_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_third <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des5_{{ $party->id }}" name="respondent_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                    @endforeach
                                    <!-- for bottom third party respondent -->
                                    @foreach ($bottom_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_respondent all_respondent_third all_respondent_third_party" id="right_respondent_{{ $party->id }}" name="respondents[]" value="{{ $party->id }}" onchange="onRespondentChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$bottom_party_type}}"> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"> N/A</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_third <?php if(isset($party->designation4) && $party->designation4=="Third-Party ".$top_party_type){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des4_{{ $party->id }}" name="respondent_{{ $party->id }}_designation4" value="Third-Party {{ $top_party_type }}">Third-Party {{ $top_party_type }}</label>
                                        </div>

                                        <div class="check-box-options">
                                            <label class="label_respondents_{{ $party->id }}"><input type="checkbox" class="right_des all_respondent_third <?php if(isset($party->designation5) && $party->designation5=='Third-Party '.$bottom_party_type ){ echo "respondent_initially_checked respondent_initially_checked_".$party->id."";} ?>" id="right_des5_{{ $party->id }}" name="respondent_{{ $party->id }}_designation5" value="Third-Party {{ $bottom_party_type }}">Third-Party {{ $bottom_party_type }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="motion_type_id" class="col-form-label text-md-left">Motion Type</label>
                            <select id="motion_type_id" name="motion_type_id" class="form-control" required="" onchange="getMotionName(this)">
                                <option value="">Select</option>
                                @foreach ($motion_types as $key => $motion_type)
                                    <option value="{{$motion_type->id}}">{{$motion_type->type}}</option>
                                @endforeach
                            </select> 
                        </div>

                        <div class="form-group col-sm-6">
                            <label for="motion_name" class="col-form-label text-md-left">Motion Name</label>
                            <input id="motion_name" type="text" class="form-control" name="motion_name" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="file_date" class="col-form-label text-md-left">File Date</label>
                            <input id="file_date" type="text" class="form-control hasDatepicker" name="file_date" value="" autocomplete="nope" onchange="getResponsedate(this.value)">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="response_deadline" class="col-form-label text-md-left">Response Deadline</label>
                            <input id="response_deadline" type="text" class="form-control hasDatepicker" name="response_deadline" value="" autocomplete="nope">
                        </div>
                        <div class="form-group col-sm-12 text-center">
                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                            <button type="reset" name="reset" class="btn btn-info">Reset/Restart Motion</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</div>
<script type="text/javascript">
    function onMovantChange(movant){
        if(movant.checked){
            $('.label_respondents_'+movant.value+'').hide();
            $('.movant_initially_checked_'+movant.value+'').prop('checked', true);
        } else {
            if(movant.id=='left_movant_'+movant.value+''){
                $('#right_respondent_'+movant.value+'').prop('disabled', false);
            }
            $('.label_respondents_'+movant.value+'').show();
            $('.movant_initially_checked_'+movant.value+'').prop('checked', false);
        }

        var type=$(movant).data('user-type');
        var all_checkboxes=$(movant).closest('.checkbox-options-outer').find(".all_movant_"+type+"_party");
        if (all_checkboxes.not(":checked").length === 0){
            $('.check_all_respondent_'+type+'_div').hide();
        } else {
            $('.check_all_respondent_'+type+'_div').show();
        }
    }


    function onRespondentChange(respondent){
        if(respondent.checked){
            $('.label_movants_'+respondent.value+'').hide();
            $('.respondent_initially_checked_'+respondent.value+'').prop('checked', true);
        } else {
            if(respondent.id=='left_respondent_'+respondent.value+''){
                $('#left_movant_'+respondent.value+'').prop('disabled', false);
            }
            $('.label_movants_'+respondent.value+'').show();
            $('.respondent_initially_checked_'+respondent.value+'').prop('checked', false);
        }

        var type=$(respondent).data('user-type');
        var all_checkboxes=$(respondent).closest('.checkbox-options-outer').find(".all_respondent_"+type+"_party");
        if (all_checkboxes.not(":checked").length === 0){
            $('.check_all_movant_'+type+'_div').hide();
        } else {
            $('.check_all_movant_'+type+'_div').show();
        }
    }

    function getMotionName(motion){
        if(motion.value){
            var party_type=$('[name="movants[]"]:checked').eq( 0 ).data('user-party');
            var motion_type=$("#motion_type_id option:selected").text();
            var motion_name=party_type;
            var length=$('[name="movants[]"]:checked').length;
            if(length > 1){
                var motion_name=party_type+"s";
            }
            var z=0;
            $('[name="movants[]"]:checked').each(function () {
                // var movantname=$(this).attr('class').split(" ")[0];
                var movantname=$(this).data('user-name');
                if(length > 1){
                    if(motion_name !=''){
                        if(z == length-1){
                            motion_name=motion_name+" and "+movantname+"";
                        } else {
                            if(z==0) {
                                motion_name=motion_name+" "+movantname+"";
                            } else {
                                motion_name=motion_name+", "+movantname+"";
                            }
                        }
                    } else {
                        motion_name=motion_name+" "+movantname+"";
                    }
                } else {
                    if(length == 1){
                        motion_name=motion_name+" "+movantname+"s’ Motion to "+motion_type+"";
                    } else {
                        motion_name=motion_name+" "+movantname+"s’ Joint Motion to "+motion_type+"";
                    }
                }
                ++z;
            });
            if(length > 1){
                motion_name=motion_name+"s’ Joint Motion to "+motion_type+"";
            }

            var parent_motion_name=$('#parent_motion_name').val();
            $('#motion_name').val(motion_name+' '+parent_motion_name);
        } else{
            $('#motion_name').val('');
        }
    }

    // check uncheck all movants/third parties
    function checkUncheckAllMovant(status, action, type){
        if(status.checked && action=='check'){
            $('.all_movant_'+type+'.movant_initially_checked').prop('checked', true).trigger("change");
            $('.all_movant_'+type+'_party').prop('checked', true).trigger("change");
            $('.uncheck_all_movant_'+type+'').prop('checked', false);
        } else{
            $('.all_movant_'+type+'').prop('checked', false).trigger("change");
            $('.check_all_movant_'+type+', .uncheck_all_movant_'+type+'').prop('checked', false);
        }
    }

    // check uncheck all respondents/third parties
    function checkUncheckAllRespondent(status, action, type){
        if(status.checked && action=='check'){
            $('.all_respondent_'+type+'.respondent_initially_checked').prop('checked', true).trigger("change");;
            $('.all_respondent_'+type+'_party').prop('checked', true).trigger("change");
            $('.uncheck_all_respondent_'+type+'').prop('checked', false);
        } else{
            $('.all_respondent_'+type+'').prop('checked', false).trigger("change");
            $('.check_all_respondent_'+type+', .uncheck_all_respondent_'+type+'').prop('checked', false);
        }
    }

    // on file date change get response date
    function getResponsedate(file_date){
        if(file_date){
            var token= $('input[name=_token]').val();
            $.ajax({
                url:"{{route('ajax_get_response_deadline_by_file_date')}}",
                method:"POST",
                // dataType: 'json',
                data:{
                    file_date: file_date, 
                    _token: token, 
                },
                success: function(data){
                    if(data=='null' || data==''){
                        $('#response_deadline').val('');
                    } else {
                        $("#response_deadline").datepicker("setDate", data);
                    }
                }
            });   
        }
    }

    $(document).ready(function(){
        $('#motion_form').validate({});
        $(".hasDatepicker").datepicker({
            startDate: "01/01/1901",
            // endDate: '+0d',
        });
        $("#file_date").datepicker("setDate", new Date());

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

    });

</script>
@endsection