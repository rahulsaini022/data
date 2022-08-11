@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center case-registration-steps">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Case Registration') }}</strong>
                    <div class="pull-right">
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

                      @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    
                    <form role="form" id="multistep_case_form" method="POST" action="{{route('cases.store_case')}}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="prospect_id" value="<?php if(isset($prospect_id) && $prospect_id !=''){ echo $prospect_id; } ?>" readonly="">
                        <div class="row setup-content form-group" id="step-1">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="case_state" class="col-md-4 col-form-label text-md-left">State : Ohio</label>
                                    <div class="col-md-8">
                                       
                                        <select id="case_state" name="case_state" class="form-control case_state_inputs" autofocus="" required="" style="display: none;" >                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_county" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
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
                                        <select id="case_court" name="case_court" class="form-control case_court_inputs" autofocus="" required="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_division" class="col-md-4 col-form-label text-md-left">Division*</label>
                                    <div class="col-md-8">
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
                                        <select id="case_judge" name="case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="case_magistrate" class="col-md-4 col-form-label text-md-left">Magistrate</label>
                                    <div class="col-md-8">
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
                                        <input id="judge_fullname" type="text" class="form-control case_judge_name_inputs" name="judge_fullname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 judge_fullname_div" style="display: none;">
                                    <label for="judge_title" class="col-md-4 col-form-label text-md-left">Judge Title</label>
                                    <div class="col-md-8">
                                        <input id="judge_title" type="text" class="form-control case_judge_name_inputs" name="judge_title" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <label for="magistrate_fullname" class="col-md-4 col-form-label text-md-left">Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_fullname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <label for="magistrate_title" class="col-md-4 col-form-label text-md-left">Magistrate Title</label>
                                    <div class="col-md-8">
                                        <input id="magistrate_title" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_title" value="" autofocus="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clerk_name" class="col-md-4 col-form-label text-md-left">Clerk</label>
                                    <div class="col-md-8">
                                        <select id="clerk_name" name="clerk_name" class="form-control clerk_name_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="clerk_title" class="col-md-4 col-form-label text-md-left">Clerk Title</label>
                                    <div class="col-md-8">
                                        <select id="clerk_title" name="clerk_title" class="form-control clerk_title_inputs court_correlation_table_select_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 clerk_name_clerktitle_inputs_div court_correlation_table_inputs_div" style="display: none;">
                                <div class="col-md-6 clerk_fullname_div" style="display: none;">
                                    <label for="clerk_fullname" class="col-md-4 col-form-label text-md-left">Clerk Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="clerk_fullname" type="text" class="form-control clerk_fullname_inputs court_correlation_table_inputs" name="clerk_fullname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 other_clerktitle_div" style="display: none;">
                                    <label for="other_clerktitle" class="col-md-4 col-form-label text-md-left">Clerk Title*</label>
                                    <div class="col-md-8">
                                        <input id="other_clerktitle" type="text" class="form-control other_clerktitle_inputs court_correlation_table_inputs" name="other_clerktitle" value="" autofocus="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="filing_location_street_ad" class="col-md-4 col-form-label text-md-left">Filing Location (Address 1)</label>
                                    <div class="col-md-8">
                                        <select id="filing_location_street_ad" name="filing_location_street_ad" class="form-control filing_location_street_ad_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Choose Address 1</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="filing_location_address_too" class="col-md-4 col-form-label text-md-left">Filing Location (Address 2)</label>
                                    <div class="col-md-8">
                                        <select id="filing_location_address_too" name="filing_location_address_too" class="form-control filing_location_address_too_inputs court_correlation_table_select_inputs" autofocus="">
                                            <option value="">Choose Address 2</option>
                                        </select>    
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="filing_location_state" class="col-md-4 col-form-label text-md-left">Filing Location (State*)</label>
                                    <div class="col-md-8">
                                        <select id="filing_location_state" name="filing_location_state" class="form-control filing_location_state_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="filing_location_city" class="col-md-4 col-form-label text-md-left">Filing Location (City*)</label>
                                    <div class="col-md-8">
                                        <select id="filing_location_city" name="filing_location_city" class="form-control filing_location_city_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="filing_location_zip" class="col-md-4 col-form-label text-md-left">Filing Location (Zip*)</label>
                                    <div class="col-md-8">
                                        <select id="filing_location_zip" name="filing_location_zip" class="form-control filing_location_zip_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Zip</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="col-md-4 col-form-label text-md-left">Email</label>
                                    <div class="col-md-8">
                                        <select id="email" name="email" class="form-control email_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Email</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="phone" class="col-md-4 col-form-label text-md-left">Phone</label>
                                    <div class="col-md-8">
                                        <select id="phone" name="phone" class="form-control phone_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Phone</option>
                                        </select>
                                        <!-- <input id="phone" type="text" class="form-control phone_inputs court_correlation_table_inputs" name="phone" value=""> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="fax" class="col-md-4 col-form-label text-md-left">Fax</label>
                                    <div class="col-md-8">
                                        <select id="fax" name="fax" class="form-control fax_inputs court_correlation_table_select_inputs">
                                            <option value="">Choose Fax</option>
                                        </select>
                                        <!-- <input id="fax" type="text" class="form-control fax_inputs court_correlation_table_inputs" name="fax" value=""> -->
                                    </div>
                                </div>
                            </div>
                            
                           <!--  <p class="text-danger no-case-types" style="display: none;">No Case Type(s) found for this division.</p> -->
                           <p class="text-danger no-case-types" style="display: none;">No Case Action(s) found for this division.</p>

                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="col-md-12 case-types-div" style="display:none;">
                                    </div>
                                </div>
                            </div>
                              

                            <div class="col-md-12 case_type_other_div_main" style="display: none;">
                                <div class="col-md-6">
                                    <label for="other_case_type" class="col-md-4 col-form-label text-md-left">Enter Case Type*</label>
                                    <div class="col-md-8">
                                        <input id="other_case_type" type="text" class="form-control" name="other_case_type" value="">
                                    </div>
                                </div>
                                <div class="col-md-6" style="display: none;">
                                    
                                </div>
                            </div>

                            <div class="col-md-12 case-filing-status-div">
                                <div class="col-md-12">
                                    <label class="col-md-12 col-form-label text-md-left">Case Filing Status*</label>
                                    <div class="col-md-3">
                                        <input type="radio" id="to_be_filed_new" name="case_filing_status" class="case_filing_status_inputs" value="to_be_filed_new" required="" checked="checked">
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
                            </div>

                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="top_party_type" class="col-md-4 col-form-label text-md-left">Top Party Type*</label>
                                    <div class="col-md-8">
                                        <select id="top_party_type" name="top_party_type" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" autofocus="" required="">
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="number_top_party_type" class="col-md-4 col-form-label text-md-left">Number of <span class="number_of_top_party_type_span">Top Parties</span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_top_party_type" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_top_party_type" value="1" required=""  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="bottom_party_type" class="col-md-4 col-form-label text-md-left">Bottom Party Type*</label>
                                    <div class="col-md-8">
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
                                    <label for="number_bottom_party_type" class="col-md-4 col-form-label text-md-left">Number of <span class="number_bottom_party_type_span">Bottom Parties</span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_bottom_party_type" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_bottom_party_type" value="1" required=""  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>

                            <!-- following inputs are added for third party complaints -->
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="if_there_is_third_party_complaint" class="col-md-4 col-form-label text-md-left">Check if there is a Third-Party Complaint*</label>
                                    <div class="col-md-8">
                                        <input id="if_there_is_third_party_complaint" type="checkbox" class="" name="if_there_is_third_party_complaint" value="Yes">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs number_third_party_complaint_div">
                                <div class="col-md-6">
                                    <label for="number_top_third_parties" class="col-md-4 col-form-label text-md-left">Number of Third Party <span class="number_of_top_party_type_span"></span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_top_third_parties" type="number" class="form-control number_third_party_complaint_inputs" name="number_top_third_parties" value="1" min="1" max="3">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="number_bottom_third_parties" class="col-md-4 col-form-label text-md-left">Number of Third Party <span class="number_bottom_party_type_span"></span>*</label>
                                    <div class="col-md-8">
                                        <input id="number_bottom_third_parties" type="number" class="form-control number_third_party_complaint_inputs" name="number_bottom_third_parties" value="1" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <!-- end of inputs added for third party complaints -->

                            <div class="col-md-12 currently_filed_inputs court_case_number_date_filed_div">
                                <div class="col-md-6 court_case_number_div">
                                    <label for="court_case_number" class="col-md-4 col-form-label text-md-left">Court Case #*</label>
                                    <div class="col-md-8">
                                        <input id="court_case_number" type="text" class="form-control currently_filed_inputs_req prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="court_case_number" autofocus="">
                                    </div>
                                </div>

                                <div class="col-md-6 date_filed_div">
                                    <label for="date_filed" class="col-md-4 col-form-label text-md-left">Date Filed*</label>
                                    <div class="col-md-8">
                                        <input id="date_filed" type="text" class="form-control hasDatepicker currently_filed_inputs_req" name="date_filed" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>

                                <div class="col-md-6 original_court_case_number_div">
                                    <label for="original_court_case_number" class="col-md-4 col-form-label text-md-left">Original Court Case #*</label>
                                    <div class="col-md-8">
                                        <input id="original_court_case_number" type="text" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_court_case_number" autofocus="">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-12 currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="date_served" class="col-md-4 col-form-label text-md-left">Date Served</label>
                                    <div class="col-md-8">
                                        <input id="date_served" type="text" class="form-control hasDatepicker" name="date_served" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="final_hearing_date" class="col-md-4 col-form-label text-md-left">Final Hearing Date</label>
                                    <div class="col-md-8">
                                        <input id="final_hearing_date" type="text" class="form-control hasDatepickerFinal" name="final_hearing_date" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_top_party_type" class="col-md-4 col-form-label text-md-left">Original Top Party Type*</label>
                                    <div class="col-md-8">
                                        <select id="original_top_party_type" name="original_top_party_type" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="" >
                                            <option value="">Choose Role</option>
                                            <option value="Plaintiff">Plaintiff</option>
                                            <option value="Petitioner">Petitioner</option>
                                            <option value="Petitioner 1">Petitioner 1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_number_top_party_type" class="col-md-4 col-form-label text-md-left">Original Number of <span id="original_number_of_top_party_type_span">Top Parties</span>*</label>
                                    <div class="col-md-8">
                                        <input id="original_number_top_party_type" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_top_party_type" value="1"  autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_bottom_party_type" class="col-md-4 col-form-label text-md-left">Original Bottom Party Type*</label>
                                    <div class="col-md-8">
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
                                    <label for="original_number_bottom_party_type" class="col-md-4 col-form-label text-md-left">Original Number of <span id="original_number_of_bottom_party_type_span">Bottom Parties</span>*</label>
                                    <div class="col-md-8">
                                        <input id="original_number_bottom_party_type" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_bottom_party_type" value="1" autofocus="" min="1" max="6">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_case_state" class="col-md-4 col-form-label text-md-left">Original State*</label>
                                    <div class="col-md-8">
                                        <select id="original_case_state" name="original_case_state" class="form-control case_state_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_county" class="col-md-4 col-form-label text-md-left">Original County*</label>
                                    <div class="col-md-8">
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
                                        <select id="original_case_court" name="original_case_court" class="form-control case_court_inputs prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" autofocus="">                                     
                                            <option value="">Choose Court</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_division" class="col-md-4 col-form-label text-md-left">Original Division*</label>
                                    <div class="col-md-8">
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
                                        <select id="original_case_judge" name="original_case_judge" class="form-control case_judge_inputs" autofocus="">                                     
                                            <option value="">Not Assigned Yet</option>
                                        </select>    
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_case_magistrate" class="col-md-4 col-form-label text-md-left">Original Magistrate</label>
                                    <div class="col-md-8">
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
                                        <input id="original_judge_fullname" type="text" class="form-control case_judge_name_inputs" name="original_judge_fullname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 judge_fullname_div original_judge_fullname_div" style="display: none;">
                                    <label for="original_judge_title" class="col-md-4 col-form-label text-md-left">Original Judge Title</label>
                                    <div class="col-md-8">
                                        <input id="original_judge_title" type="text" class="form-control case_judge_name_inputs" name="original_judge_title" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs case_judge_magistrate_name_inputs_div original_case_judge_magistrate_name_inputs_div" style="display: none;">
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <label for="original_magistrate_fullname" class="col-md-4 col-form-label text-md-left">Original Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="original_magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_fullname" value=""  autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <label for="original_magistrate_title" class="col-md-4 col-form-label text-md-left">Original Magistrate Title</label>
                                    <div class="col-md-8">
                                        <input id="original_magistrate_title" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_title" value=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_date_filed" class="col-md-4 col-form-label text-md-left">Original Date Filed</label>
                                    <div class="col-md-8">
                                        <input id="original_date_filed" type="text" class="form-control hasDatepicker" name="original_date_filed" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_date_served" class="col-md-4 col-form-label text-md-left">Original Date Served</label>
                                    <div class="col-md-8">
                                        <input id="original_date_served" type="text" class="form-control hasDatepicker" name="original_date_served" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_final_hearing_date" class="col-md-4 col-form-label text-md-left">Original Final Hearing Date</label>
                                    <div class="col-md-8">
                                        <input id="original_final_hearing_date" type="text" class="form-control hasDatepickerFinal" name="original_final_hearing_date" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="original_journalization_date" class="col-md-4 col-form-label text-md-left">Original Journalization Date</label>
                                    <div class="col-md-8">
                                        <input id="original_journalization_date" type="text" class="form-control hasDatepicker" name="original_journalization_date" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 single-line-radio-div" id="jury_demand_div">
                                    <label class="col-md-4 col-form-label text-md-left">Jury Demand*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="jury_demand_y" class="jury_demand_inputs" name="jury_demand" value="Y" required="" checked="checked">
                                        <label for="jury_demand_y">YES</label>
                                        <input type="radio" id="jury_demand_n" class="jury_demand_inputs" name="jury_demand" value="N">
                                        <label for="jury_demand_n">NO</label>
                                    </div>
                                </div>
                                <div class="col-md-6 case_sets_div" style="display: none;">
                                    <label for="case_sets" class="col-md-4 col-form-label text-md-left">SETS #*</label>
                                    <div class="col-md-8">
                                        <input id="case_sets" type="text" class="form-control" name="case_sets" autofocus="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="col-md-12">
                                    <label class="col-md-12 col-form-label text-md-left">Initial Service Types*</label>
                                    <div class="col-md-3">
                                        <input type="checkbox" id="certified_mail" name="initial_service_types[]" value="certified_mail" required="" checked="">
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
                                        <input type="checkbox" id="sheriff" name="initial_service_types[]" value="sheriff" required="">
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
                            </div>
                            
                            <div class="col-md-12 text-md-center">
                                <button class="btn btn-primary nextBtn" type="submit">Submit</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {

    $('#multistep_case_form').validate({
    });

    $(".hasDatepicker").datepicker({
        startDate: "01/01/1901",
        endDate: '+0d',
    });

    $(".hasDatepickerFinal").datepicker({
        startDate: "01/01/1901",
        // endDate: '+0d',
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
                    // $.each(data, function (key, val) {
                    //     $('.case_state_inputs').append('<option value='+key+'>'+val+'</option>');
                    // });
                    var size = Object.keys(data).length;
                    if(size=='1'){
                        var selected='selected';
                        var state_id=Object.keys(data)[0];
                    } else {
                        var selected='selected';
                        var state_id=Object.keys(data)[0];
                    }
                    $.each(data, function (key, val) {
                        if(key == 35){
                            $('.case_state_inputs').append('<option value='+key+' '+selected+'>'+val+'</option>');
                        }
                        
                    });
                    state_id = 35;
                    // to fecth counties on basis of state
                    // var state_id=$(".selected_case_state").val();
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
                }
            }
        });   

        //hide inputs for case filing status
        $('.currently_filed_inputs, .prev_filed_refiling_inputs, .prev_filed_post_decree_inputs').hide();
        $('.to_be_filed_new_inputs').show();
        $('.number_third_party_complaint_div').hide();

        // check first case filing status option
        $('.case_filing_status_inputs').attr('checked', false);
        $('#to_be_filed_new').prop("checked",true);

        // fetch counties for states
        $('#case_state').on('change', function(){
            $('.case_county_inputs, .case_court_inputs, .case_division_inputs, .case_judge_inputs, .case_magistrate_inputs, .court_correlation_table_select_inputs').find('option:not(:first)').remove();
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_inputs').val('');
            $('.case_judge_name_inputs, .case_magistrate_name_inputs, .court_correlation_table_select_inputs, .court_correlation_table_inputs, #other_case_type').prop('required', false);
            $('.case-types-div').empty();
            $('.case-action-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div,.case-action-div,.no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case-action-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div,.case-action-div,.no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case-action-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div,.case-action-div, .no-case-types, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
            $('.case-action-div').empty();
            $('.case_judge_magistrate_name_inputs_div, .case-types-div,.case-action-div, .no-case-types, .case_sets_div, .case_type_other_div_main, .clerk_name_clerktitle_inputs_div').hide();
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
                            $('.case-action-div').empty();
                            $('.case-action-div').hide();
                            $('.no-case-types').show();
                        } else {
                            $('.case-types-div').empty();
                            /*$('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left">Case Type(s)*</label>');*/

                            $('.case-types-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left">Case Action(s)*</label>');

                            $.each(data['case_types'], function (key, val) {
                               /* $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_types[]" value="'+key+'"><label for="case_type_'+key+'" class="col-form-label text-md-left">'+val+'</label></div>');*/
                               $('.case-types-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+data['coa_id'][key]+'" name="case_action[]" value="'+data['coa_id'][key]+'"><label for="case_type_'+data['coa_id'][key]+'" class="col-form-label text-md-left">'+val+'</label></div>');
                            });
                            $('.no-case-types').hide();
                            $('.case-types-div input[type="checkbox"]:first').prop('required', true);
                            $('.case-types-div').show();
                            $('.case-action-div').hide();
                        }

                        // case type change function
                        $('.case-types-div input[type="checkbox"]').on('change', function() {
                            var case_type=$(this).val();
                            //alert(case_type);

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
                            //if(case_division == 5){
                               /*$.ajax({
                                    url:"{{route('ajax_get_cause_of_action')}}",
                                    method:"POST",
                                    dataType: 'json',
                                    data:{
                                        option_id: case_type, 
                                        _token: token,
                                        devision_id: case_division
                                    },
                                    success: function(data){

                                       if(data==null || data=='null'){

                                            $('.case-action-div').empty();
                                            $('.no-aution-types').show();
                                        } else {
                                            console.log("hello");
                                            $('.case-action-div').empty();
                                            $('.case-action-div').append('<label class="col-md-12 case-type-main-label col-form-label text-md-left">Case Aution(s)*</label>');
                                            $.each(data, function (key, val) {
                                                $('.case-action-div').append('<div class="case-type-input-div"><input type="checkbox" id="case_type_'+key+'" name="case_action[]" value="'+val.coa_id+'"><label for="case_aution_'+key+'" class="col-form-label text-md-left">'+val.coa+'</label></div>');
                                            });
                                            $('.no-aution-types').hide();
                                            $('.case-aution-div input[type="checkbox"]:first').prop('required', true);
                                            $('.case-types-div').show();
                                            $('.case-action-div').show(); 
                                        }
                                }
                             });   */
                           // }
                            if(case_type=='8'){
                                // $('.case_filing_status_inputs').attr('checked', false);
                                $('#prev_filed_post_decree').prop("checked",true).trigger("change");
                                // $('#prev_filed_post_decree').attr('checked', true);
                                $('#case_sets').prop('required', true);
                                $('.case_sets_div').show();
                                $('.case-filing-status-div').hide();
                                var case_sets=true;
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
                            }
                            if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8')
                            {
                                $('.original_court_case_number_div').hide();
                            }

                            

                            if(case_sets==false){
                                $('#case_sets').val('');
                            }

                            /*var num_checked = $('input[name="case_types[]"]:checked');
                            console.log('num_checked', num_checked.length);
                            if(num_checked && num_checked.length > 10) {
                               this.checked = false;

                            }*/
                            var num_checked = $('input[name="case_action[]"]:checked');
                            console.log('num_checked', num_checked.length);
                            if(num_checked && num_checked.length > 10) {
                               this.checked = false;

                            }


                            /*if($("#case_type_42").prop("checked") == true && num_checked && num_checked.length <= 10){
                                // alert("Checkbox is checked.");
                                $(".case_type_other_div_main").show();
                                $("#other_case_type").prop('required', true);
                            }

                            else if($("#case_type_42").prop("checked") == false){
                                $(".case_type_other_div_main").hide();
                                $("#other_case_type").prop('required', false);
                                // alert("Checkbox is unchecked.");
                            }
*/
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

            $('#if_there_is_third_party_complaint').prop('checked', false);
            $('.number_third_party_complaint_inputs').prop('required', false);
            $('.number_third_party_complaint_div').hide();

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

    // // to make court case number and original court case number same
    // $('#court_case_number').on('focusout', function() {
    //     var case_type=$('#case-types-div input[type="checkbox"]:checked').val();
    //     var case_state=$('#case_state').val();
    //     var case_division=$('#case_division').val();
    //     var case_county=$('#case_county').val();
    //     var case_court=$('#case_court').val();
    //     alert(case_type);
    //     if(case_state=='35' && case_county=='2049' && case_court=='15' && case_division=='8' && case_type=='8') {
    //       $('#original_court_case_number').val(this.value);
    //       $('.original_court_case_number_div').hide();
    //     }  
    // });
    
});
</script>    
@endsection