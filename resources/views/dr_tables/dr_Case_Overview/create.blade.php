@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center dr_Case_Overview_main dr_Tables_main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Case Overview Info') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.family_law_interview_tabs',$case_data->id) }}"> Back</a>

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
                    <form role="form" id="dr_Case_Overview" method="POST" action="{{ route('drcaseoverview.store') }}" autocomplete="off">
                        @csrf
                        <input id="" type="hidden" class="form-control" name="case_id" value="{{$case_data->id}}">
                        <input id="month_diff" type="hidden" class="form-control" name="" value="">

                        <!-- Client Income Info Section -->
                        <!-- <div class="form-row Client_Income_section"> -->
                            <h5>Military/SCRA Info Section</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h6>Client Info</h6>
                                    <div class="form-group">
                                        <label>Active Duty Military?</label>
                                        <div class="w-100 dataInput">
                                            <label for="Client_Info_Active_Military" class="">
                                                <input id="Client_Info_Active_Military" type="checkbox" name="Client_Info_Active_Military" value="1" <?php if(isset($data['personalinfo']->Client_Info_Active_Military) && $data['personalinfo']->Client_Info_Active_Military=='1'){ echo "checked"; } ?> data-onload="onMilitaryChange(this, 'Client');" onchange="onMilitaryChange(this, 'Client');"> Check if Active Duty Military or Spouse/Dependant of Active Duty Military
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group w-100 Client_Info_Active_Military_Div" style="display: none;">
                                        <label>Which branch of the Military?</label>
                                        <select id="Client_Branch" name="Client_Branch" class="form-control Client_Info_Active_Military_Input">
                                            <option value="Air Force" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Air Force'){ echo "selected"; } ?>>Air Force</option>
                                            <option value="Air Force Reserves" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Air Force Reserves'){ echo "selected"; } ?>>Air Force Reserves</option>
                                            <option value="Air National Guard" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                            <option value="Army" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Army'){ echo "selected"; } ?>>Army</option>
                                            <option value="Army Reserves" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Army Reserves'){ echo "selected"; } ?>>Army Reserves</option>
                                            <option value="Army National Guard" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Army National Guard'){ echo "selected"; } ?>>Army National Guard</option>
                                            <option value="Navy" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Navy'){ echo "selected"; } ?>>Navy</option>
                                            <option value="Navy Reserves" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Navy Reserves'){ echo "selected"; } ?>>Navy Reserves</option>
                                            <option value="Marine Corps" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Marine Corps'){ echo "selected"; } ?>>Marine Corps</option>
                                            <option value="Marine Corps Reserve" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Marine Corps Reserve'){ echo "selected"; } ?>>Marine Corps Reserve</option>
                                            <option value="Coast Guard" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Coast Guard'){ echo "selected"; } ?>>Coast Guard</option>
                                            <option value="Coast Guard Reserves" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Coast Guard Reserves'){ echo "selected"; } ?>>Coast Guard Reserves</option>
                                            <option value="Air National Guard" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                            <option value="Commissioned Officer of NOAA" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Commissioned Officer of NOAA'){ echo "selected"; } ?>>Commissioned Officer of NOAA</option>
                                            <option value="Commissioned Officer of PHS" <?php if(isset($data['personalinfo']->Client_Branch) && $data['personalinfo']->Client_Branch=='Commissioned Officer of PHS'){ echo "selected"; } ?>>Commissioned Officer of PHS</option>
                                        </select>
                                    </div>
                                    <div class="form-group Client_Info_Active_Military_Div" style="display: none;">
                                        <label>Does Active Duty Prevent {{$client_name}} from Participating?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="SCRA_Prevents_Client" type="checkbox" name="SCRA_Prevents_Client" value="1" class="Client_Info_Active_Military_Input" <?php if(isset($data['personalinfo']->SCRA_Prevents_Client) && $data['personalinfo']->SCRA_Prevents_Client=='1'){ echo "checked"; } ?> data-onload="preventPartyChange(this, 'Client');" onchange="preventPartyChange(this, 'Client');"> Check if Active Duty Prevent {{$client_name}} from Participating
                                            </label>
                                            <label class="Client_Possible_SCRA_Issues_Label" style="display: none;color:red;">Possible SCRA Issues </label>
                                        </div>
                                    </div>
                                    <div class="form-group Client_Info_Active_Military_Div SCRA_Prevents_Client_Div" style="display: none;">
                                        <label>Does Active Duty Party Waive SCRA Rights?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="Client_Waive_SCRA_Rights" type="checkbox" name="Client_Waive_SCRA_Rights" value="1" class="Client_Info_Active_Military_Input SCRA_Prevents_Client_Input" <?php if(isset($data['personalinfo']->Client_Waive_SCRA_Rights) && $data['personalinfo']->Client_Waive_SCRA_Rights=='1'){ echo "checked"; } ?> data-onload="onWaiveSCRARightsChange(this, 'Client');" onchange="onWaiveSCRARightsChange(this, 'Client');"> Check if Active Duty {{$client_name}} Waives SCRA Rights
                                            </label>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group Client_Possible_SCRA_Issues_Div" style="display: none;">
                                        <label>Possible SCRA Issues?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="Client_Possible_SCRA_Issues" type="checkbox" name="Client_Possible_SCRA_Issues" value="1" class="Client_Info_Active_Military_Input SCRA_Prevents_Client_Input Client_Possible_SCRA_Issues_Input" <?php //if(isset($data['personalinfo']->Client_Possible_SCRA_Issues) && $data['personalinfo']->Client_Possible_SCRA_Issues=='1'){ echo "checked"; } ?>> Check if Active Duty {{$client_name}} Waive SCRA Rights
                                            </label>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="col-sm-6">
                                    <h6>Opponent Info</h6>
                                    <div class="form-group">
                                        <label>Active Duty Military?</label>
                                        <div class="w-100 dataInput">
                                            <label for="Op_Info_Active_Military" class="">
                                                <input id="Op_Info_Active_Military" type="checkbox" name="Op_Info_Active_Military" value="1" <?php if(isset($data['personalinfo']->Op_Info_Active_Military) && $data['personalinfo']->Op_Info_Active_Military=='1'){ echo "checked"; } ?> data-onload="onMilitaryChange(this, 'Op');" onchange="onMilitaryChange(this, 'Op');"> Check if Active Duty Military or Spouse/Dependant of Active Duty Military
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group w-100 Op_Info_Active_Military_Div" style="display: none;">
                                        <label>Which branch of the Military?</label>
                                        <select id="Op_Branch" name="Op_Branch" class="form-control Op_Info_Active_Military_Input">
                                            <option value="Air Force" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Air Force'){ echo "selected"; } ?>>Air Force</option>
                                            <option value="Air Force Reserves" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Air Force Reserves'){ echo "selected"; } ?>>Air Force Reserves</option>
                                            <option value="Air National Guard" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                            <option value="Army" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Army'){ echo "selected"; } ?>>Army</option>
                                            <option value="Army Reserves" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Army Reserves'){ echo "selected"; } ?>>Army Reserves</option>
                                            <option value="Army National Guard" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Army National Guard'){ echo "selected"; } ?>>Army National Guard</option>
                                            <option value="Navy" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Navy'){ echo "selected"; } ?>>Navy</option>
                                            <option value="Navy Reserves" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Navy Reserves'){ echo "selected"; } ?>>Navy Reserves</option>
                                            <option value="Marine Corps" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Marine Corps'){ echo "selected"; } ?>>Marine Corps</option>
                                            <option value="Marine Corps Reserve" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Marine Corps Reserve'){ echo "selected"; } ?>>Marine Corps Reserve</option>
                                            <option value="Coast Guard" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Coast Guard'){ echo "selected"; } ?>>Coast Guard</option>
                                            <option value="Coast Guard Reserves" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Coast Guard Reserves'){ echo "selected"; } ?>>Coast Guard Reserves</option>
                                            <option value="Air National Guard" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Air National Guard'){ echo "selected"; } ?>>Air National Guard</option>
                                            <option value="Commissioned Officer of NOAA" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Commissioned Officer of NOAA'){ echo "selected"; } ?>>Commissioned Officer of NOAA</option>
                                            <option value="Commissioned Officer of PHS" <?php if(isset($data['personalinfo']->Op_Branch) && $data['personalinfo']->Op_Branch=='Commissioned Officer of PHS'){ echo "selected"; } ?>>Commissioned Officer of PHS</option>
                                        </select>
                                    </div>
                                    <div class="form-group Op_Info_Active_Military_Div" style="display: none;">
                                        <label>Does Active Duty Prevent {{$opponent_name}} from Participating?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="SCRA_Prevents_Op" type="checkbox" name="SCRA_Prevents_Op" value="1" class="Op_Info_Active_Military_Input" <?php if(isset($data['personalinfo']->SCRA_Prevents_Op) && $data['personalinfo']->SCRA_Prevents_Op=='1'){ echo "checked"; } ?> data-onload="preventPartyChange(this, 'Op');" onchange="preventPartyChange(this, 'Op');"> Check if Active Duty Prevent {{$opponent_name}} from Participating
                                            </label>
                                            <label class="Op_Possible_SCRA_Issues_Label" style="display: none;color:red;">Possible SCRA Issues </label>
                                        </div>
                                    </div>
                                    <div class="form-group Op_Info_Active_Military_Div SCRA_Prevents_Op_Div" style="display: none;">
                                        <label>Does Active Duty Party Waive SCRA Rights?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="Op_Waive_SCRA_Rights" type="checkbox" name="Op_Waive_SCRA_Rights" value="1" class="Op_Info_Active_Military_Input SCRA_Prevents_Op_Input" <?php if(isset($data['personalinfo']->Op_Waive_SCRA_Rights) && $data['personalinfo']->Op_Waive_SCRA_Rights=='1'){ echo "checked"; } ?> data-onload="onWaiveSCRARightsChange(this, 'Op');" onchange="onWaiveSCRARightsChange(this, 'Op');"> Check if Active Duty {{$opponent_name}} Waives SCRA Rights
                                            </label>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group Op_Possible_SCRA_Issues_Div" style="display: none;">
                                        <label>Possible SCRA Issues?</label>
                                        <div class="w-100 dataInput">
                                            <label>
                                                <input id="Op_Possible_SCRA_Issues" type="checkbox" name="Op_Possible_SCRA_Issues" value="1" class="Op_Info_Active_Military_Input SCRA_Prevents_Op_Input Op_Possible_SCRA_Issues_Input" <?php //if(isset($data['personalinfo']->Op_Possible_SCRA_Issues) && $data['personalinfo']->Op_Possible_SCRA_Issues=='1'){ echo "checked"; } ?>> Check if Active Duty {{$opponent_name}} Waive SCRA Rights
                                            </label>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                            <h5>Children of this Marriage Info Section</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by {{$client_name}} and {{$opponent_name}} DURING their marriage. ?</label>
                                    <input id="Num_Children_ONLY_This_Marriage" type="number" class="form-control" name="Num_Children_ONLY_This_Marriage" value="<?php if(isset($data['childrensinfo']->Num_Children_ONLY_This_Marriage)){ echo $data['childrensinfo']->Num_Children_ONLY_This_Marriage; } else { echo "0"; } ?>" min="0" max="8" required>
                                </div>
                                <div class="col-sm-6">
                                        <label>How many children are Minor and/or otherwise Dependent in this marriage?</label>
                                        <input id="Num_MinorDepChildren_ONLY_This_Marriage" type="number" class="form-control" name="Num_MinorDepChildren_ONLY_This_Marriage" value="<?php if(isset($data['childrensinfo']->Num_MinorDepChildren_ONLY_This_Marriage)){ echo $data['childrensinfo']->Num_MinorDepChildren_ONLY_This_Marriage; } else { echo "0"; } ?>" min="0" max="8" required> 
                                </div>
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by {{$client_name}}’s but not {{$opponent_name}} ?</label>
                                    <input id="Num_Client_Children_NOT_this_Marriage" type="number" class="form-control" name="Num_Client_Children_NOT_this_Marriage" value="<?php if(isset($data['childrensinfo']->Num_Client_Children_NOT_this_Marriage)){ echo $data['childrensinfo']->Num_Client_Children_NOT_this_Marriage; } else { echo "0"; } ?>" min="0" max="6" required>
                                    
                                </div>
                                
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by  {{$opponent_name}}’s but not {{$client_name}}. ?</label>
                                    <input id="Num_Op_Children_NOT_this_Marriage" type="number" class="form-control" name="Num_Op_Children_NOT_this_Marriage" value="<?php if(isset($data['childrensinfo']->Num_Op_Children_NOT_this_Marriage)){ echo $data['childrensinfo']->Num_Op_Children_NOT_this_Marriage; } else { echo "0"; } ?>" min="0" max="6" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by {{$client_name}} and  {{$opponent_name}} BEFORE their marriage.. ?</label>
                                    <input id="Num_Children_Born_ONLY_These_Parties_Before_Marriage" type="number" class="form-control" name="Num_Children_Born_ONLY_These_Parties_Before_Marriage" value="<?php if(isset($data['childrensinfo']->Num_Children_Born_ONLY_These_Parties_Before_Marriage)){ echo $data['childrensinfo']->Num_Children_Born_ONLY_These_Parties_Before_Marriage; } else { echo "0"; } ?>" min="0" max="6" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by  {{$client_name}} and  {{$opponent_name}} who are emancipated and not disabled.. ?</label>
                                    <input id="Num_Children_Born_Emancipated_Not_Dep" type="number" class="form-control" name="Num_Children_Born_Emancipated_Not_Dep" value="<?php if(isset($data['childrensinfo']->Num_Children_Born_Emancipated_Not_Dep)){ echo $data['childrensinfo']->Num_Children_Born_Emancipated_Not_Dep; } else { echo "0"; } ?>" min="0" max="6" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Number of children born to and/or adopted by  {{$client_name}} and  {{$opponent_name}} who are minors or disabled and incapable of supporting themselves.?</label>
                                    <input id="Num_Children_Born_Disabled_Dependent" type="number" class="form-control" name="Num_Children_Born_Disabled_Dependent" value="<?php if(isset($data['childrensinfo']->Num_Children_Born_Disabled_Dependent)){ echo $data['childrensinfo']->Num_Children_Born_Disabled_Dependent; } else { echo "0"; } ?>" min="0" max="6" required>
                                </div>
                                <div class="col-sm-6">
                                    <label>Number of children subject to an  existing order of parenting or supporting from another Court.</label>
                                    <input id="Num_Children_Parenting_Support_Order" type="number" class="form-control" name="Num_Children_Parenting_Support_Order" value="<?php if(isset($data['childrensinfo']->Num_Children_Parenting_Support_Order)){ echo $data['childrensinfo']->Num_Children_Parenting_Support_Order; } else { echo "0"; } ?>" min="0" max="6" required>
                                </div>
                            </div>

                            <h5>Vehicles Info Section</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_Vehicles" name="Any_Vehicles" value="1" <?php if(isset($data['vehiclesinfo']->Any_Vehicles) && $data['vehiclesinfo']->Any_Vehicles=='1'){ echo "checked"; } ?> onchange="getAnyVehicle(this);"> Check if Any Vehicles (Cars, Trucks, Boats, Trailers, etc.) is Owned and/or Leased by {{$client_name}} and/or {{$opponent_name}}?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 Num_Joint_Vehicles" style="display: none;">
                                    <label>How Many Vehicles Leased or Titled in Both Parties’ Names?</label>
                                    <input id="Num_Joint_Vehicles" type="number" class="form-control" name="Num_Joint_Vehicles" value="<?php if(isset($data['vehiclesinfo']->Num_Joint_Vehicles)){ echo $data['vehiclesinfo']->Num_Joint_Vehicles; } else { echo "0"; } ?>" min="0" max="6" required>
                                 </div>
                                <div class="col-sm-6 Num_Client_Vehicles" style="display: none;">
                                    <label>How Many Vehicles Leased or Titled in just to {{$client_name}}?</label>
                                    <input id="Num_Client_Vehicles" type="number" class="form-control" name="Num_Client_Vehicles" value="<?php if(isset($data['vehiclesinfo']->Num_Client_Vehicles)){ echo $data['vehiclesinfo']->Num_Client_Vehicles; } else { echo "0"; } ?>" min="0" max="6" required> 
                                 </div>
                                <div class="col-sm-6 Num_Op_Vehicles" style="display: none;">
                                    <label>How Many Vehicles Leased or Titled in just to {{$opponent_name}}?</label>
                                    <input id="Num_Op_Vehicles" type="number" class="form-control" name="Num_Op_Vehicles" value="<?php if(isset($data['vehiclesinfo']->Num_Op_Vehicles)){ echo $data['vehiclesinfo']->Num_Op_Vehicles; } else { echo "0"; } ?>" min="0" max="6" required> 
                                 </div>
                            </div>
                            <h5>Real Estate Info Section</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_Real_Estate" name="Any_Real_Estate" value="1" <?php if(isset($data['realestateinfo']->Any_Real_Estate) && $data['realestateinfo']->Any_Real_Estate=='1'){ echo "checked"; } ?> onchange="getAnyRealEstate(this);"> Check if any Real Estate is Owned by {{$client_name}} and/or {{$opponent_name}}?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 num_Joint_realestate" style="display: none;">
                                    <label>How many Real Estate Properties are owned in BOTH Parties’ Names</label>
                                    <input id="Num_Joint_Real_Estate_Properties" type="number" class="form-control" name="Num_Joint_Real_Estate_Properties" value="<?php if(isset($data['realestateinfo']->Num_Joint_Real_Estate_Properties)){ echo $data['realestateinfo']->Num_Joint_Real_Estate_Properties; } else { echo "0"; } ?>" min="0" max="5" required>
                                 </div>
                                <div class="col-sm-6 num_Client_realestate" style="display: none;">
                                    <label>How many Real Estate Properties are owned in {{$client_name}}’s Name Only</label>
                                    <input id="Num_Client_Real_Estate_Properties" type="number" class="form-control" name="Num_Client_Real_Estate_Properties" value="<?php if(isset($data['realestateinfo']->Num_Client_Real_Estate_Properties)){ echo $data['realestateinfo']->Num_Client_Real_Estate_Properties; } else { echo "0"; } ?>" min="0" max="5" required> 
                                 </div>
                                <div class="col-sm-6 num_Op_realestate" style="display: none;">
                                    <label>How many Real Estate Properties are owned in {{$opponent_name}}’s Name Only</label>
                                    <input id="Num_Op_Real_Estate_Properties" type="number" class="form-control" name="Num_Op_Real_Estate_Properties" value="<?php if(isset($data['realestateinfo']->Num_Op_Real_Estate_Properties)){ echo $data['realestateinfo']->Num_Op_Real_Estate_Properties; } else { echo "0"; } ?>" min="0" max="5" required>
                                 </div>
                            </div>
                            <h5>Stocks/Investments Info Section</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_Stocks_Investments_Accounts" name="Any_Stocks_Investments_Accounts" value="1" <?php if(isset($data['stockinvestmentinfo']->Any_Stocks_Investments_Accounts) && $data['stockinvestmentinfo']->Any_Stocks_Investments_Accounts=='1'){ echo "checked"; } ?> onchange="getAnySIA(this);"> Check if any Stocks or Investments (Accounts or Certificates) is Owned by {{$client_name}} and/or {{$opponent_name}}?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 num_Joint_stocksinvestments_info" style="display: none;">
                                    <label>How many deposit accounts in BOTH parties’ names?</label>
                                    <input id="Num_Joint_StocksInvestments_Accounts" type="number" class="form-control" name="Num_Joint_StocksInvestments_Accounts" value="<?php if(isset($data['stockinvestmentinfo']->Num_Joint_StocksInvestments_Accounts)){ echo $data['stockinvestmentinfo']->Num_Joint_StocksInvestments_Accounts; } else { echo "0"; } ?>" min="0" max="10" required>  
                                 </div>
                                <div class="col-sm-6 num_Client_stocksinvestments_info" style="display: none;">
                                    <label>How many deposit accounts in {{$client_name}}’s name only?</label>
                                    <input id="Num_Client_StockInvestments_Accounts" type="number" class="form-control" name="Num_Client_StockInvestments_Accounts" value="<?php if(isset($data['stockinvestmentinfo']->Num_Client_StockInvestments_Accounts)){ echo $data['stockinvestmentinfo']->Num_Client_StockInvestments_Accounts; } else { echo "0"; } ?>" min="0" max="10" required>
                                 </div>
                                <div class="col-sm-6 num_Op_stocksinvestments_info" style="display: none;">
                                    <label>How many deposit accounts in {{$opponent_name}}’s name only?</label>
                                    <input id="Num_Op_StockInvestments_Accounts" type="number" class="form-control" name="Num_Op_StockInvestments_Accounts" value="<?php if(isset($data['stockinvestmentinfo']->Num_Op_StockInvestments_Accounts)){ echo $data['stockinvestmentinfo']->Num_Op_StockInvestments_Accounts; } else { echo "0"; } ?>" min="0" max="10" required> 
                                 </div>
                            </div>
                            <h5>Funds On Deposit Info Section</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_FOD" name="Any_FOD" value="1" onchange="getAnyFOD(this);" <?php if(isset($data['fundsondepositinfo']->Any_FOD) && $data['fundsondepositinfo']->Any_FOD=='1'){ echo "checked"; } ?> onchange="getAnyFOD(this);"> Do the parties have any saving, checking, or other funds on deposit?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 num_Joint_fundsondeposit_info" style="display: none;">
                                    <label>How many deposit accounts in BOTH parties’ names?</label>
                                    <input id="Num_Joint_Deposit_Accounts" type="number" class="form-control" name="Num_Joint_Deposit_Accounts" value="<?php if(isset($data['fundsondepositinfo']->Num_Joint_Deposit_Accounts)){ echo $data['fundsondepositinfo']->Num_Joint_Deposit_Accounts; } else { echo "0"; } ?>" min="0" max="10" required>  
                                 </div>
                                <div class="col-sm-6 num_Client_fundsondeposit_info" style="display: none;">
                                    <label>How many deposit accounts in {{$client_name}}’s name only?</label>
                                    <input id="Num_Client_Deposit_Accounts" type="number" class="form-control" name="Num_Client_Deposit_Accounts" value="<?php if(isset($data['fundsondepositinfo']->Num_Client_Deposit_Accounts)){ echo $data['fundsondepositinfo']->Num_Client_Deposit_Accounts; } else { echo "0"; } ?>" min="0" max="10" required>
                                 </div>
                                <div class="col-sm-6 num_Op_fundsondeposit_info" style="display: none;">
                                    <label>How many deposit accounts in {{$opponent_name}}’s name only?</label>
                                    <input id="Num_Op_Deposit_Accounts" type="number" class="form-control" name="Num_Op_Deposit_Accounts" value="<?php if(isset($data['fundsondepositinfo']->Num_Op_Deposit_Accounts)){ echo $data['fundsondepositinfo']->Num_Op_Deposit_Accounts; } else { echo "0"; } ?>" min="0" max="10" required>
                                 </div>
                            </div>
                            <h5>Pensions</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_Pension" name="Any_Pension" value="1" <?php if(isset($data['pensioninfo']->Any_Pension) && $data['pensioninfo']->Any_Pension=='1'){ echo "checked"; } ?> onchange="getAnyPension(this);"> Check if Any Pensions of {{$client_name}} and/or {{$opponent_name}}?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 Client_Op_Pension_Num_Input" style="display: none;">
                                    <label>How many pensions does {{$client_name}} have or is contributing to?</label>
                                    <input id="Num_Client_Pensions" type="number" class="form-control" name="Num_Client_Pensions" value="<?php if(isset($data['pensioninfo']->Num_Client_Pensions)){ echo $data['pensioninfo']->Num_Client_Pensions; } else { echo "0"; } ?>" min="0" max="4" required>
                                 </div>
                                <div class="col-sm-6 Client_Op_Pension_Num_Input" style="display: none;">
                                    <label for="Num_Op_Pensions">How many pensions does {{$opponent_name}} have or is contributing to?</label>
                                    <input id="Num_Op_Pensions" type="number" class="form-control" name="Num_Op_Pensions" value="<?php if(isset($data['pensioninfo']->Num_Op_Pensions)){ echo $data['pensioninfo']->Num_Op_Pensions; } else { echo "0"; } ?>" min="0" max="4" required> 
                                 </div>
                            </div>
                            <h5>Retirement Accounts</h5>
                            <div class="row mb-5">
                                <div class="col-sm-6">
                                    <label></label>
                                    <div class="w-100 dataInput">
                                         <label>
                                            <input type="checkbox" id="Any_Retirement_Accts" name="Any_Retirement_Accts" value="1" <?php if(isset($data['retirementaccountsinfo']->Any_Retirement_Accts) && $data['retirementaccountsinfo']->Any_Retirement_Accts=='1'){ echo "checked"; } ?> onchange="getAnyRetirementAccts(this);"> Does either party have a retirement account?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-6 num_Client_Retirement_Accts_info" style="display: none;">
                                    <label for="Num_Client_Retirement_Accts">How many pensions does {{$client_name}} have or is contributing to?</label>
                                    <input id="Num_Client_Retirement_Accts" type="number" class="form-control" name="Num_Client_Retirement_Accts" value="<?php if(isset($data['retirementaccountsinfo']->Num_Client_Retirement_Accts)){ echo $data['retirementaccountsinfo']->Num_Client_Retirement_Accts; } else { echo "0"; } ?>" min="0" max="4" required>
                                 </div>
                                <div class="col-sm-6 num_Op_Retirement_Accts_info" style="display: none;">
                                    <label for="Num_Op_Retirement_Accts">How many pensions does {{$opponent_name}} have or is contributing to?</label>
                                    <input id="Num_Op_Retirement_Accts" type="number" class="form-control" name="Num_Op_Retirement_Accts" value="<?php if(isset($data['retirementaccountsinfo']->Num_Op_Retirement_Accts)){ echo $data['retirementaccountsinfo']->Num_Op_Retirement_Accts; } else { echo "0"; } ?>" min="0" max="4" required>
                                 </div>
                            </div>
                        <!-- </div> -->
                        <!-- End of Client Income Info Section -->

                        <div class="form-group col-sm-12 text-center mt-4">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

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

function onWaiveSCRARightsChange(rights, rightstype){
    if(rights.checked){
        $('.'+rightstype+'_Possible_SCRA_Issues_Label').hide();
    } else {
        $('.'+rightstype+'_Possible_SCRA_Issues_Label').show();
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

function getAnyVehicle(vehicle){
    if(vehicle.checked){
        // $('#Num_Joint_Vehicles, #Num_Client_Vehicles, #Num_Op_Vehicles').val('0');
        $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').show();
    } else {
        // $('#Num_Joint_Vehicles, #Num_Client_Vehicles, #Num_Op_Vehicles').val('0');
        $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').hide();
    }
}

// show/hide this interview part based on Any Real Estate Input 
function getAnyRealEstate(vehicle){
    if(vehicle.checked){
        $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').show();
    } else {
        $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').hide();
    }
}

function getAnySIA(siacheck){
    if(siacheck.checked){
        $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').show();
    } else {
        $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').hide();
    }
}

// If there is any Funds On Deposite
function getAnyFOD(fodcheck){
    if(fodcheck.checked){
        $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').show();
    } else {
        $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').hide();
    }
}

// If Client Opponent Has Any Pension
function getAnyPension(pension){
    if(pension.checked){
        $('.Client_Op_Pension_Num_Input').show();
    } else {
        $('.Client_Op_Pension_Num_Input').hide();
    }
}

function getAnyRetirementAccts(retacc){
    if(retacc.checked){
        $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').show();
    } else {
        $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').hide();
    }
}

// format amounts to currency inputs
const formatter = new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2
});

$(document).ready(function(){

    $('#dr_Case_Overview').validate({
        
    });

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });

    $(".hasDatepicker").datepicker({
        startDate: "01/01/1900",
        // endDate: '+0d',
    });

    $('[data-onload]').each(function(){
        eval($(this).data('onload'));
    });

    var any_vehicle=$('#Any_Vehicles');
    if(any_vehicle.prop("checked") == true){
        $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').show();
    } else {
        $('.Num_Joint_Vehicles, .Num_Client_Vehicles, .Num_Op_Vehicles').hide();
    }

    var any_realestate=$('#Any_Real_Estate');
    if(any_realestate.prop("checked") == true){
        $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').show();
    } else {
        $('.num_Joint_realestate, .num_Client_realestate, .num_Op_realestate').hide();
    }

    var any_siacheck=$('#Any_Stocks_Investments_Accounts');
    if(any_siacheck.prop("checked") == true){
        $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').show();
    } else {
        $('.num_Joint_stocksinvestments_info, .num_Client_stocksinvestments_info, .num_Op_stocksinvestments_info').hide();
    }

    var any_fodcheck=$('#Any_FOD');
    if(any_fodcheck.prop("checked") == true){
        $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').show();
    } else {
        $('.num_Joint_fundsondeposit_info, .num_Client_fundsondeposit_info, .num_Op_fundsondeposit_info').hide();
    }

    var any_pensioncheck=$('#Any_Pension');
    if(any_pensioncheck.prop("checked") == true){
        $('.Client_Op_Pension_Num_Input').show();
    } else {
        $('.Client_Op_Pension_Num_Input').hide();
    }

    var any_retacc=$('#Any_Retirement_Accts');
    if(any_retacc.prop("checked") == true){
        $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').show();
    } else {
        $('.num_Client_Retirement_Accts_info, .num_Op_Retirement_Accts_info').hide();
    }

});
</script>   
@endsection