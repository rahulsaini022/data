@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center attorney-registration">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Update Attorney Info
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.show_attorney_reg_form',['party_id' => $party_id, 'case_id' => $case_id, 'number' => $party_number]) }}"> Back</a>

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
                    <?php 
                        $fullname=$attorney->name;
                        $fullname = explode(" ", $fullname);
                    ?>
                    
                    <form method="POST" action="{{route('cases.update_attorney')}}" id="attorney_reg_form">
                        @csrf
                        <input type="hidden" name="attorney_id" value="{{$attorney->id}}">
                        <input type="hidden" name="party_id" value="{{$party_id}}">
                        <input type="hidden" name="case_id" value="{{$case_id}}">
                        <input type="hidden" name="party_number" value="{{$party_number}}">
                        <div class="form-group row">

                            <label for="pro_hac_vice" class="col-md-2 col-form-label text-md-left">{{ __('Pro Hac Vice') }}</label>

                            <div class="col-md-1">
                                <input id="pro_hac_vice" type="checkbox" class="form-control @error('pro_hac_vice') is-invalid @enderror" name="pro_hac_vice" value="yes" style="width: 15px;" <?php if(isset($attorney_data->pro_vice_hac_num) && $attorney_data->pro_vice_hac_num != ''){ echo "checked"; }?>>
                                
                            </div>

                            <label class="col-md-2 col-form-label text-md-left"></label>
                            <div class="col-md-4" id="noattorney" style="display: none;"><span style="color: #e42727;">No attorney data found for this reg number.</span></div>

                        </div>
                        <div class="form-group row">

                            <label for="attorney_reg_1_state_id" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Reg #1 State*') }}</label>

                            <div class="col-md-4">
                                <input type="hidden" name="attorney_reg_1_state_id_input" id="attorney_reg_1_state_id_input" value="{{ $attorney_data->attorney_reg_1_state_id }}">
                                <select id="attorney_reg_1_state_id" name="attorney_reg_1_state_id" class="form-control states_select_input" required="" readonly="" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                    <option value="">Choose Attorney Reg #1 State*</option>
                                </select>

                                @error('attorney_reg_1_state_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="pro_vice_hac_num" class="col-md-2 col-form-label text-md-left pro_vice_hac_label" style="display: none;">{{ __('Pro Hac Vice #*') }}</label>
                            <div class="col-md-4 pro_vice_hac_label" style="display: none;">
                                <input id="pro_vice_hac_num" type="text" class="form-control @error('pro_vice_hac_num') is-invalid @enderror" name="pro_vice_hac_num" value="{{ old('pro_vice_hac_num') }}" autocomplete="pro_vice_hac_num">

                                @error('pro_vice_hac_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="attorney_reg_1_num" class="col-md-2 col-form-label text-md-left attorney_reg_1_num_label">{{ __('Attorney Reg #1*') }}</label>

                            <div class="col-md-4 attorney_reg_1_num_label">
                                <input id="attorney_reg_1_num" type="text" class="form-control @error('attorney_reg_1_num') is-invalid @enderror" name="attorney_reg_1_num" value="{{ $attorney_data->attorney_reg_1_num }}" autocomplete="attorney_reg_1_num" autofocus required="" readonly="">

                                @error('attorney_reg_1_num')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="fname" class="col-md-2 col-form-label text-md-left">{{ __('First Name*') }}</label>

                            <div class="col-md-4">
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="<?php if(isset($fullname[0])){ echo $fullname[0]; } ?>" required autocomplete="fname" autofocus>

                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="mname" class="col-md-2 col-form-label text-md-left">{{ __('Middle Name') }}</label>

                            <div class="col-md-4">
                                <input id="mname" type="text" class="form-control @error('mname') is-invalid @enderror" name="mname" value="{{ $attorney_data->mname }}" autocomplete="mname" autofocus>

                                @error('mname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="lname" class="col-md-2 col-form-label text-md-left">{{ __('Last Name*') }}</label>

                            <div class="col-md-4">
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="<?php if(isset($fullname[1])){ echo $fullname[1]; } ?>" required autocomplete="lname" autofocus>

                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>

                        <div class="form-group row"> -->
                            <label for="document_sign_name" class="col-md-2 col-form-label text-md-left">{{ __('Document Sig/Name*') }}</label>

                            <div class="col-md-4">
                                <input id="document_sign_name" type="text" class="form-control @error('document_sign_name') is-invalid @enderror" name="document_sign_name" value="{{ $attorney_data->document_sign_name }}" required autocomplete="document_sign_name">

                                @error('document_sign_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="sufname" class="col-md-2 col-form-label text-md-left">{{ __('Suffix') }}</label>

                            <div class="col-md-4">
                                <select id="sufname" name="sufname" class="form-control">
                                    <option value="">Choose Suffix Type</option>
                                    <option value="Sr." <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='Sr.'){ echo 'selected'; } ?>>Sr.</option>
                                    <option value="Jr." <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='Jr.'){ echo 'selected'; } ?>>Jr.</option>
                                    <option value="I" <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='I'){ echo 'selected'; } ?>>I</option>
                                    <option value="II" <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='II'){ echo 'selected'; } ?>>II</option>
                                    <option value="III" <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='III'){ echo 'selected'; } ?>>III</option>
                                    <option value="IV" <?php if(isset($attorney_active_data->sufname) && $attorney_active_data->sufname=='IV'){ echo 'selected'; } ?>>IV</option>
                                </select>

                                @error('sufname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        <!-- </div>

                        <div class="form-group row"> -->
                            <label for="gender" class="col-md-2 col-form-label text-md-left">{{ __('Gender') }}</label>

                            <div class="col-md-4">
                                <input type="radio" id="atgen-m" class="gender-input" name="gender" value="M" required="" <?php if(isset($attorney_active_data->gender) && $attorney_active_data->gender=='M'){ echo 'checked'; } ?>>
                                <label for="atgen-m">M</label>
                                <input type="radio" id="atgen-f" class="gender-input" name="gender" value="F" <?php if(isset($attorney_active_data->gender) && $attorney_active_data->gender=='F'){ echo 'checked'; } ?>>
                                <label for="atgen-f">F</label>
                                <input type="radio" id="atgen-n" class="gender-input" name="gender" value="N" <?php if(isset($attorney_active_data->gender) && $attorney_active_data->gender=='N'){ echo 'checked'; } ?>>
                                <label for="atgen-n">N</label>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="attorneytitle" class="col-md-2 col-form-label text-md-left">{{ __('Attorney Title') }}</label>

                            <div class="col-md-4">
                                <input id="attorneytitle" type="text" class="form-control @error('attorneytitle') is-invalid @enderror" name="attorneytitle" value="<?php if(isset($attorney_active_data->attorneytitle) && $attorney_active_data->attorneytitle !=''){ echo $attorney_active_data->attorneytitle; } ?>">

                                @error('attorneytitle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="insured" class="col-md-2 col-form-label text-md-left">{{ __('Has Malpractice Insurance') }}</label>

                            <div class="col-md-4">
                                <input type="radio" id="insured-yes" class="insured-input" name="insured" value="Yes" <?php if(isset($attorney_active_data->insured) && $attorney_active_data->insured=='Yes'){ echo 'checked'; } ?>>
                                <label for="insured-yes">Yes</label>
                                <input type="radio" id="insured-no" class="insured-input" name="insured" value="No" <?php if(isset($attorney_active_data->insured) && $attorney_active_data->insured=='No'){ echo 'checked'; } ?>>
                                <label for="insured-no">No</label>

                                @error('insured')
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
                                        <input id="special_practice_nill" type="radio" class="" name="special_practice" value="Nill" required checked autofocus>
                                        <label for="special_practice_nill" class="col-form-label text-md-left">&nbsp{{ __('N/A') }}</label>
                                    </div>
                                    <div class="col-md-8">    
                                        <input id="special_practice_court" type="radio" class="" name="special_practice" value="court" autofocus>
                                        <label for="special_practice_court" class="col-form-label text-md-left">&nbsp{{ __('Adjudicator/Court Atty') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input id="special_practice_legal_aid" type="radio" class="" name="special_practice" value="legal_aid" autofocus>
                                        <label for="special_practice_legal_aid" class="col-form-label text-md-left">{{ __('Legal Aid') }}</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input id="special_practice_law_school" type="radio" class="" name="special_practice" value="law_school" autofocus>
                                        <label for="special_practice_law_school" class="col-form-label text-md-left">{{ __('Law School Clinic') }}</label>
                                    </div>    
                                </div>
                            </div>    
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="col-form-label special_practice_inputs_label"></label>
                                    </div>
                                    <div class="col-md-8">
                                        <input id="court_text" type="text" class="special_practice_inputs form-control @error('court_text') is-invalid @enderror" name="court_text" value="{{ old('court_text') }}" autocomplete="court_text" placeholder="Enter Court">

                                        @error('court_text')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <select id="legal_aid_county" name="legal_aid_text" class="form-control special_practice_inputs">
                                            <option value="">Choose County</option>
                                        </select>

                                        @error('legal_aid_county')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                        <input id="law_school_text" type="text" class="special_practice_inputs form-control @error('law_school_text') is-invalid @enderror" name="law_school_text" value="{{ old('law_school_text') }}" autocomplete="law_school_text" placeholder="Enter Law School">

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
                            <label for="firm_name" class="col-md-2 col-form-label text-md-left">{{ __('Firm Name*') }}</label>

                            <div class="col-md-4">
                                <input id="firm_name" type="text" class="form-control @error('firm_name') is-invalid @enderror" name="firm_name" value="{{ $attorney_data->firm_name }}" required autocomplete="firm_name" autofocus>

                                @error('firm_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="firm_tagline" class="col-md-2 col-form-label text-md-left">{{ __('Firm Tagline') }}</label>

                            <div class="col-md-4">
                                <input id="firm_tagline" type="text" class="form-control @error('firm_tagline') is-invalid @enderror" name="firm_tagline" value="<?php if(isset($attorney_active_data->firm_tagline) && $attorney_active_data->firm_tagline !=''){ echo $attorney_active_data->firm_tagline; } ?>">

                                @error('firm_tagline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="firm_zipcode" class="col-md-2 col-form-label text-md-left">{{ __('Firm Zip Code*') }}</label>
                            <div class="col-md-4">
                                <p class="text-danger no-state-county-found" style="display: none;">No City, State, County found for this zipcode.</p>
                                <input id="firm_zipcode" type="text" class="form-control @error('firm_zipcode') is-invalid @enderror" name="firm_zipcode" value="{{ $attorney_data->firm_zipcode }}" required autocomplete="firm_zipcode" autofocus>

                                @error('firm_zipcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            

                        </div>

                        <div class="form-group row">


                            <label for="firm_state" class="col-md-2 col-form-label text-md-left">{{ __('Firm State*') }}</label>

                            <div class="col-md-4">
                                <input type="hidden" name="firm_state_input" id="firm_state_input" value="{{ $attorney_data->state_id }}">
                                <select id="firm_state" name="firm_state" class="form-control" required>
                                    <option value="">Choose Firm State</option>
                                </select>

                                @error('firm_state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="firm_county" class="col-md-2 col-form-label text-md-left">{{ __('Firm County*') }}</label>

                            <div class="col-md-4">
                                <input type="hidden" name="firm_county_input" id="firm_county_input" value="{{ $attorney_data->county_id }}">
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

                            <label for="firm_city" class="col-md-2 col-form-label text-md-left">{{ __('Firm City*') }}</label>

                            <div class="col-md-4">
                                <input type="hidden" name="firm_city_input" id="firm_city_input" value="{{ $attorney_data->firm_city }}">
                                <select id="firm_city" name="firm_city" class="form-control" required>
                                    <option value="">Choose Firm City</option>
                                </select>

                                @error('firm_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="firm_street_address" class="col-md-2 col-form-label text-md-left">{{ __('Firm Street Address*') }}</label>

                            <div class="col-md-4">
                                <input id="firm_street_address" type="text" class="form-control @error('firm_street_address') is-invalid @enderror" name="firm_street_address" value="{{ $attorney_data->firm_street_address }}" required autocomplete="firm_street_address" autofocus>

                                @error('firm_street_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            
                            <label for="firm_suite_unit_mailcode" class="col-md-2 col-form-label text-md-left">{{ __('Firm Suite/Unit/MailCode') }}</label>

                            <div class="col-md-4">
                                <input id="firm_suite_unit_mailcode" type="text" class="form-control @error('firm_suite_unit_mailcode') is-invalid @enderror" name="firm_suite_unit_mailcode" value="{{ $attorney_data->firm_suite_unit_mailcode }}" autocomplete="firm_suite_unit_mailcode">

                                @error('firm_suite_unit_mailcode')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="po_box" class="col-md-2 col-form-label text-md-left">{{ __('PO Box') }}</label>

                            <div class="col-md-4">
                                <input id="po_box" type="text" class="form-control @error('po_box') is-invalid @enderror" name="po_box" value="{{ $attorney_data->po_box }}" autocomplete="po_box">

                                @error('po_box')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>

                        <div class="form-group row">

                            <label for="firm_telephone" class="col-md-2 col-form-label text-md-left">{{ __('Firm Telephone') }}</label>

                            <div class="col-md-4">
                                <input id="firm_telephone" type="text" class="form-control @error('firm_telephone') is-invalid @enderror" name="firm_telephone" value="{{ $attorney_data->firm_telephone }}" autocomplete="firm_telephone" placeholder="(XXX) XXX-XXXX">

                                @error('firm_telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="firm_fax" class="col-md-2 col-form-label text-md-left">{{ __('Firm Fax') }}</label>

                            <div class="col-md-4">
                                <input id="firm_fax" type="text" class="form-control @error('firm_fax') is-invalid @enderror" name="firm_fax" value="{{ $attorney_data->firm_fax }}" placeholder="(XXX) XXX-XXXX">

                                @error('firm_fax')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                        </div>

                        <!-- <div class="form-group row">

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

                        </div> -->    

                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-md-center">
                                <button style="display: none;" type="reset" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
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
    $(document).ready(function(){

        $('#attorney_reg_form').validate({
            rules: {
                firm_telephone: {
                    // phoneUS: true
                    // pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
                     pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
                firm_fax: {
                     pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
            }
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        var token= $('input[name=_token]').val();
        var id='35';
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
                        $('#legal_aid_county').append('<option value='+key+'>'+val+'</option>');
                    });
                }   
            }
        });
        $.ajax({
            url:"{{route('ajax_get_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('.states_select_input').append('<option value='+key+'>'+val+'</option>');
                    });
                    $('#attorney_reg_1_state_id option[value=35]').attr('selected','selected');
                }
            }
        });
        
        // on special practice change
        $("input[name='special_practice']").on('change', function(){
            var special_practice=this.value;
            $('.special_practice_inputs').attr('required', false);
            $('.special_practice_inputs').removeClass('active-sp-input');
            $('.special_practice_inputs_label').text('');
            if(special_practice=='legal_aid'){
                $('#legal_aid_county').attr('required', true);
                $('#legal_aid_county').addClass('active-sp-input');
                $('.special_practice_inputs_label').text('County*');
            } else if(special_practice=='law_school'){
                $('#law_school_text').attr('required', true);
                $('#law_school_text').addClass('active-sp-input');
                $('.special_practice_inputs_label').text('Enter Law School*');
            } else if(special_practice=='court'){
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
            var zip=$('#firm_zipcode').val();
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
                            $('.no-state-county-found').show();
                        } else {
                            $('.no-state-county-found').hide();
                            $.each(data, function (key, val) {
                                $('#firm_city').append('<option value="'+data[key].city+'">'+data[key].city+'</option>');
                                $('#firm_state').append('<option value="'+data[key].state_id+'">'+data[key].state+'</option>');
                                $('#firm_county').append('<option value="'+data[key].id+'">'+data[key].county_name+'</option>');
                            });
                            var a = new Array();
                            $('#firm_city').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('#firm_state').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('#firm_county').children("option").each(function(x){
                                test = false;
                                b = a[x] = $(this).val();
                                for (i=0;i<a.length-1;i++){
                                    if (b ==a[i]) test =true;
                                }
                                if (test) $(this).remove();
                            })
                            if($('#firm_city').children('option').length=='2'){
                                $('#firm_city').children('option').first().remove();
                            }
                            if($('#firm_state').children('option').length=='2'){
                                $('#firm_state').children('option').first().remove();
                            }
                            if($('#firm_county').children('option').length=='2'){
                                $('#firm_county').children('option').first().remove();
                            }
                            $('.no-state-county-found').hide();
                            
                            var selected_state=$('#firm_state_input').val();
                            var selected_county=$('#firm_county_input').val();
                            var selected_city=$('#firm_city_input').val();
                            if(selected_state){
                                $('#firm_state_input option:selected').removeAttr('selected');
                                $('#firm_state option[value="'+selected_state+'"]').attr('selected','selected');
                                $('#firm_state_input').val("");
                            }
                            if(selected_county){
                                $('#firm_county_input option:selected').removeAttr('selected');
                                $('#firm_county option[value="'+selected_county+'"]').attr('selected','selected');
                                $('#firm_county_input').val("");
                            }
                            if(selected_city){
                                $('#firm_city_input option:selected').removeAttr('selected');
                                $('#firm_city option[value="'+selected_city+'"]').attr('selected','selected');
                                $('#firm_city_input').val("");
                            }
                        }
                    }
                });        
            }
        }


        // on pro hac change
        $('#pro_hac_vice').on('change', function() {
            if(this.checked){
                $('.pro_vice_hac_label').show();
                $('.attorney_reg_1_num_label').hide();
                $('#pro_vice_hac_num').prop('required', true);
                $('#attorney_reg_1_num').prop('required', false);
                // $('#attorney_reg_1_num').val('');
            } else {
                $('.pro_vice_hac_label').hide();
                $('.attorney_reg_1_num_label').show();
                $('#pro_vice_hac_num').prop('required', false);
                $('#attorney_reg_1_num').prop('required', true);
                $('#pro_vice_hac_num').val('');
            }
        });
    });
</script>
@endsection