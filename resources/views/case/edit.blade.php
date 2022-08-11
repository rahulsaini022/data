@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center case-registration-steps">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Case Details') }}</strong></div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button" class="btn btn-primary btn-circle">Case Info</a>
                                <p>Step 1</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button" class="btn btn-default btn-circle disabled">Client Info</a>
                                <p>Step 2</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button" class="btn btn-default btn-circle disabled">Opponent Info</a>
                                <p>Step 3</p>
                            </div>
                        </div>
                    </div>
                    <form role="form" id="multistep_case_form" method="POST" action="{{route('cases.update',['id'=>$case_data->id])}}">
                        @csrf
                        @method('put')
                        <?php 
                            $client_fullname=$client_data[0]->name;
                            $client_fullname = explode(" ", $client_fullname);
                        ?>

                        <!--  case registration 1st step -->
                        <div class="row setup-content form-group" id="step-1">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="case_state" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_state" class="selected_case_state" value="<?php if(isset($case_data->state_id)){ echo $case_data->state_id; } ?>">
                                        <select id="case_state" name="case_state" class="form-control case_state_inputs" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_county" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_county" class="selected_case_county" value="<?php if(isset($case_data->county_id)){ echo $case_data->county_id; } ?>">
                                        <select id="case_county" name="case_county" class="form-control case_county_inputs" autofocus="" required="">                                     
                                            <option value="">Choose County</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-danger no-courts" style="display: none;">No Court found for the selected state and county.</p>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="case_court" class="col-md-4 col-form-label text-md-left">Court*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_court" class="selected_case_court" value="<?php if(isset($case_data->court_id)){ echo $case_data->court_id; } ?>">
                                        <select id="case_court" name="case_court" class="form-control case_court_inputs" autofocus="" required="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_division" class="col-md-4 col-form-label text-md-left">Division*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_division" class="selected_case_division" value="<?php if(isset($case_data->division_id)){ echo $case_data->division_id; } ?>">
                                        <select id="case_division" name="case_division" class="form-control case_division_inputs" autofocus="" required="">                                     
                                            <option value="">Choose Division</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="case_judge" class="col-md-4 col-form-label text-md-left">Judge</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_judge" class="selected_case_judge" value="<?php if(isset($case_data->judge_id)){ echo $case_data->judge_id; } ?>">
                                        <select id="case_judge" name="case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_magistrate" class="col-md-4 col-form-label text-md-left">Magistrate</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_magistrate" class="selected_case_magistrate" value="<?php if(isset($case_data->magistrate_id)){ echo $case_data->magistrate_id; } ?>">
                                        <select id="case_magistrate" name="case_magistrate" class="form-control case_magistrate_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 judge_fullname_div" style="display: none;">
                                    <label for="judge_fullname" class="col-md-4 col-form-label text-md-left">Judge Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="judge_fullname" type="text" class="form-control case_judge_name_inputs" name="judge_fullname" value="<?php if(isset($case_data->judge_fullname)){ echo $case_data->judge_fullname; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <label for="magistrate_fullname" class="col-md-4 col-form-label text-md-left">Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_fullname" value="<?php if(isset($case_data->magistrate_fullname)){ echo $case_data->magistrate_fullname; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <p class="text-danger no-case-types" style="display: none;">No Case Type(s) found for this division.</p>
                            <input type="hidden" name="selected_case-types" class="selected_case-types" value="<?php if(isset($case_data->case_type_ids)){ echo $case_data->case_type_ids; } ?>">
                            <div class="col-md-12 case-types-div" style="display:none;">
                            </div>
                            <div class="col-md-12 case-filing-status-div">
                                <label class="col-md-12 col-form-label text-md-left">Case Filing Status*</label>
                                <input type="hidden" name="selected_case_filing_status" class="selected_case_filing_status" value="<?php if(isset($case_data->filing_type)){ echo $case_data->filing_type; } ?>">
                                <div class="col-md-3">
                                    <input type="radio" id="to_be_filed_new" name="case_filing_status" class="case_filing_status_inputs" value="to_be_filed_new" required="">
                                    <label for="to_be_filed_new" class="col-form-label text-md-left">To Be Filed, New</label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="radio" id="currently_filed" name="case_filing_status" class="case_filing_status_inputs" value="currently_filed">
                                    <label for="currently_filed" class="col-form-label text-md-left">Currently Filed </label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="radio" id="prev_filed_refiling" name="case_filing_status" class="case_filing_status_inputs" value="prev_filed_refiling">
                                    <label for="prev_filed_refiling" class="col-form-label text-md-left"> Previously Filed, Refiling </label>
                                </div>
                                <div class="col-md-3 prev_filed_post_decree_div">
                                    <input type="radio" id="prev_filed_post_decree" name="case_filing_status" class="case_filing_status_inputs" value="prev_filed_post_decree">
                                    <label for="prev_filed_post_decree" class="col-form-label text-md-left"> Previously Filed, Post-Decree </label>
                                </div>
                            </div>

                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="client_role" class="col-md-4 col-form-label text-md-left">Client Role*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_client_role" class="selected_client_role" value="<?php if(isset($case_data->client_role)){ echo $case_data->client_role; } ?>">
                                        <select id="client_role" name="client_role" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" autofocus="" required="">
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="number_of_clients" class="col-md-4 col-form-label text-md-left">Number of <span id="number_of_clients_span">Clients</span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_of_clients" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_of_clients" value="<?php if(isset($case_data->number_client_role)){ echo $case_data->number_client_role; } ?>" required=""  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="opponent_role" class="col-md-4 col-form-label text-md-left">Opponent Role*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_opponent_role" class="selected_opponent_role" value="<?php if(isset($case_data->opponent_role)){ echo $case_data->opponent_role; } ?>">
                                        <input type="hidden" name="opponent_role" id="opponent_role_hidden">
                                        <select id="opponent_role" name="opponent_role_select" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" autofocus="" required="" disabled="">
                                            <option value="">Choose Role</option>
                                            <option value="Defendant">Defendant</option>
                                            <option value="Respondent">Respondent</option>
                                            <option value="Petitioner 2">Petitioner 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="number_of_opponents" class="col-md-4 col-form-label text-md-left">Number of <span id="number_of_opponents_span">Opponents</span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_of_opponents" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_of_opponents" value="<?php if(isset($case_data->number_opponent_role)){ echo $case_data->number_opponent_role; } ?>" required=""  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 currently_filed_inputs court_case_number_date_filed_div">
                                <div class="col-md-6 court_case_number_div">
                                    <label for="court_case_number" class="col-md-4 col-form-label text-md-left">Court Case #*</label>
                                    <div class="col-md-8">
                                        <input id="court_case_number" type="text" class="form-control currently_filed_inputs_req prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="court_case_number" autofocus="" value="<?php if(isset($case_data->case_number)){ echo $case_data->case_number; } ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 date_filed_div">
                                    <label for="date_filed" class="col-md-4 col-form-label text-md-left">Date Filed*</label>
                                    <div class="col-md-8">
                                        <input id="date_filed" type="text" class="form-control hasDatepicker currently_filed_inputs_req" name="date_filed" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->date_filed)){ echo date("m/d/Y", strtotime($case_data->date_filed)); } ?>">
                                    </div>
                                </div>

                                <div class="col-md-6 original_court_case_number_div">
                                    <label for="original_court_case_number" class="col-md-4 col-form-label text-md-left">Original Court Case #*</label>
                                    <div class="col-md-8">
                                        <input id="original_court_case_number" type="text" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_court_case_number" autofocus="" value="<?php if(isset($case_data->original_case_number)){ echo $case_data->original_case_number; } ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="date_served" class="col-md-4 col-form-label text-md-left">Date Served</label>
                                    <div class="col-md-8">
                                        <input id="date_served" type="text" class="form-control hasDatepicker" name="date_served" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->date_served)){ echo date("m/d/Y", strtotime($case_data->date_served)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="final_hearing_date" class="col-md-4 col-form-label text-md-left">Final Hearing Date</label>
                                    <div class="col-md-8">
                                        <input id="final_hearing_date" type="text" class="form-control hasDatepicker" name="final_hearing_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->final_hearing_date)){ echo date("m/d/Y", strtotime($case_data->final_hearing_date)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_client_role" class="col-md-4 col-form-label text-md-left">Original Client Role*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_client_role" class="selected_original_client_role" value="<?php if(isset($case_data->original_client_role)){ echo $case_data->original_client_role; } ?>">
                                        <select id="original_client_role" name="original_client_role" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="" >
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_number_of_clients" class="col-md-4 col-form-label text-md-left">Original Number of <span id="original_number_of_clients_span">Clients</span>*</label>
                                    <div class="col-md-8">
                                        <input id="original_number_of_clients" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_of_clients" value="<?php if(isset($case_data->original_number_client_role)){ echo $case_data->original_number_client_role; } ?>"  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_opponent_role" class="col-md-4 col-form-label text-md-left">Original Opponent Role*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_opponent_role" class="selected_original_opponent_role" value="<?php if(isset($case_data->original_opponent_role)){ echo $case_data->original_opponent_role; } ?>">
                                        <input type="hidden" name="original_opponent_role" id="original_opponent_role_hidden">
                                        <select id="original_opponent_role" name="original_opponent_role_select" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="" disabled="">
                                            <option value="">Choose Role</option>
                                            <option value="Defendant">Defendant</option>
                                            <option value="Respondent">Respondent</option>
                                            <option value="Petitioner 2">Petitioner 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_number_of_opponents" class="col-md-4 col-form-label text-md-left">Original Number of <span id="original_number_of_opponents_span">Opponents</span>*</label>
                                    <div class="col-md-8">
                                        <input id="original_number_of_opponents" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_of_opponents" value="<?php if(isset($case_data->original_number_opponent_role)){ echo $case_data->original_number_opponent_role; } ?>" autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_case_state" class="col-md-4 col-form-label text-md-left">Original State*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_state" class="selected_original_case_state" value="<?php if(isset($case_data->original_state_id)){ echo $case_data->original_state_id; } ?>">
                                        <select id="original_case_state" name="original_case_state" class="form-control case_state_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_county" class="col-md-4 col-form-label text-md-left">Original County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_county" class="selected_original_case_county" value="<?php if(isset($case_data->original_county_id)){ echo $case_data->original_county_id; } ?>">
                                        <select id="original_case_county" name="original_case_county" class="form-control case_county_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose County</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <p class="text-danger no-courts-original" style="display: none;">No Court found for the selected state and county.</p>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_case_court" class="col-md-4 col-form-label text-md-left">Original Court*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_court" class="selected_original_case_court" value="<?php if(isset($case_data->original_court_id)){ echo $case_data->original_court_id; } ?>">
                                        <select id="original_case_court" name="original_case_court" class="form-control case_court_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_division" class="col-md-4 col-form-label text-md-left">Original Division*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_division" class="selected_original_case_division" value="<?php if(isset($case_data->original_division_id)){ echo $case_data->original_division_id; } ?>">
                                        <select id="original_case_division" name="original_case_division" class="form-control case_division_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose Division</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_case_judge" class="col-md-4 col-form-label text-md-left">Original Judge</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_judge" class="selected_original_case_judge" value="<?php if(isset($case_data->original_judge_id)){ echo $case_data->original_judge_id; } ?>">
                                        <select id="original_case_judge" name="original_case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_magistrate" class="col-md-4 col-form-label text-md-left">Original Magistrate</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_original_case_magistrate" class="selected_original_case_magistrate" value="<?php if(isset($case_data->original_magistrate_id)){ echo $case_data->original_magistrate_id; } ?>">
                                        <select id="original_case_magistrate" name="original_case_magistrate" class="form-control case_magistrate_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs case_judge_magistrate_name_inputs_div original_case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 judge_fullname_div original_judge_fullname_div" style="display: none;">
                                    <label for="original_judge_fullname" class="col-md-4 col-form-label text-md-left">Original Judge Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="original_judge_fullname" type="text" class="form-control case_judge_name_inputs" name="original_judge_fullname" value="<?php if(isset($case_data->original_judge_fullname)){ echo $case_data->original_judge_fullname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <label for="original_magistrate_fullname" class="col-md-4 col-form-label text-md-left">Original Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="original_magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_fullname" value="<?php if(isset($case_data->original_magistrate_fullname)){ echo $case_data->original_magistrate_fullname; } ?>"  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_date_filed" class="col-md-4 col-form-label text-md-left">Original Date Filed</label>
                                    <div class="col-md-8">
                                        <input id="original_date_filed" type="text" class="form-control hasDatepicker" name="original_date_filed" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_date_filed)){ echo date("m/d/Y", strtotime($case_data->original_date_filed)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_date_served" class="col-md-4 col-form-label text-md-left">Original Date Served</label>
                                    <div class="col-md-8">
                                        <input id="original_date_served" type="text" class="form-control hasDatepicker" name="original_date_served" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_date_served)){ echo date("m/d/Y", strtotime($case_data->original_date_served)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_final_hearing_date" class="col-md-4 col-form-label text-md-left">Original Final Hearing Date</label>
                                    <div class="col-md-8">
                                        <input id="original_final_hearing_date" type="text" class="form-control hasDatepicker" name="original_final_hearing_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_final_hearing_date)){ echo date("m/d/Y", strtotime($case_data->original_final_hearing_date)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_journalization_date" class="col-md-4 col-form-label text-md-left">Original Journalization Date</label>
                                    <div class="col-md-8">
                                        <input id="original_journalization_date" type="text" class="form-control hasDatepicker" name="original_journalization_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_journalization_date)){ echo date("m/d/Y", strtotime($case_data->original_journalization_date)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 single-line-radio-div" id="jury_demand_div">
                                    <label class="col-md-4 col-form-label text-md-left">Jury Demand*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="jury_demand_y" class="jury_demand_inputs" name="jury_demand" value="Y" required="" <?php if(isset($case_data->jury_demand) && $case_data->jury_demand=='Y'){ echo 'checked'; } ?>>
                                        <label for="jury_demand_y">YES</label>
                                        <input type="radio" id="jury_demand_n" class="jury_demand_inputs" name="jury_demand" value="N" <?php if(isset($case_data->jury_demand) && $case_data->jury_demand=='N'){ echo 'checked'; } ?>>
                                        <label for="jury_demand_n">NO</label>
                                    </div>
                                </div>
                                <div class="col-md-6 case_sets_div" style="display: none;">
                                    <label for="case_sets" class="col-md-4 col-form-label text-md-left">SETS #*</label>
                                    <div class="col-md-8">
                                        <input id="case_sets" type="text" class="form-control" name="case_sets" autofocus="" value="<?php if(isset($case_data->sets)){ echo $case_data->sets; } ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="col-md-12 col-form-label text-md-left">Initial Service Types*</label>
                                <input type="hidden" name="selected_initial_service_types" class="selected_initial_service_types" value="<?php if(isset($case_data->initial_service_types)){ echo $case_data->initial_service_types; } ?>">
                                <div class="col-md-3">
                                    <input type="checkbox" id="certified_mail" name="initial_service_types[]" value="certified_mail" required="">
                                    <label for="certified_mail" class="col-form-label text-md-left">Certified Mail</label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="checkbox" id="express_mail" name="initial_service_types[]" value="express_mail">
                                    <label for="express_mail" class="col-form-label text-md-left">Express Mail</label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="checkbox" id="personal_server" name="initial_service_types[]" value="personal_server">
                                    <label for="personal_server" class="col-form-label text-md-left"> Personal Server </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="publication" name="initial_service_types[]" value="publication">
                                    <label for="publication" class="col-form-label text-md-left"> Publication </label>
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" id="sheriff" name="initial_service_types[]" value="sheriff">
                                    <label for="sheriff" class="col-form-label text-md-left">Sheriff</label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="checkbox" id="residence_unknown" name="initial_service_types[]" value="residence_unknown">
                                    <label for="residence_unknown" class="col-form-label text-md-left">Residence Unknown </label>
                                </div>
                                <div class="col-md-3">    
                                    <input type="checkbox" id="waiver_of_service" name="initial_service_types[]" value="waiver_of_service">
                                    <label for="waiver_of_service" class="col-form-label text-md-left"> Waiver of Service Attached </label>
                                </div>
                            </div>
                            
                            <div class="col-md-12 text-md-center">
                                <button class="btn btn-primary nextBtn" type="button">Next</button>
                            </div>
                            
                        </div>
                        <!-- end of case registration 1st step -->
                        
                        <!-- client registration 2nd step -->
                        <div class="row form-group setup-content" id="step-2">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clprefix" class="col-md-4 col-form-label text-md-left">Prefix</label>
                                    <div class="col-md-8">
                                        <select id="clprefix" name="clprefix" class="form-control" autofocus="">
                                            <option value="">Choose Prefix Type</option>
                                            <option value="Mr."<?php if(isset($client_data[0]->prefix) && $client_data[0]->prefix=='Mr.'){ echo 'selected'; } ?> >Mr.</option>
                                            <option value="Mrs." <?php if(isset($client_data[0]->prefix) && $client_data[0]->prefix=='Mrs.'){ echo 'selected'; } ?>>Mrs.</option>
                                            <option value="Ms." <?php if(isset($client_data[0]->prefix) && $client_data[0]->prefix=='Ms.'){ echo 'selected'; } ?>>Ms.</option>
                                            <option value="Dr." <?php if(isset($client_data[0]->prefix) && $client_data[0]->prefix=='Dr.'){ echo 'selected'; } ?>>Dr.</option>
                                            <option value="Hon." <?php if(isset($client_data[0]->prefix) && $client_data[0]->prefix=='Hon.'){ echo 'selected'; } ?>>Hon.</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clfname" class="col-md-4 col-form-label text-md-left">First Name*</label>
                                    <div class="col-md-8">
                                        <input id="clfname" type="text" class="form-control" name="clfname" value="<?php if(isset($client_fullname[0])){ echo $client_fullname[0]; } ?>" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clmname" class="col-md-4 col-form-label text-md-left">Middle Name</label>
                                    <div class="col-md-8">
                                        <input id="clmname" type="text" class="form-control " name="clmname" value="<?php if(isset($client_data[0]->mname)){ echo $client_data[0]->mname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cllname" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                                    <div class="col-md-8">
                                        <input id="cllname" type="text" class="form-control" name="cllname" value="<?php if(isset($client_fullname[1])){ echo $client_fullname[1]; } ?>" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clemail" class="col-md-4 col-form-label text-md-left">Email*</label>
                                    <div class="col-md-8">
                                        <input id="clemail" type="email" class="form-control" name="clemail" value="<?php if(isset($client_data[0]->email)){ echo $client_data[0]->email; } ?>" autofocus="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="clphone" class="col-md-4 col-form-label text-md-left">Telephone</label>
                                    <div class="col-md-8">
                                        <input id="clphone" type="text" class="form-control has-pattern-one" name="clphone" value="<?php if(isset($client_data[0]->telephone)){ echo $client_data[0]->telephone; } ?>" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clsuffix" class="col-md-4 col-form-label text-md-left">Suffix</label>
                                    <div class="col-md-8">
                                        <select id="clsuffix" name="clsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr." <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='Sr.'){ echo 'selected'; } ?>>Sr.</option>
                                            <option value="Jr." <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='Jr.'){ echo 'selected'; } ?>>Jr.</option>
                                            <option value="I" <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='I'){ echo 'selected'; } ?>>I</option>
                                            <option value="II" <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='II'){ echo 'selected'; } ?>>II</option>
                                            <option value="III" <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='III'){ echo 'selected'; } ?>>III</option>
                                            <option value="IV" <?php if(isset($client_data[0]->suffix) && $client_data[0]->suffix=='IV'){ echo 'selected'; } ?>>IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprefname" class="col-md-4 col-form-label text-md-left">Preferred Name</label>
                                    <div class="col-md-8">
                                        <input id="clprefname" type="text" class="form-control" name="clprefname" value="<?php if(isset($client_data[0]->prefname)){ echo $client_data[0]->prefname; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clgen-m" name="clgender" value="M" required="" <?php if(isset($client_data[0]->gender) && $client_data[0]->gender=='M'){ echo 'checked'; } ?>>
                                        <label for="clgen-m">M</label>
                                        <input type="radio" id="clgen-f" name="clgender" value="F" <?php if(isset($client_data[0]->gender) && $client_data[0]->gender=='F'){ echo 'checked'; } ?>>
                                        <label for="clgen-f">F</label>
                                        <input type="radio" id="clgen-n" name="clgender" value="N" <?php if(isset($client_data[0]->gender) && $client_data[0]->gender=='N'){ echo 'checked'; } ?>>
                                        <label for="clgen-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-2" style="float: left;display: inline-block;"></div>

                                <div class="col-md-6">
                                    <label for="clssno" class="col-md-4 col-form-label text-md-left">Social Security Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-two" id="clssno" name="clssno" placeholder="XXX-XX-XXXX" value="<?php if(isset($client_data[0]->social_sec_number)){ echo $client_data[0]->social_sec_number; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="cldob" class="col-md-4 col-form-label text-md-left">Date of Birth*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control hasDatepicker" id="cldob" name="cldob" placeholder="MM/DD/YYYY" value="<?php if(isset($client_data[0]->date_of_birth)){ echo date("m/d/Y", strtotime($client_data[0]->date_of_birth)); } ?>" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clzip" class="col-md-4 col-form-label text-md-left">ZIP*</label>
                                    <div class="col-md-8">
                                    <p class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="clzip" name="clzip" value="<?php if(isset($client_data[0]->user_zipcode)){ echo $client_data[0]->user_zipcode; } ?>" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clstreetad" class="col-md-4 col-form-label text-md-left">Street Address*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="clstreetad" name="clstreetad" value="<?php if(isset($client_data[0]->street_address)){ echo $client_data[0]->street_address; } ?>" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-city-cl" value="<?php if(isset($client_data[0]->user_city)){ echo $client_data[0]->user_city; } ?>" class="selected-city-cl">
                                        <select id="clcity" name="clcity" class="form-control cl-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clstate" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-state-cl" value="<?php if(isset($client_data[0]->state_id)){ echo $client_data[0]->state_id; } ?>" class="selected-state-cl">
                                        <select id="clstate" name="clstate" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-county-cl" value="<?php if(isset($client_data[0]->county_id)){ echo $client_data[0]->county_id; } ?>" class="selected-county-cl">
                                        <select id="clcounty" name="clcounty" class="form-control cl-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clfax" class="col-md-4 col-form-label text-md-left">Fax</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-one" id="clfax" name="clfax" value="<?php if(isset($client_data[0]->fax)){ echo $client_data[0]->fax; } ?>" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprimlang" class="col-md-4 col-form-label text-md-left">Primary Language*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-lang-cl" value="<?php if(isset($client_data[0]->primary_language)){ echo $client_data[0]->primary_language; } ?>" class="selected-lang-cl" style="display: none;" >
                                        <select id="clprimlang" name="clprimlang" class="form-control languages-select" autofocus="" required="">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 client_primlang_other_div" style="margin-top: 20px; display: none;">
                                    <label for="client_primlang_other" class="col-md-4 col-form-label text-md-left">Add Primary Language*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="client_primlang_other" name="client_primlang_other" value="" autofocus>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Translator*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqlangtrans-y" name="clreqlangtrans" value="Y" required="" <?php if(isset($client_data[0]->req_lang_trans) && $client_data[0]->req_lang_trans=='Y'){ echo 'checked'; } ?>>
                                        <label for="clreqlangtrans-y">Y</label>
                                        <input type="radio" id="clreqlangtrans-n" name="clreqlangtrans" value="N" <?php if(isset($client_data[0]->req_lang_trans) && $client_data[0]->req_lang_trans=='N'){ echo 'checked'; } ?>>
                                        <label for="clreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clhearingimpaired-y" name="clhearingimpaired" value="Y" required="" <?php if(isset($client_data[0]->hearing_impaired) && $client_data[0]->hearing_impaired=='Y'){ echo 'checked'; } ?>>
                                        <label for="clhearingimpaired-y">Y</label>
                                        <input type="radio" id="clhearingimpaired-n" name="clhearingimpaired" value="N" <?php if(isset($client_data[0]->hearing_impaired) && $client_data[0]->hearing_impaired=='N'){ echo 'checked'; } ?>>
                                        <label for="clhearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqsignlang-y" name="clreqsignlang" value="Y" required="" <?php if(isset($client_data[0]->req_sign_lang) && $client_data[0]->req_sign_lang=='Y'){ echo 'checked'; } ?>>
                                        <label for="clreqsignlang-y">Y</label>
                                        <input type="radio" id="clreqsignlang-n" name="clreqsignlang" value="N" <?php if(isset($client_data[0]->req_sign_lang) && $client_data[0]->req_sign_lang=='N'){ echo 'checked'; } ?>>
                                        <label for="clreqsignlang-n">N</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-md-center">
                                <button class="btn btn-primary nextBtn" type="button">Next</button>
                            </div>
                        </div>
                        <!-- end of client registration 2nd step -->

                        <!--  opponent registration 3rd step -->
                        <?php 
                            $opponent_fullname=$opponent_data[0]->name;
                            $opponent_fullname = explode(" ", $opponent_fullname);
                        ?>

                        <div class="row form-group setup-content" id="step-3">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opprefix" class="col-md-4 col-form-label text-md-left">Prefix</label>
                                    <div class="col-md-8">
                                        <select id="opprefix" name="opprefix" class="form-control" autofocus="">
                                            <option value="">Choose Prefix Type</option>
                                            <option value="Mr."<?php if(isset($opponent_data[0]->prefix) && $opponent_data[0]->prefix=='Mr.'){ echo 'selected'; } ?> >Mr.</option>
                                            <option value="Mrs." <?php if(isset($opponent_data[0]->prefix) && $opponent_data[0]->prefix=='Mrs.'){ echo 'selected'; } ?>>Mrs.</option>
                                            <option value="Ms." <?php if(isset($opponent_data[0]->prefix) && $opponent_data[0]->prefix=='Ms.'){ echo 'selected'; } ?>>Ms.</option>
                                            <option value="Dr." <?php if(isset($opponent_data[0]->prefix) && $opponent_data[0]->prefix=='Dr.'){ echo 'selected'; } ?>>Dr.</option>
                                            <option value="Hon." <?php if(isset($opponent_data[0]->prefix) && $opponent_data[0]->prefix=='Hon.'){ echo 'selected'; } ?>>Hon.</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opfname" class="col-md-4 col-form-label text-md-left">First Name*</label>
                                    <div class="col-md-8">
                                        <input id="opfname" type="text" class="form-control" name="opfname" value="<?php if(isset($opponent_fullname[0])){ echo $opponent_fullname[0]; } ?>" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opmname" class="col-md-4 col-form-label text-md-left">Middle Name</label>
                                    <div class="col-md-8">
                                        <input id="opmname" type="text" class="form-control " name="opmname" value="<?php if(isset($opponent_data[0]->mname)){ echo $opponent_data[0]->mname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="oplname" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                                    <div class="col-md-8">
                                        <input id="oplname" type="text" class="form-control" name="oplname" value="<?php if(isset($opponent_fullname[1])){ echo $opponent_fullname[1]; } ?>" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opemail" class="col-md-4 col-form-label text-md-left">Email*</label>
                                    <div class="col-md-8">
                                        <input id="opemail" type="email" class="form-control" name="opemail" value="<?php if(isset($opponent_data[0]->email)){ echo $opponent_data[0]->email; } ?>" autofocus="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="opphone" class="col-md-4 col-form-label text-md-left">Telephone</label>
                                    <div class="col-md-8">
                                        <input id="opphone" type="text" class="form-control has-pattern-one" name="opphone" value="<?php if(isset($opponent_data[0]->telephone)){ echo $opponent_data[0]->telephone; } ?>" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opsuffix" class="col-md-4 col-form-label text-md-left">Suffix</label>
                                    <div class="col-md-8">
                                        <select id="opsuffix" name="opsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr." <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='Sr.'){ echo 'selected'; } ?>>Sr.</option>
                                            <option value="Jr." <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='Jr.'){ echo 'selected'; } ?>>Jr.</option>
                                            <option value="I" <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='I'){ echo 'selected'; } ?>>I</option>
                                            <option value="II" <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='II'){ echo 'selected'; } ?>>II</option>
                                            <option value="III" <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='III'){ echo 'selected'; } ?>>III</option>
                                            <option value="IV" <?php if(isset($opponent_data[0]->suffix) && $opponent_data[0]->suffix=='IV'){ echo 'selected'; } ?>>IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opprefname" class="col-md-4 col-form-label text-md-left">Preferred Name</label>
                                    <div class="col-md-8">
                                        <input id="opprefname" type="text" class="form-control" name="opprefname" value="<?php if(isset($opponent_data[0]->prefname)){ echo $opponent_data[0]->prefname; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="opgen-m" name="opgender" value="M" required="" <?php if(isset($opponent_data[0]->gender) && $opponent_data[0]->gender=='M'){ echo 'checked'; } ?>>
                                        <label for="opgen-m">M</label>
                                        <input type="radio" id="opgen-f" name="opgender" value="F" <?php if(isset($opponent_data[0]->gender) && $opponent_data[0]->gender=='F'){ echo 'checked'; } ?>>
                                        <label for="opgen-f">F</label>
                                        <input type="radio" id="opgen-n" name="opgender" value="N" <?php if(isset($opponent_data[0]->gender) && $opponent_data[0]->gender=='N'){ echo 'checked'; } ?>>
                                        <label for="opgen-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-2" style="float: left;display: inline-block;"></div>

                                <div class="col-md-6">
                                    <label for="opssno" class="col-md-4 col-form-label text-md-left">Social Security Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-two" id="opssno" name="opssno" placeholder="XXX-XX-XXXX" value="<?php if(isset($opponent_data[0]->social_sec_number)){ echo $opponent_data[0]->social_sec_number; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opdob" class="col-md-4 col-form-label text-md-left">Date of Birth*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control hasDatepicker"  id="opdob" name="opdob" placeholder="MM/DD/YYYY" value="<?php if(isset($opponent_data[0]->date_of_birth)){ echo date("m/d/Y", strtotime($opponent_data[0]->date_of_birth)); } ?>" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opzip" class="col-md-4 col-form-label text-md-left">ZIP*</label>
                                    <div class="col-md-8">
                                    <p class="text-danger no-state-county-op" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="opzip" name="opzip" value="<?php if(isset($opponent_data[0]->user_zipcode)){ echo $opponent_data[0]->user_zipcode; } ?>" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opstreetad" class="col-md-4 col-form-label text-md-left">Street Address*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="opstreetad" name="opstreetad" value="<?php if(isset($opponent_data[0]->street_address)){ echo $opponent_data[0]->street_address; } ?>" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-city-op" value="<?php if(isset($opponent_data[0]->user_city)){ echo $opponent_data[0]->user_city; } ?>" class="selected-city-op">
                                        <select id="opcity" name="opcity" class="form-control op-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opstate" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-state-op" value="<?php if(isset($opponent_data[0]->state_id)){ echo $opponent_data[0]->state_id; } ?>" class="selected-state-op">
                                        <select id="opstate" name="opstate" class="form-control op-state" autofocus="" required="">
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-county-op" value="<?php if(isset($opponent_data[0]->county_id)){ echo $opponent_data[0]->county_id; } ?>" class="selected-county-op">
                                        <select id="opcounty" name="opcounty" class="form-control op-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opfax" class="col-md-4 col-form-label text-md-left">Fax</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-one" id="opfax" name="opfax" value="<?php if(isset($opponent_data[0]->fax)){ echo $opponent_data[0]->fax; } ?>" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opprimlang" class="col-md-4 col-form-label text-md-left">Primary Language*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected-lang-op" value="<?php if(isset($opponent_data[0]->primary_language)){ echo $opponent_data[0]->primary_language; } ?>" class="selected-lang-op" style="display: none;" >
                                        <select id="opprimlang" name="opprimlang" class="form-control languages-select" autofocus="" required="">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 opponent_primlang_other_div" style="margin-top: 20px; display: none;">
                                    <label for="opponent_primlang_other" class="col-md-4 col-form-label text-md-left">Add Primary Language*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="opponent_primlang_other" name="opponent_primlang_other" value="" autofocus>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Translator*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="opreqlangtrans-y" name="opreqlangtrans" value="Y" required="" <?php if(isset($opponent_data[0]->req_lang_trans) && $opponent_data[0]->req_lang_trans=='Y'){ echo 'checked'; } ?>>
                                        <label for="opreqlangtrans-y">Y</label>
                                        <input type="radio" id="opreqlangtrans-n" name="opreqlangtrans" value="N" <?php if(isset($opponent_data[0]->req_lang_trans) && $opponent_data[0]->req_lang_trans=='N'){ echo 'checked'; } ?>>
                                        <label for="opreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="ophearingimpaired-y" name="ophearingimpaired" value="Y" required="" <?php if(isset($opponent_data[0]->hearing_impaired) && $opponent_data[0]->hearing_impaired=='Y'){ echo 'checked'; } ?>>
                                        <label for="ophearingimpaired-y">Y</label>
                                        <input type="radio" id="ophearingimpaired-n" name="ophearingimpaired" value="N" <?php if(isset($opponent_data[0]->hearing_impaired) && $opponent_data[0]->hearing_impaired=='N'){ echo 'checked'; } ?>>
                                        <label for="ophearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="opreqsignlang-y" name="opreqsignlang" value="Y" required="" <?php if(isset($opponent_data[0]->req_sign_lang) && $opponent_data[0]->req_sign_lang=='Y'){ echo 'checked'; } ?>>
                                        <label for="opreqsignlang-y">Y</label>
                                        <input type="radio" id="opreqsignlang-n" name="opreqsignlang" value="N" <?php if(isset($opponent_data[0]->req_sign_lang) && $opponent_data[0]->req_sign_lang=='N'){ echo 'checked'; } ?>>
                                        <label for="opreqsignlang-n">N</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-md-center">
                                <input name="cl_op_case_update" value="Update" class="btn btn-primary nextBtn" type="submit">
                            </div>
                        </div>

                        <!-- end of opponent registration 3rd step -->

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>                    

<script type="text/javascript">
$(document).ready(function () {
/*********** for form and steps validation    *************/
//https://codepen.io/brettmichaelorr/pen/RaRZLe

    // $("#multistep_case_form").validate({
    //     // errorPlacement: function (error, element) {
    //     //     var lastError = $(element).data('lastError'),
    //     //         newError = $(error).text();

    //     //     $(element).data('lastError', newError);

    //     //     if(newError !== '' && newError !== lastError){
    //     //         // $(element).tooltipster('content', newError);
    //     //         // $(element).tooltipster('show');
    //     //     }
    //     // },
    //     // success: function (label, element) {
    //     //     // $(element).tooltipster('hide');
    //     // }
    // });
  
    /* This code handles all of the navigation stuff.
    ** Probably leave it. Credit to https://bootsnipp.com/snippets/featured/form-wizard-and-validation
    */
    $('#multistep_case_form').validate({
        rules: {
            clphone: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            clfax: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            clssno: {
                pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
            },
            opphone: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            opfax: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            opssno: {
                pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
            },
        }
    });

    $(".hasDatepicker").datepicker({
        startDate: "01/01/1901",
        endDate: '+0d',
    });

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            // $('input, select').tooltipster("hide");
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    /* Handles validating using jQuery validate.
    */
    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input,select"),
            // curSeletcs = curStep.find("select"),
            isValid = true;

        //Loop through all inputs in this form group and validate them.
        for(var i=0; i<curInputs.length; i++){
            if (!$(curInputs[i]).valid()){
                isValid = false;
            }
        }

        if (isValid){
            //Progress to the next page.
          nextStepWizard.removeClass('disabled').trigger('click');
        }
    });

    $('div.setup-panel div a.btn-primary').trigger('click');

        // client-opponent selected zip, city, state, county
        var cl=document.getElementById('clzip');
        test(cl);
        var op=document.getElementById('opzip');
        test(op);

        function test(t){
            var type='';
                if(t.id=='clzip'){
                    type='cl';
                }
                if(t.id=='opzip'){
                    type='op';
                }
                $('.no-state-county-'+type+'').hide();
                $('.'+type+'-city').find('option').remove().end().append('<option value="">Choose City</option>');
                $('.'+type+'-state').find('option').remove().end().append('<option value="">Choose State</option>');
                $('.'+type+'-county').find('option').remove().end().append('<option value="">Choose County</option>');
                var zip=t.value;
                if( zip != '' && zip != null && zip.length >= '3'){
                    var token= $('input[name=_token]').val();
                    $.ajax({
                        url:"{{route('ajax_get_city_state_county_by_zip')}}",
                        method:"POST",
                        dataType: 'json',
                        data:{
                            zip: zip, 
                            _token: token, 
                        },
                        success: function(data){
                            // console.log(data);
                            if(data=='null' || data==''){
                                $('.no-state-county-'+type+'').show();
                              // $('.cl_no_zip').show();
                            } else {
                                // $('.cl_no_zip').hide();
                                $.each(data, function (key, val) {
                                    $('.'+type+'-city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                                    $('.'+type+'-state').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                                    $('.'+type+'-county').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                                });
                                var a = new Array();
                                $('.'+type+'-city').children("option").each(function(x){
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i=0;i<a.length-1;i++){
                                        if (b ==a[i]) test =true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('.'+type+'-state').children("option").each(function(x){
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i=0;i<a.length-1;i++){
                                        if (b ==a[i]) test =true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('.'+type+'-county').children("option").each(function(x){
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i=0;i<a.length-1;i++){
                                        if (b ==a[i]) test =true;
                                    }
                                    if (test) $(this).remove();
                                })
                                if($('.'+type+'-city').children('option').length=='2'){
                                    $('.'+type+'-city').children('option').first().remove();
                                }
                                if($('.'+type+'-state').children('option').length=='2'){
                                    $('.'+type+'-state').children('option').first().remove();
                                }
                                if($('.'+type+'-county').children('option').length=='2'){
                                    $('.'+type+'-county').children('option').first().remove();
                                }

                            }

                            var selected_city=$('.selected-city-'+type+'').val();
                            var selected_state=$('.selected-state-'+type+'').val();
                            var selected_county=$('.selected-county-'+type+'').val();
                            $('.'+type+'-city option:selected').removeAttr('selected');
                            $('.'+type+'-state option:selected').removeAttr('selected');
                            $('.'+type+'-county option:selected').removeAttr('selected');
                            $('.'+type+'-city option[value="'+selected_city+'"]').attr('selected','selected');
                            $('.'+type+'-state option[value="'+selected_state+'"]').attr('selected','selected');
                            $('.'+type+'-county option[value="'+selected_county+'"]').attr('selected','selected');
                        }
                    });        
                }
        }
    // fetch city, state, county of client based on zipcode
      $('#clzip, #opzip').on('focusout', function() {
        var type='';
        if(this.id=='clzip'){
            type='cl';
        }
        if(this.id=='opzip'){
            type='op';
        }
        $('.no-state-county-'+type+'').hide();
        $('.'+type+'-city').find('option').remove().end().append('<option value="">Choose City</option>');
        $('.'+type+'-state').find('option').remove().end().append('<option value="">Choose State</option>');
        $('.'+type+'-county').find('option').remove().end().append('<option value="">Choose County</option>');
        var zip=this.value;
        if( zip != '' && zip != null && zip.length >= '3'){
            var token= $('input[name=_token]').val();
            $.ajax({
                url:"{{route('ajax_get_city_state_county_by_zip')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    zip: zip, 
                    _token: token, 
                },
                success: function(data){
                    // console.log(data);
                    if(data=='null' || data==''){
                        $('.no-state-county-'+type+'').show();
                      // $('.cl_no_zip').show();
                    } else {
                        // $('.cl_no_zip').hide();
                        $.each(data, function (key, val) {
                            $('.'+type+'-city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                            $('.'+type+'-state').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                            $('.'+type+'-county').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                        });
                        var a = new Array();
                        $('.'+type+'-city').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('.'+type+'-state').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        var a = new Array();
                        $('.'+type+'-county').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        })
                        if($('.'+type+'-city').children('option').length=='2'){
                            $('.'+type+'-city').children('option').first().remove();
                        }
                        if($('.'+type+'-state').children('option').length=='2'){
                            $('.'+type+'-state').children('option').first().remove();
                        }
                        if($('.'+type+'-county').children('option').length=='2'){
                            $('.'+type+'-county').children('option').first().remove();
                        }

                    }
                }
            });        
        }

      });

      // fetch languages
        $.ajax({
            url:"{{route('ajax_get_languages')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('.languages-select').append('<option value='+val+'>'+val+'</option>');
                        // make language selected for client
                        var sel_lang_cl=$('.selected-lang-cl').val();
                        if($('#clprimlang option[value="'+sel_lang_cl+'"]').length > 0){
                            $('#client_primlang_other').val('');
                            $('#client_primlang_other').prop('required', false);
                            $('.client_primlang_other_div').hide();
                            $('#clprimlang option:selected').removeAttr('selected');
                            $('#clprimlang option[value='+sel_lang_cl+']').attr('selected','selected');
                        } else {
                            $('#client_primlang_other').val(sel_lang_cl);
                            $('#client_primlang_other').prop('required', true);
                            $('.client_primlang_other_div').show();
                            $('#clprimlang option:selected').removeAttr('selected');
                            $('#clprimlang option[value="OTHER"]').attr('selected','selected');
                        }
                        // make language selected for opponent
                        var sel_lang_op=$('.selected-lang-op').val();
                        if($('#opprimlang option[value="'+sel_lang_op+'"]').length > 0){
                            $('#opponent_primlang_other').val('');
                            $('#opponent_primlang_other').prop('required', false);
                            $('.opponent_primlang_other_div').hide();
                            $('#opprimlang option:selected').removeAttr('selected');
                            $('#opprimlang option[value='+sel_lang_op+']').attr('selected','selected');
                        } else {
                            $('#opponent_primlang_other').val(sel_lang_op);
                            $('#opponent_primlang_other').prop('required', true);
                            $('.opponent_primlang_other_div').show();
                            $('#opprimlang option:selected').removeAttr('selected');
                            $('#opprimlang option[value="OTHER"]').attr('selected','selected');
                        }
                    });
                }
            }
        });

        // show language input box if selected language is OTHER
        // on client primary language change
        $('#clprimlang').on('change', function() {
            var primlang=this.value;
            if(primlang=='OTHER'){
                $('#client_primlang_other').prop('required', true);
                $('.client_primlang_other_div').show();
            } else {
                $('#client_primlang_other').prop('required', false);
                $('.client_primlang_other_div').hide();     
            }
        });

        // on opponent primary language change
        $('#opprimlang').on('change', function() {
            var primlang=this.value;
            if(primlang=='OTHER'){
                $('#opponent_primlang_other').prop('required', true);
                $('.opponent_primlang_other_div').show();
            } else {
                $('#opponent_primlang_other').prop('required', false);
                $('.opponent_primlang_other_div').hide();     
            }
        });

    /***** following functions are for case registration steps *********/
        // fetch active states
        $.ajax({
            url:"{{route('ajax_get_active_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('.case_state_inputs').append('<option value='+key+'>'+val+'</option>');
                    });

                    // selected case state
                    var selected_case_state=$('.selected_case_state').val();
                    $("#case_state").val(selected_case_state);
                    var original_state_id=$('.selected_original_case_state').val();
                    $('#original_case_state').val(original_state_id);

                }
            }
        });   

        //hide inputs for case filing status
        $('.currently_filed_inputs, .prev_filed_refiling_inputs, .prev_filed_post_decree_inputs').hide();
        $('.to_be_filed_new_inputs').show();

        // check first case filing status option
        $('.case_filing_status_inputs').attr('checked', false);
        $('#to_be_filed_new').prop("checked",true);

        // fetch counties for states
        $('#case_state').on('change', function(){
            $('.case_county_inputs, .case_court_inputs, .case_division_inputs, .case_judge_inputs, .case_magistrate_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types').hide();
            var id=this.value;
            var token= $('input[name=_token]').val();
            if(id) {
                $.ajax({
                    url:"{{route('ajax_get_counties_by_state')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        id: id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data==null || data=='null'){
                        } else {
                            $.each(data, function (key, val) {
                                $('.case_county_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                        }
                    }
                });

                $('#original_case_state option:selected').removeAttr('selected');
                $('#original_case_state option[value='+id+']').attr('selected','selected');
            
            } else {
                $('#original_case_state option:selected').removeAttr('selected');
                $('#original_case_state option:first').attr('selected','selected');
            }
        });

        // fetch courts for counties,state
        $('#case_county').on('change', function(){
            $('.case_court_inputs, .case_division_inputs, .case_judge_inputs, .case_magistrate_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types').hide();
            var county_id=this.value;
            var state_id=$('#case_state').val();
            var token= $('input[name=_token]').val();
            if(county_id) {
                $.ajax({
                    url:"{{route('ajax_get_court_by_county_state')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        county_id: county_id, 
                        state_id: state_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data==null || data=='null'){
                            $('.no-courts').show();
                        } else {
                            $('.no-courts').hide();
                            $.each(data, function (key, val) {
                                $('.case_court_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                        }
                    }
                });

                $('#original_case_county option:selected').removeAttr('selected');
                $('#original_case_county option[value='+county_id+']').attr('selected','selected');
            
            } else {
                $('#original_case_county option:selected').removeAttr('selected');
                $('#original_case_county option:first').attr('selected','selected');
            }
        });

        // fetch division for court
        $('#case_court').on('change', function(){
            $('.case_division_inputs, .case_judge_inputs, .case_magistrate_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types').hide();
            var court_id=this.value;
            var token= $('input[name=_token]').val();
            if(court_id) {
                $.ajax({
                    url:"{{route('ajax_get_division_by_court')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        court_id: court_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data==null || data=='null'){
                        } else {
                            $.each(data, function (key, val) {
                                $('.case_division_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                        }
                    }
                });

                $('#original_case_court option:selected').removeAttr('selected');
                $('#original_case_court option[value='+court_id+']').attr('selected','selected');

            } else {
                $('#original_case_court option:selected').removeAttr('selected');
                $('#original_case_court option:first').attr('selected','selected');
            }
        });

        // fetch judges and magistrates for court and division
        $('#case_division').on('change', function(){
            $('.case_judge_inputs, .case_magistrate_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, #case_sets').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types, .case_sets_div').hide();
            var division_id=this.value;
            var court_id=$('#case_court').val();
            var token= $('input[name=_token]').val();
            if( division_id=='7'|| division_id=='8') {
                 $(".jury_demand_inputs").attr('checked', false);
                 $("#jury_demand_div").hide();
                 $("#jury_demand_n").attr('checked', true);
            } else {
                $(".jury_demand_inputs").attr('checked', false);
                $("#jury_demand_div").show();
                $("#jury_demand_y").attr('checked', true);
            }
            if(division_id && court_id) {
                $.ajax({
                    url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
                    method:"POST",
                    dataType: 'json',
                    data:{
                        division_id: division_id, 
                        court_id: court_id, 
                        _token: token, 
                    },
                    success: function(data){
                        // console.log(data);
                        if(data['judges']==null || data['judges']=='null'){
                            $('.case_judge_inputs').append('<option value="other">Other Judge</option>');
                        } else {
                            $.each(data['judges'], function (key, val) {
                                $('.case_judge_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                            $('.case_judge_inputs').append('<option value="other">Other Judge</option>');
                        }

                        if(data['magistrates']==null || data['magistrates']=='null'){
                            $('.case_magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        } else {
                            $.each(data['magistrates'], function (key, val) {
                                $('.case_magistrate_inputs').append('<option value='+key+'>'+val+'</option>');
                            });
                            $('.case_magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        }

                        if(data['case_types']==null || data['case_types']=='null'){
                            $('.case-types-div').empty();
                            $('.no-case-types').show();
                        } else {
                            $('.case-types-div').empty();
                            $('.case-types-div').append('<label class="col-md-12 col-form-label text-md-left">Case Type(s)*</label>');
                            $.each(data['case_types'], function (key, val) {
                                $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_types[]" value="'+key+'"><label for="case_type_'+key+'" class="col-form-label text-md-left">'+val+'</label></div>');
                            });
                            $('.no-case-types').hide();
                            $('.case-types-div').show();
                        }

                        // case type change function
                        $('.case-types-div input[type="checkbox"]').on('change', function() {
                            var case_type=$(this).val();
                            // when OHIO+Domestic Relations only select one checkbox
                            var case_state=$('#case_state').val();
                            var case_division=$('#case_division').val();
                            var case_county=$('#case_county').val();
                            var case_court=$('#case_court').val();
                            if(case_state=='35' && case_division=='8') {
                               $('.case-types-div input[type="checkbox"]').prop('checked', false);
                               this.checked = true;
                            }
                            if(case_type=='8'){
                                // $('.case_filing_status_inputs').attr('checked', false);
                                $('#prev_filed_post_decree').prop("checked",true).trigger("change");
                                // $('#prev_filed_post_decree').attr('checked', true);
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                                $('.case-filing-status-div').hide();
                            } else {
                                // $('.case_filing_status_inputs').attr('checked', false);
                                // $('#to_be_filed_new').trigger("change");
                                $('#to_be_filed_new').prop("checked",true).trigger("change");
                                // $('#to_be_filed_new').attr('checked', true);
                                $('#case_sets').prop('required', false);
                                $('.case_sets_div').hide();
                                $('.case-filing-status-div').show();
                            }
                            if(case_type=='9'  && this.checked == true){
                                // $('.case_filing_status_inputs').attr('checked', false);
                                $('.prev_filed_post_decree_div').hide();
                                $('#to_be_filed_new').prop("checked",true).trigger("change");
                                // $('#prev_filed_post_decree').attr('checked', true);
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                            } else {
                                if($("#case_type_9").prop("checked") == true){
                                    $('#case_sets').prop('required', true);
                                    $('.case_sets_div').show();
                                    $('.prev_filed_post_decree_div').hide();
                                } else {
                                    $('.prev_filed_post_decree_div').show();
                                    $('#case_sets').prop('required', false);
                                    $('.case_sets_div').hide();
                                }
                            }
                            if(case_type=='8' && this.checked == true){
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                            }
                            if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                            {
                                $('.original_court_case_number_div').hide();
                            }
                        });
                        
                    }
                });

                $('#original_case_division option:selected').removeAttr('selected');
                $('#original_case_division option[value='+division_id+']').attr('selected','selected');
            } else {
                $('#original_case_division option:selected').removeAttr('selected');
                $('#original_case_division option:first').attr('selected','selected');
            }
        });

        // on judge change
        $('#case_judge').on('change', function(){
            var case_judge=$(this).val();
            $('#original_case_judge').val(case_judge);
            var casefil='';
            $.each($(".case_filing_status_inputs:checked"), function(){            
              casefil =($(this).val());
            });
            if(case_judge=='other'){
              $('#judge_fullname').prop('required', true);
              $('.case_judge_magistrate_name_inputs_div, .judge_fullname_div').show();
              if(casefil=='to_be_filed_new'  || casefil=='currently_filed'){
                $('#original_judge_fullname').prop('required', false);
                $('.original_case_judge_magistrate_name_inputs_div').hide();
              } else {
                $('#original_judge_fullname').prop('required', true);
                $('.original_case_judge_magistrate_name_inputs_div').show();
              }  
            } else {
              $('#judge_fullname, #original_judge_fullname').prop('required', false);
              $('.judge_fullname_div').hide();
              if($('#case_magistrate').val()!='other'){
                $('.case_judge_magistrate_name_inputs_div').hide();
              }
              if($('#original_magistrate_fullname').val() !='' || $('#original_magistrate').val() =='other'){
                $('.original_case_judge_magistrate_name_inputs_div').show();
              }
            }            
        });

        // on magistrate change
        $('#case_magistrate').on('change', function(){
            var case_magistrate=$(this).val();
            $('#original_case_magistrate').val(case_magistrate);
            var casefil='';
            $.each($(".case_filing_status_inputs:checked"), function(){            
              casefil =($(this).val());
            });
            if(case_magistrate=='other'){
              $('#magistrate_fullname').prop('required', true);
              $('.case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
              if(casefil=='to_be_filed_new'  || casefil=='currently_filed'){
                $('#original_magistrate_fullname').prop('required', false);
                $('.original_case_judge_magistrate_name_inputs_div').hide();
              } else {
                $('#original_magistrate_fullname').prop('required', true);
                $('.original_case_judge_magistrate_name_inputs_div').show();
              }  
            } else {
              $('#magistrate_fullname, #original_magistrate_fullname').prop('required', false);
              $('.magistrate_fullname_div').hide();
              if($('#case_judge').val()!='other'){
                $('.case_judge_magistrate_name_inputs_div').hide();
              }
              if($('#original_judge_fullname').val()!='' || $('#original_judge').val() =='other'){
                $('.original_case_judge_magistrate_name_inputs_div').show();
              }
            }            
        });

        // for case filing status
        $('.case_filing_status_inputs').on('change', function() {
            $('#original_judge_fullname, #original_magistrate_fullname').prop('required', false);
            $('#original_magistrate_fullname_div').hide();
            $('.case_filing_status_inputs').attr('checked', false);
            $(this).attr('checked', true);
            if ( this.value === 'to_be_filed_new' ) {
                $('.currently_filed_inputs_req, .prev_filed_refiling_inputs_req, .prev_filed_post_decree_inputs_req').prop('required', false);
                $('.to_be_filed_new_inputs_req').prop('required', true);
                $('.currently_filed_inputs, .prev_filed_refiling_inputs, .prev_filed_post_decree_inputs').hide();
                $('.to_be_filed_new_inputs').show();
            } 
            else if ( this.value === 'currently_filed' ) {
                $('.to_be_filed_new_inputs_req, .prev_filed_refiling_inputs_req, .prev_filed_post_decree_inputs_req').prop('required', false);
                $('.currently_filed_inputs_req').prop('required', true);
                $('.to_be_filed_new_inputs, .prev_filed_refiling_inputs, .prev_filed_post_decree_inputs').hide();
                $('.currently_filed_inputs').show();


                // to move original court case number div along with court case number div
                $('.date_filed_div').show();
                $('.original_court_case_number_div').hide();
            }
            else if ( this.value === 'prev_filed_refiling' ) {
                $('.to_be_filed_new_inputs_req, .currently_filed_inputs_req, .prev_filed_post_decree_inputs_req').prop('required', false);
                $('.prev_filed_refiling_inputs_req').prop('required', true);
                $('.to_be_filed_new_inputs, .currently_filed_inputs, .prev_filed_post_decree_inputs').hide();
                $('.prev_filed_refiling_inputs').show();

                // to hide date filed div and show original case div
                $(".court_case_number_date_filed_div, .court_case_number_div, .original_court_case_number_div").show();
                $('.date_filed_div').hide();

                var original_case_judge=$('#original_case_judge').val();
                if(original_case_judge=='other'){
                    $('#original_judge_fullname').prop('required', true);
                    $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                } else {
                    $('#original_judge_fullname').prop('required', false);
                    $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').hide();
                }
              var original_case_magistrate=$('#original_case_magistrate').val();
              if(original_case_magistrate=='other'){
                $('#original_magistrate_fullname').prop('required', true);
                $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').show();
              } else {
                    $('#original_magistrate_fullname').prop('required', false);
                    $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').hide();
                    if(original_case_judge=='other'){
                        $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                    }
                }
            }
            else if ( this.value === 'prev_filed_post_decree' ) {
              $('.to_be_filed_new_inputs_req, .currently_filed_inputs_req, .prev_filed_refiling_inputs_req').prop('required', false);
                $('.prev_filed_post_decree_inputs_req').prop('required', true);
                $('.to_be_filed_new_inputs, .currently_filed_inputs, .prev_filed_refiling_inputs').hide();
                $('.prev_filed_post_decree_inputs').show();

                // to hide date filed div and show original case div
                $(".court_case_number_date_filed_div, .court_case_number_div, .original_court_case_number_div").show();
                $('.date_filed_div').hide();

              var original_case_judge=$('#original_case_judge').val();
              if(original_case_judge=='other'){
                $('#original_judge_fullname').prop('required', true);
                $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
              } else {
                $('#original_judge_fullname').prop('required', false);
                $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').hide();
              }
              var original_case_magistrate=$('#original_case_magistrate').val();
              if(original_case_magistrate=='other'){
                $('#original_magistrate_fullname').prop('required', true);
                $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').show();
              } else {
                    $('#original_magistrate_fullname').prop('required', false);
                    $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').hide();
                    if(original_case_judge=='other'){
                        $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                    }
                }
            }

        });

        // on client role change
        $('#client_role').on('change', function() {
            var client_role=this.value;
            if(client_role==''){
                $("#opponent_role_hidden").val('');
                $("#opponent_role").find('option:selected').attr("selected", false);
                $('#opponent_role option[value=""]').attr("selected","selected");
                $("#number_of_clients_span").html('Clients');
                $("#number_of_opponents_span").html('Opponents');
            }
            if(client_role=='Plaintiff'){
                $("#opponent_role_hidden").val('Defendant');
                $("#opponent_role").find('option:selected').attr("selected", false);
                $('#opponent_role option[value="Defendant"]').attr("selected","selected");
                $("#number_of_clients_span").html('Plaintiff');
                $("#number_of_opponents_span").html('Defendants');
            }
            if(client_role=='Petitioner'){
                $("#opponent_role_hidden").val('Respondent');
                $("#opponent_role").find('option:selected').attr("selected", false);
                $('#opponent_role option[value="Respondent"]').attr("selected","selected");
                $("#number_of_clients_span").html('Petitioner');
                $("#number_of_opponents_span").html('Respondents');
            }
            if(client_role=='Petitioner 1'){
                $("#opponent_role_hidden").val('Petitioner 2');
                $("#opponent_role").find('option:selected').attr("selected", false);
                $('#opponent_role option[value="Petitioner 2"]').attr("selected","selected");
                $("#number_of_clients_span").html('Petitioner 1');
                $("#number_of_opponents_span").html('Petitioner 2');
            }
        });

        // on original client role change
        $('#original_client_role').on('change', function() {
            var original_client_role=this.value;
            if(original_client_role==''){
                $("#original_opponent_role_hidden").val('');
                $("#original_opponent_role").val('');
                $("#original_number_of_clients_span").html('Clients');
                $("#original_number_of_opponents_span").html('Opponents');
            }
            if(original_client_role=='Plaintiff'){
                $("#original_opponent_role_hidden").val('Defendant');
                $("#original_opponent_role").val('Defendant');
                $("#original_number_of_clients_span").html('Plaintiff');
                $("#original_number_of_opponents_span").html('Defendants');
            }
            if(original_client_role=='Petitioner'){
                $("#original_opponent_role_hidden").val('Respondent');
                $("#original_opponent_role").val('Respondent');
                $("#original_number_of_clients_span").html('Petitioner');
                $("#original_number_of_opponents_span").html('Respondents');
            }
            if(original_client_role=='Petitioner 1'){
                $("#original_opponent_role_hidden").val('Petitioner 2');
                $("#original_opponent_role").val('Petitioner 2');
                $("#original_number_of_clients_span").html('Petitioner 1');
                $("#original_number_of_opponents_span").html('Petitioner 2');
            }
        });
    
    // on original state change
    $('#original_case_state').on('change', function() {
        var case_state=$('#original_case_state').val();
        $('#original_case_court, #original_case_county, #original_case_division, #original_case_judge, #original_case_magistrate').find('option:not(:first)').remove();
        $('#original_judge_fullname, #original_magistrate_fullname').prop('required', false);
        $('.original_case_judge_magistrate_name_inputs_div').hide();

        var id=this.value;
        var token= $('input[name=_token]').val();
        if(id) {
            $.ajax({
                url:"{{route('ajax_get_counties_by_state')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    id: id, 
                    _token: token, 
                },
                success: function(data){ 
                    if(data==null || data=='null'){
                    } else {
                        $.each(data, function (key, val) {
                            $('#original_case_county').append('<option value='+key+'>'+val+'</option>');
                        });
                    }
                } 
            });
        }
    });

    // on original case county change
    $('#original_case_county').on('change', function() {
        $('#original_case_court, #original_case_division, #original_case_judge, #original_case_magistrate').find('option:not(:first)').remove();
        $('#original_judge_fullname, #original_magistrate_fullname').prop('required', false);
        $('.original_case_judge_magistrate_name_inputs_div').hide();

        var county_id=this.value;
        var state_id=$('#original_case_state').val();
        var token= $('input[name=_token]').val();

        if(county_id) {
            $.ajax({
                url:"{{route('ajax_get_court_by_county_state')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    county_id: county_id, 
                    state_id: state_id, 
                    _token: token, 
                },
                success: function(data){
                    // console.log(data);
                    if(data==null || data=='null'){
                        $('.no-courts-original').show();
                    } else {
                        $('.no-courts-original').hide();
                        $.each(data, function (key, val) {
                            $('#original_case_court').append('<option value='+key+'>'+val+'</option>');
                        });
                    }
                }
            });
        }
    });

    // on original case court change
    $('#original_case_court').on('change', function() {
        $('#original_case_division, #original_case_judge, #original_case_magistrate').find('option:not(:first)').remove();
        $('#original_judge_fullname, #original_magistrate_fullname').prop('required', false);
        $('.original_case_judge_magistrate_name_inputs_div').hide();

        var court_id=this.value;
        var token= $('input[name=_token]').val();

        if(court_id) {
            $.ajax({
                url:"{{route('ajax_get_division_by_court')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    court_id: court_id, 
                    _token: token, 
                },
                success: function(data){
                    // console.log(data);
                    if(data==null || data=='null'){
                    } else {
                        $.each(data, function (key, val) {
                            $('#original_case_division').append('<option value='+key+'>'+val+'</option>');
                        });
                    }
                }
            });
        }
    });

    // on original case division change
    $('#original_case_division').on('change', function() {
        $('#original_case_judge, #original_case_magistrate').find('option:not(:first)').remove();
        $('#original_judge_fullname, #original_magistrate_fullname').prop('required', false);
        $('.original_case_judge_magistrate_name_inputs_div').hide();

        var division_id=this.value;
        var court_id=$('#original_case_court').val();
        var token= $('input[name=_token]').val();

        if(division_id && court_id) {
            $.ajax({
                url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
                method:"POST",
                dataType: 'json',
                data:{
                    division_id: division_id, 
                    court_id: court_id, 
                    _token: token, 
                },
                success: function(data){
                    // console.log(data);
                    if(data['judges']==null || data['judges']=='null'){
                        $('#original_case_judge').append('<option value="other">Other Judge</option>');
                    } else {
                        $.each(data['judges'], function (key, val) {
                            $('#original_case_judge').append('<option value='+key+'>'+val+'</option>');
                        });
                        $('#original_case_judge').append('<option value="other">Other Judge</option>');
                    }

                    if(data['magistrates']==null || data['magistrates']=='null'){
                        $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    } else {
                        $.each(data['magistrates'], function (key, val) {
                            $('#original_case_magistrate').append('<option value='+key+'>'+val+'</option>');
                        });
                        $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    }
                }
            });
        }
    });

    // on original case judge change
    $('#original_case_judge').on('change', function() {
        var original_case_judge=$(this).val();
        if(original_case_judge=='other'){
          $('#original_judge_fullname').prop('required', true);
          $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
        } else {
            if($('#original_case_magistrate').val() !='other'){
                $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').hide();
            }
            $('#original_judge_fullname').prop('required', false);
            $('.original_judge_fullname_div').hide();
        }
    });

    // on original case magistrate change
    $('#original_case_magistrate').on('change', function() {
        var original_case_magistrate=$(this).val();
        if(original_case_magistrate=='other'){
          $('#original_magistrate_fullname').prop('required', true);
          $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').show();
        } else {
            if($('#original_case_judge').val() !='other'){
                $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').hide();
            }
           $('#original_magistrate_fullname').prop('required', false);
           $('.original_magistrate_fullname_div').hide();
        }
    });

    // case selected data

    // to fecth counties on basis of state
    var state_id=$(".selected_case_state").val();
    var token= $('input[name=_token]').val();
    if(state_id) {
        $.ajax({
            url:"{{route('ajax_get_counties_by_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                id: state_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#case_county').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_case_county=$('.selected_case_county').val();
                    $("#case_county").val(selected_case_county);
                }
            }
        });
    }

    // to fetch courts on basis of counties
    var county_id=$('.selected_case_county').val();
    var state_id=$(".selected_case_state").val();
    var token= $('input[name=_token]').val();
    if(county_id) {
        $.ajax({
            url:"{{route('ajax_get_court_by_county_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                county_id: county_id, 
                state_id: state_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                    $('.no-courts').show();
                } else {
                    $('.no-courts').hide();
                    $.each(data, function (key, val) {
                        $('#case_court').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_case_court=$('.selected_case_court').val();
                    $("#case_court").val(selected_case_court);
                }
            }
        });
    }

    // to fetch division on basis of courts
    var court_id=$('.selected_case_court').val();
    var token= $('input[name=_token]').val();
    if(court_id) {
        $.ajax({
            url:"{{route('ajax_get_division_by_court')}}",
            method:"POST",
            dataType: 'json',
            data:{
                court_id: court_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#case_division').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_case_division=$('.selected_case_division').val();
                    $("#case_division").val(selected_case_division);

                    if( selected_case_division=='7'|| selected_case_division=='8') {
                         $("#jury_demand_div").hide();
                    }
                }
            }
        });
    }

    // to fetch judges and magistrates on basis of division
    var division_id=$('.selected_case_division').val();
    var court_id=$('.selected_case_court').val();
    var token= $('input[name=_token]').val();
    var magistrate_fullname=$('#magistrate_fullname').val();
    var judge_fullname=$('#judge_fullname').val();
    var selected_case_filing_status=$('.selected_case_filing_status').val();
    if(division_id && court_id) {
        $.ajax({
            url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
            method:"POST",
            dataType: 'json',
            data:{
                division_id: division_id, 
                court_id: court_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data['judges']==null || data['judges']=='null'){
                    $('#case_judge').append('<option value="other">Other Judge</option>');
                    var selected_case_judge=$('.selected_case_judge').val();
                    if(selected_case_judge){
                        $("#case_judge").val(selected_case_judge);
                    } 
                    if(judge_fullname) {
                        $("#case_judge").val('other');
                        $('#judge_fullname').prop('required', true);
                        $('.case_judge_magistrate_name_inputs_div, .judge_fullname_div').show();
                    }
                } else {
                    $.each(data['judges'], function (key, val) {
                        $('#case_judge').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#case_judge').append('<option value="other">Other Judge</option>');
                    var selected_case_judge=$('.selected_case_judge').val();
                    if(selected_case_judge){
                        $("#case_judge").val(selected_case_judge);
                    } 
                    if(judge_fullname) {
                        $("#case_judge").val('other');
                        $('#judge_fullname').prop('required', true);
                        $('.case_judge_magistrate_name_inputs_div, .judge_fullname_div').show();
                    }
                }

                if(data['magistrates']==null || data['magistrates']=='null'){
                    $('#case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_case_magistrate=$('.selected_case_magistrate').val();
                    if(selected_case_magistrate){
                        $("#case_magistrate").val(selected_case_magistrate);
                    } 
                    if(magistrate_fullname) {
                        $("#case_magistrate").val('other');
                        $('#magistrate_fullname').prop('required', true);
                        $('.case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                    }
                } else {
                    $.each(data['magistrates'], function (key, val) {
                        $('#case_magistrate').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_case_magistrate=$('.selected_case_magistrate').val();
                    if(selected_case_magistrate){
                        $("#case_magistrate").val(selected_case_magistrate);
                    } 
                    if(magistrate_fullname) {
                        $("#case_magistrate").val('other');
                        $('#magistrate_fullname').prop('required', true);
                        $('.case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                    }
                }

                if(data['case_types']==null || data['case_types']=='null'){
                    $('.case-types-div').remove();
                    $('.no-case-types').show();
                } else {
                    $('.case-types-div').empty();
                    $('.case-types-div').append('<label class="col-md-12 col-form-label text-md-left">Case Type(s)*</label>');
                    $.each(data['case_types'], function (key, val) {
                        $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_types[]" value="'+key+'"><label for="case_type_'+key+'" class="col-form-label text-md-left">'+val+'</label></div>');
                    });
                    $('.no-case-types').hide();
                    $('.case-types-div').show();

                    var selected_case_types=$('.selected_case-types').val();
                    var case_has_9='';
                    if(selected_case_types) {
                        var array = selected_case_types.split(',');
                        $('.case-type-input-div input').removeAttr('checked');
                        $.each(array, function (key, val) {
                            $('#case_type_'+val+'').attr('checked','checked');
                        });
                    }
                    var case_has_9 = array.includes("9");
                    $.each($(".case-type-input-div input:checked"), function(){            
                      casefil =($(this).val());
                    });
                    $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");

                    var case_type=casefil;
                    var case_state=$('#case_state').val();
                    var case_division=$('#case_division').val();
                    var case_county=$('#case_county').val();
                    var case_court=$('#case_court').val();
                    if(case_type=='8'){
                        // $('.case_filing_status_inputs').attr('checked', false);
                        $('#prev_filed_post_decree').prop("checked",true).trigger("change");
                        // $('#prev_filed_post_decree').attr('checked', true);
                        $('#case_sets').prop('required', true);
                        $('.case_sets_div').show();
                        $('.case-filing-status-div').hide();
                    } else {
                        // $('.case_filing_status_inputs').attr('checked', false);
                        // $('#to_be_filed_new').trigger("change");
                        $('#to_be_filed_new').prop("checked",true).trigger("change");
                        // $('#to_be_filed_new').attr('checked', true);
                        $('#case_sets').prop('required', false);
                        $('.case_sets_div').hide();
                        $('.case-filing-status-div').show();
                    }
                    if(case_has_9==true  && $('#case_type_9').is(":checked")){
                        // $('.case_filing_status_inputs').attr('checked', false);
                        $('.prev_filed_post_decree_div').hide();
                        // $('#to_be_filed_new').prop("checked",true).trigger("change");
                        $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                        // $('#prev_filed_post_decree').attr('checked', true);
                        $('#case_sets').prop('required', true);
                        $('.case_sets_div').show();
                    } else {
                        if($("#case_type_9").prop("checked") == true){
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                            $('.prev_filed_post_decree_div').hide();
                        } else {
                            $('.prev_filed_post_decree_div').show();
                            $('#case_sets').prop('required', false);
                            $('.case_sets_div').hide();
                        }
                    }
                    if(case_type=='8' && $('#case_type_8').is(":checked")){
                        $('#case_sets').prop('required', true);
                        $('.case_sets_div').show();
                    }
                    if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                    {
                        $('.original_court_case_number_div').hide();
                    }
                    if(case_type !='8' && case_type !='9' && case_has_9==false){
                        $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                        var case_sets=$('#case_sets').val();
                        if(case_sets){
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                        } else {
                            $('#case_sets').prop('required', false);
                            $('.case_sets_div').hide();
                        }
                    }


                    // case type change function
                    $('.case-types-div input[type="checkbox"]').on('change', function() {
                        var case_type=$(this).val();
                        // when OHIO+Domestic Relations only select one checkbox
                        var case_state=$('#case_state').val();
                        var case_division=$('#case_division').val();
                        var case_county=$('#case_county').val();
                        var case_court=$('#case_court').val();
                        if(case_state=='35' && case_division=='8') {
                           $('.case-types-div input[type="checkbox"]').prop('checked', false);
                           this.checked = true;
                        }
                        if(case_type=='8'){
                            // $('.case_filing_status_inputs').attr('checked', false);
                            $('#prev_filed_post_decree').prop("checked",true).trigger("change");
                            // $('#prev_filed_post_decree').attr('checked', true);
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                            $('.case-filing-status-div').hide();
                        } else {
                            // $('.case_filing_status_inputs').attr('checked', false);
                            // $('#to_be_filed_new').trigger("change");
                            $('#to_be_filed_new').prop("checked",true).trigger("change");
                            // $('#to_be_filed_new').attr('checked', true);
                            $('#case_sets').prop('required', false);
                            $('.case_sets_div').hide();
                            $('.case-filing-status-div').show();
                        }
                        if(case_type=='9'  && this.checked == true){
                            // $('.case_filing_status_inputs').attr('checked', false);
                            $('.prev_filed_post_decree_div').hide();
                            $('#to_be_filed_new').prop("checked",true).trigger("change");
                            // $('#prev_filed_post_decree').attr('checked', true);
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                        } else {
                            if($("#case_type_9").prop("checked") == true){
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                                $('.prev_filed_post_decree_div').hide();
                            } else {
                                $('.prev_filed_post_decree_div').show();
                                $('#case_sets').prop('required', false);
                                $('.case_sets_div').hide();
                            }
                        }
                        if(case_type=='8' && this.checked == true){
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                        }
                        if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                        {
                            $('.original_court_case_number_div').hide();
                        }
                    });
                }
            }
        });
    }

    var case_sets=$('#case_sets').val();
    if(case_sets){
        $('#case_sets').prop('required', true);
        $('.case_sets_div').show();
    } else {
        $('#case_sets').prop('required', false);
        $('.case_sets_div').hide();
    }

    // fetch client role
    var selected_client_role=$('.selected_client_role').val();
    var selected_opponent_role=$('.selected_opponent_role').val();
    if(selected_client_role){
        $("#opponent_role_hidden").val(selected_opponent_role);
        $("#client_role").find('option:selected').attr("selected", false);
        $('#client_role option[value="'+selected_client_role+'"]').attr("selected","selected");
        $("#opponent_role").find('option:selected').attr("selected", false);
        $('#opponent_role option[value="'+selected_opponent_role+'"]').attr("selected","selected");
        $("#number_of_clients_span").html(selected_client_role);
        $("#number_of_opponents_span").html(selected_opponent_role);
    }

    // fetch client role
    var original_selected_client_role=$('.selected_original_client_role').val();
    var original_selected_opponent_role=$('.selected_original_opponent_role').val();
    if(original_selected_client_role){
        $("#original_opponent_role_hidden").val(original_selected_opponent_role);
        $("#original_client_role").find('option:selected').attr("selected", false);
        $('#original_client_role option[value="'+original_selected_client_role+'"]').attr("selected","selected");
        $("#original_opponent_role").find('option:selected').attr("selected", false);
        $('#original_opponent_role option[value="'+original_selected_opponent_role+'"]').attr("selected","selected");
        $("#original_number_of_clients_span").html(original_selected_client_role);
        $("#original_number_of_opponents_span").html(original_selected_opponent_role);
    }

    // to fetch original case counties
    var original_state_id=$('.selected_original_case_state').val();
    var token= $('input[name=_token]').val();
    if(original_state_id) {
        $.ajax({
            url:"{{route('ajax_get_counties_by_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                id: original_state_id, 
                _token: token, 
            },
            success: function(data){ 
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#original_case_county').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_original_case_county=$('.selected_original_case_county').val();
                    $("#original_case_county").val(selected_original_case_county);
                }
            } 
        });
    }

    // to fetch original courts on basis of original counties
    var original_county_id=$('.selected_original_case_county').val();
    var original_state_id=$(".selected_original_case_state").val();
    var token= $('input[name=_token]').val();
    if(original_county_id) {
        $.ajax({
            url:"{{route('ajax_get_court_by_county_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                county_id: original_county_id, 
                state_id: original_state_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                    $('.no-courts-original').show();
                } else {
                    $('.no-courts-original').hide();
                    $.each(data, function (key, val) {
                        $('#original_case_court').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_original_case_court=$('.selected_original_case_court').val();
                    $("#original_case_court").val(selected_original_case_court);
                }
            }
        });
    }

    // to fetch original division on basis of original courts
    var original_court_id=$('.selected_original_case_court').val();
    var token= $('input[name=_token]').val();
    if(original_court_id) {
        $.ajax({
            url:"{{route('ajax_get_division_by_court')}}",
            method:"POST",
            dataType: 'json',
            data:{
                court_id: original_court_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#original_case_division').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_original_case_division=$('.selected_original_case_division').val();
                    $("#original_case_division").val(selected_original_case_division);
                }
            }
        });
    }

    // to fetch judges and magistrates on basis of division
    var original_division_id=$('.selected_original_case_division').val();
    var original_court_id=$('.selected_original_case_court').val();
    var token= $('input[name=_token]').val();
    var original_magistrate_fullname=$('#original_magistrate_fullname').val();
    var original_judge_fullname=$('#original_judge_fullname').val();
    if(original_division_id && original_court_id) {
        $.ajax({
            url:"{{route('ajax_get_judge_magistrate_casetype_by_court_div')}}",
            method:"POST",
            dataType: 'json',
            data:{
                division_id: original_division_id, 
                court_id: original_court_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data['judges']==null || data['judges']=='null'){
                    $('#original_case_judge').append('<option value="other">Other Judge</option>');
                    var selected_original_case_judge=$('.selected_original_case_judge').val();
                    if(selected_original_case_judge){
                        $("#original_case_judge").val(selected_original_case_judge);
                    } 
                    if(original_judge_fullname) {
                        $("#original_case_judge").val('other');
                        $('#original_judge_fullname').prop('required', true);
                        $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                    }
                } else {
                    $.each(data['judges'], function (key, val) {
                        $('#original_case_judge').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#original_case_judge').append('<option value="other">Other Judge</option>');
                    var selected_original_case_judge=$('.selected_original_case_judge').val();
                    if(selected_original_case_judge){
                        $("#original_case_judge").val(selected_original_case_judge);
                    } 
                    if(original_judge_fullname) {
                        $("#original_case_judge").val('other');
                        $('#original_judge_fullname').prop('required', true);
                        $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                    }
                }

                if(data['magistrates']==null || data['magistrates']=='null'){
                    $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_original_case_magistrate=$('.selected_original_case_magistrate').val();
                    if(selected_original_case_magistrate){
                        $("#original_case_magistrate").val(selected_original_case_magistrate);
                    } 
                    if(original_magistrate_fullname) {
                        $("#original_case_magistrate").val('other');
                        $('#original_magistrate_fullname').prop('required', true);
                        $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').show();
                    }
                } else {
                    $.each(data['magistrates'], function (key, val) {
                        $('#original_case_magistrate').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_original_case_magistrate=$('.selected_original_case_magistrate').val();
                    if(selected_original_case_magistrate){
                        $("#original_case_magistrate").val(selected_original_case_magistrate);
                    } 
                    if(original_magistrate_fullname) {
                        $("#original_case_magistrate").val('other');
                        $('#original_magistrate_fullname').prop('required', true);
                        $('.original_case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                    }
                }
            }
        });
    }

    // selected initial service types
    var selected_initial_service_types=$('.selected_initial_service_types').val();
    if(selected_initial_service_types) {
        var array = selected_initial_service_types.split(',');
        $('input[name="initial_service_types"]').removeAttr('checked');
        $.each(array, function (key, val) {
            $('#'+val+'').attr('checked','checked');
        });
    }
    
});
</script>    
@endsection