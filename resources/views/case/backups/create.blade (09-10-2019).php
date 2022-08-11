@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center case-registration-steps">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Case Registration') }}</strong></div>
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
                    <form role="form" id="multistep_case_form" method="POST" action="{{route('cases.store')}}">
                        @csrf
                        <!--  case registration 1st step -->
                        <div class="row setup-content form-group" id="step-1">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="case_state" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                        <select id="case_state" name="case_state" class="form-control case_state_inputs" autofocus="" required="">                                     
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
                                <div class="col-md-6 magistrate_fullname_div" style="display: none;">
                                    <label for="magistrate_fullname" class="col-md-4 col-form-label text-md-left">Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="magistrate_fullname" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-danger no-case-types" style="display: none;">No Case Type(s) found for this division.</p>
                            <div class="col-md-12 case-types-div" style="display:none;">
                            </div>
                            <div class="col-md-12 case-filing-status-div">
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

                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="client_role" class="col-md-4 col-form-label text-md-left">Client Role*</label>
                                    <div class="col-md-8">
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
                                        <input id="number_of_clients" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_of_clients" value="1" required=""  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 to_be_filed_new_inputs currently_filed_inputs">
                                <div class="col-md-6">
                                    <label for="opponent_role" class="col-md-4 col-form-label text-md-left">Opponent Role*</label>
                                    <div class="col-md-8">
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
                                        <input id="number_of_opponents" type="number" class="form-control to_be_filed_new_inputs_req currently_filed_inputs_req" name="number_of_opponents" value="1" required=""  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
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
                                        <input id="final_hearing_date" type="text" class="form-control hasDatepicker" name="final_hearing_date" autofocus="" placeholder="MM/DD/YYYY">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_client_role" class="col-md-4 col-form-label text-md-left">Original Client Role*</label>
                                    <div class="col-md-8">
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
                                        <input id="original_number_of_clients" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_of_clients" value="1"  autofocus="" min="1" max="3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 prev_filed_refiling_inputs prev_filed_post_decree_inputs">
                                <div class="col-md-6">
                                    <label for="original_opponent_role" class="col-md-4 col-form-label text-md-left">Original Opponent Role*</label>
                                    <div class="col-md-8">
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
                                        <input id="original_number_of_opponents" type="number" class="form-control prev_filed_refiling_inputs_req prev_filed_post_decree_inputs_req" name="original_number_of_opponents" value="1" autofocus="" min="1" max="3">
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
                                <div class="col-md-6 magistrate_fullname_div original_magistrate_fullname_div" style="display: none;">
                                    <label for="original_magistrate_fullname" class="col-md-4 col-form-label text-md-left">Original Magistrate Full Name*</label>
                                    <div class="col-md-8">
                                        <input id="original_magistrate_fullname" type="text" class="form-control case_magistrate_name_inputs" name="original_magistrate_fullname" value=""  autofocus="">
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
                                        <input id="original_final_hearing_date" type="text" class="form-control hasDatepicker" name="original_final_hearing_date" autofocus="" placeholder="MM/DD/YYYY">
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
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Hon.">Hon.</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clfname" class="col-md-4 col-form-label text-md-left">First Name*</label>
                                    <div class="col-md-8">
                                        <input id="clfname" type="text" class="form-control" name="clfname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clmname" class="col-md-4 col-form-label text-md-left">Middle Name</label>
                                    <div class="col-md-8">
                                        <input id="clmname" type="text" class="form-control " name="clmname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cllname" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                                    <div class="col-md-8">
                                        <input id="cllname" type="text" class="form-control" name="cllname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clemail" class="col-md-4 col-form-label text-md-left">Email*</label>
                                    <div class="col-md-8">
                                        <input id="clemail" type="email" class="form-control" name="clemail" value="" autofocus="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="clphone" class="col-md-4 col-form-label text-md-left">Telephone</label>
                                    <div class="col-md-8">
                                        <input id="clphone" type="text" class="form-control has-pattern-one" name="clphone" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clsuffix" class="col-md-4 col-form-label text-md-left">Suffix</label>
                                    <div class="col-md-8">
                                        <select id="clsuffix" name="clsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr.">Sr.</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprefname" class="col-md-4 col-form-label text-md-left">Preferred Name</label>
                                    <div class="col-md-8">
                                        <input id="clprefname" type="text" class="form-control" name="clprefname" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clgen-m" name="clgender" value="M" required="">
                                        <label for="clgen-m">M</label>
                                        <input type="radio" id="clgen-f" name="clgender" value="F">
                                        <label for="clgen-f">F</label>
                                        <input type="radio" id="clgen-n" name="clgender" value="N">
                                        <label for="clgen-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-2" style="float: left;display: inline-block;"></div>

                                <div class="col-md-6">
                                    <label for="clssno" class="col-md-4 col-form-label text-md-left">Social Security Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-two" id="clssno" name="clssno" placeholder="XXX-XX-XXXX" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="cldob" class="col-md-4 col-form-label text-md-left">Date of Birth*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control hasDatepicker" id="cldob" name="cldob" placeholder="MM/DD/YYYY" value="" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clzip" class="col-md-4 col-form-label text-md-left">ZIP*</label>
                                    <div class="col-md-8">
                                    <p class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="clzip" name="clzip" value="" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clstreetad" class="col-md-4 col-form-label text-md-left">Street Address*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="clstreetad" name="clstreetad" value="" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
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
                                        <select id="clstate" name="clstate" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
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
                                        <input type="text" class="form-control has-pattern-one" id="clfax" name="clfax" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprimlang" class="col-md-4 col-form-label text-md-left">Primary Language*</label>
                                    <div class="col-md-8">
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
                                        <input type="radio" id="clreqlangtrans-y" name="clreqlangtrans" value="Y" required="">
                                        <label for="clreqlangtrans-y">Y</label>
                                        <input type="radio" id="clreqlangtrans-n" name="clreqlangtrans" value="N">
                                        <label for="clreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clhearingimpaired-y" name="clhearingimpaired" value="Y" required="">
                                        <label for="clhearingimpaired-y">Y</label>
                                        <input type="radio" id="clhearingimpaired-n" name="clhearingimpaired" value="N">
                                        <label for="clhearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqsignlang-y" name="clreqsignlang" value="Y" required="">
                                        <label for="clreqsignlang-y">Y</label>
                                        <input type="radio" id="clreqsignlang-n" name="clreqsignlang" value="N">
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

                        <div class="row form-group setup-content" id="step-3">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opprefix" class="col-md-4 col-form-label text-md-left">Prefix</label>
                                    <div class="col-md-8">
                                        <select id="opprefix" name="opprefix" class="form-control" autofocus="">
                                            <option value="">Choose Prefix Type</option>
                                            <option value="Mr.">Mr.</option>
                                            <option value="Mrs.">Mrs.</option>
                                            <option value="Ms.">Ms.</option>
                                            <option value="Dr.">Dr.</option>
                                            <option value="Hon.">Hon.</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opfname" class="col-md-4 col-form-label text-md-left">First Name*</label>
                                    <div class="col-md-8">
                                        <input id="opfname" type="text" class="form-control" name="opfname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opmname" class="col-md-4 col-form-label text-md-left">Middle Name</label>
                                    <div class="col-md-8">
                                        <input id="opmname" type="text" class="form-control " name="opmname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="oplname" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                                    <div class="col-md-8">
                                        <input id="oplname" type="text" class="form-control" name="oplname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opemail" class="col-md-4 col-form-label text-md-left">Email*</label>
                                    <div class="col-md-8">
                                        <input id="opemail" type="email" class="form-control" name="opemail" value="" autofocus="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="opphone" class="col-md-4 col-form-label text-md-left">Telephone</label>
                                    <div class="col-md-8">
                                        <input id="opphone" type="text" class="form-control has-pattern-one" name="opphone" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opsuffix" class="col-md-4 col-form-label text-md-left">Suffix</label>
                                    <div class="col-md-8">
                                        <select id="opsuffix" name="opsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr.">Sr.</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opprefname" class="col-md-4 col-form-label text-md-left">Preferred Name</label>
                                    <div class="col-md-8">
                                        <input id="opprefname" type="text" class="form-control" name="opprefname" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="opgen-m" name="opgender" value="M" required="">
                                        <label for="opgen-m">M</label>
                                        <input type="radio" id="opgen-f" name="opgender" value="F">
                                        <label for="opgen-f">F</label>
                                        <input type="radio" id="opgen-n" name="opgender" value="N">
                                        <label for="opgen-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-2" style="float: left;display: inline-block;"></div>

                                <div class="col-md-6">
                                    <label for="opssno" class="col-md-4 col-form-label text-md-left">Social Security Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-two" id="opssno" name="opssno" placeholder="XXX-XX-XXXX" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opdob" class="col-md-4 col-form-label text-md-left">Date of Birth*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control hasDatepicker" id="opdob" name="opdob" placeholder="MM/DD/YYYY" value="" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opzip" class="col-md-4 col-form-label text-md-left">ZIP*</label>
                                    <div class="col-md-8">
                                    <p class="text-danger no-state-county-op" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="opzip" name="opzip" value="" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="opstreetad" class="col-md-4 col-form-label text-md-left">Street Address*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="opstreetad" name="opstreetad" value="" autofocus="" required="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
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
                                        <select id="opstate" name="opstate" class="form-control op-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
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
                                        <input type="text" class="form-control has-pattern-one" id="opfax" name="opfax" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="opprimlang" class="col-md-4 col-form-label text-md-left">Primary Language*</label>
                                    <div class="col-md-8">
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
                                        <input type="radio" id="opreqlangtrans-y" name="opreqlangtrans" value="Y" required="">
                                        <label for="opreqlangtrans-y">Y</label>
                                        <input type="radio" id="opreqlangtrans-n" name="opreqlangtrans" value="N">
                                        <label for="opreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="ophearingimpaired-y" name="ophearingimpaired" value="Y" required="">
                                        <label for="ophearingimpaired-y">Y</label>
                                        <input type="radio" id="ophearingimpaired-n" name="ophearingimpaired" value="N">
                                        <label for="ophearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="opreqsignlang-y" name="opreqsignlang" value="Y" required="">
                                        <label for="opreqsignlang-y">Y</label>
                                        <input type="radio" id="opreqsignlang-n" name="opreqsignlang" value="N">
                                        <label for="opreqsignlang-n">N</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="attorney_reg_3_state_id" class="col-md-12 col-form-label text-md-left">Registration User Terms and Conditions</label>
                                <textarea id="agreement" name="agreement" rows="5" class="form-control" disabled="">Welcome to FirstDraftData.com Providing data services to Lawyers and Legal Professionals.

If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern our relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.

The use of this website is subject to the following terms of use:

The content of the pages of this website and the data services provided are for your general information and use only. It is subject to change without notice.

Use of this website, other than the FDD Quick Child Computation Worksheets, requires client-specific registration and may only be used you clients who are duly register, having paid in full.  You acknowlege use of this website for the benefit of unregistered clients is actionable fraud and sanctionable by the State Bar.

This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties.

Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose.

You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.

Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.

This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.

All trade marks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website.

Members of the Bar who serve as Legal Aid attorneys or who work as official adjudicators can obtain our services at greatly reduced rates, many times free.  In such cases, the Bar member certifies they we use such discounted services, other than the FDD Quick Child Support Computation Worksheets, solely in representing Legal Aid clients or for purposes of official adjudicators.

Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.

From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).

You further agree that any dispute between you and us arising in relationship to the use of this website shall be manditorily exclusively and finally arbitrated by John Lah, Esq. with a hearing and binding decision to be completed in 30 days.  You further agree that any potential recovery by you shall be limited to the registration fee you paid for client(s).

You acknowledge that we do not represent your client(s).  We serve you and you remain ultimately professionally resposible for reviewing and using our data services for your client(s).  As such, your use of our service maintains attorney client privelege.

You agree we cannot verify nor are we in any way responsible to assure the accuracy or veracity of data your client(s) provide nor the resulting data services.  We perform data services for you, not your client(s), and will provide such services only to you, not your client(s).  We will not answer legal questions from your client(s) but may, occassionally and at our discretion, answer technical questions regarding the use of the website.

Finally, all sales are final, and no service is owed where fees are not paid in full.  There is no refund for any reason.
</textarea>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6 terms-checkbox-div">
                                    <label for="agreement_checkbox" class="col-md-6 col-form-label text-md-left">Check box to agree to terms*</label>
                                    <div class="col-md-6">
                                        <input id="agreement_checkbox" type="checkbox" class="" name="agreement_checkbox" required="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                            </div>

                            <div class="col-md-12 text-md-center">
                                <button class="btn btn-primary nextBtn" type="submit">Submit</button>
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