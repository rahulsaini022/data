
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center case-registration-steps party-registration-main">
        <div class="col-md-12">
            <?php 
                $client_fullname=$client_data->name;
                $client_fullname = explode(" ", $client_fullname);
                if($client_data->party_group=='top'){
                    if(isset($case_data->top_party_type)){
                        $client_party_type=$case_data->top_party_type;
                    } else {
                        $client_party_type=$case_data->original_top_party_type;
                    }
                } 
                if($client_data->party_group=='bottom'){
                    if(isset($case_data->bottom_party_type)){
                        $client_party_type=$case_data->bottom_party_type;
                    } else {
                        $client_party_type=$case_data->original_bottom_party_type;
                    }
                }

                // for third parties
                if($client_data->party_group=='top_third'){
                    if(isset($case_data->top_party_type)){
                        $client_party_type=$case_data->top_party_type;
                    } else {
                        $client_party_type=$case_data->original_top_party_type;
                    }
                    $client_party_type="Third-Party ".$client_party_type;
                } 
                if($client_data->party_group=='bottom_third'){
                    if(isset($case_data->bottom_party_type)){
                        $client_party_type=$case_data->bottom_party_type;
                    } else {
                        $client_party_type=$case_data->original_bottom_party_type;
                    }
                    $client_party_type="Third-Party ".$client_party_type;
                }
            ?>
            <div class="card">
                <div class="card-header"><strong>Edit {{$client_party_type}} @if($client_party_type !='Petitioner 1' && $client_party_type !='Petitioner 2')(#{{$client_data->number}})@endif Details</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.show_party_reg_form',['case_id' => $client_data->case_id]) }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    
                    <form role="form" id="multistep_case_form" method="POST" action="{{route('cases.update_party',['user_id'=>$client_data->user_id,'case_id'=>$client_data->case_id])}}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="partynum" value="{{$client_data->number}}">
                        <input type="hidden" name="party_group" value="{{$client_data->party_group}}">
                        <input type="hidden" name="initial_party_type" value="{{$client_data->type}}">
                        <div class="row form-group setup-content" id="step-2">
                            <div class="col-md-12">
                                <?php if($client_data->party_group =='top' || $client_data->party_group =='bottom') { ?>
                                <div class="col-md-6">
                                    <label class="col-md-4 col-form-label text-md-left">Party Type*</label>
                                    <div class="col-md-8">
                                        <?php
                                        $style='';
                                            if(isset($already_client) && $already_client=='top' && $client_data->party_group =='bottom'){
                                                $style='display:none';
                                            }

                                            if(isset($already_client) && $already_client=='bottom' && $client_data->party_group =='top'){
                                                $style='display:none';
                                            }

                                        ?>
                                            <input type="radio" id="party_type-client" name="party_type" value="client" required="" <?php if(isset($client_data->type) && $client_data->type=='client'){ echo 'checked'; } ?> style="{{ $style }}">
                                            <label for="party_type-client" style="{{ $style }}">Client</label>
                                        <input type="radio" id="party_type-opponent" name="party_type" value="opponent" <?php if(isset($client_data->type) && $client_data->type=='opponent'){ echo 'checked'; } ?>>
                                        <label for="party_type-opponent">Opponent</label>
                                        <input type="radio" id="party_type-ally" name="party_type" value="ally" <?php if(isset($client_data->type) && $client_data->type=='ally'){ echo 'checked'; } ?>>
                                        <label for="party_type-ally">Ally</label>
                                    </div>
                                </div>
                                <?php } else { ?>
                                    <input type="hidden" name="party_type" value="client">
                                <?php } ?>
                                <div class="col-md-6">
                                    <label class="col-md-4 col-form-label text-md-left">Party Entity*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="individual" name="party_entity" class="party_entity" value="individual" required="" <?php $required=''; if(isset($client_data->party_entity) && $client_data->party_entity=='individual'){ echo 'checked'; $required='required';} ?>>
                                        <label for="individual">Individual</label>
                                        <input type="radio" id="organization_company" class="party_entity" name="party_entity" value="organization_company" <?php if(isset($client_data->party_entity) && $client_data->party_entity=='organization_company'){ echo 'checked'; $required='';} ?>>
                                        <label for="organization_company">Organization/Company</label>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if(isset($client_data->org_comp_name)){ ?>
                                <div class="col-md-12 org_comp_name_main_div">
                            <?php } else { ?>
                                <div class="col-md-12 org_comp_name_main_div" style="display: none;">
                            <?php } ?>
                             <div class="col-md-6 org_comp_name_div">
                                    
                                    <div class="col-md-8">
                                        <label for="org_comp_name" class=" col-form-label text-md-left">Organization/Company Name*</label>
                                        <input type="text" id="org_comp_name" class="form-control" name="org_comp_name" value="<?php if(isset($client_data->org_comp_name)){ echo $client_data->org_comp_name; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 care_of_div">
                                    <label class="col-md-4 col-form-label text-md-left">C/O*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="care_of-atty" name="care_of" value="atty" <?php if(isset($client_data->care_of) && $client_data->care_of=='atty'){ echo 'checked'; } ?>>
                                        <label for="care_of-atty">Atty</label>
                                        <input type="radio" id="care_of-other" name="care_of" value="other" <?php if(isset($client_data->care_of) && $client_data->care_of=='other'){ echo 'checked'; } ?>>
                                        <label for="care_of-other">Other</label>
                                    </div>
                                </div>

                               
                                <div class="col-md-6">
                                </div>
                            </div>

                            <div class="col-md-12 pauperis_div" <?php if(isset($client_data->party_entity) && $client_data->party_entity !='individual'){ echo 'style="display:none"'; }?>>
                                <div class="col-md-6">
                                  <label class="col-md-4 col-form-label text-md-left">In <i>Forma Pauperis</i>*</label>
                                  <div class="col-md-8">
                                      <input type="radio" id="pauperis-Yes" name="pauperis" class="pauperis" value="Yes" <?php if(isset($client_data->pauperis) && $client_data->pauperis =='Yes'){ echo 'checked'; } ?>>
                                      <label for="pauperis-Yes"> Yes</label>
                                      <input type="radio" id="pauperis-No" class="pauperis" name="pauperis" value="No" <?php if(isset($client_data->pauperis) && $client_data->pauperis =='No'){ echo 'checked'; } ?>>
                                      <label for="pauperis-No"> No</label>
                                  </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>

                            <div class="col-md-12 designation-main-div">
                                <div class="col-md-12 designation-num-div">
                                   
                                        
                                            <label class=" col-md-2 col-form-label text-md-left">Designation*</label>
                                        
                                        <div class="col-md-10">
                                        <?php if($client_data->party_group =='top' || $client_data->party_group =='bottom') { ?>
                                            <label style="margin-right: 10px;"for="designation1" class="party-designations">1. <input type="checkbox" id="designation1" class="designation" name="designation1" value="{{$client_party_type}}" style="margin-top: 4px; margin-right: 5px;" checked="" readonly="" onclick="return false;"/><span id="designation1_span">{{$client_party_type}}</span></label>
                                            <label style="margin-right: 10px;"for="designation2" class="party-designations">2. <input type="checkbox" id="designation2" class="designation" name="designation2" value="Cross-claimant" style="margin-top: 4px; margin-right: 5px;" <?php if(isset($client_data->designation2) && $client_data->designation2=='Cross-claimant'){ echo 'checked'; } ?>> Cross-claimant</label>
                                            <label style="margin-right: 10px;"for="designation3" class="party-designations">3. <input type="checkbox" id="designation3" class="designation" name="designation3" value="Cross-claim Defendant" style="margin-top: 4px; margin-right: 5px;" <?php if(isset($client_data->designation3) && $client_data->designation3=='Cross-claim Defendant'){ echo 'checked'; } ?>> Cross-claim Defendant</label>
                                        <?php } ?>
                                        <?php if(isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint=='Yes'){ ?>
                                            <label style="margin-right: 10px;"for="designation4" class="third-party-designations">4. <input type="checkbox" id="designation4" class="designation" name="designation4" value="Third-Party {{$case_data->top_party_type}}" style="margin-top: 4px; margin-right: 5px;" <?php if(isset($client_data->designation4) && $client_data->designation4=='Third-Party '.$case_data->top_party_type){ echo 'checked'; } ?>>Third-Party {{$case_data->top_party_type}}</label>
                                            <label style="margin-right: 10px;"for="designation5" class="third-party-designations">5. <input type="checkbox" id="designation5" class="designation" name="designation5" value="Third-Party {{$case_data->bottom_party_type}}" style="margin-top: 4px; margin-right: 5px;" <?php if(isset($client_data->designation5) && $client_data->designation5=='Third-Party '.$case_data->bottom_party_type){ echo 'checked'; } ?>>Third-Party {{$case_data->bottom_party_type}}</label>
                                        <?php } ?>
                                        </div>
                                  
                                </div>
                            </div>
                            <div class="col-md-12 op_ally_div" <?php if(isset($client_data->type) && $client_data->type=='client'){ echo 'style="display:none"'; } ?>>
                                <div class="col-md-6">
                                    <label class="col-md-4 col-form-label text-md-left">Name Unknown*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="name_unknown-Yes" name="name_unknown" class="name_unknown" value="Yes" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='Yes'){ echo 'checked'; } ?>>
                                        <label for="name_unknown-Yes"> Yes</label>
                                        <input type="radio" id="name_unknown-No" class="name_unknown" name="name_unknown" value="No" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='No'){ echo 'checked'; } ?>>
                                        <label for="name_unknown-No"> No</label>
                                    </div>
                                </div>


                            </div>
                            <div class="col-md-12 name_unknown_div m-0" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='No'){ echo 'style="display:none"'; } ?>>
                                                                <div class="col-md-6 name_unknown_div m-0" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='No'){ echo 'style="display:none"'; } ?>>
                                
                                    <div class="col-md-12  m-0">
                                          <label for="gen_desc" class=" col-form-label text-md-left">Gen Desc</label>
                                      <input id="gen_desc" type="text" class="form-control" name="gen_desc" value="<?php if(isset($client_data->gen_desc)){ echo $client_data->gen_desc; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 row mt-3">
                                     <label class="col-md-5 col-form-label text-md-left">More than one Gen Desc</label>
                                    <div class="col-md-7 m-0">
                                       
                                        <input type="radio" id="is_multi_desc-Yes" name="is_multi_desc" class="is_multi_desc" value="Yes" <?php if(isset($client_data->is_multi_desc) && $client_data->is_multi_desc =='Yes'){ echo 'checked'; } ?>>
                                        <label for="is_multi_desc-Yes"> Yes</label>
                                        <input type="radio" id="is_multi_desc-No" class="is_multi_desc" name="is_multi_desc" value="No" <?php if(isset($client_data->is_multi_desc) && $client_data->is_multi_desc =='No'){ echo 'checked'; } ?>>
                                        <label for="is_multi_desc-No"> No</label>
                                    </div>
                                </div>

                                <div class="col-md-6 more_gen_desc" <?php if(isset($client_data->is_multi_desc) && $client_data->is_multi_desc =='No'){ echo 'style="display:none"'; } ?>>
                                  
                                    <div class="col-md-8">
                                        <label for="more_gen_desc" class=" col-form-label text-md-left">More Gen Desc</label>
                                      <input id="more_gen_desc" type="text" class="form-control" name="more_gen_desc" value="<?php if(isset($client_data->more_gen_desc)){ echo $client_data->more_gen_desc; } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clprefix" class=" col-form-label text-md-left">Prefix</label>
                                        <select id="clprefix" name="clprefix" class="form-control" autofocus="">
                                            <option value="">Choose Prefix Type</option>
                                            <option value="Mr."<?php if(isset($client_data->prefix) && $client_data->prefix=='Mr.'){ echo 'selected'; } ?> >Mr.</option>
                                            <option value="Mrs." <?php if(isset($client_data->prefix) && $client_data->prefix=='Mrs.'){ echo 'selected'; } ?>>Mrs.</option>
                                            <option value="Ms." <?php if(isset($client_data->prefix) && $client_data->prefix=='Ms.'){ echo 'selected'; } ?>>Ms.</option>
                                            <option value="Dr." <?php if(isset($client_data->prefix) && $client_data->prefix=='Dr.'){ echo 'selected'; } ?>>Dr.</option>
                                            <option value="Hon." <?php if(isset($client_data->prefix) && $client_data->prefix=='Hon.'){ echo 'selected'; } ?>>Hon.</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                  
                                    <div class="col-md-12 m-0">
                                          <label for="clfname" class=" col-form-label text-md-left">First Name*</label>
                                        <input id="clfname" type="text" class="form-control" name="clfname" value="<?php if(isset($client_data->fname)){ echo $client_data->fname; } ?>" <?php echo $required;?> autofocus="" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='Yes'){ echo 'readonly'; } ?>>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="col-md-12 m-0">
                                   
                                        <label for="clmname" class=" col-form-label text-md-left">Middle Name</label>
                                        <input id="clmname" type="text" class="form-control " name="clmname" value="<?php if(isset($client_data->mname)){ echo $client_data->mname; } ?>" autofocus="">
                                    </div>
                                </div>
                           
                               
                                <div class="col-md-6">
                                  
                                   <div class="col-md-12 m-0">
                                          <label for="cllname" class=" col-form-label text-md-left">Last Name*</label>
                                        <input id="cllname" type="text" class="form-control" name="cllname" value="<?php if(isset($client_data->lname)){ echo $client_data->lname; } ?>" <?php echo $required;?>  autofocus="" <?php if(isset($client_data->name_unknown) && $client_data->name_unknown =='Yes'){ echo 'readonly'; } ?>>
                                    </div>
                                </div>
                            
                                <div class="col-md-6">
                                   <div class="col-md-12 m-0">
                                         <label for="clemail" class= "col-form-label text-md-left">Email<span id="email_asterisk" <?php if(isset($client_data->type) && $client_data->type !='client'){ echo 'style="display:none;"'; } ?>>*</span></label>
                                   
                                        <?php if(isset($client_data->email) && strpos($client_data->email, 'unknown_'.$client_data->case_id.'_') !== false){ echo '<input type="hidden" name="op_ally_email" value="'.$client_data->email.'">'; } ?>
                                        <input id="clemail" type="email" class="form-control" name="clemail" value="<?php if(isset($client_data->email) && strpos($client_data->email, 'unknown_'.$client_data->case_id.'_') === false){ echo $client_data->email; } ?>" <?php if(isset($client_data->type) && $client_data->type =='client'){ echo "required"; } ?>>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="col-md-12 m-0">
                                    
                                          <label for="clphone" class="col-form-label text-md-left">Telephone</label>
                                        <input id="clphone" maxlength="14" onkeypress="return onlyNumber(event)" type="text" class="form-control has-pattern-one" name="clphone" value="<?php if(isset($client_data->telephone)){ echo $client_data->telephone; } ?>" autofocus="" placeholder="(XXX) XXX-XXXX">
                                  </div>
                                </div>
                            
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clsuffix" class=" col-form-label text-md-left">Suffix</label>
                                        <select id="clsuffix" name="clsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr." <?php if(isset($client_data->suffix) && $client_data->suffix=='Sr.'){ echo 'selected'; } ?>>Sr.</option>
                                            <option value="Jr." <?php if(isset($client_data->suffix) && $client_data->suffix=='Jr.'){ echo 'selected'; } ?>>Jr.</option>
                                            <option value="I" <?php if(isset($client_data->suffix) && $client_data->suffix=='I'){ echo 'selected'; } ?>>I</option>
                                            <option value="II" <?php if(isset($client_data->suffix) && $client_data->suffix=='II'){ echo 'selected'; } ?>>II</option>
                                            <option value="III" <?php if(isset($client_data->suffix) && $client_data->suffix=='III'){ echo 'selected'; } ?>>III</option>
                                            <option value="IV" <?php if(isset($client_data->suffix) && $client_data->suffix=='IV'){ echo 'selected'; } ?>>IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                    <div class="col-md-12 m-0">
                                        <label for="clprefname" class=" col-form-label text-md-left">Preferred Name</label>
                                        <input id="clprefname" type="text" class="form-control" name="clprefname" value="<?php if(isset($client_data->prefname)){ echo $client_data->prefname; } ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         {{-- <label for="short_name" class="     col-form-label text-md-left">{{$client_party_type}} (#{{$client_data->number}}) Short Name for Pleadings/Motions</label> --}}
                                         <label for="short_name" class="     col-form-label text-md-left">{{$client_party_type}} Short Name for Pleadings/Motions</label>
                                        <input id="short_name" type="text" class="form-control" name="short_name" value="<?php if(isset($client_data->short_name)){ echo $client_data->short_name; } ?>">
                                    </div>
                                </div>
                           
                                
                                <?php if(isset($client_data->party_entity) && $client_data->party_entity=='organization_company'){ ?>
                                <div class="col-md-6 cldob-main-div" style="display: none;">
                                <?php } else { ?>    
                                <div class="col-md-6 cldob-main-div">
                                <?php } ?>
                                 
                                    <div class="col-md-12 m-0">
                                           <label for="cldob" class=" col-form-label text-md-left">Date of Birth</label>
                                        <input type="text" class="form-control hasDatepicker" id="cldob"  name="cldob" placeholder="MM/DD/YYYY" max="<?= date('Y-m-d'); ?>" value="<?php if(isset($client_data->date_of_birth)){ echo date("m/d/Y", strtotime($client_data->date_of_birth)); } ?>" autofocus="">
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div mt-3">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clgen-m" class="gender-input" name="clgender" value="M" required="" <?php if(isset($client_data->gender) && $client_data->gender=='M'){ echo 'checked'; } ?>>
                                        <label for="clgen-m">M</label>
                                        <input type="radio" id="clgen-f" class="gender-input" name="clgender" value="F" <?php if(isset($client_data->gender) && $client_data->gender=='F'){ echo 'checked'; } ?>>
                                        <label for="clgen-f">F</label>
                                        <input type="radio" id="clgen-n" class="gender-input" name="clgender" value="N" <?php if(isset($client_data->gender) && $client_data->gender=='N'){ echo 'checked'; } ?>>
                                        <label for="clgen-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-2" style="float: left;display: inline-block;"></div>
                                <?php if(isset($client_data->party_entity) && $client_data->party_entity=='organization_company'){ ?>
                                <div class="col-md-6 clssno_div" style="display: none;">
                                <?php } else { ?>
                                <div class="col-md-6 clssno_div">
                                <?php } ?>
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clssno" class="col-form-label text-md-left">Social Security (Individual) Number</label>
                                        <input type="text" maxlength="11" onkeypress="return onlyNumber(event)" class="form-control has-pattern-two" id="clssno" name="clssno" placeholder="XXX-XX-XXXX" value="<?php if(isset($client_data->social_sec_number)){ echo $client_data->social_sec_number; } ?>" autofocus="">
                                    </div>
                                </div>
                                 @if($hascaseid ==1)
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clssno" class=" col-form-label text-md-left">Relationship to Child(ren)</label>
                                         <select id="relation_id" name="relation" class="form-control" autofocus="" required=""> 
                                            <option>Select Relation</option>                                    
                                            <option value="Mother" <?php if(isset($client_data->relation) && $client_data->relation=='Mother'){ echo 'selected'; }?> >Mother</option>
                                            <option value="Father" <?php if(isset($client_data->relation) && $client_data->relation=='Father'){ echo 'selected'; }?>>Father</option>
                                            <option value="Maternal Grandmother" <?php if(isset($client_data->relation) && $client_data->relation=='Maternal Grandmother'){ echo 'selected'; }?>>Maternal Grandmother</option>
                                            <option value="Maternal Grandfather" <?php if(isset($client_data->relation) && $client_data->relation=='Maternal Grandfather'){ echo 'selected'; }?>>Maternal Grandfather</option>
                                            <option value="Paternal Grandmother" <?php if(isset($client_data->relation) && $client_data->relation=='Paternal Grandmother'){ echo 'selected'; }?>>Paternal Grandmother</option>
                                            <option value="Paternal Grandfather" <?php if(isset($client_data->relation) && $client_data->relation=='Paternal Grandfather'){ echo 'selected'; }?>>Paternal Grandfather</option>
                                            <option value="Maternal Aunt" <?php if(isset($client_data->relation) && $client_data->relation=='Maternal Aunt'){ echo 'selected'; }?>>Maternal Aunt</option>
                                            <option value="Maternal Uncle" <?php if(isset($client_data->relation) && $client_data->relation=='Maternal Uncle'){ echo 'selected'; }?>>Maternal Uncle</option>
                                            <option value="Paternal Aunt" <?php if(isset($client_data->relation) && $client_data->relation=='Paternal Aunt'){ echo 'selected'; }?>>Paternal Aunt</option>
                                            <option value="Paternal Uncle" <?php if(isset($client_data->relation) && $client_data->relation=='Paternal Uncle'){ echo 'selected'; }?>>Paternal Uncle</option>
                                            <option value="Sibling" <?php if(isset($client_data->relation) && $client_data->relation=='Sibling'){ echo 'selected'; }?>>Sibling</option>
                                        </select>  
                                    </div>
                                </div>
                                @endif
                                 <div class="col-md-6 client_relation_other_div" style="margin-top: 20px; display: none;">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="client_relation_other" class="col-form-label text-md-left">Other Relation</label>
                                        <input type="text" class="form-control" id="relation_other" name="other_relation" value=" <?php if(isset($client_data->other_relation) && $client_data->relation=='Sibling'){ echo $client_data->other_relation; }?>" autofocus>
                                        </select>
                                    </div>
                                </div>
                                <?php if(isset($client_data->party_entity) && $client_data->party_entity=='organization_company'){ ?>
                                <div class="col-md-6 employer_identification_div">
                                    <?php } else { ?>
                                <div class="col-md-6 employer_identification_div" style="display: none;">
                                <?php } ?>    
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="employer_identification" class=" col-form-label text-md-left">Employer Identification (Org/Co) Number</label>
                                        <input type="text" class="form-control" id="employer_identification" name="employer_identification" placeholder="XX-XXXXXXX" value="<?php if(isset($client_data->employer_identification)){ echo $client_data->employer_identification; } ?>" autofocus="">
                                    </div>
                                </div>
                            
                                <div class="col-md-6 op_ally_div" <?php if(isset($client_data->type) && $client_data->type=='client'){ echo 'style="display:none"'; } ?>>
                                    <label class="col-md-4 col-form-label text-md-left">Address Unknown*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="address_unknown-Yes" name="address_unknown" class="address_unknown" value="Yes" <?php if(isset($client_data->address_unknown) && $client_data->address_unknown =='Yes'){ echo 'checked'; } ?>>
                                        <label for="address_unknown-Yes"> Yes</label>
                                        <input type="radio" id="address_unknown-No" class="address_unknown" name="address_unknown" value="No" <?php if(isset($client_data->address_unknown) && $client_data->address_unknown =='No'){ echo 'checked'; } ?>>
                                        <label for="address_unknown-No"> No</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clzip" class=" col-form-label text-md-left">ZIP*</label>
                                    <p class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="clzip" name="clzip" value="<?php if(isset($client_data->user_zipcode)){ echo $client_data->user_zipcode; } ?>" autofocus="" required="">
                                    </div>
                                </div>
                           

                                <div class="col-md-6">
                                  
                                    <div class="col-md-12 m-0">
                                          <label for="clstate" class=" col-form-label text-md-left">State*</label>
                                        <input type="hidden" name="selected-state-cl" value="<?php if(isset($client_data->state_id)){ echo $client_data->state_id; } ?>" class="selected-state-cl">
                                        <select id="clstate" name="clstate" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                  
                                    <div class="col-md-12 m-0">
                                          <label for="clcounty" class="col-form-label text-md-left">County*</label>
                                        <input type="hidden" name="selected-county-cl" value="<?php if(isset($client_data->county_id)){ echo $client_data->county_id; } ?>" class="selected-county-cl">
                                        <select id="clcounty" name="clcounty" class="form-control cl-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                </div>

                           
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clcity" class=" col-form-label text-md-left">City*</label>
                                        <input type="hidden" name="selected-city-cl" value="<?php if(isset($client_data->user_city)){ echo $client_data->user_city; } ?>" class="selected-city-cl">
                                        <select id="clcity" name="clcity" class="form-control cl-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    
                                    <div class="col-md-12 m-0">
                                        <label for="clstreetad" class="col-form-label text-md-left">Street Address*</label>
                                        <input type="text" class="form-control" id="clstreetad" name="clstreetad" value="<?php if(isset($client_data->street_address)){ echo $client_data->street_address; } ?>" autofocus="" required="">
                                    </div>
                                </div>
                           
                                <div class="col-md-6">
                                  
                                    <div class="col-md-12 m-0">
                                          <label for="unit" class=" col-form-label text-md-left">Unit</label>
                                        <input id="unit" type="text" class="form-control " name="unit" value="<?php if(isset($client_data->unit)){ echo $client_data->unit; } ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="pobox" class=" col-form-label text-md-left">PO Box</label>
                                        <input id="pobox" type="text" class="form-control" name="pobox" value="<?php if(isset($client_data->pobox)){ echo $client_data->pobox; } ?>">
                                    </div>
                                </div>
   
                                <div class="col-md-6">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="clfax"  class=" col-form-label text-md-left">Fax</label>
                                        <input type="text" maxlength="14" onkeypress="return onlyNumber(event)" class="form-control has-pattern-one" id="clfax" name="clfax" value="<?php if(isset($client_data->fax)){ echo $client_data->fax; } ?>" autofocus="" placeholder="(XXX) XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                    <div class="col-md-12 m-0">
                                        <label for="clprimlang" class=" col-form-label text-md-left">Primary Language*</label>
                                        <input type="hidden" name="selected-lang-cl" value="<?php if(isset($client_data->primary_language)){ echo $client_data->primary_language; } ?>" class="selected-lang-cl" style="display: none;" >
                                        <select id="clprimlang" name="clprimlang" class="form-control languages-select" autofocus="" required="">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 client_primlang_other_div" style="margin-top: 20px; display: none;">
                                   
                                    <div class="col-md-12 m-0">
                                         <label for="client_primlang_other" class=" col-form-label text-md-left">Add Primary Language*</label>
                                        <input type="text" class="form-control" id="client_primlang_other" name="client_primlang_other" value="" autofocus>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Translator*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqlangtrans-y" name="clreqlangtrans" value="Y" required="" <?php if(isset($client_data->req_lang_trans) && $client_data->req_lang_trans=='Y'){ echo 'checked'; } ?>>
                                        <label for="clreqlangtrans-y">Y</label>
                                        <input type="radio" id="clreqlangtrans-n" name="clreqlangtrans" value="N" <?php if(isset($client_data->req_lang_trans) && $client_data->req_lang_trans=='N'){ echo 'checked'; } ?>>
                                        <label for="clreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clhearingimpaired-y" name="clhearingimpaired" value="Y" required="" <?php if(isset($client_data->hearing_impaired) && $client_data->hearing_impaired=='Y'){ echo 'checked'; } ?>>
                                        <label for="clhearingimpaired-y">Y</label>
                                        <input type="radio" id="clhearingimpaired-n" name="clhearingimpaired" value="N" <?php if(isset($client_data->hearing_impaired) && $client_data->hearing_impaired=='N'){ echo 'checked'; } ?>>
                                        <label for="clhearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqsignlang-y" name="clreqsignlang" value="Y" required="" <?php if(isset($client_data->req_sign_lang) && $client_data->req_sign_lang=='Y'){ echo 'checked'; } ?>>
                                        <label for="clreqsignlang-y">Y</label>
                                        <input type="radio" id="clreqsignlang-n" name="clreqsignlang" value="N" <?php if(isset($client_data->req_sign_lang) && $client_data->req_sign_lang=='N'){ echo 'checked'; } ?>>
                                        <label for="clreqsignlang-n">N</label>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-12 text-md-center">
                                <input name="cl_op_case_update" value="Update" class="btn btn-primary nextBtn" type="submit">
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
    $("#clphone").inputmask("(999) 999-9999");
    $("#clssno").inputmask("999-99-9999");
    $("#clfax").inputmask("(999) 999-9999");
     $('input[type=radio][name=clgender]').change(function() {
            if (this.value == 'M') {
                $('#relation_id').each(function() {
                                       
                                            $(this).val('Father').prop("selected", true);
                                        
                                    }); 
            }
           else if (this.value == 'F') {
                $('#relation_id').each(function() {
                   
                     $(this).val('Mother').prop("selected", true);
                    
                });
            }
        });
  

    $('#multistep_case_form').validate({
        rules: {
            clphone: {
                pattern:(/\(?[0-9]{3}\) [0-9]{3}-[0-9]{4}$/)
            },
            clfax: {
                pattern: (/\(?[0-9]{3}\) [0-9]{3}-[0-9]{4}$/)
            },
            clssno: {
                pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
            },
            clemail:{
                pattern:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
            },
            employer_identification: {
                pattern: /[0-9]{2}-[0-9]{7}/
            },
            // opphone: {
            //     pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            // },
            // opfax: {
            //     pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            // },
            // opssno: {
            //     pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
            // },
          
        }
    });

    $(".hasDatepicker").datepicker({
        startDate: "01/01/1901",
        endDate: '+0d',
    });

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });

        // client-opponent selected zip, city, state, county
        var cl=document.getElementById('clzip');
        test(cl);
        // var op=document.getElementById('opzip');
        // test(op);

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
                                $('.no-state-county-cl').hide();
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
      // $('#clzip, #opzip').on('focusout', function() {
      // $('#clzip').on('keyup', function() {
      $('#clzip').on('input', function() {
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
                        $('.no-state-county-cl').hide();
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

        // on party entity change
        $('.party_entity').on('change', function() {
            if(this.value=='organization_company') {
                $('#org_comp_name, #care_of-atty').prop('required', true);
                $('#clfname, #cllname').prop('required', false);
                $('.org_comp_name_main_div').show();
                $('.gender-input').prop('checked', false);
                $('#clgen-n').prop('checked', true);
                $('#cldob').prop('required', false);
                $('.cldob-main-div').hide(); 
                $('.employer_identification_div, .care_of_div').show(); 
                $('.clssno_div').hide();
                if($('#party_type-client').prop("checked") == true){
                    $('.care_of').prop('checked', false);
                    $('#care_of-atty').prop('checked', true);
                } else {
                    $('.care_of').prop('checked', false);
                    $('#care_of-other').prop('checked', true);
                }

                $('.pauperis_div').hide();
                $('input[name="pauperis"]').prop('checked', false);
                $('#pauperis-No').prop('checked', true);

            } else {
                $('#org_comp_name, #care_of-atty').prop('required', false);
                $('#clfname, #cllname').prop('required', true);
                $('.org_comp_name_main_div').hide();
                // $('#cldob').prop('required', true);
                $('.cldob-main-div').show(); 
                $('.employer_identification_div, .care_of_div').hide(); 
                $('.clssno_div').show();   
                $('.care_of').prop('checked', false);

                $('.pauperis_div').show();
            }
        });

        // show party reg form
        $('#clprefix').on('change', function() {
            if(this.value=='Mr.'){
                $('.gender-input').prop('checked', false);
                $('#clgen-m').prop('checked', true);
                $(this).val('Father').prop("selected", true);
            }
            if(this.value=='Mrs.' || this.value=='Ms.'){
                $('.gender-input').prop('checked', false);
                $('#clgen-f').prop('checked', true);
                $(this).val('Mother').prop("selected", true);
            }
        });

        $('input[name="party_type"]').on('change', function() {
            if(this.value=='client'){
                $('.care_of').prop('checked', false);
                $('#care_of-atty').prop('checked', true);
                $('#clemail').prop('required', true);
                $('#email_asterisk').show();

                $('.op_ally_div, .name_unknown_div').hide();
                $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]').prop('checked', false);
                $('#gen_desc, #more_gen_desc').val('');
                $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
            }else{
                $('.care_of').prop('checked', false);
                $('#care_of-other').prop('checked', true);
                $('#clemail').prop('required', false);
                $('#email_asterisk').hide();

                $('.op_ally_div').show();
                $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]').prop('checked', false);
                $('#gen_desc, #more_gen_desc').val('');
                $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                $('.name_unknown_div').hide();
            }
        });

        $('input[name="name_unknown"]').on('change', function() {
            if(this.value=='Yes'){
                $('#clfname, #cllname').prop('readonly', true);
                $('#clfname').val('Name(s)');
                $('#cllname').val('Unknown');
                $('.name_unknown_div').show();
                $('.more_gen_desc').hide();
            }else{
                $('#clfname, #cllname').prop('readonly', false);
                $('#clfname, #cllname, #gen_desc, #more_gen_desc').val('');
                $('.name_unknown_div').hide();
                $('input[name="is_multi_desc"]').prop('checked', false);
                $('#is_multi_desc-No').prop('checked', true);
            }
        });

        $('input[name="is_multi_desc"]').on('change', function() {
            if(this.value=='Yes'){
                $('.more_gen_desc').show();
            }else{
                $('.more_gen_desc').hide();
                $('#more_gen_desc').val('');
            }
        });


        if($('#address_unknown-Yes').is(":checked")){
            $('#clzip, #clstreetad').val('');
            $('#clzip, #clstreetad').prop('readonly', true);
            $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', false);
            $('#clstate, #clcounty, #clcity').empty();
            $('#clstate').append('<option value="">Choose State</option>');
            $('#clcounty').append('<option value="">Choose County</option>');
            $('#clcity').append('<option value="">Choose City</option>');
        }else{
            $('#clzip, #clstreetad').prop('readonly', false);
            $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', true);
        }

        $('input[name="address_unknown"]').on('change', function() {
            if(this.value=='Yes'){
                $('#clzip, #clstreetad').val('');
                $('#clzip, #clstreetad').prop('readonly', true);
                $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', false);
                $('#clstate, #clcounty, #clcity').empty();
                $('#clstate').append('<option value="">Choose State</option>');
                $('#clcounty').append('<option value="">Choose County</option>');
                $('#clcity').append('<option value="">Choose City</option>');
            }else{
                $('#clzip, #clstreetad').prop('readonly', false);
                $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', true);
            }
        });
    
});
//      var tele = document.querySelector('#clphone');

// tele.addEventListener('keydown', function(e){
 
//   if (event.key != 'Backspace' && (tele.value.length === 3 ||  tele.value.length === 7 )){
//   tele.value += '-';
//   }

// });




//         var fax = document.querySelector('#clfax');

// fax.addEventListener('keydown', function(e){
 
//   if (event.key != 'Backspace' && (fax.value.length === 3 ||  fax.value.length === 7 )){
//   fax.value += '-';
//   }
// });        
//         var clssno = document.querySelector('#clssno');
 
// clssno.addEventListener('keydown', function(e){
 

//   if (event.key != 'Backspace' && (clssno.value.length === 3 || clssno.value.length === 6)){
//   clssno.value += '-';
//   }
// });  
</script>    
@endsection