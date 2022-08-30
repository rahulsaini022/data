@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center case-registration-steps">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Case Informations') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('cases.show_party_reg_form',['case_id' => $case_data->id]) }}"> Edit Parties</a>
                        <a class="btn btn-primary" href="{{ route('cases.index') }}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form id="multistep_case_form" method="POST" action="{{route('cases.update_case',['id'=>$case_data->id])}}" autocomplete="off">
                        @csrf
                        @method('put')
                        <!--  case registration 3rd step -->
                        <div class="row form-group">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="case_state" class="col-form-label text-md-left">State </label>
                                          <input type="text" disabled value="Ohio" class="form-control" >
                                         <input type="hidden" name="selected_case_state" class="selected_case_state" value="<?php if(isset($case_data->state_id)){ echo $case_data->state_id; } ?>">
                                        <select id="case_state" name="case_state" class="form-control case_state_inputs" autofocus="" required="" style="display:none;">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="case_county" class="col-form-label text-md-left">County*</label>
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
                                    <div class="col-md-10">
                                          <label for="case_court" class="col-form-label text-md-left">Court*</label>
                                        <input type="hidden" name="selected_case_court" class="selected_case_court" value="<?php if(isset($case_data->court_id)){ echo $case_data->court_id; } ?>">
                                        <select id="case_court" name="case_court" class="form-control case_court_inputs" autofocus="" required="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="case_division" class="col-form-label text-md-left">Division*</label>
                                        <input type="hidden" name="selected_case_division" class="selected_case_division" value="<?php if(isset($case_data->division_id)){ echo $case_data->division_id; } ?>">
                                        <select id="case_division" name="case_division" class="form-control case_division_inputs" autofocus="" required="">                                     
                                            <option value="">Choose Division</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="case_judge" class="col-form-label text-md-left">Judge</label>
                                        <input type="hidden" name="selected_case_judge" class="selected_case_judge" value="<?php if(isset($case_data->judge_id)){ echo $case_data->judge_id; } ?>">
                                        <select id="case_judge" name="case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="case_magistrate" class="col-form-label text-md-left">Magistrate</label>
                                        <input type="hidden" name="selected_case_magistrate" class="selected_case_magistrate" value="<?php if(isset($case_data->magistrate_id)){ echo $case_data->magistrate_id; } ?>">
                                        <select id="case_magistrate" name="case_magistrate" class="form-control case_magistrate_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 judge_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="judge_fullname" class="col-form-label text-md-left">Judge Full Name*</label>
                                        <input id="judge_fullname" type="text" class="form-control case_judge_name_inputs" name="judge_fullname" value="<?php if(isset($case_data->judge_fullname)){ echo $case_data->judge_fullname; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 judge_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="judge_title" class="col-form-label text-md-left">Judge Title</label>
                                        <input id="judge_title" type="text" class="form-control case_judge_name_inputs" name="judge_title" value="<?php if(isset($case_data->judge_title)){ echo $case_data->judge_title; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                           <label for="magistrate_fullname" class="col-form-label text-md-left">Magistrate Full Name*</label>
                                        <input id="magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_fullname" value="<?php if(isset($case_data->magistrate_fullname)){ echo $case_data->magistrate_fullname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                          <label for="magistrate_title" class="col-form-label text-md-left">Magistrate Title</label>
                                        <input id="magistrate_title" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_title" value="<?php if(isset($case_data->magistrate_title)){ echo $case_data->magistrate_title; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                            <label for="clerk_name" class="col-form-label text-md-left">Clerk</label>
                                        <input type="hidden" name="selected_clerk_name" class="selected_clerk_name" value="<?php if(isset($case_data->clerk_name)){ echo $case_data->clerk_name; } ?>">
                                        <select id="clerk_name" name="clerk_name" class="form-control clerk_name_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="clerk_title" class="col-form-label text-md-left">Clerk Title</label>
                                        <input type="hidden" name="selected_clerk_title" class="selected_clerk_title" value="<?php if(isset($case_data->clerk_title)){ echo $case_data->clerk_title; } ?>">
                                        <select id="clerk_title" name="clerk_title" class="form-control clerk_title_inputs court_correlation_table_select_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 clerk_name_clerktitle_inputs_div court_correlation_table_inputs_div" style="display: none;">
                                <div class="col-md-6 clerk_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                            <label for="clerk_fullname" class="col-form-label text-md-left">Clerk Full Name*</label>
                                        <input id="clerk_fullname" type="text" class="form-control clerk_fullname_inputs court_correlation_table_inputs" name="clerk_fullname" value="<?php if(isset($case_data->clerk_name)){ echo $case_data->clerk_name; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 other_clerktitle_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="other_clerktitle" class="col-form-label text-md-left">Clerk Title*</label>
                                        <input id="other_clerktitle" type="text" class="form-control other_clerktitle_inputs court_correlation_table_inputs" name="other_clerktitle" value="<?php if(isset($case_data->clerk_title)){ echo $case_data->clerk_title; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="filing_location_street_ad" class="col-form-label text-md-left">Filing Location (Address 1)</label>
                                        <input type="hidden" name="selected_filing_location_street_ad" class="selected_filing_location_street_ad" value="<?php if(isset($case_data->street_ad)){ echo $case_data->street_ad; } ?>">
                                        <select id="filing_location_street_ad" name="filing_location_street_ad" class="form-control filing_location_street_ad_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Choose Address 1</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="filing_location_address_too" class="col-form-label text-md-left">Filing Location (Address 2)</label>
                                        <input type="hidden" name="selected_filing_location_address_too" class="selected_filing_location_address_too" value="<?php if(isset($case_data->address_too)){ echo $case_data->address_too; } ?>">
                                        <select id="filing_location_address_too" name="filing_location_address_too" class="form-control filing_location_address_too_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Choose Address 2</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="filing_location_state" class="col-form-label text-md-left">Filing Location (State*)</label>
                                        <input type="hidden" name="selected_filing_location_state" class="selected_filing_location_state" value="<?php if(isset($case_data->courtcase_state_name)){ echo $case_data->courtcase_state_name; } ?>">
                                        <select id="filing_location_state" name="filing_location_state" class="form-control filing_location_state_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="filing_location_city" class="col-form-label text-md-left">Filing Location (City*)</label>
                                        <input type="hidden" name="selected_filing_location_city" class="selected_filing_location_city" value="<?php if(isset($case_data->city)){ echo $case_data->city; } ?>">
                                        <select id="filing_location_city" name="filing_location_city" class="form-control filing_location_city_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                 <label for="filing_location_zip" class="col-form-label text-md-left">Filing Location (Zip*)</label>
                                        <input type="hidden" name="selected_filing_location_zip" class="selected_filing_location_zip" value="<?php if(isset($case_data->zip)){ echo $case_data->zip; } ?>">
                                        <select id="filing_location_zip" name="filing_location_zip" class="form-control filing_location_zip_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Zip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="email" class="col-form-label text-md-left">Email</label>
                                        <input type="hidden" name="selected_email" class="selected_email" value="<?php if(isset($case_data->email)){ echo $case_data->email; } ?>">
                                        <select id="email" name="email" class="form-control email_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                        <label for="phone" class="col-form-label text-md-left">Phone</label>
                                        <input type="hidden" name="selected_phone" class="selected_phone" value="<?php if(isset($case_data->phone)){ echo $case_data->phone; } ?>">
                                        <select id="phone" name="phone" class="form-control phone_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Phone</option>
                                        </select>
                                        <!-- <input id="phone" type="text" class="form-control phone_inputs court_correlation_table_inputs" name="phone" value=""> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="fax" class="col-form-label text-md-left">Fax</label>
                                        <input type="hidden" name="selected_fax" class="selected_fax" value="<?php if(isset($case_data->fax)){ echo $case_data->fax; } ?>">
                                        <select id="fax" name="fax" class="form-control fax_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Fax</option>
                                        </select>
                                        <!-- <input id="fax" type="text" class="form-control fax_inputs court_correlation_table_inputs" name="fax" value=""> -->
                                    </div>
                                </div>
                            </div>
                           <!--  <p class="text-danger no-case-types" style="display: none;">No Case Type(s) found for this division.</p>  -->
                           <p class="text-danger no-case-types" style="display: none;">No Case Action(s) found for this division.</p>
                            <input type="hidden" name="selected_case-types" class="selected_case-types" value="<?php if(isset($case_data->coa_ids)){ echo $case_data->coa_ids; } ?>">
                                    <div class="col-md-12 case-types-div" style="display:none;margin:0px 30px; flex: auto;padding-right: 0px;">
                                    </div>
                            <?php if(isset($case_data->other_case_type)){ ?>
                            <div class="col-md-12 case_type_other_div_main">
                            <?php } else { ?>
                            <div class="col-md-12 case_type_other_div_main" style="display: none;">
                                <?php } ?>    
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="other_case_type" class="col-form-label text-md-left">Enter Case Type*</label>
                                        <input id="other_case_type" type="text" class="form-control" name="other_case_type" value="<?php if(isset($case_data->other_case_type)){ echo $case_data->other_case_type; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                </div>
                            </div>
                            <div class="col-md-12 case-filing-status-div">
                                <div class="col-md-12">
                                    <label class="col-md-12 col-form-label text-md-left">Case Filing Status*</label>
                                    <input type="hidden" name="selected_case_filing_status" class="selected_case_filing_status" value="<?php if(isset($case_data->filing_type)){ echo $case_data->filing_type; } ?>">
                                    <div class="col-md-3 display-checkbox">
                                        <input type="radio" id="to_be_filed_new" name="case_filing_status" class="case_filing_status_inputs" value="to_be_filed_new" required="">
                                        <label for="to_be_filed_new" class="col-form-label text-md-left">To Be Filed, New</label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="radio" id="currently_filed" name="case_filing_status" class="case_filing_status_inputs" value="currently_filed">
                                        <label for="currently_filed" class="col-form-label text-md-left">Currently Filed </label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="radio" id="prev_filed_refiling" name="case_filing_status" class="case_filing_status_inputs" value="prev_filed_refiling">
                                        <label for="prev_filed_refiling" class="col-form-label text-md-left"> Previously Filed, Refiling </label>
                                    </div>
                                    <div class="col-md-3 prev_filed_post_decree_div display-checkbox">
                                        <input type="radio" id="prev_filed_post_decree" name="case_filing_status" class="case_filing_status_inputs" value="prev_filed_post_decree">
                                        <label for="prev_filed_post_decree" class="col-form-label text-md-left"> Previously Filed, Post-Decree </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="top_party_type" class="col-form-label text-md-left">Top Party Type*</label>
                                        <input type="hidden" name="selected_client_role" class="selected_client_role" value="<?php if(isset($case_data->top_party_type)){ echo $case_data->top_party_type; } ?>">
                                        <select id="top_party_type" name="top_party_type" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" autofocus="" required="">
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="number_top_party_type" class="col-form-label text-md-left">Number of <span class="number_of_top_party_type_span">Clients</span>*</label>
                                        <input id="number_top_party_type" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_top_party_type" value="<?php if(isset($case_data->number_top_party_type)){ echo $case_data->number_top_party_type; } ?>" required=""  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="bottom_party_type" class="col-form-label text-md-left">Bottom Party Type*</label>
                                        <input type="hidden" name="selected_opponent_role" class="selected_opponent_role" value="<?php if(isset($case_data->bottom_party_type)){ echo $case_data->bottom_party_type; } ?>">
                                        <input type="hidden" name="bottom_party_type" id="bottom_party_type_hidden">
                                        <select id="bottom_party_type" name="opponent_role_select" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" autofocus="" required="" disabled="">
                                            <option value="">Choose Role</option>
                                            <option value="Defendant">Defendant</option>
                                            <option value="Respondent">Respondent</option>
                                            <option value="Petitioner 2">Petitioner 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="number_bottom_party_type" class="col-form-label text-md-left">Number of <span class="number_bottom_party_type_span">Opponents</span>*</label>
                                        <input id="number_bottom_party_type" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_bottom_party_type" value="<?php if(isset($case_data->number_bottom_party_type)){ echo $case_data->number_bottom_party_type; } ?>" required=""  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <!-- following inputs are added for third party complaints -->
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <input type="hidden" name="" id="if_there_is_third_party_complaint_val" value="<?php if(isset($case_data->if_there_is_third_party_complaint)){ echo $case_data->if_there_is_third_party_complaint; } ?>">
                                    <div class="col-md-10 display-checkbox">
                                        <input id="if_there_is_third_party_complaint" type="checkbox" class="" name="if_there_is_third_party_complaint" value="Yes" <?php if(isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint=='Yes'){ echo "checked"; } ?>>
                                     <label for="if_there_is_third_party_complaint" class="col-form-label text-md-left">Check if there is a Third-Party Complaint</label>
                                    </div>
                                </div>
                               <div class="col-md-6 single-line-radio-div" id="jury_demand_div">
                                    <div class="col-md-10 ">
                                         <label class="col-form-label text-md-left">Jury Demand*  &nbsp;</label>
                                      <div class="form-check-inline mt-2">  
                                        <input type="radio" id="jury_demand_y" class="jury_demand_inputs" name="jury_demand" value="Y" required="" <?php if(isset($case_data->jury_demand) && $case_data->jury_demand=='Y'){ echo 'checked'; } ?>>
                                        <label class="mb-0" for="jury_demand_y">YES</label></div>
                                         <div class="form-check-inline mt-2">  
                                        <input type="radio" id="jury_demand_n" class="jury_demand_inputs" name="jury_demand" value="N" <?php if(isset($case_data->jury_demand) && $case_data->jury_demand=='N'){ echo 'checked'; } ?>>
                                        <label class="mb-0" for="jury_demand_n">NO</label>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6 case_sets_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="case_sets" class="col-form-label text-md-left">SETS #*</label>
                                        <input id="case_sets_backup" type="hidden" class="form-control" name="case_sets_backup" value="<?php if(isset($case_data->sets)){ echo $case_data->sets; } ?>">
                                        <input id="case_sets" type="text" class="form-control" name="case_sets" autofocus="" value="<?php if(isset($case_data->sets)){ echo $case_data->sets; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs number_third_party_complaint_div">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="number_top_third_parties" class="col-form-label text-md-left">Number of Third Party <span class="number_of_top_party_type_span"></span>*</label>
                                        <input id="number_top_third_parties" type="number" class="form-control number_third_party_complaint_inputs" name="number_top_third_parties" value="<?php if(isset($case_data->number_top_third_parties)){ echo $case_data->number_top_third_parties; } ?>" min="1" max="3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="number_bottom_third_parties" class="col-form-label text-md-left">Number of Third Party <span class="number_bottom_party_type_span"></span>*</label>
                                        <input id="number_bottom_third_parties" type="number" class="form-control number_third_party_complaint_inputs" name="number_bottom_third_parties" value="<?php if(isset($case_data->number_bottom_third_parties)){ echo $case_data->number_bottom_third_parties; } ?>" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <!-- end of inputs added for third party complaints -->
                            <div class="col-md-12 currently_filed_inputs court_case_number_date_filed_div">
                                <div class="col-md-6 court_case_number_div">
                                    <div class="col-md-10">
                                         <label for="court_case_number" class="col-form-label text-md-left">Court Case #*</label>
                                        <input id="court_case_number" type="text" class="form-control currently_filed_inputs_req prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="court_case_number" autofocus="" value="<?php if(isset($case_data->case_number)){ echo $case_data->case_number; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 date_filed_div">
                                    <div class="col-md-10">
                                          <label for="date_filed" class="col-form-label text-md-left">Date Filed*</label>
                                        <input id="date_filed" type="text" class="form-control hasDatepicker currently_filed_inputs_req" name="date_filed" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->date_filed)){ echo date("m/d/Y", strtotime($case_data->date_filed)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 original_court_case_number_div">
                                    <div class="col-md-10">
                                        <label for="original_court_case_number" class="col-form-label text-md-left">Original Court Case #*</label>
                                        <input id="original_court_case_number" type="text" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_court_case_number" autofocus="" value="<?php if(isset($case_data->original_case_number)){ echo $case_data->original_case_number; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 currently_filed_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="date_served" class="col-form-label text-md-left">Date Served</label>
                                        <input id="date_served" type="text" class="form-control hasDatepicker" name="date_served" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->date_served)){ echo date("m/d/Y", strtotime($case_data->date_served)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="final_hearing_date" class="col-form-label text-md-left">Final Hearing Date</label>
                                        <input id="final_hearing_date" type="text" class="form-control hasDatepickerFinal" name="final_hearing_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->final_hearing_date)){ echo date("m/d/Y", strtotime($case_data->final_hearing_date)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                           <label for="original_top_party_type" class="col-form-label text-md-left">Original Top Party Type*</label>
                                        <input type="hidden" name="selected_original_client_role" class="selected_original_client_role" value="<?php if(isset($case_data->original_top_party_type)){ echo $case_data->original_top_party_type; } ?>">
                                        <select id="original_top_party_type" name="original_top_party_type" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="" >
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                        <label for="original_number_top_party_type" class="col-form-label text-md-left">Original Number of <span id="original_number_of_top_party_type_span">Top Parties</span>*</label>
                                        <input id="original_number_top_party_type" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_top_party_type" value="<?php if(isset($case_data->original_number_top_party_type)){ echo $case_data->original_number_top_party_type; } ?>"  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                        <label for="original_bottom_party_type" class="col-form-label text-md-left">Original Bottom Party Type*</label>
                                        <input type="hidden" name="selected_original_opponent_role" class="selected_original_opponent_role" value="<?php if(isset($case_data->original_bottom_party_type)){ echo $case_data->original_bottom_party_type; } ?>">
                                        <input type="hidden" name="original_bottom_party_type" id="original_bottom_party_type_hidden">
                                        <select id="original_bottom_party_type" name="original_opponent_role_select" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="" disabled="">
                                            <option value="">Choose Role</option>
                                            <option value="Defendant">Defendant</option>
                                            <option value="Respondent">Respondent</option>
                                            <option value="Petitioner 2">Petitioner 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                           <label for="original_number_bottom_party_type" class="col-form-label text-md-left">Original Number of <span id="original_number_of_bottom_party_type_span">Bottom Parties</span>*</label>
                                        <input id="original_number_bottom_party_type" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_bottom_party_type" value="<?php if(isset($case_data->original_number_bottom_party_type)){ echo $case_data->original_number_bottom_party_type; } ?>" autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="original_case_state" class="col-form-label text-md-left">Original State*</label>
                                        <input type="hidden" name="selected_original_case_state" class="selected_original_case_state" value="<?php if(isset($case_data->original_state_id)){ echo $case_data->original_state_id; } ?>">
                                        <select id="original_case_state" name="original_case_state" class="form-control case_state_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                           <label for="original_case_county" class="col-form-label text-md-left">Original County*</label>
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
                                    <div class="col-md-10">
                                         <label for="original_case_court" class="col-form-label text-md-left">Original Court*</label>
                                        <input type="hidden" name="selected_original_case_court" class="selected_original_case_court" value="<?php if(isset($case_data->original_court_id)){ echo $case_data->original_court_id; } ?>">
                                        <select id="original_case_court" name="original_case_court" class="form-control case_court_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="original_case_division" class="col-form-label text-md-left">Original Division*</label>
                                        <input type="hidden" name="selected_original_case_division" class="selected_original_case_division" value="<?php if(isset($case_data->original_division_id)){ echo $case_data->original_division_id; } ?>">
                                        <select id="original_case_division" name="original_case_division" class="form-control case_division_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose Division</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="original_case_judge" class="col-form-label text-md-left">Original Judge</label>
                                        <input type="hidden" name="selected_original_case_judge" class="selected_original_case_judge" value="<?php if(isset($case_data->original_judge_id)){ echo $case_data->original_judge_id; } ?>">
                                        <select id="original_case_judge" name="original_case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                        <label for="original_case_magistrate" class="col-form-label text-md-left">Original Magistrate</label>
                                        <input type="hidden" name="selected_original_case_magistrate" class="selected_original_case_magistrate" value="<?php if(isset($case_data->original_magistrate_id)){ echo $case_data->original_magistrate_id; } ?>">
                                        <select id="original_case_magistrate" name="original_case_magistrate" class="form-control case_magistrate_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs case_judge_magistrate_name_inputs_div original_case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 judge_fullname_div original_judge_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="original_judge_fullname" class="col-form-label text-md-left">Original Judge Full Name*</label>
                                        <input id="original_judge_fullname" type="text" class="form-control case_judge_name_inputs" name="original_judge_fullname" value="<?php if(isset($case_data->original_judge_fullname)){ echo $case_data->original_judge_fullname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 judge_fullname_div original_judge_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="original_judge_title" class="col-form-label text-md-left">Original Judge Title</label>
                                        <input id="original_judge_title" type="text" class="form-control case_judge_name_inputs" name="original_judge_title" value="<?php if(isset($case_data->original_judge_title)){ echo $case_data->original_judge_title; } ?>" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs case_judge_magistrate_name_inputs_div original_case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                          <label for="original_magistrate_fullname" class="col-form-label text-md-left">Original Magistrate Full Name*</label>
                                        <input id="original_magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_fullname" value="<?php if(isset($case_data->original_magistrate_fullname)){ echo $case_data->original_magistrate_fullname; } ?>"  autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <div class="col-md-10">
                                         <label for="original_magistrate_title" class="col-form-label text-md-left">Original Magistrate Title</label>
                                        <input id="original_magistrate_title" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_title" value="<?php if(isset($case_data->original_magistrate_title)){ echo $case_data->original_magistrate_title; } ?>"  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                          <label for="original_date_filed" class="col-form-label text-md-left">Original Date Filed</label>
                                        <input id="original_date_filed" type="text" class="form-control hasDatepicker" name="original_date_filed" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_date_filed)){ echo date("m/d/Y", strtotime($case_data->original_date_filed)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                        <label for="original_date_served" class="col-form-label text-md-left">Original Date Served</label>
                                        <input id="original_date_served" type="text" class="form-control hasDatepicker" name="original_date_served" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_date_served)){ echo date("m/d/Y", strtotime($case_data->original_date_served)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="original_final_hearing_date" class="col-form-label text-md-left">Original Final Hearing Date</label>
                                        <input id="original_final_hearing_date" type="text" class="form-control hasDatepickerFinal" name="original_final_hearing_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_final_hearing_date)){ echo date("m/d/Y", strtotime($case_data->original_final_hearing_date)); } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="original_journalization_date" class="col-form-label text-md-left">Original Journalization Date</label>
                                        <input id="original_journalization_date" type="text" class="form-control hasDatepicker" name="original_journalization_date" autofocus="" placeholder="MM/DD/YYYY" value="<?php if(isset($case_data->original_journalization_date)){ echo date("m/d/Y", strtotime($case_data->original_journalization_date)); } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <label class="col-md-12 col-form-label text-md-left initial_service_types_error ">Initial Service Types*</label>
                                    <input type="hidden" name="selected_initial_service_types" class="selected_initial_service_types" value="<?php if(isset($case_data->initial_service_types)){ echo $case_data->initial_service_types; } ?>">
                                    <div class="col-md-3 display-checkbox">
                                        <input type="checkbox" id="certified_mail" name="initial_service_types[]" value="certified_mail" required="">
                                        <label for="certified_mail" class="col-form-label text-md-left">Certified Mail</label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="checkbox" id="express_mail" name="initial_service_types[]" value="express_mail">
                                        <label for="express_mail" class="col-form-label text-md-left">Express Mail</label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="checkbox" id="personal_server" name="initial_service_types[]" value="personal_server">
                                        <label for="personal_server" class="col-form-label text-md-left"> Personal Server </label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">
                                        <input type="checkbox" id="publication" name="initial_service_types[]" value="publication">
                                        <label for="publication" class="col-form-label text-md-left"> Publication </label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">
                                        <input type="checkbox" id="sheriff" name="initial_service_types[]" value="sheriff">
                                        <label for="sheriff" class="col-form-label text-md-left">Sheriff</label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="checkbox" id="residence_unknown" name="initial_service_types[]" value="residence_unknown">
                                        <label for="residence_unknown" class="col-form-label text-md-left">Residence Unknown </label>
                                    </div>
                                    <div class="col-md-3 display-checkbox">    
                                        <input type="checkbox" id="waiver_of_service" name="initial_service_types[]" value="waiver_of_service">
                                        <label for="waiver_of_service" class="col-form-label text-md-left"> Waiver of Service Attached </label>
                                    </div>
                                 </div>
                            </div>
                            @if (isset($case_data->short_caption))
                                    <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="col-md-10">
                                         <label for="short_caption" class="col-form-label text-md-left">Short Caption*</label>
                                        <input id="short_caption" type="text" disabled class="form-control" name="short_caption" autofocus="" value="<?php if(isset($case_data->short_caption)){ echo $case_data->short_caption; } ?>" required>
                                    </div>
                                </div>
                            </div> 
                            @endif
                            <div class="col-md-12 text-md-center">
                                <input name="case_update" value="Update" class="btn btn-primary nextBtn" type="submit">
                                <a class="btn btn-primary" href="{{ route('cases.show_party_reg_form',['case_id' => $case_data->id]) }}"> Edit Parties</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#multistep_case_form').validate({
      errorPlacement: function(error, element) {
            if (element.attr("name") === "case_action[]") {
                error.appendTo('.case-type-vaidation-error');
            }
            else if (element.attr("name") === "initial_service_types[]") {
                error.appendTo('.initial_service_types_error');
            }
               else {
                error.insertAfter(element);
            }
        }
    });
       /***** following functions are for case registration steps *********/
       $(".hasDatepicker").datepicker({
            startDate: "01/01/1901",
            endDate: '+0d',
        });
       $(".hasDatepickerFinal").datepicker({
            startDate: "01/01/1901",
            // endDate: '+0d',
        });
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
            $('.case_county_inputs, .case_court_inputs, .case_division_inputs, .case_judge_inputs, .case_magistrate_inputs, .court_correlation_table_select_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_select_inputs, .court_correlation_table_inputs, #other_case_type').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case_court_inputs, .case_division_inputs, .case_judge_inputs, .case_magistrate_inputs, .court_correlation_table_select_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_select_inputs, .court_correlation_table_inputs, #other_case_type').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case_division_inputs, .case_judge_inputs, .case_magistrate_inputs, .court_correlation_table_select_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_select_inputs, .court_correlation_table_inputs, #other_case_type').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case_judge_inputs, .case_magistrate_inputs, .court_correlation_table_select_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_select_inputs, .court_correlation_table_inputs, #case_sets, #other_case_type').prop('required', false);
            $('.case-types-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div, .no-case-types, .case_sets_div, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
                            var size = Object.keys(data['judges']).length;
                            if(size=='1'){
                                var selected='selected';
                            } else {
                                var selected='';
                            }
                            $.each(data['judges'], function (key, val) {
                                $('.case_judge_inputs').append('<option value='+key+' '+selected+'>'+val+'</option>');
                            });
                            $('.case_judge_inputs').append('<option value="other">Other Judge</option>');
                        }
                        if(data['magistrates']==null || data['magistrates']=='null'){
                            $('.case_magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        } else {
                            var size = Object.keys(data['magistrates']).length;
                            if(size=='1'){
                                var selected='selected';
                            } else {
                                var selected='';
                            }
                            $.each(data['magistrates'], function (key, val) {
                                $('.case_magistrate_inputs').append('<option value='+key+' '+selected+'>'+val+'</option>');
                            });
                            $('.case_magistrate_inputs').append('<option value="other">Other Magistrate</option>');
                        }
                        if(data['case_types']==null || data['case_types']=='null'){
                            $('.case-types-div').empty();
                            $('.no-case-types').show();
                        } else {
                            $('.case-types-div').empty();
                            /*$('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left">Case Type(s)*</label>');*/
                            $('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left case-type-vaidation-error">Case Action(s)*</label>');
                            $.each(data['case_types'], function (key, val) {
                               /* $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_types[]" value="'+key+'"><label for="case_type_'+key+'" class="col-form-label text-md-left">'+val+'</label></div>'); */
                               $('.case-types-div').append('<div class="case-type-input-div col-xs-12"><input  type="checkbox" id="case_type_'+data['coa_id'][key]+'" class="col-xs-2  case_type_error_input" name="case_action[]" value="'+data['coa_id'][key]+'"><label for="case_type_'+data['coa_id'][key]+'" class="col-form-label text-md-left col-xs-8">'+val+'</label></div>');
                            });
                            $('.no-case-types').hide();
                            $('.case-types-div input[type="checkbox"]:first').prop('required', true);
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
                            $('.prev_filed_post_decree_div').show();
                            var case_sets=false;
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
                                // $('#case_sets').val('');
                                $('.case_sets_div').hide();
                                $('.case-filing-status-div').show();
                            }
                            if($("#case_type_49").prop("checked") == true || $("#case_type_50").prop("checked") == true || $("#case_type_51").prop("checked") == true || $("#case_type_52").prop("checked") == true){
                                // $('.case_filing_status_inputs').attr('checked', false);
                                $('.prev_filed_post_decree_div').hide();
                                $('#to_be_filed_new').prop("checked",true).trigger("change");
                                // $('#prev_filed_post_decree').attr('checked', true);
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                                var case_sets=true;
                            } else if($("#case_type_49").prop("checked") == false && $("#case_type_50").prop("checked") == false && $("#case_type_51").prop("checked") == false && $("#case_type_52").prop("checked") == false){
                                    $('.prev_filed_post_decree_div').show();
                                    $('#case_sets').prop('required', false);
                                    // $('#case_sets').val('');
                                    $('.case_sets_div').hide();
                            }
                            if(case_type=='8' && this.checked == true){
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                                var case_sets=true;
                            }
                            if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                            {
                                $('.original_court_case_number_div').hide();
                            }
                            if(case_sets==false){
                                $('#case_sets').val('');
                            } else {
                                $('#case_sets').val($('#case_sets_backup').val());
                            }
                             var num_checked = $('input[name="case_action[]"]:checked');
                            console.log('num_checked', num_checked.length);
                            if(num_checked && num_checked.length > 10) {
                               this.checked = false;
                            }
                            if($("#case_type_42").prop("checked") == true && num_checked && num_checked.length <= 10){
                                // alert("Checkbox is checked.");
                                $(".case_type_other_div_main").show();
                                $("#other_case_type").prop('required', true);
                            }
                            else if($("#case_type_42").prop("checked") == false){
                                $(".case_type_other_div_main").hide();
                                $("#other_case_type").prop('required', false);
                                // alert("Checkbox is unchecked.");
                            }
                        });
                        // to fetch clerk and other information
                        if(data['clerks']==null || data['clerks']=='null'){
                            $('.clerk_name_inputs').append('<option value="other">Other Clerk</option>');
                            $('.clerk_title_inputs').append('<option value="other">Other Clerk Title</option>');
                        } else {
                            var size = Object.keys(data['clerks']).length;
                            if(size=='1'){
                                var selected='selected';
                            } else {
                                var selected='';
                            }
                            $.each(data['clerks'], function (key, val) {
                                $(".clerk_name_inputs").append("<option value='"+val.clerkname+"' "+selected+">"+val.clerkname+"</option>");
                                $(".clerk_title_inputs").append("<option value='"+val.clerktitle+"' "+selected+">"+val.clerktitle+"</option>");
                            });
                            $(".clerk_name_inputs").append("<option value='other'>Other Clerk</option>");
                            $(".clerk_title_inputs").append("<option value='other'>Other Clerk Title</option>");
                        }
                        if(data['court_correlation_table_data']==null || data['court_correlation_table_data']=='null'){
                        } else {
                            var size = Object.keys(data['court_correlation_table_data']).length;
                            if(size=='1'){
                                var selected='selected';
                            } else {
                                var selected='';
                            }
                            $.each(data['court_correlation_table_data'], function (key, val) {
                                if(val.street_ad !=null && val.street_ad !='null'){
                                    $("#filing_location_street_ad").append("<option value='"+val.street_ad+"' "+selected+">"+val.street_ad+"</option>");
                                }
                                if(val.address_too !=null && val.address_too !="null"){
                                    $("#filing_location_address_too").append("<option value='"+val.address_too+"' "+selected+">"+val.address_too+"</option>");
                                }
                                if(val.state !=null && val.state !="null"){
                                    $("#filing_location_state").append("<option value='"+val.state+"' "+selected+">"+val.state+"</option>");
                                }
                                if(val.city !=null && val.city !="null"){
                                    $("#filing_location_city").append("<option value='"+val.city+"' "+selected+">"+val.city+"</option>");
                                }
                                if(val.zip !=null && val.zip !="null"){
                                    $("#filing_location_zip").append("<option value='"+val.zip+"' "+selected+">"+val.zip+"</option>");
                                }
                                if(val.email !=null && val.email !="null"){
                                    $("#email").append("<option value='"+val.email+"' "+selected+">"+val.email+"</option>");
                                }
                                if(val.phone !=null && val.phone !="null"){
                                    $("#phone").append("<option value='"+val.phone+"' "+selected+">"+val.phone+"</option>");
                                    // $("#phone").val(val.phone);
                                }
                                if(val.fax !=null && val.fax !="null"){
                                    $("#fax").append("<option value='"+val.fax+"' "+selected+">"+val.fax+"</option>");
                                    // $("#fax").val(val.fax);
                                }
                            });
                            // remove duplicates
                            var ids_array=['filing_location_street_ad', 'filing_location_address_too', 'filing_location_state', 'filing_location_city', 'filing_location_zip', 'email', 'phone', 'fax'];
                            $.each(ids_array, function (key, val) { 
                                var a = new Array();
                                $('#'+val+'').children("option").each(function(x){
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i=0;i<a.length-1;i++){
                                        if (b ==a[i]) test =true;
                                    }
                                    if (test) $(this).remove();
                                });
                                if($('#'+val+'').children('option').length=='2'){
                                    $('#'+val+'').val($("#"+val+" option:eq(1)").val());
                                }
                            })
                        }
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
        // on clerk name change
        $('#clerk_name').on('change', function(){
            var clerk_name=$(this).val();
            if(clerk_name=='other'){
              $('#clerk_fullname').prop('required', true);
              $('.clerk_name_clerktitle_inputs_div, .clerk_fullname_div').show();
            } else {
              $('#clerk_fullname').prop('required', false);
              $('.clerk_fullname_div').hide();
            }            
        });
        // on clerk title change
        $('#clerk_title').on('change', function(){
            var clerk_title=$(this).val();
            if(clerk_title=='other'){
              $('#other_clerktitle').prop('required', true);
              $('.clerk_name_clerktitle_inputs_div, .other_clerktitle_div').show();
            } else {
              $('#other_clerktitle').prop('required', false);
              $('.other_clerktitle_div').hide();
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
            if($('#if_there_is_third_party_complaint_val').val()=='Yes'){
            } else {
                $('#if_there_is_third_party_complaint').prop('checked', false);
                $('.number_third_party_complaint_inputs').prop('required', false);
                $('.number_third_party_complaint_div').hide();
            }
        });
        // on top_party_type change
        $('#top_party_type').on('change', function() {
            var top_party_type=this.value;
            if(top_party_type==''){
                $("#bottom_party_type_hidden").val('');
                $("#bottom_party_type").find('option:selected').attr("selected", false);
                $('#bottom_party_type option[value=""]').attr("selected","selected");
                $(".number_of_top_party_type_span").html('Clients');
                $(".number_bottom_party_type_span").html('Opponents');
            }
            if(top_party_type=='Plaintiff'){
                $("#bottom_party_type_hidden").val('Defendant');
                $("#bottom_party_type").find('option:selected').attr("selected", false);
                $('#bottom_party_type option[value="Defendant"]').attr("selected","selected");
                $(".number_of_top_party_type_span").html('Plaintiff');
                $(".number_bottom_party_type_span").html('Defendants');
            }
            if(top_party_type=='Petitioner'){
                $("#bottom_party_type_hidden").val('Respondent');
                $("#bottom_party_type").find('option:selected').attr("selected", false);
                $('#bottom_party_type option[value="Respondent"]').attr("selected","selected");
                $(".number_of_top_party_type_span").html('Petitioner');
                $(".number_bottom_party_type_span").html('Respondents');
            }
            if(top_party_type=='Petitioner 1'){
                $("#bottom_party_type_hidden").val('Petitioner 2');
                $("#bottom_party_type").find('option:selected').attr("selected", false);
                $('#bottom_party_type option[value="Petitioner 2"]').attr("selected","selected");
                $(".number_of_top_party_type_span").html('Petitioner 1');
                $(".number_bottom_party_type_span").html('Petitioner 2');
            }
        });
        // on original top_party_type change
        $('#original_top_party_type').on('change', function() {
            var original_top_party_type=this.value;
            if(original_top_party_type==''){
                $("#original_bottom_party_type_hidden").val('');
                $("#original_bottom_party_type").val('');
                $("#original_number_of_top_party_type_span").html('Clients');
                $("#original_number_of_bottom_party_type_span").html('Opponents');
            }
            if(original_top_party_type=='Plaintiff'){
                $("#original_bottom_party_type_hidden").val('Defendant');
                $("#original_bottom_party_type").val('Defendant');
                $("#original_number_of_top_party_type_span").html('Plaintiff');
                $("#original_number_of_bottom_party_type_span").html('Defendants');
            }
            if(original_top_party_type=='Petitioner'){
                $("#original_bottom_party_type_hidden").val('Respondent');
                $("#original_bottom_party_type").val('Respondent');
                $("#original_number_of_top_party_type_span").html('Petitioner');
                $("#original_number_of_bottom_party_type_span").html('Respondents');
            }
            if(original_top_party_type=='Petitioner 1'){
                $("#original_bottom_party_type_hidden").val('Petitioner 2');
                $("#original_bottom_party_type").val('Petitioner 2');
                $("#original_number_of_top_party_type_span").html('Petitioner 1');
                $("#original_number_of_bottom_party_type_span").html('Petitioner 2');
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
                    } else {
                        if(judge_fullname) {
                            $("#case_judge").val('other');
                            $('#judge_fullname').prop('required', true);
                            $('.case_judge_magistrate_name_inputs_div, .judge_fullname_div').show();
                        }
                    } 
                } else {
                    $.each(data['judges'], function (key, val) {
                        $('#case_judge').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#case_judge').append('<option value="other">Other Judge</option>');
                    var selected_case_judge=$('.selected_case_judge').val();
                    if(selected_case_judge){
                        $("#case_judge").val(selected_case_judge);
                    } else {
                        if(judge_fullname) {
                            $("#case_judge").val('other');
                            $('#judge_fullname').prop('required', true);
                            $('.case_judge_magistrate_name_inputs_div, .judge_fullname_div').show();
                        }
                    }
                }
                if(data['magistrates']==null || data['magistrates']=='null'){
                    $('#case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_case_magistrate=$('.selected_case_magistrate').val();
                    if(selected_case_magistrate){
                        $("#case_magistrate").val(selected_case_magistrate);
                    } else {
                        if(magistrate_fullname) {
                            $("#case_magistrate").val('other');
                            $('#magistrate_fullname').prop('required', true);
                            $('.case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                        }
                    }
                } else {
                    $.each(data['magistrates'], function (key, val) {
                        $('#case_magistrate').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_case_magistrate=$('.selected_case_magistrate').val();
                    if(selected_case_magistrate){
                        $("#case_magistrate").val(selected_case_magistrate);
                    } else {
                        if(magistrate_fullname) {
                            $("#case_magistrate").val('other');
                            $('#magistrate_fullname').prop('required', true);
                            $('.case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                        }
                    }
                }
                if(data['case_types']==null || data['case_types']=='null'){
                    $('.case-types-div').remove();
                    $('.no-case-types').show();
                } else {
                    $('.case-types-div').empty();
                    $('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left case-type-vaidation-error">Case Action(s)* </label>');
                    $.each(data['case_types'], function (key, val) {
                        $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+data['coa_id'][key]+'" class="case_type_error_input" name="case_action[]" value="'+data['coa_id'][key]+'"><label for="case_type_'+data['coa_id'][key]+'" class="col-form-label text-md-left">'+val+'</label></div>');
                    });
                    $('.no-case-types').hide();
                    $('.case-types-div input[type="checkbox"]:first').prop('required', true);
                    $('.case-types-div').show();
                    var selected_case_types=$('.selected_case-types').val();
                    // var case_has_9='';
                    if(selected_case_types) {
                        var array = selected_case_types.split(',');
                        $('.case-type-input-div input').removeAttr('checked');
                        $.each(array, function (key, val) {
                            $('#case_type_'+val+'').attr('checked','checked');
                        });
                    }
                    // var case_has_9 = array.includes("9");
                    $.each($(".case-type-input-div input:checked"), function(){            
                      casefil =($(this).val());
                    });
                    $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                    var case_type=casefil;
                    var case_state=$('#case_state').val();
                    var case_division=$('#case_division').val();
                    var case_county=$('#case_county').val();
                    var case_court=$('#case_court').val();
                    $('.prev_filed_post_decree_div').show();
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
                        // $('#case_sets').val('');
                        $('.case_sets_div').hide();
                        $('.case-filing-status-div').show();
                    }
                    if($("#case_type_49").prop("checked") == true || $("#case_type_50").prop("checked") == true || $("#case_type_51").prop("checked") == true || $("#case_type_52").prop("checked") == true){
                        // $('.case_filing_status_inputs').attr('checked', false);
                        $('.prev_filed_post_decree_div').hide();
                        // $('#to_be_filed_new').prop("checked",true).trigger("change");
                        $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                        // $('#prev_filed_post_decree').attr('checked', true);
                        $('#case_sets').prop('required', true);
                        $('.case_sets_div').show();
                    } else if($("#case_type_49").prop("checked") == false && $("#case_type_50").prop("checked") == false && $("#case_type_51").prop("checked") == false && $("#case_type_52").prop("checked") == false){
                            $('.prev_filed_post_decree_div').show();
                            $('#case_sets').prop('required', false);
                            // $('#case_sets').val('');
                            $('.case_sets_div').hide();
                            $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                    }
                    if(case_type=='8' && $('#case_type_8').is(":checked")){
                        $('#case_sets').prop('required', true);
                        $('.case_sets_div').show();
                    }
                    if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                    {
                        $('.original_court_case_number_div').hide();
                    }
                    if(case_type !='8' && case_type !='49' && case_type !='50'&& case_type !='51' && case_type !='52'){
                        $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                        var case_sets=$('#case_sets').val();
                        if(case_sets){
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                        } else {
                            $('#case_sets').prop('required', false);
                            // $('#case_sets').val('');
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
                        $('.prev_filed_post_decree_div').show();
                        var case_sets=false;
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
                            // $('#case_sets').val('');
                            $('.case_sets_div').hide();
                            $('.case-filing-status-div').show();
                        }
                        if($("#case_type_49").prop("checked") == true || $("#case_type_50").prop("checked") == true || $("#case_type_51").prop("checked") == true || $("#case_type_52").prop("checked") == true){
                            // $('.case_filing_status_inputs').attr('checked', false);
                            $('.prev_filed_post_decree_div').hide();
                            // $('#to_be_filed_new').prop("checked",true).trigger("change");
                            $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                            // $('#prev_filed_post_decree').attr('checked', true);
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                            var case_sets=true;
                        } else if($("#case_type_49").prop("checked") == false && $("#case_type_50").prop("checked") == false && $("#case_type_51").prop("checked") == false && $("#case_type_52").prop("checked") == false){
                                $('.prev_filed_post_decree_div').show();
                                $('#case_sets').prop('required', false);
                                // $('#case_sets').val('');
                                $('.case_sets_div').hide();
                                $('#'+selected_case_filing_status+'').prop("checked",true).trigger("change");
                        }
                        if(case_type=='8' && this.checked == true){
                            $('#case_sets').prop('required', true);
                            $('.case_sets_div').show();
                            var case_sets=true;
                        }
                        if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                        {
                            $('.original_court_case_number_div').hide();
                        }
                        if(case_sets==false){
                            $('#case_sets').val('');
                        } else {
                            $('#case_sets').val($('#case_sets_backup').val());
                        }
                         var num_checked = $('input[name="case_action[]"]:checked');
                            console.log('num_checked', num_checked.length);
                            if(num_checked && num_checked.length > 10) {
                               this.checked = false;
                            }
                             if($("#case_type_42").prop("checked") == true && num_checked && num_checked.length <= 10){
                            // alert("Checkbox is checked.");
                            $(".case_type_other_div_main").show();
                            $("#other_case_type").prop('required', true);
                        }
                        else if($("#case_type_42").prop("checked") == false){
                            $(".case_type_other_div_main").hide();
                            $("#other_case_type").prop('required', false);
                            // alert("Checkbox is unchecked.");
                        }
                    });
                    // following if is used to empty temp if_there_is_third_party_complaint_val input to show third party inputs initially.
                    if($('#if_there_is_third_party_complaint_val').val()=='Yes'){
                        $('#if_there_is_third_party_complaint_val').val('');
                    }
                }
                // to fetch clerk and other information
                if(data['clerks']==null || data['clerks']=='null'){
                    $('.clerk_name_inputs').append('<option value="other">Other Clerk</option>');
                    $('.clerk_title_inputs').append('<option value="other">Other Clerk Title</option>');                    
                } else {
                    var selected_clerk_name=$('.selected_clerk_name').val();
                    var selected_clerk_title=$('.selected_clerk_title').val();
                    var clerk_name_exists=0;
                    var clerk_title_exists=0;
                    $.each(data['clerks'], function (key, val) {
                        if(selected_clerk_name == val.clerkname){
                            var selected1='selected';
                            ++clerk_name_exists;
                        }
                        if(selected_clerk_title == val.clerktitle){
                            var selected2='selected';
                            ++clerk_title_exists;
                        }
                        $(".clerk_name_inputs").append("<option value='"+val.clerkname+"' "+selected1+">"+val.clerkname+"</option>");
                        $(".clerk_title_inputs").append("<option value='"+val.clerktitle+"' "+selected2+">"+val.clerktitle+"</option>");
                    });
                    $(".clerk_name_inputs").append("<option value='other'>Other Clerk</option>");
                    $(".clerk_title_inputs").append("<option value='other'>Other Clerk Title</option>");
                    if(selected_clerk_name && clerk_name_exists === 0 ){
                        $('.clerk_name_inputs option[value="other"]').attr("selected","selected");
                        $('#clerk_fullname').prop('required', true);
                        $('.clerk_name_clerktitle_inputs_div, .clerk_fullname_div').show();
                    }
                    if(selected_clerk_title && clerk_title_exists === 0 ){
                        $('.clerk_title_inputs option[value="other"]').attr("selected","selected");
                        $('#other_clerktitle').prop('required', true);
                        $('.clerk_name_clerktitle_inputs_div, .other_clerktitle_div').show();
                    }
                }
                if(data['court_correlation_table_data']==null || data['court_correlation_table_data']=='null'){
                } else {
                    $.each(data['court_correlation_table_data'], function (key, val) {
                        if(val.street_ad !=null && val.street_ad !='null'){
                            $("#filing_location_street_ad").append("<option value='"+val.street_ad+"'>"+val.street_ad+"</option>");
                        }
                        if(val.address_too !=null && val.address_too !="null"){
                            $("#filing_location_address_too").append("<option value='"+val.address_too+"'>"+val.address_too+"</option>");
                        }
                        if(val.state !=null && val.state !="null"){
                            $("#filing_location_state").append("<option value='"+val.state+"'>"+val.state+"</option>");
                        }
                        if(val.city !=null && val.city !="null"){
                            $("#filing_location_city").append("<option value='"+val.city+"'>"+val.city+"</option>");
                        }
                        if(val.zip !=null && val.zip !="null"){
                            $("#filing_location_zip").append("<option value='"+val.zip+"'>"+val.zip+"</option>");
                        }
                        if(val.email !=null && val.email !="null"){
                            $("#email").append("<option value='"+val.email+"'>"+val.email+"</option>");
                        }
                        if(val.phone !=null && val.phone !="null"){
                            $("#phone").append("<option value='"+val.phone+"'>"+val.phone+"</option>");
                            // $("#phone").val(val.phone);
                        }
                        if(val.fax !=null && val.fax !="null"){
                            $("#fax").append("<option value='"+val.fax+"'>"+val.fax+"</option>");
                            // $("#fax").val(val.fax);
                        }
                    });
                    var selected_filing_location_street_ad=$('.selected_filing_location_street_ad').val();
                    var selected_filing_location_address_too=$('.selected_filing_location_address_too').val();
                    var selected_filing_location_state=$('.selected_filing_location_state').val();
                    var selected_filing_location_city=$('.selected_filing_location_city').val();
                    var selected_filing_location_zip=$('.selected_filing_location_zip').val();
                    var selected_email=$('.selected_email').val();
                    var selected_phone=$('.selected_phone').val();
                    var selected_fax=$('.selected_fax').val();
                    $('#filing_location_street_ad').val(selected_filing_location_street_ad);
                    $('#filing_location_address_too').val(selected_filing_location_address_too);
                    $('#filing_location_state').val(selected_filing_location_state);
                    $('#filing_location_city').val(selected_filing_location_city);
                    $('#filing_location_zip').val(selected_filing_location_zip);
                    $('#email').val(selected_email);
                    $('#phone').val(selected_phone);
                    $('#fax').val(selected_fax);
                    // remove duplicates
                    var ids_array=['filing_location_street_ad', 'filing_location_address_too', 'filing_location_state', 'filing_location_city', 'filing_location_zip', 'email', 'phone', 'fax'];
                    $.each(ids_array, function (key, val) {
                        var a = new Array();
                        $('#'+val+'').children("option").each(function(x){
                            test = false;
                            b = a[x] = $(this).val();
                            for (i=0;i<a.length-1;i++){
                                if (b ==a[i]) test =true;
                            }
                            if (test) $(this).remove();
                        });
                    })
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
        // $('#case_sets').val('');
        $('.case_sets_div').hide();
    }
    // fetch top_party_type
    var selected_client_role=$('.selected_client_role').val();
    var selected_opponent_role=$('.selected_opponent_role').val();
    if(selected_client_role){
        $("#bottom_party_type_hidden").val(selected_opponent_role);
        $("#top_party_type").find('option:selected').attr("selected", false);
        $('#top_party_type option[value="'+selected_client_role+'"]').attr("selected","selected");
        $("#bottom_party_type").find('option:selected').attr("selected", false);
        $('#bottom_party_type option[value="'+selected_opponent_role+'"]').attr("selected","selected");
        $(".number_of_top_party_type_span").html(selected_client_role);
        $(".number_bottom_party_type_span").html(selected_opponent_role);
    }
    // fetch top_party_type
    var original_selected_client_role=$('.selected_original_client_role').val();
    var original_selected_opponent_role=$('.selected_original_opponent_role').val();
    if(original_selected_client_role){
        $("#original_bottom_party_type_hidden").val(original_selected_opponent_role);
        $("#original_top_party_type").find('option:selected').attr("selected", false);
        $('#original_top_party_type option[value="'+original_selected_client_role+'"]').attr("selected","selected");
        $("#original_bottom_party_type").find('option:selected').attr("selected", false);
        $('#original_bottom_party_type option[value="'+original_selected_opponent_role+'"]').attr("selected","selected");
        $("#original_number_of_top_party_type_span").html(original_selected_client_role);
        $("#original_number_of_bottom_party_type_span").html(original_selected_opponent_role);
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
                    } else {
                        if(original_judge_fullname) {
                            $("#original_case_judge").val('other');
                            $('#original_judge_fullname').prop('required', true);
                            $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                        }
                    }
                } else {
                    $.each(data['judges'], function (key, val) {
                        $('#original_case_judge').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#original_case_judge').append('<option value="other">Other Judge</option>');
                    var selected_original_case_judge=$('.selected_original_case_judge').val();
                    if(selected_original_case_judge){
                        $("#original_case_judge").val(selected_original_case_judge);
                    } else {
                        if(original_judge_fullname) {
                            $("#original_case_judge").val('other');
                            $('#original_judge_fullname').prop('required', true);
                            $('.original_case_judge_magistrate_name_inputs_div, .original_judge_fullname_div').show();
                        }
                    }
                }
                if(data['magistrates']==null || data['magistrates']=='null'){
                    $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_original_case_magistrate=$('.selected_original_case_magistrate').val();
                    if(selected_original_case_magistrate){
                        $("#original_case_magistrate").val(selected_original_case_magistrate);
                    } else {
                        if(original_magistrate_fullname) {
                            $("#original_case_magistrate").val('other');
                            $('#original_magistrate_fullname').prop('required', true);
                            $('.original_case_judge_magistrate_name_inputs_div, .original_magistrate_fullname_div').show();
                        }
                    }
                } else {
                    $.each(data['magistrates'], function (key, val) {
                        $('#original_case_magistrate').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#original_case_magistrate').append('<option value="other">Other Magistrate</option>');
                    var selected_original_case_magistrate=$('.selected_original_case_magistrate').val();
                    if(selected_original_case_magistrate){
                        $("#original_case_magistrate").val(selected_original_case_magistrate);
                    } else {
                        if(original_magistrate_fullname) {
                            $("#original_case_magistrate").val('other');
                            $('#original_magistrate_fullname').prop('required', true);
                            $('.original_case_judge_magistrate_name_inputs_div, .magistrate_fullname_div').show();
                        }
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
    // on third party checkbox checked
    $('#if_there_is_third_party_complaint').on('change', function() {
        if(this.checked){
            $('.number_third_party_complaint_div').show();
            $('.number_third_party_complaint_inputs').prop('required', true);
        } else {
            $('.number_third_party_complaint_div').hide();
            $('.number_third_party_complaint_inputs').prop('required', false);
        }
    });
});
</script>
@endsection
