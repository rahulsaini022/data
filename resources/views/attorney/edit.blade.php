@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center attorney-edit-profile">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Account Info') }}</strong>
                    <div class="pull-right">
                        @hasrole('super admin')
                        <a class="btn btn-primary" href="{{ route('attorneys.index') }}">Back</a>
                        @endhasrole
                        @hasrole('attorney')
                        <a class="btn btn-primary" href="{{ route('attorneys.show', ['id' => Auth::user()->id]) }}">Back</a>
                        @endhasrole
                    </div>
                </div>
                <?php
                $fullname = $attorney->name;
                $fullname = explode(' ', $fullname);
                ?>
                <div class="card-body">
                     @include('layouts.message')
                    <form method="POST" action="{{ route('attorneys.update', ['id' => $attorney->id]) }}" id="attorney_edit_form" autocomplete="off">
                        @method('put')
                        @csrf
                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="prefill_from_permanent_data" class="col-form-label text-md-left">{{ __('Prefill from permanent data') }}</label>
                                <input id="prefill_from_permanent_data" type="checkbox" class="form-control is-invalid" name="" value="yes" style="width: 15px;">
                            </div>
                            {{-- <label class="col-md-2 col-form-label text-md-left"></label> --}}
                            <div class="col-md-4" id="noattorney" style="display: none;"><span class="text-info">No
                                    attorney data found for this reg number.</span></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="fname" class=" col-form-label text-md-left">{{ __('First Name*') }}</label>
                                <input id="fname" type="text" onfocus="this.value = this.value;" class="form-control @error('fname') is-invalid @enderror" name="fname" value="<?php if (isset($fullname[0])) {
                                                                                                                                                                                    echo $fullname[0];
                                                                                                                                                                                } ?>" required autocomplete="fname" autofocus>
                                @error('fname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="mname" class=" col-form-label text-md-left">{{ __('Middle Name') }}</label>
                                <input id="mname" type="text" class="form-control @error('mname') is-invalid @enderror" name="mname" value="<?php if (isset($attorney_data)) {
                                                                                                                                                echo $attorney_data->mname;
                                                                                                                                            } ?>" autocomplete="mname" autofocus>
                                @error('mname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="lname" class=" col-form-label text-md-left">{{ __('Last Name*') }}</label>
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="<?php if (isset($fullname[1])) {
                                                                                                                                                echo $fullname[1];
                                                                                                                                            } ?>" required autocomplete="lname" autofocus>
                                @error('lname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- </div>
                            <div class="form-group row"> -->
                            <div class="col-md-4">
                                <label for="document_sign_name" class=" col-form-label text-md-left">{{ __('Document Sig/Name*') }}</label>
                                <input id="document_sign_name" type="text" class="form-control @error('document_sign_name') is-invalid @enderror" name="document_sign_name" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                                        echo $attorney_data->document_sign_name;
                                                                                                                                                                                    } ?>" required autocomplete="document_sign_name">
                                @error('document_sign_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            {{-- </div>
                        <div class="form-group row"> --}}
                            <div class="col-md-4">
                                <label for="email" class=" col-form-label text-md-left">{{ __('E-Mail Address*') }}</label>
                                <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $attorney->email }}" required autocomplete="email">
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
                                    <option value="Sr." <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'Sr.') {
                                                            echo 'selected';
                                                        } ?>>Sr.</option>
                                    <option value="Jr." <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'Jr.') {
                                                            echo 'selected';
                                                        } ?>>Jr.</option>
                                    <option value="I" <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'I') {
                                                            echo 'selected';
                                                        } ?>>I</option>
                                    <option value="II" <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'II') {
                                                            echo 'selected';
                                                        } ?>>II</option>
                                    <option value="III" <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'III') {
                                                            echo 'selected';
                                                        } ?>>III</option>
                                    <option value="IV" <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'IV') {
                                                            echo 'selected';
                                                        } ?>>IV</option>
                                    <option value="V" <?php if (isset($attorney_data->sufname) && $attorney_data->sufname == 'V') {
                                                            echo 'selected';
                                                        } ?>>V</option>
                                </select>
                                @error('sufname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="attorneytitle" class=" col-form-label text-md-left">{{ __('Attorney Title') }}</label>
                                <input id="attorneytitle" type="text" class="form-control @error('attorneytitle') is-invalid @enderror" name="attorneytitle" value="<?php if (isset($attorney_data->attorneytitle) && $attorney_data->attorneytitle != '') {
                                                                                                                                                                        echo $attorney_data->attorneytitle;
                                                                                                                                                                    } ?>">
                                @error('attorneytitle')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <label for="gender" class="form-check-label col-form-label text-md-left ">{{ __('Gender') }}</label>
                                    <div class="form-check form-check-inline ml-2">
                                        <input type="radio" id="atgen-m" class="gender-input" name="gender" value="M" required="" <?php if (isset($attorney_data->gender) && $attorney_data->gender == 'M') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?>>
                                        <label class="form-check-label" for="atgen-m"> M</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="atgen-f" class="gender-input" name="gender" value="F" <?php if (isset($attorney_data->gender) && $attorney_data->gender == 'F') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                        <label class="form-check-label" for="atgen-f"> F</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="atgen-n" class="gender-input" name="gender" value="N" <?php if (isset($attorney_data->gender) && $attorney_data->gender == 'N') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                        <label class="form-check-label" for="atgen-n"> N</label>
                                    </div>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <label class="form-check-label" for="insured" class=" col-form-label text-md-left">{{ __('Has Malpractice Insurance') }}</label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="insured-yes" class="insured-input" name="insured" value="Yes" <?php if (isset($attorney_data->insured) && $attorney_data->insured == 'Yes') {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?>>
                                        <label class="form-check-label" for="insured-yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="insured-no" class="insured-input" name="insured" value="No" <?php if (isset($attorney_data->insured) && $attorney_data->insured == 'No') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?>>
                                        <label class="form-check-label" for="insured-no">No</label>
                                    </div>
                                    @error('insured')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                              <label class="col-md-2 col-form-label text-md-left">{{ __('Special Practice Type*') }}</label>
                            <div class="col-md-6">
                              
                                <div class="row">
                                    <div class="col-lg-4 special_practice ">
                                        @if($attorney_data && $attorney_data->special_practice =='Nill') 
                                            <input class="special" id="special_practice_nill" type="radio" class="" name="special_practice" value="Nill" checked required autofocus>
                                        @else
                                            <input class="special" id="special_practice_nill" type="radio" class="" name="special_practice" value="Nill" required autofocus>
                                        @endif
                                        <label for="special_practice_nill" class="col-form-label text-md-left">&nbsp{{ __('N/A') }}</label>
                                    </div>
                                    <div class="col-lg-8 special_practice ">
                                        @if($attorney_data && $attorney_data->special_practice =='court') 
                                            <input class="special" id="special_practice_court" type="radio" class="" name="special_practice" value="court" checked autofocus>
                                        @else
                                            <input class="special" id="special_practice_court" type="radio" class="" name="special_practice" value="court" autofocus>
                                        @endif
                                        <label for="special_practice_court" class="col-form-label text-md-left">&nbsp{{ __('Adjudicator/Court Atty') }}</label>
                                    </div>
                                    <div class="col-lg-4 special_practice ">
                                        @if($attorney_data && $attorney_data->special_practice =='legal_aid') 
                                            <input class="special" id="special_practice_legal_aid" type="radio" class="" name="special_practice" value="legal_aid" checked autofocus>
                                        @else
                                            <input class="special" id="special_practice_legal_aid" type="radio" class="" name="special_practice" value="legal_aid" autofocus>
                                        @endif
                                        <label for="special_practice_legal_aid" class="col-form-label text-md-left">{{ __('Legal Aid') }}</label>
                                    </div>
                                    <div class="col-lg-8 special_practice ">
                                        @if($attorney_data && $attorney_data->special_practice =='law_school')
                                            <input class="special" id="special_practice_law_school" type="radio" class="" name="special_practice" value="law_school" checked autofocus>
                                        @else
                                            <input class="special" id="special_practice_law_school" type="radio" class="" name="special_practice" value="law_school" autofocus>
                                        @endif
                                        <label for="special_practice_law_school" class="col-form-label text-md-left">{{ __('Law School Clinic') }}</label>
                                    </div>    
                                </div>
                            </div>    
                            <div class="col-md-4">
                                <div class="row">
                                 
                                   
                                        @if($attorney_data && $attorney_data->special_practice =='court')
                                            <label class="col-form-label special_practice_inputs_label">Enter Court*</label>
                                        @elseif($attorney_data && $attorney_data->special_practice =='law_school')
                                            <label class="col-form-label special_practice_inputs_label">Enter Law School*</label>
                                        @elseif($attorney_data && $attorney_data->special_practice =='legal_aid')
                                            <label class="col-form-label special_practice_inputs_label">County*</label>
                                        @else
                                            <label class="col-form-label special_practice_inputs_label"></label>
                                        @endif
                                        @if($attorney_data && $attorney_data->special_practice =='court')
                                            <input id="court_text" type="text" class="special_practice_inputs active-sp-input form-control @error('court_text') is-invalid @enderror" name="court_text" value="{{ $attorney_data->special_practice_text }}" autocomplete="court_text" required>
                                        @else
                                            <input id="court_text" type="text" class="special_practice_inputs form-control @error('court_text') is-invalid @enderror" name="court_text" value="" autocomplete="court_text">
                                        @endif
                                            
                                        @error('court_text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        @if($attorney_data && $attorney_data->special_practice =='legal_aid')
                                            <input type="hidden" name="legal_aid_county_input" value="{{ $attorney_data->special_practice_text }}" id="legal_aid_county_input">
                                            <select id="legal_aid_county" name="legal_aid_text" class="form-control special_practice_inputs active-sp-input" required>
                                                <option value="">Choose County</option>
                                            </select>
                                        @else
                                            <input type="hidden" name="legal_aid_county_input" value="" id="legal_aid_county_input">
                                            <select id="legal_aid_county" name="legal_aid_text" class="form-control special_practice_inputs">
                                                <option value="">Choose County</option>
                                            </select>
                                        @endif

                                        @error('legal_aid_county')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        @if($attorney_data && $attorney_data->special_practice =='law_school')
                                            <input id="law_school_text" type="text" class="special_practice_inputs active-sp-input form-control @error('law_school_text') is-invalid @enderror" name="law_school_text" value="{{ $attorney_data->special_practice_text }}" required autocomplete="law_school_text" placeholder="Law School">
                                        @else
                                            <input id="law_school_text" type="text" class="special_practice_inputs form-control @error('law_school_text') is-invalid @enderror" name="law_school_text" value="" autocomplete="law_school_text" placeholder="Law School">
                                        @endif

                                        @error('law_school_text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                               
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="currentstatus" class=" col-form-label text-md-left">{{ __('Current Status') }}</label>
                                <input id="currentstatus" type="text" class="form-control @error('currentstatus') is-invalid @enderror" name="currentstatus" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                        echo $attorney_data->currentstatus;
                                                                                                                                                                    } ?>" autocomplete="currentstatus" readonly="">
                                @error('currentstatus')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="birthdate" class=" col-form-label text-md-left">{{ __('Date of Birth') }}</label>
                                <input id="birthdate" type="text" class="form-control @error('birthdate') is-invalid @enderror hasDatepicker" name="birthdate" value="<?php if (isset($attorney_data->birthdate)) {
                                                                                                                                                                            echo date('m/d/Y', strtotime($attorney_data->birthdate));
                                                                                                                                                                        } ?>" autocomplete="birthdate" disabled="">
                                @error('birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="admissiondate" class=" col-form-label text-md-left">{{ __('Admission Date') }}</label>
                                <input id="admissiondate" type="text" class="form-control @error('admissiondate') is-invalid @enderror hasDatepicker" name="admissiondate" value="<?php if (isset($attorney_data->admissiondate)) {
                                                                                                                                                                                        echo date('m/d/Y', strtotime($attorney_data->admissiondate));
                                                                                                                                                                                    } ?>" autocomplete="admissiondate" disabled="">
                                @error('admissiondate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label for="howadmitted" class=" col-form-label text-md-left">{{ __('How Admitted') }}</label>
                                <input id="howadmitted" type="text" class="form-control @error('howadmitted') is-invalid @enderror" name="howadmitted" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                    echo $attorney_data->howadmitted;
                                                                                                                                                                } ?>" autocomplete="howadmitted" readonly="">
                                @error('howadmitted')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="firm_name" class=" col-form-label text-md-left">{{ __('Firm Name*') }}</label>
                                <input id="firm_name" type="text" class="form-control @error('firm_name') is-invalid @enderror" name="firm_name" value="<?php if (isset($attorney_data)) {
                                                                                                                                                            echo $attorney_data->firm_name;
                                                                                                                                                        } ?>" required autocomplete="firm_name" autofocus>
                                @error('firm_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="firm_tagline" class=" col-form-label text-md-left">{{ __('Firm Tagline') }}</label>
                                <input id="firm_tagline" type="text" class="form-control @error('firm_tagline') is-invalid @enderror" name="firm_tagline" value="<?php if (isset($attorney_data->firm_tagline) && $attorney_data->firm_tagline != '') {
                                                                                                                                                                        echo $attorney_data->firm_tagline;
                                                                                                                                                                    } ?>">
                                @error('firm_tagline')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="firm_zipcode" class=" col-form-label text-md-left">{{ __('Firm Zip Code*') }}</label>
                                <p class="text-danger no-state-county-found" style="display: none;">No City,
                                    State, County found for this zipcode.</p>
                                <input id="firm_zipcode" type="text" class="form-control @error('firm_zipcode') is-invalid @enderror" name="firm_zipcode" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                        echo $attorney_data->firm_zipcode;
                                                                                                                                                                    } ?>" required autocomplete="firm_zipcode" autofocus>
                                @error('firm_zipcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="firm_state" class=" col-form-label text-md-left">{{ __('Firm State*') }}</label>
                                <input type="hidden" name="firm_state_input" id="firm_state_input" value="<?php if (isset($attorney_data)) {
                                                                                                                echo $attorney_data->state_id;
                                                                                                            } ?>">
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
                                <label for="firm_county" class=" col-form-label text-md-left">{{ __('Firm County*') }}</label>
                                <input type="hidden" name="firm_county_input" id="firm_county_input" value="<?php if (isset($attorney_data)) {
                                                                                                                echo $attorney_data->county_id;
                                                                                                            } ?>">
                                <select id="firm_county" name="firm_county" class="form-control" required>
                                    <option value="">Choose Firm County</option>
                                </select>
                                @error('firm_county')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="firm_city" class=" col-form-label text-md-left">{{ __('Firm City*') }}</label>
                                <input type="hidden" name="firm_city_input" id="firm_city_input" value="<?php if (isset($attorney_data)) {
                                                                                                            echo $attorney_data->firm_city;
                                                                                                        } ?>">
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
                                <label for="firm_street_address" class=" col-form-label text-md-left">{{ __('Firm Street Address*') }}</label>
                                <input id="firm_street_address" type="text" class="form-control @error('firm_street_address') is-invalid @enderror" name="firm_street_address" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                                            echo $attorney_data->firm_street_address;
                                                                                                                                                                                        } ?>" required autocomplete="firm_street_address" autofocus>
                                @error('firm_street_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="firm_suite_unit_mailcode" class=" col-form-label text-md-left">{{ __('Firm Suite/Unit/MailCode') }}</label>
                                <input id="firm_suite_unit_mailcode" type="text" class="form-control @error('firm_suite_unit_mailcode') is-invalid @enderror" name="firm_suite_unit_mailcode" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                                                            echo $attorney_data->firm_suite_unit_mailcode;
                                                                                                                                                                                                        } ?>" autocomplete="firm_suite_unit_mailcode">
                                @error('firm_suite_unit_mailcode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">



                            <div class="col-md-4">
                                <label for="po_box" class=" col-form-label text-md-left">{{ __('PO Box') }}</label>
                                <input id="po_box" type="text" class="form-control @error('po_box') is-invalid @enderror" name="po_box" value="<?php if (isset($attorney_data)) {
                                                                                                                                                    echo $attorney_data->po_box;
                                                                                                                                                } ?>" autocomplete="po_box">
                                @error('po_box')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="col-md-4">
                                <label for="firm_telephone" class=" col-form-label text-md-left">{{ __('Firm Telephone') }}</label>
                                <input id="firm_telephone" maxlength="14" onkeypress="return onlyNumber(event);"  type="text" class="form-control @error('firm_telephone') is-invalid @enderror" name="firm_telephone" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                            echo $attorney_data->firm_telephone;
                                                                                                                                                                        } ?>" autocomplete="firm_telephone" autofocus placeholder="(XXX) XXX-XXXX">
                                @error('firm_telephone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="firm_fax" class=" col-form-label text-md-left">{{ __('Firm Fax') }}</label>
                                <input id="firm_fax"  maxlength="14" type="text" onkeypress="return onlyNumber(event);"  class="form-control @error('firm_fax') is-invalid @enderror" name="firm_fax" value="<?php if (isset($attorney_data)) {
                                                                                                                                                            echo $attorney_data->firm_fax;
                                                                                                                                                        } ?>" placeholder="(XXX) XXX-XXXX">
                                @error('firm_fax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="attorney_reg_1_state_id" class=" col-form-label text-md-left">{{ __('Attorney Reg #1 State*') }}</label>
                                <input type="hidden" name="attorney_reg_1_state_id_input" id="attorney_reg_1_state_id_input" value="<?php if (isset($attorney_data)) {
                                                                                                                                        echo $attorney_data->attorney_reg_1_state_id;
                                                                                                                                    } ?>">
                                <select id="attorney_reg_1_state_id" name="attorney_reg_1_state_id" class="form-control states_select_input" required="" readonly="" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                    <option value="">Choose Attorney Reg #1 State</option>
                                </select>
                                @error('attorney_reg_1_state_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="attorney_reg_1_num" class=" col-form-label text-md-left">{{ __('Attorney Reg #1*') }}</label>
                                <input id="attorney_reg_1_num" type="text" class="form-control @error('attorney_reg_1_num') is-invalid @enderror" name="attorney_reg_1_num" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                                        echo $attorney_data->attorney_reg_1_num;
                                                                                                                                                                                    } ?>" autocomplete="attorney_reg_1_num" autofocus required="" readonly="">
                                @error('attorney_reg_1_num')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <div class="form-check-inline mt-2">
                                    <label for="pro_hac_vice" class=" col-form-label text-md-left">{{ __('Pro Hac Vice') }}</label>
                                    <input id="pro_hac_vice" type="checkbox" class="form-control @error('pro_hac_vice') is-invalid @enderror" name="pro_hac_vice" value="yes" style="width: 15px;" <?php if (isset($attorney_data->pro_vice_hac_num) && $attorney_data->pro_vice_hac_num != '') {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                </div>
                            </div>
                            <?php if (isset($attorney_data->pro_vice_hac_num) && $attorney_data->pro_vice_hac_num != '') { ?>

                                <div class="col-md-4 pro_vice_hac_label">
                                    <label for="pro_vice_hac_num" class=" col-form-label text-md-left pro_vice_hac_label">{{ __('Pro Hac Vice #*') }}</label>
                                    <input id="pro_vice_hac_num" type="text" class="form-control @error('pro_vice_hac_num') is-invalid @enderror" name="pro_vice_hac_num" value="<?php if (isset($attorney_data)) {
                                                                                                                                                                                        echo $attorney_data->pro_vice_hac_num;
                                                                                                                                                                                    } ?>" autocomplete="pro_vice_hac_num">
                                    @error('pro_vice_hac_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            <?php } else { ?>

                                <div class="col-md-4 pro_vice_hac_label" style="display: none;">
                                    <label for="pro_vice_hac_num" class=" col-form-label text-md-left pro_vice_hac_label" style="display: none;">{{ __('Pro Hac Vice #*') }}</label>
                                    <input id="pro_vice_hac_num" type="text" class="form-control @error('pro_vice_hac_num') is-invalid @enderror" name="pro_vice_hac_num" value="" autocomplete="pro_vice_hac_num">
                                    @error('pro_vice_hac_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group row">

                            <div class="col-md-4">
                                <label for="update_source_data" class=" col-form-label text-md-left">{{ __('Update Permanent Data*') }}</label>
                                <div class="form-check-inline">

                                    <input type="radio" id="update_source_data-yes" class="update_source_data-input form-check-input" name="update_source_data" value="Yes" required="">
                                    <label class="form-check-label" for="update_source_data-yes">Yes</label>
                                </div>
                                <div class="form-check-inline">
                                    <input type="radio" id="update_source_data-no" class="update_source_data-input form-check-input" name="update_source_data" value="No" checked="">
                                    <label class="form-check-label" for="update_source_data-no">No</label>
                                </div>

                                @error('update_source_data')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                </div>
                {{-- <!-- <div class="form-group row">
                            <label for="attorney_reg_2_state_id" class=" col-form-label text-md-left">{{ __('Attorney Reg #2 State') }}</label>
                <div class="col-md-4">
                    <input type="hidden" name="attorney_reg_2_state_id_input" id="attorney_reg_2_state_id_input" value="{{ $attorney_data->attorney_reg_2_state_id }}">
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
                    <input id="attorney_reg_2_num" type="text" class="form-control @error('attorney_reg_2_num') is-invalid @enderror" name="attorney_reg_2_num" value="{{ $attorney_data->attorney_reg_2_num }}" autocomplete="attorney_reg_2_num" autofocus>
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
                    <input type="hidden" name="attorney_reg_3_state_id_input" id="attorney_reg_3_state_id_input" value="{{ $attorney_data->attorney_reg_3_state_id }}">
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
                    <input id="attorney_reg_3_num" type="text" class="form-control @error('attorney_reg_3_num') is-invalid @enderror" name="attorney_reg_3_num" value="{{ $attorney_data->attorney_reg_3_num }}" autocomplete="attorney_reg_3_num" autofocus>
                    @error('attorney_reg_3_num')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div> --> --}}
            <div class="form-group row mb-0">
                <div class="col-md-12 text-center p-3">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<script type="text/javascript">
    //cusrso set at  the end of input field
    //          var el = document.getElementById('fname'); 
    //          console.log(el);
    //   el.focus()
    //   if (typeof el.selectionStart == "number") {
    //       el.selectionStart = el.selectionEnd = el.value.length;
    //   } else if (typeof el.createTextRange != "undefined") {           
    //       var range = el.createTextRange();
    //       range.collapse(false);
    //       range.select();
    //   }
    $(document).ready(function() {
        $('#attorney_edit_form').validate({
            rules: {
                firm_telephone: {
                    // phoneUS: true
                    pattern: (/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
                firm_fax: {
                    pattern: (/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
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
        // get counties
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
                    var sel_county = $('#legal_aid_county_input').val();
                    if (sel_county) {
                        $('#legal_aid_county option[value=' + sel_county + ']').attr('selected',
                            'selected');
                    }
                }
            }
        });
        // // get counties by states
        // var firm_state=$('#firm_state_input').val();
        // if(firm_state){
        //     var token= $('input[name=_token]').val();
        //     $.ajax({
        //         url:"{{ route('ajax_get_counties_by_state') }}",
        //         method:"POST",
        //         dataType: 'json',
        //         data:{
        //             id: firm_state, 
        //             _token: token, 
        //         },
        //         success: function(data){
        //             console.log(data);
        //             if(data==null || data=='null'){
        //             } else {
        //                 $('#firm_county').empty();
        //                 $('#firm_county').append('<option value="">Choose Firm County</option>');
        //                 $.each(data, function (key, val) {
        //                     $('#firm_county').append('<option value='+key+'>'+val+'</option>');
        //                 });
        //                 var sel_firm_county=$('#firm_county_input').val();
        //                 if(sel_firm_county){
        //                     $('#firm_county option[value='+sel_firm_county+']').attr('selected','selected');
        //                 }
        //             }
        //         }
        //     });
        // }
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
                    var sel_reg_1_state = $('#attorney_reg_1_state_id_input').val();
                    if (sel_reg_1_state) {
                        $('#attorney_reg_1_state_id option[value=' + sel_reg_1_state + ']').attr(
                            'selected', 'selected');
                    }
                    var sel_reg_2_state = $('#attorney_reg_2_state_id_input').val();
                    if (sel_reg_2_state) {
                        $('#attorney_reg_2_state_id option[value=' + sel_reg_2_state + ']').attr(
                            'selected', 'selected');
                    }
                    var sel_reg_3_state = $('#attorney_reg_3_state_id_input').val();
                    if (sel_reg_3_state) {
                        $('#attorney_reg_3_state_id option[value=' + sel_reg_3_state + ']').attr(
                            'selected', 'selected');
                    }
                }
            }
        });
        // $('#firm_state').on('change', function(){
        //     var id=this.value;
        //     var token= $('input[name=_token]').val();
        //     $.ajax({
        //         url:"{{ route('ajax_get_counties_by_state') }}",
        //         method:"POST",
        //         dataType: 'json',
        //         data:{
        //             id: id, 
        //             _token: token, 
        //         },
        //         success: function(data){
        //             console.log(data);
        //             if(data==null || data=='null'){
        //             } else {
        //                 $('#firm_county').empty();
        //                 $('#firm_county').append('<option value="">Choose Firm County</option>');
        //                 $.each(data, function (key, val) {
        //                     $('#firm_county').append('<option value='+key+'>'+val+'</option>');
        //                 });
        //             }
        //         }
        //     });
        // });
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
        getStateCountyCityByZip();
        // $('#firm_zipcode').on('keyup', function() {
        $('#firm_zipcode').on('input', function() {
            getStateCountyCityByZip();
        });

        function getStateCountyCityByZip() {
            $('.no-state-county-found').hide();
            $('#firm_city').find('option').remove().end().append('<option value="">Choose City</option>');
            $('#firm_state').find('option').remove().end().append('<option value="">Choose State</option>');
            $('#firm_county').find('option').remove().end().append('<option value="">Choose County</option>');
            var zip = $('#firm_zipcode').val();
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
                                $('#firm_city').append('<option value="' + data[key].city +
                                    '">' + data[key].city + '</option>');
                                $('#firm_state').append('<option value="' + data[key]
                                    .state_id + '">' + data[key].state + '</option>');
                                $('#firm_county').append('<option value="' + data[key].id +
                                    '">' + data[key].county_name + '</option>');
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
                            var selected_state = $('#firm_state_input').val();
                            var selected_county = $('#firm_county_input').val();
                            var selected_city = $('#firm_city_input').val();
                            if (selected_state) {
                                $('#firm_state_input option:selected').removeAttr('selected');
                                $('#firm_state option[value="' + selected_state + '"]').attr(
                                    'selected', 'selected');
                                $('#firm_state_input').val("");
                            }
                            if (selected_county) {
                                $('#firm_county_input option:selected').removeAttr('selected');
                                $('#firm_county option[value="' + selected_county + '"]').attr(
                                    'selected', 'selected');
                                $('#firm_county_input').val("");
                            }
                            if (selected_city) {
                                $('#firm_city_input option:selected').removeAttr('selected');
                                $('#firm_city option[value="' + selected_city + '"]').attr(
                                    'selected', 'selected');
                                $('#firm_city_input').val("");
                            }
                        }
                    }
                });
            }
        }
        // on pro hac change
        $('#pro_hac_vice').on('change', function() {
            if (this.checked) {
                $('.pro_vice_hac_label').show();
                // $('.attorney_reg_1_num_label').hide();
                $('#pro_vice_hac_num').prop('required', true);
                // $('#attorney_reg_1_num').prop('required', false);
                // $('#attorney_reg_1_num').val('');
            } else {
                $('.pro_vice_hac_label').hide();
                // $('.attorney_reg_1_num_label').show();
                $('#pro_vice_hac_num').prop('required', false);
                // $('#attorney_reg_1_num').prop('required', true);
                $('#pro_vice_hac_num').val('');
            }
        });
    });
    // prefill from permanent data
    $('#prefill_from_permanent_data').on('change', function() {
        $('#noattorney').hide();
        if ($(this).is(':checked')) {
            var reg_num = $('#attorney_reg_1_num').val();
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
                            //  $('#attorney_reg_1_num').val(data.registrationnumber_state1);
                            $('#attorney_edit_form').trigger("reset");
                            $('#prefill_from_permanent_data').prop('checked', true);
                            $('#attorney_reg_1_num').val(reg_num);
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
                            $('#firm_suite_unit_mailcode').val(data.firm_suite_unit_mailcode);
                            $('#po_box').val(data.po_box);
                            $('#sufname option[value=' + data.sufname + ']').attr('selected',
                                'selected');
                            $('#currentstatus').val(data.currentstatus);
                            $("input[name='gender'][value='" + data.gender + "']").prop('checked',
                                true);
                            $('#attorneytitle').val(data.attorneytitle);
                            $("input[name='insured'][value='" + data.insured + "']").prop('checked',
                                true);
                            $('#admissiondate').val(data.admissiondate);
                            $('#admissiondate').datepicker("setDate", new Date(data.admissiondate));
                            $('#howadmitted').val(data.howadmitted);
                            $('#birthdate').datepicker("setDate", new Date(data.birthdate));
                            $('#firm_tagline').val(data.firm_tagline);
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
                                                    data[key].city + '">' +
                                                    data[key].city +
                                                    '</option>');
                                                $('#firm_state').append(
                                                    '<option value="' +
                                                    data[key].state_id +
                                                    '">' + data[key].state +
                                                    '</option>');
                                                $('#firm_county').append(
                                                    '<option value="' +
                                                    data[key].id + '">' +
                                                    data[key].county_name +
                                                    '</option>');
                                            });
                                            var a = new Array();
                                            $('#firm_city').children("option").each(
                                                function(x) {
                                                    test = false;
                                                    b = a[x] = $(this).val();
                                                    for (i = 0; i < a.length -
                                                        1; i++) {
                                                        if (b == a[i]) test = true;
                                                    }
                                                    if (test) $(this).remove();
                                                })
                                            var a = new Array();
                                            $('#firm_state').children("option").each(
                                                function(x) {
                                                    test = false;
                                                    b = a[x] = $(this).val();
                                                    for (i = 0; i < a.length -
                                                        1; i++) {
                                                        if (b == a[i]) test = true;
                                                    }
                                                    if (test) $(this).remove();
                                                })
                                            var a = new Array();
                                            $('#firm_county').children("option").each(
                                                function(x) {
                                                    test = false;
                                                    b = a[x] = $(this).val();
                                                    for (i = 0; i < a.length -
                                                        1; i++) {
                                                        if (b == a[i]) test = true;
                                                    }
                                                    if (test) $(this).remove();
                                                })
                                            if ($('#firm_city').children('option')
                                                .length == '2') {
                                                $('#firm_city').children('option')
                                                    .first().remove();
                                            }
                                            if ($('#firm_state').children('option')
                                                .length == '2') {
                                                $('#firm_state').children('option')
                                                    .first().remove();
                                            }
                                            if ($('#firm_county').children('option')
                                                .length == '2') {
                                                $('#firm_county').children('option')
                                                    .first().remove();
                                            }
                                            $('#firm_state option[value="' + state_id +
                                                '"]').attr('selected', 'selected');
                                            $('#firm_county option[value="' +
                                                county_id + '"]').attr('selected',
                                                'selected');
                                            $('#firm_city option[value="' + firm_city +
                                                '"]').attr('selected', 'selected');
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            }
        } else {
            location.reload();
        }
    });
      var tele = document.querySelector('#firm_telephone');

tele.addEventListener('keydown', function(e){
 
  if (event.key != 'Backspace' && (tele.value.length === 0 )){
  tele.value += '(';
  }
  if (event.key != 'Backspace' && (tele.value.length === 4 )){
  tele.value += ')';
  }
  if (event.key != 'Backspace' && (tele.value.length === 5 )){
  tele.value += ' ';
  }
  if (event.key != 'Backspace' && (tele.value.length === 9 )){
  tele.value += '-';
  }
});
        var fax = document.querySelector('#firm_fax');
// console.log(fax);
fax.addEventListener('keydown', function(e){
 
  if (event.key != 'Backspace' && (fax.value.length === 0 )){
  fax.value += '(';
  }
  if (event.key != 'Backspace' && (fax.value.length === 4 )){
  fax.value += ')';
  }
  if (event.key != 'Backspace' && (fax.value.length === 5 )){
  fax.value += ' ';
  }
  if (event.key != 'Backspace' && (fax.value.length === 9 )){
  fax.value += '-';
  }
});  
  
</script>
@endsection