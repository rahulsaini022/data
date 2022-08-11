@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center pleadings-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Pleading') }}</strong>
                  <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.pleadings',['case_id' => $case_data->id]) }}"> Back</a>

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
                    @if(isset($case_data) && $case_data->if_there_is_third_party_complaint=='Yes')
                    <div id="pleading-drafting-section" class="col-sm-12">
                    @else 
                    <div id="pleading-drafting-section" class="col-sm-12 pleading-without-third-parties">
                    @endif
                      <form id="pleading_form" method="POST" action="{{route('cases.pleadings.subordinate.update')}}" autocomplete="off">
                          @csrf
                          @method('put')
                          <input type="hidden" name="case_id" value="{{$case_data->id}}">
                          <input type="hidden" name="pleading_id" value="{{$pleading->id}}">
                          <input type="hidden" name="parent_pleading_id" value="{{$pleading->parent_pleading_id}}">
                          <input type="hidden" name="motion_category" value="New Subordinate Pleading">
                          <input type="hidden" name="pleading_level" value="">
                          <input type="hidden" name="pleading_name" id="pleading_name" value="{{$pleading->pleading_name}}">
                          
                          <input type="hidden" name="top_party_type" id="top_party_type" value="{{$top_party_type}}">
                          <input type="hidden" name="bottom_party_type" id="bottom_party_type" value="{{$bottom_party_type}}">
                          <input type="hidden" name="user_ids_top_string" id="user_ids_top_string" value="{{ $user_ids_top_string }}">
                          <input type="hidden" name="user_ids_bottom_string" id="user_ids_bottom_string" value="{{ $user_ids_bottom_string }}">
                        <div class="form-group col-sm-12">
                            <div class="form-group col-sm-6">
                                <label for="date_filed" class="col-form-label text-md-left"><strong>Date Filed</strong></label>
                                <input id="date_filed" type="text" class="form-control hasDatepicker" name="date_filed" value="<?php if(isset($pleading->date_filed)){ echo date("m/d/Y", strtotime($pleading->date_filed)); } ?>" autocomplete="nope">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="pleading_type_id" class="col-form-label text-md-left"><strong>Pleading Type</strong></label>
                                <select id="pleading_type_id" name="pleading_type_id" class="form-control" required="" onchange="getPleadingName(this)">
                                    <option value="">Select</option>
                                    @foreach ($pleading_types as $key => $pleading_type)
                                        <option value="{{$pleading_type->id}}" <?php if(isset($pleading->pleading_type_id) && $pleading->pleading_type_id==$pleading_type->id){ echo "selected"; } ?>>{{$pleading_type->type}}</option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="form-group col-sm-6">
                                <label class="col-form-label text-md-left"><strong>This Pleading Brings In New Third-Parties?</strong></label>
                                <input type="radio" id="pleading_has_new_third_parties_y" class="pleading_has_new_third_parties_inputs" name="pleading_has_new_third_parties" value="Yes" required="" onclick="pleadingHasNewThirdparties(this);">
                                <label for="pleading_has_new_third_parties_y">YES</label>
                                <input type="radio" id="pleading_has_new_third_parties_n" class="pleading_has_new_third_parties_inputs" name="pleading_has_new_third_parties" value="No" onclick="pleadingHasNewThirdparties(this);" checked="">
                                <label for="pleading_has_new_third_parties_n">NO</label>
                            </div>
                            <div class="form-group col-sm-6"></div>

                            <h4 class="tableHeading">Choose Filing Parties</h4>
                            <div class="checkbox-options-outer four-option">
                                <div class="check-box-options check-box-options-heading"><strong>Name</strong></div>
                            </div>
                            <div class="check_all_filing_top_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_filing_top" id="check_all_filing_top" name="check_all_filing_top" value="" onchange="checkUncheckAllFiling(this, 'check','top');"> All Top Party Roles</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_filing_top" id="uncheck_all_filing_top" name="uncheck_all_filing_top" value=""  onchange="checkUncheckAllFiling(this, 'uncheck','top');"> Clear all Top Party Roles</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    @foreach ($top_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_filings_{{ $party->id }}"><input type="checkbox" class="filing_clients left_filings all_filing_top all_filing_top_party" id="left_filing_{{ $party->id }}" name="filings[]" value="{{ $party->id }}" onchange="onFilingChange(this);" data-onload="onFilingChange(this);" required="" data-user-name="{{ $party->name }}" data-user-type="top" data-user-party="{{$top_party_type}}" <?php if(isset($filingparties) && in_array($party->id, $filingparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="check_all_filing_bottom_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_filing_bottom" id="check_all_filing_bottom" name="check_all_filing_bottom" value=""  onchange="checkUncheckAllFiling(this, 'check','bottom');"> All Bottom Party Roles</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_filing_bottom" id="uncheck_all_filing_bottom" name="uncheck_all_filing_bottom" value=""  onchange="checkUncheckAllFiling(this, 'uncheck','bottom');"> Clear all Bottom Party Roles</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    @foreach ($bottom_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_filings_{{ $party->id }}"><input type="checkbox" class="right_filing all_filing_bottom all_filing_bottom_party" id="left_filing_{{ $party->id }}" name="filings[]" value="{{ $party->id }}" onchange="onFilingChange(this);" data-onload="onFilingChange(this);" data-user-name="{{ $party->name }}" data-user-type="bottom" data-user-party="{{$bottom_party_type}}" <?php if(isset($filingparties) && in_array($party->id, $filingparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- for third parties -->
                            @if(isset($top_third_party_data) && count($top_third_party_data) > 0 || isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                            <div class="check_all_filing_third_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_filing_third" id="check_all_filing_third" name="check_all_filing_third" value="" onchange="checkUncheckAllFiling(this, 'check','third');"> All Third-Parties</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_filing_third" id="uncheck_all_filing_third" name="uncheck_all_filing_third" value="" onchange="checkUncheckAllFiling(this, 'uncheck','third');"> Clear all Third-Parties</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    <!-- for top third party filing -->
                                    @foreach ($top_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_filings_{{ $party->id }}"><input type="checkbox" class="right_filing all_filing_third all_filing_third_party" id="left_filing_{{ $party->id }}" name="filings[]" value="{{ $party->id }}" onchange="onFilingChange(this);" data-onload="onFilingChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$top_party_type}}" <?php if(isset($filingparties) && in_array($party->id, $filingparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                    @endforeach
                                    <!-- for bottom third party filing -->
                                    @foreach ($bottom_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_filings_{{ $party->id }}"><input type="checkbox" class="right_filing all_filing_third all_filing_third_party" id="left_filing_{{ $party->id }}" name="filings[]" value="{{ $party->id }}" onchange="onFilingChange(this);" data-onload="onFilingChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$bottom_party_type}}" <?php if(isset($filingparties) && in_array($party->id, $filingparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                        <div class="check-box-options" style="border-right:none;"></div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>


                        <div class="form-group col-sm-6">
                            <label class="col-form-label text-md-left"><strong>Pleading Includes Claims?</strong></label>
                            <input type="radio" id="pleading_includes_claims_y" class="pleading_includes_claims_inputs" name="pleading_includes_claims" value="Yes" required="" onchange="pleadingIncludeClaims(this)" <?php if(isset($pleading->pleading_includes_claims)  && $pleading->pleading_includes_claims=='Yes'){echo "checked"; } ?>>
                            <label for="pleading_includes_claims_y">YES</label>
                            <input type="radio" id="pleading_includes_claims_n" class="pleading_includes_claims_inputs" name="pleading_includes_claims" value="No" onchange="pleadingIncludeClaims(this)">
                            <label for="pleading_includes_claims_n">NO</label>
                        </div>
                        <div class="form-group col-sm-6"></div>
                        @if(isset($pleading->pleading_includes_claims)  && $pleading->pleading_includes_claims=='Yes')
                        <div class="form-group col-sm-12 responsible-parties-main">
                        @else
                        <div class="form-group col-sm-12 responsible-parties-main" style="display: none;">
                        @endif
                            <h4 class="tableHeading">Choose Responsive Parties</h4>
                            <div class="checkbox-options-outer four-option">
                                <div class="check-box-options check-box-options-heading"><strong>Name</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Service Date</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Initial Deadline</strong></div>
                                <div class="check-box-options check-box-options-heading"><strong>Current Deadline</strong></div>
                            </div>
                            <div class="check_all_responsible_top_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_responsible_top" id="check_all_responsible_top" name="check_all_responsible_top" value="" onchange="checkUncheckAllResponsible(this, 'check','top');">  All Top Party Roles</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_responsible_top" id="uncheck_all_responsible_top" name="uncheck_all_responsible_top" value="" onchange="checkUncheckAllResponsible(this, 'uncheck','top');"> Clear all Top Party Roles</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    @foreach ($top_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_responsibles_{{ $party->id }}"><input type="checkbox" class="responsible_clients left_responsibles all_responsible_top all_responsible_top_party" id="left_responsible_{{ $party->id }}" name="responsibles[]" value="{{ $party->id }}" onchange="onResponsibleChange(this);" data-onload="onResponsibleChange(this);" required="" data-user-name="{{ $party->name }}" data-user-type="top" data-user-party="{{$top_party_type}}" <?php if(isset($responsibleparties) && in_array($party->id, $responsibleparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <input id="service_date_{{ $party->id }}" type="text" class="form-control hasDatepicker service_deadline_inputs label_responsibles_{{ $party->id }}" name="service_date_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['service_date'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['service_date'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="initial_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker initial_deadline_inputs label_responsibles_{{ $party->id }}" name="initial_deadline_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['initial_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['initial_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="current_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker current_deadline_inputs label_responsibles_{{ $party->id }}" name="current_deadline_{{ $party->id }}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['current_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['current_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="check_all_responsible_bottom_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_responsible_bottom" id="check_all_responsible_bottom" name="check_all_responsible_bottom" value="" onchange="checkUncheckAllResponsible(this, 'check','bottom');"> All Bottom Party Roles</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_responsible_bottom" id="uncheck_all_responsible_bottom" name="uncheck_all_responsible_bottom" value="" onchange="checkUncheckAllResponsible(this, 'uncheck','bottom');"> Clear all Bottom Party Roles</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    @foreach ($bottom_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_responsibles_{{ $party->id }}"><input type="checkbox" class="right_responsible all_responsible_bottom all_responsible_bottom_party" id="right_responsible_{{ $party->id }}" name="responsibles[]" value="{{ $party->id }}" onchange="onResponsibleChange(this);" data-onload="onResponsibleChange(this);" data-user-name="{{ $party->name }}" data-user-type="bottom" data-user-party="{{$bottom_party_type}}" <?php if(isset($responsibleparties) && in_array($party->id, $responsibleparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <input id="service_date_{{ $party->id }}" type="text" class="form-control hasDatepicker service_deadline_inputs label_responsibles_{{ $party->id }}" name="service_date_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['service_date'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['service_date'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="initial_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker initial_deadline_inputs label_responsibles_{{ $party->id }}" name="initial_deadline_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['initial_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['initial_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="current_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker current_deadline_inputs label_responsibles_{{ $party->id }}" name="current_deadline_{{ $party->id }}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['current_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['current_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- for third parties -->
                            @if(isset($top_third_party_data) && count($top_third_party_data) > 0 || isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                            <div class="check_all_responsible_third_div">
                                <div class="mt-3">
                                    <div class="d-inline text-primary mr-3"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="check_all_responsible_third" id="check_all_responsible_third" name="check_all_responsible_third" value="" onchange="checkUncheckAllResponsible(this, 'check','third');"> All Third-Parties</label></div>
                                    <div class="d-inline text-primary"><label class="" style="margin-bottom: 0px;"><input type="checkbox" class="uncheck_all_responsible_third" id="uncheck_all_responsible_third" name="uncheck_all_responsible_third" value="" onchange="checkUncheckAllResponsible(this, 'uncheck','third');"> Clear all Third-Parties</label></div>
                                </div>
                                <div class="checkbox-options-outer four-option">
                                    <!-- for top third party responsible -->
                                    @foreach ($top_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_responsibles_{{ $party->id }}"><input type="checkbox" class="right_responsible all_responsible_third all_responsible_third_party" id="right_responsible_{{ $party->id }}" name="responsibles[]" value="{{ $party->id }}" onchange="onResponsibleChange(this);" data-onload="onResponsibleChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$top_party_type}}" <?php if(isset($responsibleparties) && in_array($party->id, $responsibleparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <input id="service_date_{{ $party->id }}" type="text" class="form-control hasDatepicker service_deadline_inputs label_responsibles_{{ $party->id }}" name="service_date_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['service_date'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['service_date'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="initial_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker initial_deadline_inputs label_responsibles_{{ $party->id }}" name="initial_deadline_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['initial_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['initial_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="current_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker current_deadline_inputs label_responsibles_{{ $party->id }}" name="current_deadline_{{ $party->id }}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['current_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['current_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                    @endforeach
                                    <!-- for bottom third party responsible -->
                                    @foreach ($bottom_third_party_data as $key => $party)
                                        <div class="check-box-options">
                                            <label class="label_responsibles_{{ $party->id }}"><input type="checkbox" class="right_responsible all_responsible_third all_responsible_third_party" id="right_responsible_{{ $party->id }}" name="responsibles[]" value="{{ $party->id }}" onchange="onResponsibleChange(this);" data-onload="onResponsibleChange(this);" data-user-name="{{ $party->name }}" data-user-type="third" data-user-party="Third-Party {{$bottom_party_type}}" <?php if(isset($responsibleparties) && in_array($party->id, $responsibleparties)){ echo "checked"; } ?>> {{ $party->name }}</label>
                                        </div>
                                        <div class="check-box-options">
                                            <input id="service_date_{{ $party->id }}" type="text" class="form-control hasDatepicker service_deadline_inputs label_responsibles_{{ $party->id }}" name="service_date_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['service_date'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['service_date'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="initial_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker initial_deadline_inputs label_responsibles_{{ $party->id }}" name="initial_deadline_{{ $party->id }}" data-party-id="{{$party->id}}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['initial_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['initial_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                        <div class="check-box-options">
                                            <input id="current_deadline_{{ $party->id }}" type="text" class="form-control hasDatepicker current_deadline_inputs label_responsibles_{{ $party->id }}" name="current_deadline_{{ $party->id }}" value="<?php if(isset($responsiblepartiesdeadlines[$party->id]['current_deadline'])){ echo date("m/d/Y", strtotime($responsiblepartiesdeadlines[$party->id]['current_deadline'])); } ?>" autocomplete="nope">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group col-sm-12 text-center">
                            <button type="submit" name="save" class="btn btn-primary" onclick="getPleadingName();">Save</button>
                            <button type="reset" name="reset" class="btn btn-info">Reset/Restart Pleading</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>          
        </div>
    </div>
</div>
<script type="text/javascript">
    // if pleading has new third party
    function pleadingHasNewThirdparties(inputdata){
        if(inputdata.checked && inputdata.value=='Yes'){
            window.location.href = "{{ route('cases.pleadings.pleadinghasnewthirdparties',['case_id'=> $case_data->id, 'action' => 'edit', 'pleading_id' => $pleading->id])}}";
        } else {

        }
    }

    function onFilingChange(filing){
        if(filing.checked){
            $('.label_responsibles_'+filing.value+'').hide();
            $('.filing_initially_checked_'+filing.value+'').prop('checked', true);
            
            var type=$(filing).data('user-type');
            if(type=='top'){
                $( ".all_filing_bottom_party" ).each(function( index ) {
                    $(this).prop('disabled', true);
                    $('.check_all_filing_bottom, .uncheck_all_filing_bottom').prop('disabled', true);
                });
            } else {
                $( ".all_filing_top_party" ).each(function( index ) {
                    $(this).prop('disabled', true);
                    $('.check_all_filing_top, .uncheck_all_filing_top').prop('disabled', true);
                });
            }
        } else {
            if(filing.id=='left_filing_'+filing.value+''){
                $('#right_responsible_'+filing.value+'').prop('disabled', false);
            }
            $('.label_responsibles_'+filing.value+'').show();
            $('.filing_initially_checked_'+filing.value+'').prop('checked', false);

            var type=$(filing).data('user-type');
            if(type=='top'){
                var num_top_checked=$('input.all_filing_top_party:checked').length;
                if(num_top_checked > 0){
                    $( ".all_filing_bottom_party" ).each(function( index ) {
                        $(this).prop('disabled', true);
                        $('.check_all_filing_bottom, .uncheck_all_filing_bottom').prop('disabled', true);
                    });
                } else {
                    $( ".all_filing_bottom_party" ).each(function( index ) {
                        $(this).prop('disabled', false);
                        $('.check_all_filing_bottom, .uncheck_all_filing_bottom').prop('disabled', false);
                    });
                }
            } else {
                var num_bottom_checked=$('input.all_filing_bottom_party:checked').length;
                if(num_bottom_checked > 0){
                    $( ".all_filing_top_party" ).each(function( index ) {
                        $(this).prop('disabled', true);
                        $('.check_all_filing_top, .uncheck_all_filing_top').prop('disabled', true);
                    });
                } else {
                    $( ".all_filing_top_party" ).each(function( index ) {
                        $(this).prop('disabled', false);
                        $('.check_all_filing_top, .uncheck_all_filing_top').prop('disabled', false);
                    });
                }
            }
        }

        var type=$(filing).data('user-type');
        var all_checkboxes=$(filing).closest('.checkbox-options-outer').find(".all_filing_"+type+"_party");
        if (all_checkboxes.not(":checked").length === 0){
            $('.check_all_responsible_'+type+'_div').hide();
        } else {
            $('.check_all_responsible_'+type+'_div').show();
        }
    }

    function onResponsibleChange(responsible){
        if(responsible.checked){
            $('.label_filings_'+responsible.value+'').hide();
            $('.responsible_initially_checked_'+responsible.value+'').prop('checked', true);

            var type=$(responsible).data('user-type');
            if(type=='top'){
                $( ".all_responsible_bottom_party" ).each(function( index ) {
                    $(this).prop('disabled', true);
                    $('.check_all_responsible_bottom, .uncheck_all_responsible_bottom').prop('disabled', true);
                });
            } else {
                $( ".all_responsible_top_party" ).each(function( index ) {
                    $(this).prop('disabled', true);
                    $('.check_all_responsible_top, .uncheck_all_responsible_top').prop('disabled', true);
                });
            }
        } else {
            if(responsible.id=='left_responsible_'+responsible.value+''){
                $('#left_filing_'+responsible.value+'').prop('disabled', false);
            }
            $('.label_filings_'+responsible.value+'').show();
            $('.responsible_initially_checked_'+responsible.value+'').prop('checked', false);

            var type=$(responsible).data('user-type');
            if(type=='top'){
                var num_top_checked=$('input.all_responsible_top_party:checked').length;
                if(num_top_checked > 0){
                    $( ".all_responsible_bottom_party" ).each(function( index ) {
                        $(this).prop('disabled', true);
                        $('.check_all_responsible_bottom, .uncheck_all_responsible_bottom').prop('disabled', true);
                    });
                } else {
                    $( ".all_responsible_bottom_party" ).each(function( index ) {
                        $(this).prop('disabled', false);
                        $('.check_all_responsible_bottom, .uncheck_all_responsible_bottom').prop('disabled', false);
                    });
                }
            } else {
                var num_bottom_checked=$('input.all_responsible_bottom_party:checked').length;
                if(num_bottom_checked > 0){
                    $( ".all_responsible_top_party" ).each(function( index ) {
                        $(this).prop('disabled', true);
                        $('.check_all_responsible_top, .uncheck_all_responsible_top').prop('disabled', true);
                    });
                } else {
                    $( ".all_responsible_top_party" ).each(function( index ) {
                        $(this).prop('disabled', false);
                        $('.check_all_responsible_top, .uncheck_all_responsible_top').prop('disabled', false);
                    });
                }
            }
        }

        var type=$(responsible).data('user-type');
        var all_checkboxes=$(responsible).closest('.checkbox-options-outer').find(".all_responsible_"+type+"_party");
        if (all_checkboxes.not(":checked").length === 0){
            $('.check_all_filing_'+type+'_div').hide();
        } else {
            $('.check_all_filing_'+type+'_div').show();
        }
    }

    // check uncheck all filings/third parties
    function checkUncheckAllFiling(status, action, type){
        if(status.checked && action=='check'){
            $('.all_filing_'+type+'.filing_initially_checked').prop('checked', true).trigger("change");
            $('.all_filing_'+type+'_party').prop('checked', true).trigger("change");
            $('.uncheck_all_filing_'+type+'').prop('checked', false);
        } else{
            $('.all_filing_'+type+'').prop('checked', false).trigger("change");
            $('.check_all_filing_'+type+', .uncheck_all_filing_'+type+'').prop('checked', false);
        }
    }

    // check uncheck all responsibles/third parties
    function checkUncheckAllResponsible(status, action, type){
        if(status.checked && action=='check'){
            $('.all_responsible_'+type+'.responsible_initially_checked').prop('checked', true).trigger("change");;
            $('.all_responsible_'+type+'_party').prop('checked', true).trigger("change");
            $('.uncheck_all_responsible_'+type+'').prop('checked', false);
        } else{
            $('.all_responsible_'+type+'').prop('checked', false).trigger("change");
            $('.check_all_responsible_'+type+', .uncheck_all_responsible_'+type+'').prop('checked', false);
        }
    }

    // on pleading Include Claims change show/hide responsible parties
    function pleadingIncludeClaims(claims){
        if(claims.checked && claims.value=='Yes'){
            $('.responsible-parties-main').show();
        } else {
            $('.responsible-parties-main').hide();
        }
    }

    // get pleading name
    function getPleadingName(){
        var party_type=$('[name="filings[]"]:checked').eq( 0 ).data('user-party');
        var pleading_type=$("#pleading_type_id option:selected").text();
        var pleading_name=party_type;
        var length=$('[name="filings[]"]:checked').length;
        if(length > 1){
            var pleading_name=party_type+"s";
        }
        var z=0;
        $('[name="filings[]"]:checked').each(function () {
            // var filingname=$(this).attr('class').split(" ")[0];
            var filingname=$(this).data('user-name');
            if(length > 1){
                if(pleading_name !=''){
                    if(z == length-1){
                        pleading_name=pleading_name+" and "+filingname+"";
                    } else {
                        if(z==0) {
                            pleading_name=pleading_name+" "+filingname+"";
                        } else {
                            pleading_name=pleading_name+", "+filingname+"";
                        }
                    }
                } else {
                    pleading_name=pleading_name+" "+filingname+"";
                }
            } else {
                if(length == 1){
                    pleading_name=pleading_name+" "+filingname+"’s "+pleading_type+"";
                } else {
                    pleading_name=pleading_name+" "+filingname+"’s "+pleading_type+"";
                }
            }
            ++z;
        });
        if(length > 1){
            pleading_name=pleading_name+"’s "+pleading_type+"";
        }
        $('#pleading_name').val(pleading_name);
        return true;
    }

    $(document).ready(function(){
        $('#pleading_form').validate({});

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1901",
            // endDate: '+0d',
        });

        $('#date_filed').datepicker( {
            startDate: "01/01/1901",
        }).on('changeDate',function(ev){
            // console.log(ev);
            var start_date=this.value;
            $('.service_deadline_inputs').each(function(){
                $(this).datepicker("setDate", start_date);
            });

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
                            $('.initial_deadline_inputs').val('');
                            $('.current_deadline_inputs').val('');
                        } else {
                           $('.initial_deadline_inputs').each(function(){
                                $(this).datepicker("setDate", data);
                            });

                            $('.current_deadline_inputs').each(function(){
                                $(this).datepicker("setDate", data);
                            });
                        }
                    }
                });   
            }
        });

        $('.service_deadline_inputs').datepicker( {
            startDate: "01/01/1901",
        }).on('changeDate',function(ev){
            var start_date=this.value;
            var party_id=$(this).data('party-id');
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
                            $('#initial_deadline_'+party_id+'').val('');
                            $('#current_deadline_'+party_id+'').val('');
                        } else {
                            $('#initial_deadline_'+party_id+'').datepicker("setDate", data);
                            $('#current_deadline_'+party_id+'').datepicker("setDate", data);
                        }
                    }
                });   
            }
        });

        $('.initial_deadline_inputs').change(function(){
            var start_date=this.value;
            var party_id=$(this).data('party-id');
            $('#current_deadline_'+party_id+'').datepicker("setDate", start_date);
        });

    });

</script>
@endsection