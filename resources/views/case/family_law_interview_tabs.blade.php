@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard case-edit-data-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>Family Law Interview/Data: {{ $data['client_name'] }}</strong>
                  <div class="pull-right">

                      @if (Session::get('complete_initial_interview'))
                          <a class="btn btn-success" href="{{ route('cases.pleadings',['case_id' => $case_id]) }}">Back to Pleadings</a>
                      @endif
                        @hasrole('client')
                            <a class="btn btn-primary" href="{{ route('client.cases') }}"> Back</a>
                        @else 
                            <a class="btn btn-primary" href="{{ route('cases.edit_case_data',$case_id) }}"> Back</a>
                        @endhasrole

                    </div>
                </div>
                <div class="card-body table-sm table-responsive case_data_outerbox">
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
                    <div class="row" id="auxiliary_data_button_div">
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addcaseoverviewinfo'])  && $data['addcaseoverviewinfo']==false)
                          <a class="btn btn-danger" href="{{route('drcaseoverview.create',$case_id) }}">Add Case Overview Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drcaseoverview.edit',$case_id) }}">Update Case Overview Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addpersonalinfo']) && $data['addpersonalinfo']==false) 
                          <a class="btn btn-danger" href="{{route('drpersonalinfo.create',$case_id) }}">Add Personal Info</a>
                        @elseif(isset($data['addpersonalinfo']) && $data['addpersonalinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drpersonalinfo.edit',$case_id) }}">Update Personal Info</a>
                        @else 
                          <a class="btn btn-success" href="{{route('drpersonalinfo.edit',$case_id) }}">Update Personal Info</a>         
                        @endif  
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addchildreninfo'])  && $data['addchildreninfo']==false)
                          <a class="btn btn-danger" href="{{route('drchildren.create',$case_id) }}">Add Children Info</a>
                        @elseif(isset($data['addchildreninfo']) && $data['addchildreninfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drchildren.edit',$case_id) }}">Update Children Info</a>
                        @else 
                          <a class="btn btn-success" href="{{route('drchildren.edit',$case_id) }}">Update Children Info</a>                           
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addinsuranceinfo'])  && $data['addinsuranceinfo']==false)
                          <a class="btn btn-danger" href="{{route('drinsurance.create',$case_id) }}">Add Insurance Info</a>
                        @else 
                          <a class="btn btn-success" href="{{route('drinsurance.edit',$case_id) }}">Update Insurance Info</a>                            
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addtemporaryordersinfo'])  && $data['addtemporaryordersinfo']==false)
                          <a class="btn btn-danger" href="{{route('drtemporaryorders.create',$case_id) }}">Add Temporary Orders Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drtemporaryorders.edit',$case_id) }}">Update Temporary Orders Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmonthlyhousingexpensesinfo'])  && $data['addmonthlyhousingexpensesinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmonthlyhousingexpenses.create',$case_id) }}">Add Monthly Housing Expenses Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmonthlyhousingexpenses.edit',$case_id) }}">Update Monthly Housing Expenses Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmonthlyhealthcareexpensesinfo'])  && $data['addmonthlyhealthcareexpensesinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmonthlyhealthcareexpenses.create',$case_id) }}">Add Monthly Health Care Expenses Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmonthlyhealthcareexpenses.edit',$case_id) }}">Update Monthly Health Care Expenses Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmonthlyeducationexpensesinfo'])  && $data['addmonthlyeducationexpensesinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmonthlyeducationexpenses.create',$case_id) }}">Add Monthly Education Expenses Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmonthlyeducationexpenses.edit',$case_id) }}">Update Monthly Education Expenses Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addgiftinheritanceinfo'])  && $data['addgiftinheritanceinfo']==false)
                          <a class="btn btn-danger" href="{{route('drgiftinheritance.create',$case_id) }}">Add Gift Inheritance Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drgiftinheritance.edit',$case_id) }}">Update Gift Inheritance Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmonthlylivingexpensesinfo'])  && $data['addmonthlylivingexpensesinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmonthlylivingexpenses.create',$case_id) }}">Add Monthly Living Expenses Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmonthlylivingexpenses.edit',$case_id) }}">Update Monthly Living Expenses Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmonthlydebtpaymentsinfo'])  && $data['addmonthlydebtpaymentsinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmonthlydebtpayments.create',$case_id) }}">Add Monthly Debt Payments Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmonthlydebtpayments.edit',$case_id) }}">Update Monthly Debt Payments Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addmarriageinfo'])  && $data['addmarriageinfo']==false)
                          <a class="btn btn-danger" href="{{route('drmarriageinfo.create',$case_id) }}">Add Marriage Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drmarriageinfo.edit',$case_id) }}">Update Marriage Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addspousalsupportthismarriageinfo'])  && $data['addspousalsupportthismarriageinfo']==false)
                          <a class="btn btn-danger" href="{{route('drspousalsupportthismarriage.create',$case_id) }}">Add Spousal Support This Marriage Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drspousalsupportthismarriage.edit',$case_id) }}">Update Spousal Support This Marriage Info</a>
                        @endif
                      </div>
                      @if(isset($data['ismarriageinfoset'])  && $data['ismarriageinfoset']==true && isset($data['Num_MinorDependant_Children_of_this_Marriage'])  && $data['Num_MinorDependant_Children_of_this_Marriage'] > 0)
                      <div class="col-sm-6 text-center mt-4">
                        <!-- show following links to add/update Monthly Expenses Children Of This Marriage Info only if Marriage Info is set and Number of minor or dependant children born to and/or adopted by the parties during marriage is greater than 0 -->
                        

                          @if(isset($data['addmonthlyexpenseschildrenofthismarriageinfo'])  && $data['addmonthlyexpenseschildrenofthismarriageinfo']==false)
                            <a class="btn btn-danger" href="{{route('drmonthlyexpenseschildrenofthismarriage.create',$case_id) }}">Add Monthly Expenses Children Of This Marriage Info</a>
                          @else
                            <a class="btn btn-success" href="{{route('drmonthlyexpenseschildrenofthismarriage.edit',$case_id) }}">Update Monthly Expenses Children Of This Marriage Info</a>
                          @endif
                      </div>
                        @else
                          <!-- <label class="badge badge-danger">N/A</label> -->
                        @endif
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addfundsondepositinfo'])  && $data['addfundsondepositinfo']==false)
                          <a class="btn btn-danger" href="{{route('drfundsondeposit.create',$case_id) }}">Add Funds On Deposit Info</a>
                        @elseif(isset($data['addfundsondepositinfo']) && $data['addfundsondepositinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drfundsondeposit.edit',$case_id) }}">Update Funds On Deposit Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drfundsondeposit.edit',$case_id) }}">Update Funds On Deposit Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addstocksinvestmentsinfo'])  && $data['addstocksinvestmentsinfo']==false)
                          <a class="btn btn-danger" href="{{route('drstocksinvestments.create',$case_id) }}">Add Stocks Investments Info</a>
                        @elseif(isset($data['addstocksinvestmentsinfo']) && $data['addstocksinvestmentsinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drstocksinvestments.edit',$case_id) }}">Update Stocks Investments Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drstocksinvestments.edit',$case_id) }}">Update Stocks Investments Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addrealestateinfo'])  && $data['addrealestateinfo']==false)
                          <a class="btn btn-danger" href="{{route('drrealestate.create',$case_id) }}">Add Real Estate Info</a>
                        @elseif(isset($data['addrealestateinfo']) && $data['addrealestateinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drrealestate.edit',$case_id) }}">Update Real Estate Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drrealestate.edit',$case_id) }}">Update Real Estate Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addretirementacctsinfo'])  && $data['addretirementacctsinfo']==false)
                          <a class="btn btn-danger" href="{{route('drretirementaccts.create',$case_id) }}">Add Retirement Accts Info</a>
                        @elseif(isset($data['addretirementacctsinfo']) && $data['addretirementacctsinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drretirementaccts.edit',$case_id) }}">Update Retirement Accts Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drretirementaccts.edit',$case_id) }}">Update Retirement Accts Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addvehiclesinfo'])  && $data['addvehiclesinfo']==false)
                          <a class="btn btn-danger" href="{{route('drvehicles.create',$case_id) }}">Add Vehicles Info</a>
                        @elseif(isset($data['addvehiclesinfo']) && $data['addvehiclesinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drvehicles.edit',$case_id) }}">Update Vehicles Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drvehicles.edit',$case_id) }}">Update Vehicles Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addpensionsinfo'])  && $data['addpensionsinfo']==false)
                          <a class="btn btn-danger" href="{{route('drpensions.create',$case_id) }}">Add Pensions Info</a>
                        @elseif(isset($data['addpensionsinfo']) && $data['addpensionsinfo']=='update') 
                          <a class="btn btn-danger" href="{{route('drpensions.edit',$case_id) }}">Update Pensions Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drpensions.edit',$case_id) }}">Update Pensions Info</a>
                        @endif
                      </div>
                      <div class="col-sm-6 text-center mt-4">
                        @if(isset($data['addincomeinfo'])  && $data['addincomeinfo']==false)
                          <a class="btn btn-danger" href="{{route('drincome.create',$case_id) }}">Add Income Info</a>
                        @elseif(isset($data['addincomeinfo']) && $data['addincomeinfo']=='update') 
                          <a class="btn btn-danger tt" href="{{route('drincome.edit',$case_id) }}">Update Income Info</a>
                        @else
                          <a class="btn btn-success" href="{{route('drincome.edit',$case_id) }}">Update Income Info</a>
                        @endif
                      </div>

                    </div>

                </div>
            </div>          
        </div>
    </div>
</div>        
@endsection