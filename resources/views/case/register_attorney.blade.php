@extends('layouts.app')
@section('content')
    <style type="text/css">
        table.formatHTML5 tr.selected {
            background-color: #e92929 !important;
            color: #fff;
            vertical-align: middle;
            padding: 1.5em;
        }

        table.formatHTML5 tbody tr {
            cursor: pointer;
            /* add gradient */
        }
    </style>
    <div class="container">
        <div class="row justify-content-center attorney-registration">
            <div class="col-md-12">
                <div class="card">
                    <?php
                    $t = 1;
                    $user_party_group = $case_party_user->user_party_group;
                    $party_number = $case_party_user->party_number;
                    $customer_attorney_info = Auth::user()->attorney;
                    ?>
                    <div class="card-header">Attorney Registration For {{ $user_party_group }} @if ($user_party_group != 'Petitioner 1')
                            (#{{ $party_number }})
                        @endif
                        <div class="pull-right">
                            <a class="btn btn-primary"
                                href="{{ route('cases.show_party_reg_form', ['case_id' => $case_id]) }}"> Back</a>
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
                        @if (isset($party_attorney))
                            <?php $t = count($party_attorney);
                            ?>
                            <h4>Attorneys For {{ $user_party_group }} @if ($user_party_group != 'Petitioner 1')
                                    (#{{ $party_number }})
                                @endif
                                @if ($t < 3)
                                    <span class="pull-right"><button type="button"
                                            id="show_attorney_form"style="margin-bottom: 15px;"
                                            class="show-attorney-form btn btn-primary">Add Attorney (#{{ ++$t }})
                                        </button></span>
                                @endif
                            </h4>
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Firm Name</th>
                                    <th>Firm City</th>
                                    <th>Firm State</th>
                                    <th>Firm County</th>
                                    <th>Trial Attorney</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($party_attorney as $key => $partyattorney)
                                    <tr>
                                        <td>{{ $partyattorney->name }}</td>
                                        <td><?php if (isset($partyattorney->email) && strpos($partyattorney->email, 'unknown_' . $case_id . '_') === false) {
                                            echo $partyattorney->email;
                                        } ?></td>
                                        <td>{{ $partyattorney->firm_name }}</td>
                                        <td>{{ $partyattorney->firm_city }}</td>
                                        <td>{{ $partyattorney->state }}</td>
                                        <td>{{ $partyattorney->county }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('cases.party.trial_attorney') }}"
                                                autocomplete="off">
                                                @csrf
                                                <input type="hidden" class="trial_party_number" name="party_number"
                                                    value="{{ $party_number }}">
                                                <input type="hidden" class="trial_party_id" name="party_id"
                                                    value="{{ $case_party_user->user_id }}">
                                                <input type="hidden" class="trial_attorney_id" name="attorney_id"
                                                    value="{{ $partyattorney->id }}">
                                                <input type="hidden" class="trial_case_id" name="case_id"
                                                    value="{{ $case_id }}">
                                                <input class="is_trial_attorney" type="checkbox" class="form-control"
                                                    name="is_trial_attorney" value="Yes" <?php if (isset($partyattorney->trial_attorney) && $partyattorney->trial_attorney == 'Yes') {
                                                        echo 'checked';
                                                    } ?>>
                                                <button type="submit" class="btn btn-primary ml-2 trial_update_btn"
                                                    <?php if (isset($partyattorney->trial_attorney) && $partyattorney->trial_attorney == 'No') {
                                                        echo 'disabled';
                                                    } ?>>Update</button>
                                            </form>
                                        </td>
                                        <td>
                                            <!-- <a class="btn btn-primary mb-2" href="">Edit</a> -->
                                            <a class="btn btn-info mb-2"
                                                href="{{ route('cases.show_update_party_attorney_form', ['party_id' => $case_party_user->user_id, 'case_id' => $case_id, 'attorney_id' => $partyattorney->id, 'party_number' => $party_number]) }}">Edit</a>
                                            <a class="btn btn-danger mb-2" onclick="return ConfirmStatus(event);"
                                                href="{{ route('cases.delete_party_attorney', ['party_id' => $case_party_user->user_id, 'case_id' => $case_id, 'attorney_id' => $partyattorney->id, 'party_number' => $party_number]) }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                        @if ($case_party_user->total_attornies < 3)
                            @if (isset($party_attorney))
                                <div class="col-md-12 attorney-form-show" style="display: none;">
                                @else
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <h4 style="margin-left: -30px;">For {{ $user_party_group }} @if ($user_party_group != 'Petitioner 1')
                                                    (#{{ $party_number }})
                                                @endif
                                            </h4>
                                        </div>
                            @endif
                            <div class="col-md-6">
                                <h4 style="margin-left: -30px;">Register Attorney (#{{ $t }})</h4>
                            </div>
                    </div><br>
                    @if (isset($party_attorney))
                        <form method="POST" class="attorney-form-show container" action="{{ route('cases.store_attorney') }}"
                            id="attorney_reg_form" style="display: none;">
                        @else
                            <form method="POST" class="container" action="{{ route('cases.store_attorney') }}" id="attorney_reg_form">
                    @endif
                    @csrf
                    <input type="hidden" name="party_id" value="{{ $case_party_user->user_id }}">
                    <input type="hidden" name="party_group" value="{{ $case_party_user->party_group }}">
                    <input type="hidden" name="case_id" value="{{ $case_id }}">
                    <input type="hidden" name="party_number" value="{{ $party_number }}">
                    <div class="form-group row">
                        <div class="col-md-3 form-check form-check-inline">
                            <input id="pro_hac_vice" type="checkbox"
                                class="form-control form-check-input @error('pro_hac_vice') is-invalid @enderror"
                                name="pro_hac_vice" value="yes" style="width: 15px;">
                            <label for="pro_hac_vice"
                                class="col-form-label text-md-left form-check-label">{{ __('Pro Hac Vice') }}</label>
                        </div>
                        <div class="col-md-3 form-check form-check-inline">
                            @if (isset($total_trial_attorneys) && $total_trial_attorneys == '0')
                                <input id="trial_attorney" type="checkbox"
                                    class="form-control form-check-input @error('trial_attorney') is-invalid @enderror"
                                    name="trial_attorney" value="Yes" style="width: 15px;" <?php if ($t == '1') {
                                        echo ' checked';
                                    } ?>>
                                <label for="trial_attorney"
                                    class=" col-form-label text-md-left">{{ __('Trial Attorney') }}</label>
                            @endif
                        </div>
                        <div class="col-md-3 form-check form-check-inline">
                            @if (isset($total_customer_attorney) && $total_customer_attorney == '0' && $user_party_group != 'Defendant')
                                <input id="customer_attorney" type="checkbox"
                                    class="form-control form-check-input customer_attorney" name="customer_attorney"
                                    value="Yes" style="width: 15px;" <?php if ($t == '1') {
                                        echo " data-onload='isCustomerAttorney(this)' ";
                                    } else {
                                        echo "onchange='isCustomerAttorney(this)'";
                                    } ?>
                                    data-reg="{{ $customer_attorney_info->attorney_reg_1_num }}"
                                    data-id="{{ Auth::user()->id }}" <?php if ($t == '1') {
                                        echo ' checked';
                                    } ?>>
                                <label for="customer_attorney"
                                    class=" col-form-label text-md-left">{{ $customer_attorney_info->document_sign_name }}</label>
                            @endif
                        </div>
                        <div class="col-md-3 form-check form-check-inline">
                            @if (isset($party_attorney) && !empty($party_attorney) && $user_party_group == 'Defendant')
                                @foreach ($party_attorney as $attorney)
                                    <?php
                                    $customer_attorney_infos = $attorney->attorney;
                                    ?>
                                    <input id="" type="checkbox"
                                        class="form-control form-check-input customer_attorney" name="customer_attorney"
                                        value="Yes" data-reg="{{ $customer_attorney_infos->attorney_reg_1_num }}"
                                        data-id="{{ $customer_attorney_infos->user_id }}" style="width: 15px;"
                                        <?php //if ($t=='1'){ echo "onclick='return false' data-onload='isCustomerAttorney(this)' checked"; } else { echo "onchange='isCustomerAttorney(this)'"; }
                                        ?>>
                                    <label for="customer_attorney"
                                        class=" col-form-label text-md-left">{{ $attorney->name }}</label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                   
                    <div class="form-group row">
                       
                        <div class="col-md-4">
                             <label for="attorney_reg_1_state_id"
                            class=" col-form-label text-md-left">{{ __('Attorney Reg State*') }}</label>
                            <select id="attorney_reg_1_state_id" name="attorney_reg_1_state_id"
                                class="form-control states_select_input" required="">
                                <option value="">Choose Attorney Reg #1 State*</option>
                            </select>
                            @error('attorney_reg_1_state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      
                        <div class="col-md-4 pro_vice_hac_label" style="display: none;">
                              <label for="pro_vice_hac_num" class="col-form-label text-md-left pro_vice_hac_label"
                            style="display: none;">{{ __('Pro Hac Vice #*') }}</label>
                            <input id="pro_vice_hac_num" type="text"
                                class="form-control @error('pro_vice_hac_num') is-invalid @enderror"
                                name="pro_vice_hac_num" value="{{ old('pro_vice_hac_num') }}"
                                autocomplete="pro_vice_hac_num">
                            @error('pro_vice_hac_num')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4 attorney_reg_1_num_label">
                             <label for="attorney_reg_1_num"
                            class=" col-form-label text-md-left attorney_reg_1_num_label">{{ __('Attorney Reg #*') }}
                            <i class="fa fa-search lookupicone col-md-1 text-md-left" aria-hidden="true"
                                data-toggle="modal" data-target="#myNewDynamicModal"></i>
                        </label>
                            <input id="attorney_reg_1_num" type="text"
                                class="form-control @error('attorney_reg_1_num') is-invalid @enderror"
                                name="attorney_reg_1_num" value="{{ old('attorney_reg_1_num') }}"
                                autocomplete="attorney_reg_1_num" autofocus required="">
                                <div id="noattorney" style="display: none;"><span style="color: #e42727;">No
                                attorney data found for this reg number.</span></div>
                            @error('attorney_reg_1_num')
                                `
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                    
                        <div class="col-md-4">
                                <label for="fname"
                            class=" col-form-label text-md-left">{{ __('First Name*') }}</label>
                            <input id="fname" type="text"
                                class="form-control @error('fname') is-invalid @enderror" name="fname"
                                value="{{ old('fname') }}" required autocomplete="fname" autofocus>
                            @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="mname"
                            class=" col-form-label text-md-left">{{ __('Middle Name') }}</label>
                            <input id="mname" type="text"
                                class="form-control @error('mname') is-invalid @enderror" name="mname"
                                value="{{ old('mname') }}" autocomplete="mname" autofocus>
                            @error('mname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                  
                      
                        <div class="col-md-4">
                              <label for="lname"
                            class=" col-form-label text-md-left">{{ __('Last Name*') }}</label>
                            <input id="lname" type="text"
                                class="form-control @error('lname') is-invalid @enderror" name="lname"
                                value="{{ old('lname') }}" required autocomplete="lname" autofocus>
                            @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- </div>
                            <div class="form-group row"> -->
                      
                        <div class="col-md-4">
                              <label for="document_sign_name"
                            class=" col-form-label text-md-left">{{ __('Document Sig/Name*') }}</label>
                            <input id="document_sign_name" type="text"
                                class="form-control @error('document_sign_name') is-invalid @enderror"
                                name="document_sign_name" value="{{ old('document_sign_name') }}" required
                                autocomplete="document_sign_name">
                            @error('document_sign_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                  
                       
                        <div class="col-md-4">
                             <label for="email"
                            class="col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                             <label for="sufname" class=" col-form-label text-md-left">{{ __('Suffix') }}</label>
                            <select id="sufname" name="sufname" class="form-control" autofocus="">
                                <option value="">Choose Suffix Type</option>
                                <option value="Sr.">Sr.</option>
                                <option value="Jr.">Jr.</option>
                                <option value="I">I</option>
                                <option value="II">II</option>
                                <option value="III">III</option>
                                <option value="IV">IV</option>
                                <option value="V">V</option>
                            </select>
                            @error('sufname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                          <div class="col-md-4 mt-4">
                              <label for="gender" class=" col-form-label text-md-left">{{ __('Gender*') }}</label>
                            <input type="radio" id="clgen-m" class="gender-input" name="gender" value="M"
                                required="" checked="">
                            <label for="clgen-m">M</label>
                            <input type="radio" id="clgen-f" class="gender-input" name="gender" value="F">
                            <label for="clgen-f">F</label>
                            <input type="radio" id="clgen-n" class="gender-input" name="gender" value="N">
                            <label for="clgen-n">N</label>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label text-md-left">{{ __('Special Practice Type*') }}</label>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <input id="special_practice_nill" type="radio" class=""
                                        name="special_practice" value="Nill" required checked autofocus>
                                    <label for="special_practice_nill"
                                        class="col-form-label text-md-left">&nbsp{{ __('N/A') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="special_practice_court" type="radio" class=""
                                        name="special_practice" value="court" autofocus>
                                    <label for="special_practice_court"
                                        class="col-form-label text-md-left">&nbsp{{ __('Adjudicator/Court Atty') }}</label>
                                </div>
                                <div class="col-md-4">
                                    <input id="special_practice_legal_aid" type="radio" class=""
                                        name="special_practice" value="legal_aid" autofocus>
                                    <label for="special_practice_legal_aid"
                                        class="col-form-label text-md-left">{{ __('Legal Aid') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input id="special_practice_law_school" type="radio" class=""
                                        name="special_practice" value="law_school" autofocus>
                                    <label for="special_practice_law_school"
                                        class="col-form-label text-md-left">{{ __('Law School Clinic') }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                              
                                <div class="col-md-8 offset-md-4">
                                     <label class="col-form-label special_practice_inputs_label"></label>
                                    <input id="court_text" type="text"
                                        class="special_practice_inputs form-control @error('court_text') is-invalid @enderror"
                                        name="court_text" value="{{ old('court_text') }}" autocomplete="court_text"
                                        placeholder="Enter Court">
                                    @error('court_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <select id="legal_aid_county" name="legal_aid_text"
                                        class="form-control special_practice_inputs">
                                        <option value="">Choose County</option>
                                    </select>
                                    @error('legal_aid_county')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <input id="law_school_text" type="text"
                                        class="special_practice_inputs form-control @error('law_school_text') is-invalid @enderror"
                                        name="law_school_text" value="{{ old('law_school_text') }}"
                                        autocomplete="law_school_text" placeholder="Enter Law School">
                                    @error('law_school_text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                       
                        
                     
                        <div class="col-md-4">
                               <label for="currentstatus"
                            class="col-form-label text-md-left">{{ __('Current Status') }}</label>
                            <input id="currentstatus" type="text"
                                class="form-control @error('currentstatus') is-invalid @enderror" name="currentstatus"
                                value="{{ old('currentstatus') }}" autocomplete="currentstatus">
                            @error('currentstatus')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                      
                      
                      
                        <div class="col-md-4">
                              <label for="attorneytitle"
                            class=" col-form-label text-md-left">{{ __('Attorney Title') }}</label>
                            <input id="attorneytitle" type="text"
                                class="form-control @error('attorneytitle') is-invalid @enderror" name="attorneytitle"
                                value="{{ old('attorneytitle') }}" autocomplete="attorneytitle">
                            @error('attorneytitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                       
                        <div class="col-md-4 mt-4">
                             <label for="insured"
                            class=" col-form-label text-md-left">{{ __('Has Malpractice Insurance') }}</label>
                            <input type="radio" id="insured-y" class="insured-input" name="insured" value="Yes">
                            <label for="insured-y">Yes</label>
                            <input type="radio" id="insured-n" class="insured-input" name="insured" value="No"
                                checked="">
                            <label for="insured-n">No</label>
                            @error('insured')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="admissiondate"
                            class=" col-form-label text-md-left">{{ __('Admission Date') }}</label>
                            <input id="admissiondate" type="text"
                                class="form-control @error('admissiondate') is-invalid @enderror hasDatepicker"
                                name="admissiondate" value="{{ old('admissiondate') }}" autocomplete="admissiondate">
                            @error('admissiondate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                      
                        <div class="col-md-4">
                              <label for="howadmitted"
                            class=" col-form-label text-md-left">{{ __('How Admitted') }}</label>
                            <input id="howadmitted" type="text"
                                class="form-control @error('howadmitted') is-invalid @enderror" name="howadmitted"
                                value="{{ old('howadmitted') }}" autocomplete="howadmitted">
                            @error('howadmitted')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                      
                        <div class="col-md-4">
                              <label for="birthdate"
                            class="col-form-label text-md-left">{{ __('Date of Birth') }}</label>
                            <input id="birthdate" type="text"
                                class="form-control @error('birthdate') is-invalid @enderror hasDatepicker"
                                name="birthdate" value="{{ old('birthdate') }}" autocomplete="birthdate">
                            @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                       
                        <div class="col-md-4">
                             <label for="firm_name"
                            class=" col-form-label text-md-left">{{ __('Firm Name*') }}</label>
                            <input id="firm_name" type="text"
                                class="form-control @error('firm_name') is-invalid @enderror" name="firm_name"
                                value="Attorney at Law" required autocomplete="firm_name" autofocus>
                            @error('firm_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="firm_zipcode"
                            class=" col-form-label text-md-left">{{ __('Firm Zip Code*') }}</label>
                          
                            <input id="firm_zipcode" type="text"
                                class="form-control @error('firm_zipcode') is-invalid @enderror" name="firm_zipcode"
                                value="{{ old('firm_zipcode') }}" required autocomplete="firm_zipcode" autofocus>
                              <span class="text-danger no-state-county-found" style="display: none;">No City, State, County
                                found for this zipcode.</span>
                                @error('firm_zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                       
                        <div class="col-md-4">
                             <label for="firm_state"
                            class=" col-form-label text-md-left">{{ __('Firm State*') }}</label>
                            <select id="firm_state" name="firm_state" class="form-control" required>
                                <option value="">Choose Firm State</option>
                            </select>
                            @error('firm_state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="firm_county"
                            class=" col-form-label text-md-left">{{ __('Firm County*') }}</label>
                            <select id="firm_county" name="firm_county" class="form-control" required>
                                <option value="">Choose Firm County</option>
                            </select>
                            @error('firm_county')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                  
                       
                        <div class="col-md-4">
                             <label for="firm_city"
                            class=" col-form-label text-md-left">{{ __('Firm City*') }}</label>
                            <select id="firm_city" name="firm_city" class="form-control" required>
                                <option value="">Choose Firm City</option>
                            </select>
                            @error('firm_city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="firm_street_address"
                            class="col-form-label text-md-left">{{ __('Firm Street Address*') }}</label>
                            <input id="firm_street_address" type="text"
                                class="form-control @error('firm_street_address') is-invalid @enderror"
                                name="firm_street_address" value="{{ old('firm_street_address') }}" required
                                autocomplete="firm_street_address" autofocus>
                            @error('firm_street_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                       
                        <div class="col-md-4">
                             <label for="firm_suite_unit_mailcode"
                            class=" col-form-label text-md-left">{{ __('Firm Suite/Unit/MailCode') }}</label>
                            <input id="firm_suite_unit_mailcode" type="text"
                                class="form-control @error('firm_suite_unit_mailcode') is-invalid @enderror"
                                name="firm_suite_unit_mailcode" value="{{ old('firm_suite_unit_mailcode') }}"
                                autocomplete="firm_suite_unit_mailcode">
                            @error('firm_suite_unit_mailcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="po_box" class="col-form-label text-md-left">{{ __('PO Box') }}</label>
                            <input id="po_box" type="text"
                                class="form-control @error('po_box') is-invalid @enderror" name="po_box"
                                value="{{ old('po_box') }}" autocomplete="po_box">
                            @error('po_box')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                  
                       
                        <div class="col-md-4">
                             <label for="firm_telephone"
                            class=" col-form-label text-md-left">{{ __('Firm Telephone') }}</label>
                            <input id="firm_telephone" onkeypress='return onlyNumber(event)' maxlength="14"
                                type="text" class="form-control @error('firm_telephone') is-invalid @enderror"
                                name="firm_telephone" value="{{ old('firm_telephone') }}"
                                autocomplete="firm_telephone" placeholder="(XXX) XXX-XXXX">
                            @error('firm_telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                       
                        <div class="col-md-4">
                             <label for="firm_fax"
                            class="col-form-label text-md-left">{{ __('Firm Fax') }}</label>
                            <input id="firm_fax" type="text" maxlength="14" onkeypress='return onlyNumber(event)'
                                class="form-control @error('firm_fax') is-invalid @enderror" name="firm_fax"
                                value="{{ old('firm_fax') }}" placeholder="(XXX) XXX-XXXX">
                            @error('firm_fax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                   
                       
                        <div class="col-md-4">
                             <label for="firm_tagline"
                            class="col-form-label text-md-left">{{ __('Firm Tagline') }}</label>
                            <input id="firm_tagline" type="text"
                                class="form-control @error('firm_tagline') is-invalid @enderror" name="firm_tagline"
                                value="{{ old('firm_tagline') }}" autocomplete="firm_tagline">
                            @error('firm_tagline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!--  <div class="form-group row">
                                <label for="attorney_reg_2_state_id" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg #2 State') }}</label>
                                <div class="col-md-4">
                                    <select id="attorney_reg_2_state_id" name="attorney_reg_2_state_id" class="form-control states_select_input">
                                        <option value="">Choose Attorney Reg #2 State</option>
                                    </select>
                                    @error('attorney_reg_2_state_id')
        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
    @enderror
                                </div>
                                <label for="attorney_reg_2_num" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg #2') }}</label>
                                <div class="col-md-4">
                                    <input id="attorney_reg_2_num" type="text" class="form-control @error('attorney_reg_2_num') is-invalid @enderror" name="attorney_reg_2_num" value="{{ old('attorney_reg_2_num') }}" autocomplete="attorney_reg_2_num" autofocus>
                                    @error('attorney_reg_2_num')
        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="attorney_reg_3_state_id" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg #3 State') }}</label>
                                <div class="col-md-4">
                                    <select id="attorney_reg_3_state_id" name="attorney_reg_3_state_id" class="form-control states_select_input">
                                        <option value="">Choose Attorney Reg #3 State</option>
                                    </select>
                                    @error('attorney_reg_3_state_id')
        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
    @enderror
                                </div>
                                <label for="attorney_reg_3_num" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg #3') }}</label>
                                <div class="col-md-4">
                                    <input id="attorney_reg_3_num" type="text" class="form-control @error('attorney_reg_3_num') is-invalid @enderror" name="attorney_reg_3_num" value="{{ old('attorney_reg_3_num') }}" autocomplete="attorney_reg_3_num" autofocus>
                                    @error('attorney_reg_3_num')
        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
    @enderror
                                </div>
                            </div>     -->
                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-md-center">
                            <button style="display: none;" type="reset" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- The New Dynamic Modal -->
    <div class="modal" id="myNewDynamicModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <h2>Search Attorney</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body text-center">
                    <form method="POST" action="">
                        @csrf
                        <input id="type" type="hidden" name="type" value="" style="display: none;"
                            required="">
                        <DIV class="row">
                            <div class="col-sm-12 mb-3">
                                <input type="number" min="0" class="form-control" name=""
                                    id="search_reg" placeholder="Registration Number" autocomplete="off">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <input type="text" class="form-control" name="" id="first_name"
                                    placeholder=" First Name" autocomplete="off">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <input type="text" class="form-control" name="" id="last_name"
                                    placeholder=" Last Name" autocomplete="off">
                            </div>
                            <div class="col-sm-6 mb-3 text-left">
                                <input type="button" id="search" class="btn btn-success mb-2" name="submit"
                                    value="Search">
                            </div>
                            <div class="col-sm-12 d-inline-flex mb-2 result" style="display:none;">
                                <table id="extradata" class="formatHTML5 table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Registration Number</th>
                                            <th>First name</th>
                                            <th>Last Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <p id="errormsg" style="display: none; text-align: center;"> No records found.</p>
                            </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
            var token = $('input[name=_token]').val();
            var state_id = 35;
            $('#search').on('click', function(e) {
                var words = $("#search_reg").val();
                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                if (words.length == 0) {
                    $('#extradata tbody').html(' ');
                }
                $.ajax({
                    url: "{{ route('ajax_get_search_data') }}",
                    method: "GET",
                    dataType: 'json',
                    data: {
                        search_tag: words,
                        state_id: state_id,
                        first_name: first_name,
                        last_name: last_name,
                        _token: token,
                    },
                    success: function(data) {
                        $('#extradata tbody').html(' ');
                        if (data != '') {
                            if (data == null || data == 'null') {
                                $("#errormsg").show();
                                $(".result").hide();
                            } else {
                                $("#errormsg").hide();
                                $('#extradata tbody').html(' ');
                                $(".result").show();
                                $.each(data, function(key, val) {
                                    $('#extradata').append('<tr><td class="r">' + val
                                        .registrationnumber +
                                        '</td><td class="f">' + val.fname +
                                        '</td><td class="l">' + val.lname +
                                        '</td></tr>');
                                });
                                $('#extradata').append('</tbody>');
                            }
                        } else {
                            $('#extradata tbody').html(' ');
                        }
                    }
                });
            });
            $('#attorney_reg_form').validate({
                rules: {
                    firm_telephone: {
                        // phoneUS: true
                        // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                        pattern: (/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                    },
                    firm_fax: {
                        pattern: (/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                    },
                    email: {
                        pattern: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
                    }
                }
            });
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $(".hasDatepicker").datepicker({
                startDate: "01/01/1901",
                endDate: '+0d',
            });
            var token = $('input[name=_token]').val();
            var id = '35';
            $.ajax({
                url: "{{ route('ajax_get_counties_by_state') }}",
                method: "POST",
                dataType: 'json',
                data: {
                    id: id,
                    _token: token,
                },
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('#legal_aid_county').append('<option value=' + key + '>' + val +
                                '</option>');
                        });
                    }
                }
            });
            $.ajax({
                url: "{{ route('ajax_get_states') }}",
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('.states_select_input').append('<option value=' + key + '>' +
                                val + '</option>');
                        });
                        $('#attorney_reg_1_state_id option[value=35]').attr('selected', 'selected');
                        // to run on load if customer attorney checked after states are appended
                        $('[data-onload]').each(function() {
                            eval($(this).data('onload'));
                        });
                    }
                }
            });
            $('#attorney_reg_1_num').on('input', function() {
                $('#noattorney').hide();
                var reg_num = this.value;
                $('#attorney_reg_form').trigger("reset");
                $('#attorney_reg_1_num').val(reg_num);
                var state_id = $('#attorney_reg_1_state_id').val();
                if (reg_num) {
                    var token = $('input[name=_token]').val();
                    $.ajax({
                        url: "{{ route('ajax_get_attorney_by_reg_num') }}",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            reg_num: reg_num,
                            state_id: state_id,
                            _token: token,
                        },
                        success: function(data) {
                            // console.log(data);
                            if (data == null || data == 'null') {
                                $('#noattorney').show();
                            } else {
                                $('#noattorney').hide();
                                //$('#attorney_reg_1_num').val(data.registrationnumber_state1);
                                $('#fname').val(data.fname);
                                $('#mname').val(data.mname);
                                $('#lname').val(data.lname);
                                $('#email').val(data.email);
                                $('#document_sign_name').val(data.document_sign_name);
                                $('#firm_name').val(data.firm_name);
                                $('#firm_street_address').val(data.firm_street_address);
                                $('#firm_city').val(data.firm_city);
                                $('#firm_zipcode').val(data.firm_zip);
                                $('#firm_telephone').val(data.firm_telephone);
                                $('#firm_fax').val(data.firm_fax);
                                $('#firm_suite_unit_mailcode').val(data
                                    .firm_suite_unit_mailcode);
                                $('#po_box').val(data.po_box);
                                $("#sufname option[value='" + data.sufname + "']").attr(
                                    'selected', 'selected');
                                $('#currentstatus').val(data.currentstatus);
                                $("input[name='gender'][value='" + data.gender + "']").prop(
                                    'checked', true);
                                $('#attorneytitle').val(data.attorneytitle);
                                $("input[name='insured'][value='" + data.insured + "']").prop(
                                    'checked', true);
                                $('#admissiondate').val(data.admissiondate);
                                $('#admissiondate').datepicker("setDate", new Date(data
                                    .admissiondate));
                                $('#howadmitted').val(data.howadmitted);
                                $('#birthdate').datepicker("setDate", new Date(data.birthdate));
                                $('#firm_tagline').val(data.firm_tagline);
                                // $('#firm_state option[value='+data.registration_state_id+']').attr('selected','selected');
                                /*if(reg_num=='{{ Auth::user()->attorney->attorney_reg_1_num }}'){
                                    $(".customer_attorney").prop('checked', true);
                                }*/
                                var county_id = data.county_id;
                                var firm_city = data.firm_city;
                                var state_id = data.registration_state_id;
                                $('.no-state-county-found').hide();
                                $('#firm_city').find('option').remove().end().append(
                                    '<option value="">Choose City</option>');
                                $('#firm_state').find('option').remove().end().append(
                                    '<option value="">Choose State</option>');
                                $('#firm_county').find('option').remove().end().append(
                                    '<option value="">Choose County</option>');
                                if (data.firm_zip != '' && data.firm_zip != null) {
                                    var token = $('input[name=_token]').val();
                                    $.ajax({
                                        url: "{{ route('ajax_get_city_state_county_by_zip') }}",
                                        method: "POST",
                                        dataType: 'json',
                                        data: {
                                            zip: data.firm_zip,
                                            _token: token,
                                        },
                                        success: function(data) {
                                            // console.log(data);
                                            if (data == 'null' || data == '') {
                                                $('.no-state-county-found').show();
                                            } else {
                                                $.each(data, function(key, val) {
                                                    $('#firm_city').append(
                                                        '<option value="' +
                                                        data[key].city +
                                                        '">' + data[key]
                                                        .city +
                                                        '</option>');
                                                    $('#firm_state').append(
                                                        '<option value="' +
                                                        data[key]
                                                        .state_id +
                                                        '">' + data[key]
                                                        .state +
                                                        '</option>');
                                                    $('#firm_county')
                                                        .append(
                                                            '<option value="' +
                                                            data[key].id +
                                                            '">' + data[key]
                                                            .county_name +
                                                            '</option>');
                                                });
                                                var a = new Array();
                                                $('#firm_city').children("option")
                                                    .each(function(x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                    .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                var a = new Array();
                                                $('#firm_state').children("option")
                                                    .each(function(x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                    .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                var a = new Array();
                                                $('#firm_county').children("option")
                                                    .each(function(x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                    .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                if ($('#firm_city').children(
                                                        'option').length == '2') {
                                                    $('#firm_city').children(
                                                            'option').first()
                                                        .remove();
                                                }
                                                if ($('#firm_state').children(
                                                        'option').length == '2') {
                                                    $('#firm_state').children(
                                                            'option').first()
                                                        .remove();
                                                }
                                                if ($('#firm_county').children(
                                                        'option').length == '2') {
                                                    $('#firm_county').children(
                                                            'option').first()
                                                        .remove();
                                                }
                                                $('#firm_state option[value="' +
                                                    state_id + '"]').attr(
                                                    'selected', 'selected');
                                                $('#firm_county option[value="' +
                                                    county_id + '"]').attr(
                                                    'selected', 'selected');
                                                $('#firm_city option[value="' +
                                                    firm_city + '"]').attr(
                                                    'selected', 'selected');
                                                $('.no-state-county-found').hide();
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                }
            });
            $(document).on('keyup', '#search_reg,#first_name,#last_name', function(event) {
                if (event.keyCode === 13) {
                    $("#search").click();
                }
            });
            <?php // if ($t!='1'){
            ?>
            $('.customer_attorney').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#noattorney').hide();
                    var thisval = $(this);
                    var reg_num = $(this).attr('data-reg');
                    var id = $(this).attr('data-id');
                    $('#attorney_reg_form').trigger("reset");
                    $('#attorney_reg_1_num').val(reg_num);
                    var state_id = $('#attorney_reg_1_state_id').val();
                    if (reg_num) {
                        var token = $('input[name=_token]').val();
                        $.ajax({
                            url: "{{ route('ajax_get_attorney_by_reg_num') }}",
                            method: "POST",
                            dataType: 'json',
                            data: {
                                reg_num: reg_num,
                                id: id,
                                state_id: state_id,
                                _token: token,
                            },
                            success: function(data) {
                                // console.log(data);
                                if (data == null || data == 'null') {
                                    $('#noattorney').show();
                                    $(".customer_attorney").attr('checked', true);
                                } else {
                                    $(".customer_attorney").attr('checked', true);
                                    $('#noattorney').hide();
                                    //$('#attorney_reg_1_num').val(data.registrationnumber_state1);
                                    $('#fname').val(data.fname);
                                    $('#mname').val(data.mname);
                                    $('#lname').val(data.lname);
                                    $('#email').val(data.email);
                                    $('#document_sign_name').val(data.document_sign_name);
                                    $('#firm_name').val(data.firm_name);
                                    $('#firm_street_address').val(data.firm_street_address);
                                    $('#firm_city').val(data.firm_city);
                                    $('#firm_zipcode').val(data.firm_zip);
                                    $('#firm_telephone').val(data.firm_telephone);
                                    $('#firm_fax').val(data.firm_fax);
                                    $('#firm_suite_unit_mailcode').val(data
                                        .firm_suite_unit_mailcode);
                                    $('#po_box').val(data.po_box);
                                    //$('#sufname option[value='+data.sufname+']').attr('selected','selected');
                                    $('#currentstatus').val(data.currentstatus);
                                    $("input[name='gender'][value='" + data.gender + "']").prop(
                                        'checked', true);
                                    $('#attorneytitle').val(data.attorneytitle);
                                    $("input[name='insured'][value='" + data.insured + "']")
                                        .prop('checked', true);
                                    $('#admissiondate').val(data.admissiondate);
                                    $('#admissiondate').datepicker("setDate", new Date(data
                                        .admissiondate));
                                    $('#howadmitted').val(data.howadmitted);
                                    $('#birthdate').datepicker("setDate", new Date(data
                                        .birthdate));
                                    $('#firm_tagline').val(data.firm_tagline);
                                    // $('#firm_state option[value='+data.registration_state_id+']').attr('selected','selected');
                                    /*  if(reg_num=='{{ Auth::user()->attorney->attorney_reg_1_num }}'){
                                    $("#customer_attorney").prop('checked', true);
                                }
    */
                                    var county_id = data.county_id;
                                    var firm_city = data.firm_city;
                                    var state_id = data.registration_state_id;
                                    $('.no-state-county-found').hide();
                                    $('#firm_city').find('option').remove().end().append(
                                        '<option value="">Choose City</option>');
                                    $('#firm_state').find('option').remove().end().append(
                                        '<option value="">Choose State</option>');
                                    $('#firm_county').find('option').remove().end().append(
                                        '<option value="">Choose County</option>');
                                    if (data.firm_zip != '' && data.firm_zip != null) {
                                        var token = $('input[name=_token]').val();
                                        $.ajax({
                                            url: "{{ route('ajax_get_city_state_county_by_zip') }}",
                                            method: "POST",
                                            dataType: 'json',
                                            data: {
                                                zip: data.firm_zip,
                                                _token: token,
                                            },
                                            success: function(data) {
                                                // console.log(data);
                                                if (data == 'null' || data == '') {
                                                    $('.no-state-county-found')
                                                        .show();
                                                } else {
                                                    $.each(data, function(key,
                                                    val) {
                                                        $('#firm_city')
                                                            .append(
                                                                '<option value="' +
                                                                data[key]
                                                                .city +
                                                                '">' + data[
                                                                    key]
                                                                .city +
                                                                '</option>'
                                                                );
                                                        $('#firm_state')
                                                            .append(
                                                                '<option value="' +
                                                                data[key]
                                                                .state_id +
                                                                '">' + data[
                                                                    key]
                                                                .state +
                                                                '</option>'
                                                                );
                                                        $('#firm_county')
                                                            .append(
                                                                '<option value="' +
                                                                data[key]
                                                                .id + '">' +
                                                                data[key]
                                                                .county_name +
                                                                '</option>'
                                                                );
                                                    });
                                                    var a = new Array();
                                                    $('#firm_city').children(
                                                        "option").each(function(
                                                        x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                            .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++
                                                            ) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                    var a = new Array();
                                                    $('#firm_state').children(
                                                        "option").each(function(
                                                        x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                            .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++
                                                            ) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                    var a = new Array();
                                                    $('#firm_county').children(
                                                        "option").each(function(
                                                        x) {
                                                        test = false;
                                                        b = a[x] = $(this)
                                                            .val();
                                                        for (i = 0; i < a
                                                            .length - 1; i++
                                                            ) {
                                                            if (b == a[i])
                                                                test = true;
                                                        }
                                                        if (test) $(this)
                                                            .remove();
                                                    })
                                                    if ($('#firm_city').children(
                                                            'option').length ==
                                                        '2') {
                                                        $('#firm_city').children(
                                                                'option').first()
                                                            .remove();
                                                    }
                                                    if ($('#firm_state').children(
                                                            'option').length ==
                                                        '2') {
                                                        $('#firm_state').children(
                                                                'option').first()
                                                            .remove();
                                                    }
                                                    if ($('#firm_county').children(
                                                            'option').length ==
                                                        '2') {
                                                        $('#firm_county').children(
                                                                'option').first()
                                                            .remove();
                                                    }
                                                    $('#firm_state option[value="' +
                                                        state_id + '"]').attr(
                                                        'selected', 'selected');
                                                    $('#firm_county option[value="' +
                                                        county_id + '"]').attr(
                                                        'selected', 'selected');
                                                    $('#firm_city option[value="' +
                                                        firm_city + '"]').attr(
                                                        'selected', 'selected');
                                                    $('.no-state-county-found')
                                                        .hide();
                                                }
                                            }
                                        });
                                    }
                                }
                            }
                        });
                    }
                } else {
                    //$(".customer_attorney").prop('checked', false);
                    $(".customer_attorney").removeAttr('checked');
                    $('#noattorney').hide();
                    $('#attorney_reg_form').trigger("reset");
                }
            });
            <?php //}
            ?>
            // on special practice change
            $("input[name='special_practice']").on('change', function() {
                var special_practice = this.value;
                $('.special_practice_inputs').attr('required', false);
                $('.special_practice_inputs').removeClass('active-sp-input');
                $('.special_practice_inputs_label').text('');
                if (special_practice == 'legal_aid') {
                    $('#legal_aid_county').attr('required', true);
                    $('#legal_aid_county').addClass('active-sp-input');
                    $('.special_practice_inputs_label').text('County*');
                } else if (special_practice == 'law_school') {
                    $('#law_school_text').attr('required', true);
                    $('#law_school_text').addClass('active-sp-input');
                    $('.special_practice_inputs_label').text('Enter Law School*');
                } else if (special_practice == 'court') {
                    $('#court_text').attr('required', true);
                    $('#court_text').addClass('active-sp-input');
                    $('.special_practice_inputs_label').text('Enter Court*');
                }
            });
            // fetch city, state, county of client based on zipcode
            // $('#firm_zipcode').on('keyup', function() {
            $('#firm_zipcode').on('input', function() {
                $('.no-state-county-found').hide();
                $('#firm_city').find('option').remove().end().append(
                    '<option value="">Choose City</option>');
                $('#firm_state').find('option').remove().end().append(
                    '<option value="">Choose State</option>');
                $('#firm_county').find('option').remove().end().append(
                    '<option value="">Choose County</option>');
                var zip = this.value;
                if (zip != '' && zip != null && zip.length >= '3') {
                    var token = $('input[name=_token]').val();
                    $.ajax({
                        url: "{{ route('ajax_get_city_state_county_by_zip') }}",
                        method: "POST",
                        dataType: 'json',
                        data: {
                            zip: zip,
                            _token: token,
                        },
                        success: function(data) {
                            // console.log(data);
                            if (data == 'null' || data == '') {
                                $('.no-state-county-found').show();
                            } else {
                                $('.no-state-county-found').hide();
                                $.each(data, function(key, val) {
                                    $('#firm_city').append('<option value="' + data[key]
                                        .city + '">' + data[key].city + '</option>');
                                    $('#firm_state').append('<option value="' + data[
                                            key].state_id + '">' + data[key].state +
                                        '</option>');
                                    $('#firm_county').append('<option value="' + data[
                                            key].id + '">' + data[key].county_name +
                                        '</option>');
                                });
                                var a = new Array();
                                $('#firm_city').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('#firm_state').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('#firm_county').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                if ($('#firm_city').children('option').length == '2') {
                                    $('#firm_city').children('option').first().remove();
                                }
                                if ($('#firm_state').children('option').length == '2') {
                                    $('#firm_state').children('option').first().remove();
                                }
                                if ($('#firm_county').children('option').length == '2') {
                                    $('#firm_county').children('option').first().remove();
                                }
                                $('.no-state-county-found').hide();
                            }
                        }
                    });
                }
            });
            // show attorney reg form
            $('.show-attorney-form').on('click', function() {
                $('.attorney-form-show').show();
            });
            // on pro hac change
            $('#pro_hac_vice').on('change', function() {
                if (this.checked) {
                    $('.pro_vice_hac_label').show();
                    $('.attorney_reg_1_num_label').hide();
                    $('#pro_vice_hac_num').prop('required', true);
                    $('#attorney_reg_1_num').prop('required', false);
                    $('#attorney_reg_1_num').val('');
                } else {
                    $('.pro_vice_hac_label').hide();
                    $('.attorney_reg_1_num_label').show();
                    $('#pro_vice_hac_num').prop('required', false);
                    $('#attorney_reg_1_num').prop('required', true);
                    $('#pro_vice_hac_num').val('');
                }
            });
            // on update trial attorney change
            $('.is_trial_attorney').on('change', function() {
                if (this.checked) {
                    $(".is_trial_attorney").prop('checked', false);
                    $(".trial_update_btn").attr('disabled', true);
                    $(this).prop('checked', true);
                    $(this).closest("form").find('.trial_update_btn').attr('disabled', false);
                } else {
                    $(".trial_update_btn").attr('disabled', true);
                    // $(this).prop('checked', true);
                    // $(this).closest("form").find('.trial_update_btn').attr('disabled', false);
                }
            });
        });

        // prefill form with logged in attorney info if customer attorney
        function isCustomerAttorney(input_data) {
            if ($(input_data).is(':checked')) {
                $('#attorney_reg_1_num').val('{{ $customer_attorney_info->attorney_reg_1_num }}').trigger('input');
            } else {
                $('#attorney_reg_form').trigger("reset");
            }
        }
        $(document).on('click', 'tbody tr', function() {
            $('.selected').removeClass('selected');
            $(this).addClass("selected");
            var name = $(this).closest('tr').find('.r').text();
            var fname = $(this).closest('tr').find('.f').text();
            var mname = $(this).closest('tr').find('.m').text();
            var lname = $(this).closest('tr').find('.l').text();
            $("#attorney_reg_1_num").val(name).trigger('input');
            $(".customer_attorney").prop('checked', false);
            $("#fname").val(fname);
            $("#mname").val(mname);
            $("#lname").val(lname);
            $('#myNewDynamicModal').modal('hide');
        });
        var tele = document.querySelector('#firm_telephone');
        tele.addEventListener('keydown', function(e) {
            if (event.key != 'Backspace' && (tele.value.length === 0)) {
                tele.value += '(';
            }
            if (event.key != 'Backspace' && (tele.value.length === 4)) {
                tele.value += ')';
            }
            if (event.key != 'Backspace' && (tele.value.length === 5)) {
                tele.value += ' ';
            }
            if (event.key != 'Backspace' && (tele.value.length === 9)) {
                tele.value += '-';
            }
        });
        var fax = document.querySelector('#firm_fax');
        // console.log(fax);
        fax.addEventListener('keydown', function(e) {
            if (event.key != 'Backspace' && (fax.value.length === 0)) {
                fax.value += '(';
            }
            if (event.key != 'Backspace' && (fax.value.length === 4)) {
                fax.value += ')';
            }
            if (event.key != 'Backspace' && (fax.value.length === 5)) {
                fax.value += ' ';
            }
            if (event.key != 'Backspace' && (fax.value.length === 9)) {
                fax.value += '-';
            }
        });
    </script>
@endsection
