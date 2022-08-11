@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_personalinfo_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Personal Info') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.family_law_interview_tabs',$case_id) }}"> Back</a>

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
                    <form role="form" id="dr_personalinfo" method="POST" action="{{route('drpersonalinfo.store')}}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_id}}"> 
                        <!-- Client Personal Info Section -->
                        <div class="row form-group client_info_section">
                            <div class="col-md-12"><h4>{{$client_name}} Info</h4></div>
                            <div class="col-md-6">
                                <label for="Client_Info_Resident_of_Court_State_Since_Date" class="col-form-label text-md-left">Resident of {{$case_info->state_name}} since</label>
                                <input id="Client_Info_Resident_of_Court_State_Since_Date" type="text" class="form-control hasDatepicker" name="Client_Info_Resident_of_Court_State_Since_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Resident_of_Court_County_Since_Date" class="col-form-label text-md-left">Resident of {{$case_info->county_name}} County since</label>
                                <input id="Client_Info_Resident_of_Court_County_Since_Date" type="text" class="form-control hasDatepicker" name="Client_Info_Resident_of_Court_County_Since_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Number_Adults_Living_With" class="col-form-label text-md-left">Number of adults living with {{$client_name}}</label>
                                <input id="Client_Info_Number_Adults_Living_With" type="number" class="form-control" name="Client_Info_Number_Adults_Living_With" value="" min="0"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Maiden_Name" class="col-form-label text-md-left">Full Maiden Name</label>
                                <input id="Client_Info_Maiden_Name" type="text" class="form-control" name="Client_Info_Maiden_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Currently pregnant? </label><br>
                                <label for="Client_Info_Currently_Pregnant_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Currently_Pregnant_Yes" type="checkbox" name="Client_Info_Currently_Pregnant" value="1" onchange="showHideDiv(this, 'Client_Info_Due_Date');"> Check if currently pregnant
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_Due_Date_Div" style="display: none;">
                                <label for="Client_Info_Due_Date" class="col-form-label text-md-left">Due Date*</label>
                                <input id="Client_Info_Due_Date" type="text" class="form-control due_date" name="Client_Info_Due_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Want Former Name Restored? </label><br>
                                <label for="Client_Info_Restore_Former_Name_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Restore_Former_Name_Yes" type="checkbox" name="Client_Info_Restore_Former_Name" value="1" onchange="showHideDiv(this, 'Client_Info_Former_Name');"> Check to Restore Former Name
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_Former_Name_Div" style="display: none;">
                                <label for="Client_Info_Former_Name" class="col-form-label text-md-left">Former Name to Restore*</label>
                                <input id="Client_Info_Former_Name" type="text" class="form-control" name="Client_Info_Former_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Birthplace_City" class="col-form-label text-md-left">Birthplace City</label>
                                <input id="Client_Info_Birthplace_City" type="text" class="form-control" name="Client_Info_Birthplace_City" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Birthplace_State" class="col-form-label text-md-left">Birthplace State</label>
                                <input id="Client_Info_Birthplace_State" type="text" class="form-control" name="Client_Info_Birthplace_State" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Active Duty Military? </label><br>
                                <label for="Client_Info_Active_Military" class="col-md-12 radio-label">
                                    <input id="Client_Info_Active_Military" type="checkbox" name="Client_Info_Active_Military" value="1" data-onload="onMilitaryChange(this, 'Client');"  onchange="onMilitaryChange(this, 'Client');" <?php if(isset($drcaseoverview->Client_Info_Active_Military) && $drcaseoverview->Client_Info_Active_Military=='1'){ echo "checked"; } ?>> Check if Active Duty Military or Spouse/Dependant of Active Duty Military
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_Active_Military_Div" style="display: none;">
                                <label for="Client_Branch" class="col-form-label text-md-left">Which branch of the Military?</label>
                                <select id="Client_Branch" name="Client_Branch" class="form-control Client_Info_Active_Military_Input">
                                    <option value="Air Force" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Air Force'){ echo "selected"; } ?>>Air Force</option>
                                    <option value="Air Force Reserves" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Air Force Reserves'){ echo "selected"; } ?>>Air Force Reserves</option>
                                    <option value="Air National Guard" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                    <option value="Army" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Army'){ echo "selected"; } ?>>Army</option>
                                    <option value="Army Reserves" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Army Reserves'){ echo "selected"; } ?>>Army Reserves</option>
                                    <option value="Army National Guard" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Army National Guard'){ echo "selected"; } ?>>Army National Guard</option>
                                    <option value="Navy" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Navy'){ echo "selected"; } ?>>Navy</option>
                                    <option value="Navy Reserves" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Navy Reserves'){ echo "selected"; } ?>>Navy Reserves</option>
                                    <option value="Marine Corps" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Marine Corps'){ echo "selected"; } ?>>Marine Corps</option>
                                    <option value="Marine Corps Reserve" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Marine Corps Reserve'){ echo "selected"; } ?>>Marine Corps Reserve</option>
                                    <option value="Coast Guard" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Coast Guard'){ echo "selected"; } ?>>Coast Guard</option>
                                    <option value="Coast Guard Reserves" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Coast Guard Reserves'){ echo "selected"; } ?>>Coast Guard Reserves</option>
                                    <option value="Air National Guard" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                    <option value="Commissioned Officer of NOAA" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Commissioned Officer of NOAA'){ echo "selected"; } ?>>Commissioned Officer of NOAA</option>
                                    <option value="Commissioned Officer of PHS" <?php if(isset($drcaseoverview->Client_Branch) && $drcaseoverview->Client_Branch=='Commissioned Officer of PHS'){ echo "selected"; } ?>>Commissioned Officer of PHS</option>
                                </select> 
                            </div>
                            <div class="col-md-6 Client_Info_Active_Military_Div" style="display: none;">
                                <label class="col-form-label text-md-left">Does Active Duty Prevent {{$client_name}} from Participating? </label><br>
                                <label for="SCRA_Prevents_Client" class="col-md-12 radio-label">
                                    <input id="SCRA_Prevents_Client" type="checkbox" name="SCRA_Prevents_Client" value="1" class="Client_Info_Active_Military_Input" data-onload="preventPartyChange(this, 'Client');" onchange="preventPartyChange(this, 'Client');" <?php if(isset($drcaseoverview->SCRA_Prevents_Client) && $drcaseoverview->SCRA_Prevents_Client=='1'){ echo "checked"; } ?>> Check if Active Duty Prevent {{$client_name}} from Participating
                                </label>
                                <label class="Client_Possible_SCRA_Issues_Label" style="display: none;color:red;">Possible SCRA Issues </label>
                            </div>
                            <div class="col-md-6 Client_Info_Active_Military_Div SCRA_Prevents_Client_Div" style="display: none;">
                                <label class="col-form-label text-md-left">Does Active Duty {{$client_name}} Waive SCRA Rights? </label><br>
                                <label for="Client_Waive_SCRA_Rights" class="col-md-12 radio-label">
                                    <input id="Client_Waive_SCRA_Rights" type="checkbox" name="Client_Waive_SCRA_Rights" value="1" class="Client_Info_Active_Military_Input SCRA_Prevents_Client_Input" <?php if(isset($drcaseoverview->Client_Waive_SCRA_Rights) && $drcaseoverview->Client_Waive_SCRA_Rights=='1'){ echo "checked"; } ?> data-onload="onWaiveSCRARightsChange(this, 'Client');" onchange="onWaiveSCRARightsChange(this, 'Client');"> Check if Active Duty {{$client_name}} Waives SCRA Rights
                                </label>
                            </div>
                            <div class="col-md-6 Client_Possible_SCRA_Issues_Div" style="display: none;">
                                
                                <label for="Client_Possible_SCRA_Issues" class="col-md-12 radio-label" style="display: none;">
                                    <input id="Client_Possible_SCRA_Issues" type="checkbox" name="Client_Possible_SCRA_Issues" value="1" class="Client_Info_Active_Military_Input SCRA_Prevents_Client_Input Client_Possible_SCRA_Issues_Input" <?php if(isset($drcaseoverview->Client_Possible_SCRA_Issues) && $drcaseoverview->Client_Possible_SCRA_Issues=='1'){ echo "checked"; } ?>> Check if Active Duty {{$client_name}} Waive SCRA Rights
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label for="Client_Info_Last_Elementary_School_Name" class="col-form-label text-md-left">Last Elementary School Name</label>
                                <input id="Client_Info_Last_Elementary_School_Name" type="text" class="form-control" name="Client_Info_Last_Elementary_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_Elementary" class="col-form-label text-md-left">Years Completed (Elementary School)?</label>
                                <select id="Client_Info_Years_Completed_Elementary" name="Client_Info_Years_Completed_Elementary" class="form-control">
                                    <option value="0" selected="">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Last_Middle_School_Name" class="col-form-label text-md-left">Last Middle/Junior High School Name</label>
                                <input id="Client_Info_Last_Middle_School_Name" type="text" class="form-control" name="Client_Info_Last_Middle_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_Middle_School" class="col-form-label text-md-left">Years Completed (Middle/Junior High School)?</label>
                                <select id="Client_Info_Years_Completed_Middle_School" name="Client_Info_Years_Completed_Middle_School" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Last_High_School_Name" class="col-form-label text-md-left">Last High School Name</label>
                                <input id="Client_Info_Last_High_School_Name" type="text" class="form-control" name="Client_Info_Last_High_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_High_School" class="col-form-label text-md-left">Years Completed (High School)?</label>
                                <select id="Client_Info_Years_Completed_High_School" name="Client_Info_Years_Completed_High_School" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Received Diploma or GED? </label><br>
                                <label for="Client_Info_High_School_Diploma_or_GED_High_School_Diploma" class="col-md-5 radio-label">High School Diploma
                                    <input id="Client_Info_High_School_Diploma_or_GED_High_School_Diploma" type="radio" name="Client_Info_High_School_Diploma_or_GED" value="High School Diploma"  checked="">
                                </label>
                                <label for="Client_Info_High_School_Diploma_or_GED_GED" class="col-md-2 radio-label">GED
                                    <input id="Client_Info_High_School_Diploma_or_GED_GED" type="radio" name="Client_Info_High_School_Diploma_or_GED" value="GED"> 
                                </label>
                                <label for="Client_Info_High_School_Diploma_or_GED_N/A" class="col-md-2 radio-label">N/A
                                    <input id="Client_Info_High_School_Diploma_or_GED_N/A" type="radio" name="Client_Info_High_School_Diploma_or_GED" value="N/A"> 
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_College1_Name" class="col-form-label text-md-left">College 1 Name</label>
                                <input id="Client_Info_College1_Name" type="text" class="form-control" name="Client_Info_College1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_College1" class="col-form-label text-md-left">Years completed at College 1</label>
                                <select id="Client_Info_Years_Completed_College1" name="Client_Info_Years_Completed_College1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_College1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_College1_Degree_Awarded_Yes" type="checkbox" name="Client_Info_College1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_College1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_College1_Degree_Div" style="display: none;">
                                <label for="Client_Info_College1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_College1_Degree" type="text" class="form-control" name="Client_Info_College1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_College2_Name" class="col-form-label text-md-left">College 2 Name</label>
                                <input id="Client_Info_College2_Name" type="text" class="form-control" name="Client_Info_College2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_College2" class="col-form-label text-md-left">Years completed at College 2</label>
                                <select id="Client_Info_Years_Completed_College2" name="Client_Info_Years_Completed_College2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_College2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_College2_Degree_Awarded_Yes" type="checkbox" name="Client_Info_College2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_College2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_College2_Degree_Div" style="display: none;">
                                <label for="Client_Info_College2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_College2_Degree" type="text" class="form-control" name="Client_Info_College2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Grad_School1_Name" class="col-form-label text-md-left">Grad School 1 Name</label>
                                <input id="Client_Info_Grad_School1_Name" type="text" class="form-control" name="Client_Info_Grad_School1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_Grad_School1" class="col-form-label text-md-left">Years completed at Grad School 1</label>
                                <select id="Client_Info_Years_Completed_Grad_School1" name="Client_Info_Years_Completed_Grad_School1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_GradSchool1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_GradSchool1_Degree_Awarded_Yes" type="checkbox" name="Client_Info_GradSchool1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_Grad_School1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_Grad_School1_Degree_Div" style="display: none;">
                                <label for="Client_Info_Grad_School1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_Grad_School1_Degree" type="text" class="form-control" name="Client_Info_Grad_School1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Grad_School2_Name" class="col-form-label text-md-left">Grad School 2 Name</label>
                                <input id="Client_Info_Grad_School2_Name" type="text" class="form-control" name="Client_Info_Grad_School2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_Grad_School2" class="col-form-label text-md-left">Years completed at Grad School 2</label>
                                <select id="Client_Info_Years_Completed_Grad_School2" name="Client_Info_Years_Completed_Grad_School2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_GradSchool2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_GradSchool2_Degree_Awarded_Yes" type="checkbox" name="Client_Info_GradSchool2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_Grad_School2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_Grad_School2_Degree_Div" style="display: none;">
                                <label for="Client_Info_Grad_School2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_Grad_School2_Degree" type="text" class="form-control" name="Client_Info_Grad_School2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_TechPro_School1_Name" class="col-form-label text-md-left">Technical/Professional School 1 Name</label>
                                <input id="Client_Info_TechPro_School1_Name" type="text" class="form-control" name="Client_Info_TechPro_School1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_TechPro_School1" class="col-form-label text-md-left">Years Completed at Technical/Professional School 1</label>
                                <select id="Client_Info_Years_Completed_TechPro_School1" name="Client_Info_Years_Completed_TechPro_School1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_TechPro_School1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_TechPro_School1_Degree_Awarded_Yes" type="checkbox" name="Client_Info_TechPro_School1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_TechPro_School1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_TechPro_School1_Degree_Div" style="display: none;">
                                <label for="Client_Info_TechPro_School1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_TechPro_School1_Degree" type="text" class="form-control" name="Client_Info_TechPro_School1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_TechPro_School2_Name" class="col-form-label text-md-left">Technical/Professional School 2 Name</label>
                                <input id="Client_Info_TechPro_School2_Name" type="text" class="form-control" name="Client_Info_TechPro_School2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Years_Completed_TechPro_School2" class="col-form-label text-md-left">Years Completed at Technical/Professional School 2</label>
                                <select id="Client_Info_Years_Completed_TechPro_School2" name="Client_Info_Years_Completed_TechPro_School2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Client_Info_TechPro_School2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_TechPro_School2_Degree_Awarded_Yes" type="checkbox" name="Client_Info_TechPro_School2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Client_Info_TechPro_School2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Client_Info_TechPro_School2_Degree_Div" style="display: none;">
                                <label for="Client_Info_TechPro_School2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Client_Info_TechPro_School2_Degree" type="text" class="form-control" name="Client_Info_TechPro_School2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Currently Retired? </label><br>
                                <label for="Client_Info_Retired_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Retired_Y_N_Yes" type="checkbox" name="Client_Info_Retired_Y_N" value="1"> Check if you’re currently Retired
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receive Public Assistance? </label><br>
                                <label for="Client_Info_Public_Assistance_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Public_Assistance_Y_N_Yes" type="checkbox" name="Client_Info_Public_Assistance_Y_N" value="1"> Check if you receive Public Assistance
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Have  Pending Public Assistance Application? </label><br>
                                <label for="Client_Info_Public_Assistance_App_Pending_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Public_Assistance_App_Pending_Y_N_Yes" type="checkbox" name="Client_Info_Public_Assistance_App_Pending_Y_N" value="1"> Check if you have a  Pending Public Assistance Application
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Father_Name" class="col-form-label text-md-left">Father’s Full Name</label>
                                <input id="Client_Info_Father_Name" type="text" class="form-control" name="Client_Info_Father_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Father_Address" class="col-form-label text-md-left">Father’s Address</label>
                                <input id="Client_Info_Father_Address" type="text" class="form-control" name="Client_Info_Father_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Father Deceased? </label><br>
                                <label for="Client_Info_Father_Deceased_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Father_Deceased_Y_N_Yes" type="checkbox" name="Client_Info_Father_Deceased_Y_N" value="1"> Check if your Father is deceased?
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Mother_Name" class="col-form-label text-md-left">Mother‘s Full Name</label>
                                <input id="Client_Info_Mother_Name" type="text" class="form-control" name="Client_Info_Mother_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Mother_Address" class="col-form-label text-md-left">Mother’s Address</label>
                                <input id="Client_Info_Mother_Address" type="text" class="form-control" name="Client_Info_Mother_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Mother Deceased? </label><br>
                                <label for="Client_Info_Mother_Deceased_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Mother_Deceased_Y_N_Yes" type="checkbox" name="Client_Info_Mother_Deceased_Y_N" value="1"> Check if your Mother is deceased?
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Closest_Friend_or_Relative_Full_Name" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Full Name</label>
                                <input id="Client_Info_Closest_Friend_or_Relative_Full_Name" type="text" class="form-control" name="Client_Info_Closest_Friend_or_Relative_Full_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Closest_Friend_or_Relative_Phone_Number" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Phone Number</label>
                                <input id="Client_Info_Closest_Friend_or_Relative_Phone_Number" type="text" class="form-control" name="Client_Info_Closest_Friend_or_Relative_Phone_Number" value="" placeholder="(XXX) XXX-XXXX"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Closest_Friend_or_Relative_Full_Address" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Full Address</label>
                                <input id="Client_Info_Closest_Friend_or_Relative_Full_Address" type="text" class="form-control" name="Client_Info_Closest_Friend_or_Relative_Full_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Height" class="col-form-label text-md-left">Height</label>
                                <select id="Client_Info_Height" name="Client_Info_Height" class="form-control">
                                    <option value="4’ 6”">4’ 6”</option>
                                    <option value="4’ 7”">4’ 7”</option>
                                    <option value="4’ 8”">4’ 8”</option>
                                    <option value="4’ 9”">4’ 9”</option>
                                    <option value="5’ 0”">5’ 0”</option>
                                    <option value="5’ 1”">5’ 1”</option>
                                    <option value="5’ 2”">5’ 2”</option>
                                    <option value="5’ 3”">5’ 3”</option>
                                    <option value="5’ 4”">5’ 4”</option>
                                    <option value="5’ 5”">5’ 5”</option>
                                    <option value="5’ 6”">5’ 6”</option>
                                    <option value="5’ 7”">5’ 7”</option>
                                    <option value="5’ 8”">5’ 8”</option>
                                    <option value="5’ 9”">5’ 9”</option>
                                    <option value="6’ 0”" selected="">6’ 0”</option>
                                    <option value="6’ 1”">6’ 1”</option>
                                    <option value="6’ 2”">6’ 2”</option>
                                    <option value="6’ 3”">6’ 3”</option>
                                    <option value="6’ 4”">6’ 4”</option>
                                    <option value="6’ 5”">6’ 5”</option>
                                    <option value="6’ 6”">6’ 6”</option>
                                    <option value="6’ 7”">6’ 7”</option>
                                    <option value="6’ 8”">6’ 8”</option>
                                    <option value="6’ 9”">6’ 9”</option>
                                    <option value="7’ 0”">7’ 0”</option>
                                    <option value="7’ 1”">7’ 1”</option>
                                    <option value="7’ 2”">7’ 2”</option>
                                    <option value="7’ 3”">7’ 3”</option>
                                    <option value="7’ 4”">7’ 4”</option>
                                    <option value="7’ 5”">7’ 5”</option>
                                    <option value="7’ 6”">7’ 6”</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Weight" class="col-form-label text-md-left">Weight</label>
                                <input id="Client_Info_Weight" type="text" class="form-control" name="Client_Info_Weight" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Hair_Color" class="col-form-label text-md-left">Hair Color</label>
                                <select id="Client_Info_Hair_Color" name="Client_Info_Hair_Color" class="form-control">
                                    <option value="Black">Black</option>
                                    <option value="Blond">Blond</option>
                                    <option value="Brown">Brown</option>
                                    <option value="Grey/White">Grey/White</option>
                                    <option value="Red">Red</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Client_Info_Eye_Color" class="col-form-label text-md-left">Eye Color</label>
                                <select id="Client_Info_Eye_Color" name="Client_Info_Eye_Color" class="form-control">
                                    <option value="Amber">Amber</option>
                                    <option value="Blue">Blue</option>
                                    <option value="Gray">Gray</option>
                                    <option value="Green">Green</option>
                                    <option value="Hazel">Hazel</option>
                                    <option value="Red">Red</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Race </label><br>
                                <label for="Client_Info_Race_W_B_A_O_W" class="col-md-3 radio-label">White
                                    <input id="Client_Info_Race_W_B_A_O_W" type="radio" name="Client_Info_Race_W_B_A_O" value="White">
                                </label>
                                <label for="Client_Info_Race_W_B_A_O_B" class="col-md-3 radio-label">Black
                                    <input id="Client_Info_Race_W_B_A_O_B" type="radio" name="Client_Info_Race_W_B_A_O" value="Black">
                                </label>
                                <label for="Client_Info_Race_W_B_A_O_A" class="col-md-3 radio-label">Asian
                                    <input id="Client_Info_Race_W_B_A_O_A" type="radio" name="Client_Info_Race_W_B_A_O" value="Asian">
                                </label>
                                <label for="Client_Info_Race_W_B_A_O_O" class="col-md-3 radio-label">Other
                                    <input id="Client_Info_Race_W_B_A_O_O" type="radio" name="Client_Info_Race_W_B_A_O" value="Other" checked="">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Divorced Prior to This Marriage? </label><br>
                                <label for="Client_Divorced_Prior_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Divorced_Prior_Yes" type="checkbox" name="Client_Divorced_Prior" value="1"> Check if you were Divorced prior to this Marriage?
                                </label>
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Date1" class="col-form-label text-md-left">First Prior Divorce Date*</label>
                                <input id="Client_Info_Prior_Divorce_Date1" type="text" class="form-control hasDatepicker Client_Divorced_Prior_First_Inputs" name="Client_Info_Prior_Divorce_Date1" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Case_Num1" class="col-form-label text-md-left">First Prior Divorce Case Number*</label>
                                <input id="Client_Info_Prior_Divorce_Case_Num1" type="text" class="form-control Client_Divorced_Prior_First_Inputs" name="Client_Info_Prior_Divorce_Case_Num1" value=""> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce1_Support_PAID" class="col-form-label text-md-left">First Prior Divorce Monthly Spousal Support PAID*</label>
                                <input id="Client_Info_Prior_Divorce1_Support_PAID" type="number" class="form-control Client_Divorced_Prior_First_Inputs" name="Client_Info_Prior_Divorce1_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce1_Support_RECEIVED" class="col-form-label text-md-left">First Prior Divorce Monthly Spousal Support RECEIVED*</label>
                                <input id="Client_Info_Prior_Divorce1_Support_RECEIVED" type="number" class="form-control Client_Divorced_Prior_First_Inputs" name="Client_Info_Prior_Divorce1_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Place1" class="col-form-label text-md-left">First Prior Divorce City, State*</label>
                                <input id="Client_Info_Prior_Divorce_Place1" type="text" class="form-control  Client_Divorced_Prior_First_Inputs" name="Client_Info_Prior_Divorce_Place1" value=""> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Date2" class="col-form-label text-md-left">Second Prior Divorce Date</label>
                                <input id="Client_Info_Prior_Divorce_Date2" type="text" class="form-control hasDatepicker Client_Divorced_Prior_Second_Inputs" name="Client_Info_Prior_Divorce_Date2" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Case_Num2" class="col-form-label text-md-left">Second Prior Divorce Case Number</label>
                                <input id="Client_Info_Prior_Divorce_Case_Num2" type="text" class="form-control Client_Divorced_Prior_Second_Inputs" name="Client_Info_Prior_Divorce_Case_Num2" value=""> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce2_Support_PAID" class="col-form-label text-md-left">Second Prior Divorce Monthly Spousal Support PAID</label>
                                <input id="Client_Info_Prior_Divorce2_Support_PAID" type="number" class="form-control Client_Divorced_Prior_Second_Inputs" name="Client_Info_Prior_Divorce2_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce2_Support_RECEIVED" class="col-form-label text-md-left">Second Prior Divorce Monthly Spousal Support RECEIVED</label>
                                <input id="Client_Info_Prior_Divorce2_Support_RECEIVED" type="number" class="form-control Client_Divorced_Prior_Second_Inputs" name="Client_Info_Prior_Divorce2_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Client_Divorced_Prior_Div" style="display:none;">
                                <label for="Client_Info_Prior_Divorce_Place2" class="col-form-label text-md-left">Second Prior Divorce City, State</label>
                                <input id="Client_Info_Prior_Divorce_Place2" type="text" class="form-control Client_Divorced_Prior_Second_Inputs" name="Client_Info_Prior_Divorce_Place2" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receiving Public Assistance Cash Grant? </label><br>
                                <label for="Client_Info_Public_Assistance_Cash_Grant_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Public_Assistance_Cash_Grant_Y_N_Yes" type="checkbox" name="Client_Info_Public_Assistance_Cash_Grant_Y_N" value="1"> Check if you receiving Public Assistance Cash Grant
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receiving Public Assistance Medical? </label><br>
                                <label for="Client_Info_Public_Assistance_Medical_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Client_Info_Public_Assistance_Medical_Y_N_Yes" type="checkbox" name="Client_Info_Public_Assistance_Medical_Y_N" value="1"> Check if you receive Public Assistance Medical
                                </label>
                            </div>
                        </div>
                        <!-- End of Client Personal Info Section -->

                        <!-- Opponent Personal Info Section -->
                        <div class="row form-group opponent_info_section">
                            <div class="col-md-12"><h4>{{$opponent_name}} Info</h4></div>
                            <div class="col-md-6">
                                <label for="Op_Info_Resident_of_Court_State_Since_Date" class="col-form-label text-md-left">Resident of {{$case_info->state_name}} since</label>
                                <input id="Op_Info_Resident_of_Court_State_Since_Date" type="text" class="form-control hasDatepicker" name="Op_Info_Resident_of_Court_State_Since_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Resident_of_Court_County_Since_Date" class="col-form-label text-md-left">Resident of {{$case_info->county_name}} County since</label>
                                <input id="Op_Info_Resident_of_Court_County_Since_Date" type="text" class="form-control hasDatepicker" name="Op_Info_Resident_of_Court_County_Since_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Number_Adults_Living_With" class="col-form-label text-md-left">Number of adults living with {{$opponent_name}}</label>
                                <input id="Op_Info_Number_Adults_Living_With" type="number" class="form-control" name="Op_Info_Number_Adults_Living_With" value="" min="0"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Maiden_Name" class="col-form-label text-md-left">Full Maiden Name</label>
                                <input id="Op_Info_Maiden_Name" type="text" class="form-control" name="Op_Info_Maiden_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Currently pregnant? </label><br>
                                <label for="Op_Info_Currently_Pregnant_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Currently_Pregnant_Yes" type="checkbox" name="Op_Info_Currently_Pregnant" value="1" onchange="showHideDiv(this, 'Op_Info_Due_Date');"> Check if currently pregnant
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_Due_Date_Div" style="display: none;">
                                <label for="Op_Info_Due_Date" class="col-form-label text-md-left">Due Date*</label>
                                <input id="Op_Info_Due_Date" type="text" class="form-control due_date" name="Op_Info_Due_Date" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Want Former Name Restored? </label><br>
                                <label for="Op_Info_Restore_Former_Name_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Restore_Former_Name_Yes" type="checkbox" name="Op_Info_Restore_Former_Name" value="1" onchange="showHideDiv(this, 'Op_Info_Former_Name');"> Check to Restore Former Name
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_Former_Name_Div" style="display: none;">
                                <label for="Op_Info_Former_Name" class="col-form-label text-md-left">Former Name to Restore*</label>
                                <input id="Op_Info_Former_Name" type="text" class="form-control" name="Op_Info_Former_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Birthplace_City" class="col-form-label text-md-left">Birthplace City</label>
                                <input id="Op_Info_Birthplace_City" type="text" class="form-control" name="Op_Info_Birthplace_City" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Birthplace_State" class="col-form-label text-md-left">Birthplace State</label>
                                <input id="Op_Info_Birthplace_State" type="text" class="form-control" name="Op_Info_Birthplace_State" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Active Duty Military? </label><br>
                                <label for="Op_Info_Active_Military" class="col-md-12 radio-label">
                                    <input id="Op_Info_Active_Military" type="checkbox" name="Op_Info_Active_Military" value="1" data-onload="onMilitaryChange(this, 'Op');" onchange="onMilitaryChange(this, 'Op');" <?php if(isset($drcaseoverview->Op_Info_Active_Military) && $drcaseoverview->Op_Info_Active_Military=='1'){ echo "checked"; } ?>> Check if Active Duty Military or Spouse/Dependant of Active Duty Military
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_Active_Military_Div" style="display: none;">
                                <label for="Op_Branch" class="col-form-label text-md-left">Which branch of the Military?</label>
                                <select id="Op_Branch" name="Op_Branch" class="form-control Op_Info_Active_Military_Input">
                                    <option value="Air Force" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Air Force'){ echo "selected"; } ?>>Air Force</option>
                                    <option value="Air Force Reserves" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Air Force Reserves'){ echo "selected"; } ?>>Air Force Reserves</option>
                                    <option value="Air National Guard" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                    <option value="Army" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Army'){ echo "selected"; } ?>>Army</option>
                                    <option value="Army Reserves" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Army Reserves'){ echo "selected"; } ?>>Army Reserves</option>
                                    <option value="Army National Guard" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Army National Guard'){ echo "selected"; } ?>>Army National Guard</option>
                                    <option value="Navy" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Navy'){ echo "selected"; } ?>>Navy</option>
                                    <option value="Navy Reserves" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Navy Reserves'){ echo "selected"; } ?>>Navy Reserves</option>
                                    <option value="Marine Corps" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Marine Corps'){ echo "selected"; } ?>>Marine Corps</option>
                                    <option value="Marine Corps Reserve" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Marine Corps Reserve'){ echo "selected"; } ?>>Marine Corps Reserve</option>
                                    <option value="Coast Guard" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Coast Guard'){ echo "selected"; } ?>>Coast Guard</option>
                                    <option value="Coast Guard Reserves" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Coast Guard Reserves'){ echo "selected"; } ?>>Coast Guard Reserves</option>
                                    <option value="Air National Guard" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                    <option value="Commissioned Officer of NOAA" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Commissioned Officer of NOAA'){ echo "selected"; } ?>>Commissioned Officer of NOAA</option>
                                    <option value="Commissioned Officer of PHS" <?php if(isset($drcaseoverview->Op_Branch) && $drcaseoverview->Op_Branch=='Commissioned Officer of PHS'){ echo "selected"; } ?>>Commissioned Officer of PHS</option>
                                </select> 
                            </div>
                            <div class="col-md-6 Op_Info_Active_Military_Div" style="display: none;">
                                <label class="col-form-label text-md-left">Does Active Duty Prevent {{$opponent_name}} from Participating? </label><br>
                                <label for="SCRA_Prevents_Op" class="col-md-12 radio-label">
                                    <input id="SCRA_Prevents_Op" type="checkbox" name="SCRA_Prevents_Op" value="1" class="Op_Info_Active_Military_Input"  data-onload="preventPartyChange(this, 'Op');" onchange="preventPartyChange(this, 'Op');" <?php if(isset($drcaseoverview->SCRA_Prevents_Op) && $drcaseoverview->SCRA_Prevents_Op=='1'){ echo "checked"; } ?>> Check if Active Duty Prevent {{$opponent_name}} from Participating
                                </label>
                                <label class="Op_Possible_SCRA_Issues_Label" style="display: none;color:red;">Possible SCRA Issues </label>
                            </div>
                            <div class="col-md-6 Op_Info_Active_Military_Div SCRA_Prevents_Op_Div" style="display: none;">
                                <label class="col-form-label text-md-left">Does Active Duty {{$opponent_name}} Waive SCRA Rights? </label><br>
                                <label for="Op_Waive_SCRA_Rights" class="col-md-12 radio-label">
                                    <input id="Op_Waive_SCRA_Rights" type="checkbox" name="Op_Waive_SCRA_Rights" value="1" class="Op_Info_Active_Military_Input SCRA_Prevents_Op_Input" <?php if(isset($drcaseoverview->Op_Waive_SCRA_Rights) && $drcaseoverview->Op_Waive_SCRA_Rights=='1'){ echo "checked"; } ?> data-onload="onWaiveSCRARightsChange(this, 'Op');" onchange="onWaiveSCRARightsChange(this, 'Op');"> Check if Active Duty {{$opponent_name}} Waives SCRA Rights
                                </label>
                            </div>
                            <div class="col-md-6 Op_Possible_SCRA_Issues_Div" style="display: none;">
                                <label for="Op_Possible_SCRA_Issues" class="col-md-12 radio-label" style="display: none;">
                                    <input id="Op_Possible_SCRA_Issues" type="checkbox" name="Op_Possible_SCRA_Issues" value="1" class="Op_Info_Active_Military_Input SCRA_Prevents_Op_Input Op_Possible_SCRA_Issues_Input" <?php if(isset($drcaseoverview->Op_Possible_SCRA_Issues) && $drcaseoverview->Op_Possible_SCRA_Issues=='1'){ echo "checked"; } ?>> Check if Active Duty {{$opponent_name}} Waive SCRA Rights
                                </label>
                            </div>

                            <div class="col-md-6">
                                <label for="Op_Info_Last_Elementary_School_Name" class="col-form-label text-md-left">Last Elementary School Name</label>
                                <input id="Op_Info_Last_Elementary_School_Name" type="text" class="form-control" name="Op_Info_Last_Elementary_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_Elementary" class="col-form-label text-md-left">Years Completed (Elementary School)?</label>
                                <select id="Op_Info_Years_Completed_Elementary" name="Op_Info_Years_Completed_Elementary" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Last_Middle_School_Name" class="col-form-label text-md-left">Last Middle/Junior High School Name</label>
                                <input id="Op_Info_Last_Middle_School_Name" type="text" class="form-control" name="Op_Info_Last_Middle_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_Middle_School" class="col-form-label text-md-left">Years Completed (Middle/Junior High School)?</label>
                                <select id="Op_Info_Years_Completed_Middle_School" name="Op_Info_Years_Completed_Middle_School" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Last_High_School_Name" class="col-form-label text-md-left">Last High School Name</label>
                                <input id="Op_Info_Last_High_School_Name" type="text" class="form-control" name="Op_Info_Last_High_School_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_High_School" class="col-form-label text-md-left">Years Completed (High School)?</label>
                                <select id="Op_Info_Years_Completed_High_School" name="Op_Info_Years_Completed_High_School" class="form-control">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Received Diploma or GED? </label><br>
                                <label for="Op_Info_High_School_Diploma_or_GED_High_School_Diploma" class="col-md-5 radio-label">High School Diploma
                                    <input id="Op_Info_High_School_Diploma_or_GED_High_School_Diploma" type="radio" name="Op_Info_High_School_Diploma_or_GED" value="High School Diploma"  checked="">
                                </label>
                                <label for="Op_Info_High_School_Diploma_or_GED_GED" class="col-md-2 radio-label">GED
                                    <input id="Op_Info_High_School_Diploma_or_GED_GED" type="radio" name="Op_Info_High_School_Diploma_or_GED" value="GED"> 
                                </label>
                                <label for="Op_Info_High_School_Diploma_or_GED_N/A" class="col-md-2 radio-label">N/A
                                    <input id="Op_Info_High_School_Diploma_or_GED_N/A" type="radio" name="Op_Info_High_School_Diploma_or_GED" value="N/A"> 
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_College1_Name" class="col-form-label text-md-left">College 1 Name</label>
                                <input id="Op_Info_College1_Name" type="text" class="form-control" name="Op_Info_College1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_College1" class="col-form-label text-md-left">Years completed at College 1</label>
                                <select id="Op_Info_Years_Completed_College1" name="Op_Info_Years_Completed_College1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_College1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_College1_Degree_Awarded_Yes" type="checkbox" name="Op_Info_College1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_College1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_College1_Degree_Div" style="display: none;">
                                <label for="Op_Info_College1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_College1_Degree" type="text" class="form-control" name="Op_Info_College1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_College2_Name" class="col-form-label text-md-left">College 2 Name</label>
                                <input id="Op_Info_College2_Name" type="text" class="form-control" name="Op_Info_College2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_College2" class="col-form-label text-md-left">Years completed at College 2</label>
                                <select id="Op_Info_Years_Completed_College2" name="Op_Info_Years_Completed_College2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_College2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_College2_Degree_Awarded_Yes" type="checkbox" name="Op_Info_College2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_College2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_College2_Degree_Div" style="display: none;">
                                <label for="Op_Info_College2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_College2_Degree" type="text" class="form-control" name="Op_Info_College2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Grad_School1_Name" class="col-form-label text-md-left">Grad School 1 Name</label>
                                <input id="Op_Info_Grad_School1_Name" type="text" class="form-control" name="Op_Info_Grad_School1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_Grad_School1" class="col-form-label text-md-left">Years completed at Grad School 1</label>
                                <select id="Op_Info_Years_Completed_Grad_School1" name="Op_Info_Years_Completed_Grad_School1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_GradSchool1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_GradSchool1_Degree_Awarded_Yes" type="checkbox" name="Op_Info_GradSchool1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_Grad_School1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_Grad_School1_Degree_Div" style="display: none;">
                                <label for="Op_Info_Grad_School1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_Grad_School1_Degree" type="text" class="form-control" name="Op_Info_Grad_School1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Grad_School2_Name" class="col-form-label text-md-left">Grad School 2 Name</label>
                                <input id="Op_Info_Grad_School2_Name" type="text" class="form-control" name="Op_Info_Grad_School2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_Grad_School2" class="col-form-label text-md-left">Years completed at Grad School 2</label>
                                <select id="Op_Info_Years_Completed_Grad_School2" name="Op_Info_Years_Completed_Grad_School2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_GradSchool2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_GradSchool2_Degree_Awarded_Yes" type="checkbox" name="Op_Info_GradSchool2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_Grad_School2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_Grad_School2_Degree_Div" style="display: none;">
                                <label for="Op_Info_Grad_School2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_Grad_School2_Degree" type="text" class="form-control" name="Op_Info_Grad_School2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_TechPro_School1_Name" class="col-form-label text-md-left">Technical/Professional School 1 Name</label>
                                <input id="Op_Info_TechPro_School1_Name" type="text" class="form-control" name="Op_Info_TechPro_School1_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_TechPro_School1" class="col-form-label text-md-left">Years Completed at Technical/Professional School 1</label>
                                <select id="Op_Info_Years_Completed_TechPro_School1" name="Op_Info_Years_Completed_TechPro_School1" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_TechPro_School1_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_TechPro_School1_Degree_Awarded_Yes" type="checkbox" name="Op_Info_TechPro_School1_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_TechPro_School1_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_TechPro_School1_Degree_Div" style="display: none;">
                                <label for="Op_Info_TechPro_School1_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_TechPro_School1_Degree" type="text" class="form-control" name="Op_Info_TechPro_School1_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_TechPro_School2_Name" class="col-form-label text-md-left">Technical/Professional School 2 Name</label>
                                <input id="Op_Info_TechPro_School2_Name" type="text" class="form-control" name="Op_Info_TechPro_School2_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Years_Completed_TechPro_School2" class="col-form-label text-md-left">Years Completed at Technical/Professional School 2</label>
                                <select id="Op_Info_Years_Completed_TechPro_School2" name="Op_Info_Years_Completed_TechPro_School2" class="form-control">
                                    <option value="">Select</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Degree Awarded? </label><br>
                                <label for="Op_Info_TechPro_School2_Degree_Awarded_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_TechPro_School2_Degree_Awarded_Yes" type="checkbox" name="Op_Info_TechPro_School2_Degree_Awarded" value="1" onchange="showHideDiv(this, 'Op_Info_TechPro_School2_Degree');"> Check if you obtained a Degree
                                </label>
                            </div>
                            <div class="col-md-6 Op_Info_TechPro_School2_Degree_Div" style="display: none;">
                                <label for="Op_Info_TechPro_School2_Degree" class="col-form-label text-md-left">Degree</label>
                                <input id="Op_Info_TechPro_School2_Degree" type="text" class="form-control" name="Op_Info_TechPro_School2_Degree" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Currently Retired? </label><br>
                                <label for="Op_Info_Retired_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Retired_Y_N_Yes" type="checkbox" name="Op_Info_Retired_Y_N" value="1"> Check if you’re currently Retired
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receive Public Assistance? </label><br>
                                <label for="Op_Info_Public_Assistance_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Public_Assistance_Y_N_Yes" type="checkbox" name="Op_Info_Public_Assistance_Y_N" value="1"> Check if you receive Public Assistance
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Have  Pending Public Assistance Application? </label><br>
                                <label for="Op_Info_Public_Assistance_App_Pending_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Public_Assistance_App_Pending_Y_N_Yes" type="checkbox" name="Op_Info_Public_Assistance_App_Pending_Y_N" value="1"> Check if you have a  Pending Public Assistance Application
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Father_Name" class="col-form-label text-md-left">Father’s Full Name</label>
                                <input id="Op_Info_Father_Name" type="text" class="form-control" name="Op_Info_Father_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Father_Address" class="col-form-label text-md-left">Father’s Address</label>
                                <input id="Op_Info_Father_Address" type="text" class="form-control" name="Op_Info_Father_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Father Deceased? </label><br>
                                <label for="Op_Info_Father_Deceased_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Father_Deceased_Y_N_Yes" type="checkbox" name="Op_Info_Father_Deceased_Y_N" value="1"> Check if your Father is deceased?
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Mother_Name" class="col-form-label text-md-left">Mother‘s Full Name</label>
                                <input id="Op_Info_Mother_Name" type="text" class="form-control" name="Op_Info_Mother_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Mother_Address" class="col-form-label text-md-left">Mother’s Address</label>
                                <input id="Op_Info_Mother_Address" type="text" class="form-control" name="Op_Info_Mother_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Mother Deceased? </label><br>
                                <label for="Op_Info_Mother_Deceased_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Mother_Deceased_Y_N_Yes" type="checkbox" name="Op_Info_Mother_Deceased_Y_N" value="1"> Check if your Mother is deceased?
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Closest_Friend_or_Relative_Full_Name" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Full Name</label>
                                <input id="Op_Info_Closest_Friend_or_Relative_Full_Name" type="text" class="form-control" name="Op_Info_Closest_Friend_or_Relative_Full_Name" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Closest_Friend_or_Relative_Phone_Number" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Phone Number</label>
                                <input id="Op_Info_Closest_Friend_or_Relative_Phone_Number" type="text" class="form-control" name="Op_Info_Closest_Friend_or_Relative_Phone_Number" value="" placeholder="(XXX) XXX-XXXX"> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Closest_Friend_or_Relative_Full_Address" class="col-form-label text-md-left">Closest (distance-wise) Friend or Relative Full Address</label>
                                <input id="Op_Info_Closest_Friend_or_Relative_Full_Address" type="text" class="form-control" name="Op_Info_Closest_Friend_or_Relative_Full_Address" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Height" class="col-form-label text-md-left">Height</label>
                                <select id="Op_Info_Height" name="Op_Info_Height" class="form-control">
                                    <option value="4’ 6”">4’ 6”</option>
                                    <option value="4’ 7”">4’ 7”</option>
                                    <option value="4’ 8”">4’ 8”</option>
                                    <option value="4’ 9”">4’ 9”</option>
                                    <option value="5’ 0”">5’ 0”</option>
                                    <option value="5’ 1”">5’ 1”</option>
                                    <option value="5’ 2”">5’ 2”</option>
                                    <option value="5’ 3”">5’ 3”</option>
                                    <option value="5’ 4”">5’ 4”</option>
                                    <option value="5’ 5”">5’ 5”</option>
                                    <option value="5’ 6”">5’ 6”</option>
                                    <option value="5’ 7”">5’ 7”</option>
                                    <option value="5’ 8”">5’ 8”</option>
                                    <option value="5’ 9”">5’ 9”</option>
                                    <option value="6’ 0”" selected="">6’ 0”</option>
                                    <option value="6’ 1”">6’ 1”</option>
                                    <option value="6’ 2”">6’ 2”</option>
                                    <option value="6’ 3”">6’ 3”</option>
                                    <option value="6’ 4”">6’ 4”</option>
                                    <option value="6’ 5”">6’ 5”</option>
                                    <option value="6’ 6”">6’ 6”</option>
                                    <option value="6’ 7”">6’ 7”</option>
                                    <option value="6’ 8”">6’ 8”</option>
                                    <option value="6’ 9”">6’ 9”</option>
                                    <option value="7’ 0”">7’ 0”</option>
                                    <option value="7’ 1”">7’ 1”</option>
                                    <option value="7’ 2”">7’ 2”</option>
                                    <option value="7’ 3”">7’ 3”</option>
                                    <option value="7’ 4”">7’ 4”</option>
                                    <option value="7’ 5”">7’ 5”</option>
                                    <option value="7’ 6”">7’ 6”</option>
                                </select>   
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Weight" class="col-form-label text-md-left">Weight</label>
                                <input id="Op_Info_Weight" type="text" class="form-control" name="Op_Info_Weight" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Hair_Color" class="col-form-label text-md-left">Hair Color</label>
                                <select id="Op_Info_Hair_Color" name="Op_Info_Hair_Color" class="form-control">
                                    <option value="Black">Black</option>
                                    <option value="Blond">Blond</option>
                                    <option value="Brown">Brown</option>
                                    <option value="Grey/White">Grey/White</option>
                                    <option value="Red">Red</option>
                                    <option value="N/A">N/A</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="Op_Info_Eye_Color" class="col-form-label text-md-left">Eye Color</label>
                                <select id="Op_Info_Eye_Color" name="Op_Info_Eye_Color" class="form-control">
                                    <option value="Amber">Amber</option>
                                    <option value="Blue">Blue</option>
                                    <option value="Gray">Gray</option>
                                    <option value="Green">Green</option>
                                    <option value="Hazel">Hazel</option>
                                    <option value="Red">Red</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Race </label><br>
                                <label for="Op_Info_Race_W_B_A_O_W" class="col-md-3 radio-label">White
                                    <input id="Op_Info_Race_W_B_A_O_W" type="radio" name="Op_Info_Race_W_B_A_O" value="White">
                                </label>
                                <label for="Op_Info_Race_W_B_A_O_B" class="col-md-3 radio-label">Black
                                    <input id="Op_Info_Race_W_B_A_O_B" type="radio" name="Op_Info_Race_W_B_A_O" value="Black">
                                </label>
                                <label for="Op_Info_Race_W_B_A_O_A" class="col-md-3 radio-label">Asian
                                    <input id="Op_Info_Race_W_B_A_O_A" type="radio" name="Op_Info_Race_W_B_A_O" value="Asian">
                                </label>
                                <label for="Op_Info_Race_W_B_A_O_O" class="col-md-3 radio-label">Other
                                    <input id="Op_Info_Race_W_B_A_O_O" type="radio" name="Op_Info_Race_W_B_A_O" value="Other" checked="">
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Divorced Prior to This Marriage? </label><br>
                                <label for="Op_Divorced_Prior_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Divorced_Prior_Yes" type="checkbox" name="Op_Divorced_Prior" value="1"> Check if you were Divorced prior to this Marriage?
                                </label>
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Date1" class="col-form-label text-md-left">First Prior Divorce Date*</label>
                                <input id="Op_Info_Prior_Divorce_Date1" type="text" class="form-control hasDatepicker Op_Divorced_Prior_First_Inputs" name="Op_Info_Prior_Divorce_Date1" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Case_Num1" class="col-form-label text-md-left">First Prior Divorce Case Number*</label>
                                <input id="Op_Info_Prior_Divorce_Case_Num1" type="text" class="form-control Op_Divorced_Prior_First_Inputs" name="Op_Info_Prior_Divorce_Case_Num1" value=""> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce1_Support_PAID" class="col-form-label text-md-left">First Prior Divorce Monthly Spousal Support PAID*</label>
                                <input id="Op_Info_Prior_Divorce1_Support_PAID" type="number" class="form-control Op_Divorced_Prior_First_Inputs" name="Op_Info_Prior_Divorce1_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce1_Support_RECEIVED" class="col-form-label text-md-left">First Prior Divorce Monthly Spousal Support RECEIVED*</label>
                                <input id="Op_Info_Prior_Divorce1_Support_RECEIVED" type="number" class="form-control Op_Divorced_Prior_First_Inputs" name="Op_Info_Prior_Divorce1_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Place1" class="col-form-label text-md-left">First Prior Divorce City, State*</label>
                                <input id="Op_Info_Prior_Divorce_Place1" type="text" class="form-control Op_Divorced_Prior_First_Inputs" name="Op_Info_Prior_Divorce_Place1" value=""> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Date2" class="col-form-label text-md-left">Second Prior Divorce Date</label>
                                <input id="Op_Info_Prior_Divorce_Date2" type="text" class="form-control hasDatepicker Op_Divorced_Prior_Second_Inputs" name="Op_Info_Prior_Divorce_Date2" value="" autocomplete="nope"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Case_Num2" class="col-form-label text-md-left">Second Prior Divorce Case Number</label>
                                <input id="Op_Info_Prior_Divorce_Case_Num2" type="text" class="form-control Op_Divorced_Prior_Second_Inputs" name="Op_Info_Prior_Divorce_Case_Num2" value=""> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce2_Support_PAID" class="col-form-label text-md-left">Second Prior Divorce Monthly Spousal Support PAID</label>
                                <input id="Op_Info_Prior_Divorce2_Support_PAID" type="number" class="form-control Op_Divorced_Prior_Second_Inputs" name="Op_Info_Prior_Divorce2_Support_PAID" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce2_Support_RECEIVED" class="col-form-label text-md-left">Second Prior Divorce Monthly Spousal Support RECEIVED</label>
                                <input id="Op_Info_Prior_Divorce2_Support_RECEIVED" type="number" class="form-control Op_Divorced_Prior_Second_Inputs" name="Op_Info_Prior_Divorce2_Support_RECEIVED" value="0.00" min="0.00" step="0.01" max="999999.99"> 
                            </div>
                            <div class="col-md-6 Op_Divorced_Prior_Div" style="display:none;">
                                <label for="Op_Info_Prior_Divorce_Place2" class="col-form-label text-md-left">Second Prior Divorce City, State</label>
                                <input id="Op_Info_Prior_Divorce_Place2" type="text" class="form-control Op_Divorced_Prior_Second_Inputs" name="Op_Info_Prior_Divorce_Place2" value=""> 
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receiving Public Assistance Cash Grant? </label><br>
                                <label for="Op_Info_Public_Assistance_Cash_Grant_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Public_Assistance_Cash_Grant_Y_N_Yes" type="checkbox" name="Op_Info_Public_Assistance_Cash_Grant_Y_N" value="1"> Check if you receiving Public Assistance Cash Grant
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label text-md-left">Receiving Public Assistance Medical? </label><br>
                                <label for="Op_Info_Public_Assistance_Medical_Y_N_Yes" class="col-md-12 radio-label">
                                    <input id="Op_Info_Public_Assistance_Medical_Y_N_Yes" type="checkbox" name="Op_Info_Public_Assistance_Medical_Y_N" value="1"> Check if you receive Public Assistance Medical
                                </label>
                            </div>
                            <div class="col-md-12" style="text-align: center;margin-top: 20px;">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <!-- End of Opponent Personal Info Section -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    function showHideDiv(checkbox, inputname){
        if(checkbox.checked){
            $('#'+inputname+'').prop('required', true);
            $('.'+inputname+'_Div').show();
            if(inputname=='Client_Info_Former_Name'){
                var fullmaidenname=$('#Client_Info_Maiden_Name').val();
                $('#'+inputname+'').val(fullmaidenname);
            }
            if(inputname=='Op_Info_Former_Name'){
                var fullmaidenname=$('#Op_Info_Maiden_Name').val();
                $('#'+inputname+'').val(fullmaidenname);
            }
        } else {
            $('#'+inputname+'').prop('required', false);
            $('#'+inputname+'').val('');
            $('.'+inputname+'_Div').hide();
            if(inputname=='Client_Info_Former_Name'){
                $('#'+inputname+'').val('');
            }
            if(inputname=='Op_Info_Former_Name'){
                $('#'+inputname+'').val('');
            }
        }
    }

    function onMilitaryChange(military, militarytype){
        if(military.checked){
            $('.'+militarytype+'_Info_Active_Military_Div').show();
            if($('#SCRA_Prevents_'+militarytype+'').prop('checked')== true){
                $('.SCRA_Prevents_'+militarytype+'_Div').show();
                $('.'+militarytype+'_Possible_SCRA_Issues_Div').show();
            }else {
                $('.SCRA_Prevents_'+militarytype+'_Div').hide();
                $('.'+militarytype+'_Possible_SCRA_Issues_Div').hide();
            }
        } else {
            $('.'+militarytype+'_Possible_SCRA_Issues_Div').hide();
            $('.'+militarytype+'_Info_Active_Military_Div').hide();
        }
    }

    function preventPartyChange(party, partytype){
        if(party.checked){
            if($('#'+partytype+'_Info_Active_Military').prop('checked')== true){
                $('.SCRA_Prevents_'+partytype+'_Div').show();
                $('.'+partytype+'_Possible_SCRA_Issues_Div').show();
            }else {
                $('.SCRA_Prevents_'+partytype+'_Div').hide();
                $('.'+partytype+'_Possible_SCRA_Issues_Div').hide();
            }
            $('.'+partytype+'_Possible_SCRA_Issues_Label').show();
        } else {
            // if($('#'+partytype+'_Info_Active_Military').prop('checked')== true){
            //     $('.SCRA_Prevents_'+partytype+'_Div').hide();
            // } else {
            //     $('.SCRA_Prevents_'+partytype+'_Div').hide();
            // }
            $('.SCRA_Prevents_'+partytype+'_Div').hide();
            $('.'+partytype+'_Possible_SCRA_Issues_Div').hide();
            $('.'+partytype+'_Possible_SCRA_Issues_Label').hide();
        }
    }

    function onWaiveSCRARightsChange(rights, rightstype){
        if(rights.checked){
            $('.'+rightstype+'_Possible_SCRA_Issues_Label').hide();
        } else {
            $('.'+rightstype+'_Possible_SCRA_Issues_Label').show();
        }
    }

    $(document).ready(function(){

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $('#dr_personalinfo').validate({
            rules: {
                Client_Info_Closest_Friend_or_Relative_Phone_Number: {
                    // phoneUS: true
                    pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
                Op_Info_Closest_Friend_or_Relative_Phone_Number: {
                    pattern:(/\(?[\d\s]{3}\) [\d\s]{3}-[\d\s]{4}$/)
                },
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1900",
            endDate: '+0d',
        });

        $(".due_date").datepicker({
            startDate: new Date(),
        });

        $('[data-onload]').each(function(){
            eval($(this).data('onload'));
        });

        // hide prior divorce related fields if divorce prior to this marriage is no and vice versa
        $('input[name=Client_Divorced_Prior]').on('change', function(){
            if(this.value=='1' && this.checked){
                $('.Client_Divorced_Prior_First_Inputs').prop('required', true);
                $('.Client_Divorced_Prior_Div').show();
            } else {
                $('.Client_Divorced_Prior_First_Inputs').prop('required', false);
                $('.Client_Divorced_Prior_First_Inputs').val('');
                $('.Client_Divorced_Prior_Second_Inputs').val('');
                $('.Client_Divorced_Prior_Div').hide();
            }
        });

        // hide prior divorce related fields if divorce prior to this marriage is no and vice versa
        $('input[name=Op_Divorced_Prior]').on('change', function(){
            if(this.value=='1' && this.checked){
                $('.Op_Divorced_Prior_First_Inputs').prop('required', true);
                $('.Op_Divorced_Prior_Div').show();
            } else {
                $('.Op_Divorced_Prior_First_Inputs').prop('required', false);
                $('.Op_Divorced_Prior_First_Inputs').val('');
                $('.Op_Divorced_Prior_Second_Inputs').val('');
                $('.Op_Divorced_Prior_Div').hide();
            }
        });

    });
</script>   
@endsection