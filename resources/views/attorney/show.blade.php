@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard attorney-show">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Attorney Detail') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('attorneys.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">

                        <div class="row">

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <?php 
                                    $fullname=$user->name;
                                    $fullname = explode(" ", $fullname);
                                ?>
                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>First Name:</strong>

                                    @if (isset($fullname[0]))
                                        {{ $fullname[0] }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Last Name:</strong>

                                    @if (isset($fullname[1]))
                                        {{ $fullname[1] }}
                                    @endif

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Middle Name:</strong>
                                    @if (isset($attorney_data->mname))
                                        {{ $attorney_data->mname }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Document Sig/Name:</strong>
                                    @if (isset($attorney_data->document_sign_name))
                                        {{ $attorney_data->document_sign_name }}
                                    @endif    
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Email:</strong>

                                    {{ $user->email }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Special Practice Type:</strong>
                                    @if (isset($attorney_data->special_practice))
                                        {{ $attorney_data->special_practice }}
                                    @endif    
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #1 State:</strong>
                                    @if (isset($attorney_data->attorney_attorney_reg_1_state_id))
                                        {{ $attorney_data->attorney_attorney_reg_1_state_id }}
                                    @endif    
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #1:</strong>
                                    @if (isset($attorney_data->attorney_reg_1_num))
                                        {{ $attorney_data->attorney_reg_1_num }}
                                    @endif    
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #2 State:</strong>
                                    @if (isset($attorney_data->attorney_attorney_reg_2_state_id))
                                        {{ $attorney_data->attorney_attorney_reg_2_state_id }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #2:</strong>
                                    @if (isset($attorney_data->attorney_reg_2_num))
                                        {{ $attorney_data->attorney_reg_2_num }}
                                    @endif
                                    
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #3 State:</strong>
                                    @if (isset($attorney_data->attorney_attorney_reg_3_state_id))
                                        {{ $attorney_data->attorney_attorney_reg_3_state_id }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #3:</strong>
                                    @if (isset($attorney_data->attorney_reg_3_num))
                                        {{ $attorney_data->attorney_reg_3_num }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Name:</strong>
                                    @if (isset($attorney_data->firm_name))
                                        {{ $attorney_data->firm_name }}
                                    @endif

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Street Address:</strong>
                                    @if (isset($attorney_data->firm_street_address))
                                        {{ $attorney_data->firm_street_address }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm City:</strong>
                                    @if (isset($attorney_data->firm_city))
                                        {{ $attorney_data->firm_city }}
                                    @endif

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm State:</strong>
                                    @if (isset($attorney_data->firm_state))
                                        {{ $attorney_data->firm_state }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm County:</strong>
                                    @if (isset($attorney_data->firm_county))
                                        {{ $attorney_data->firm_county }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Zip Code:</strong>
                                    @if (isset($attorney_data->firm_zipcode))
                                        {{ $attorney_data->firm_zipcode }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Fax #:</strong>
                                    @if (isset($attorney_data->firm_fax))
                                        {{ $attorney_data->firm_fax }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                    <strong>Firm Telephone:</strong>
                                    @if (isset($attorney_data->firm_telephone))
                                        {{ $attorney_data->firm_telephone }}
                                    @endif 
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>PO Box:</strong>
                                    @if (isset($attorney_data->po_box))
                                        {{ $attorney_data->po_box }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Suite/Unit/MailCode:</strong>
                                    @if (isset($attorney_data->firm_suite_unit_mailcode))
                                        {{ $attorney_data->firm_suite_unit_mailcode }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Tagline:</strong>
                                    @if (isset($attorney_data->firm_tagline))
                                        {{ $attorney_data->firm_tagline }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                    
                                    <strong>Suffix:</strong>
                                    @if (isset($attorney_data->sufname))
                                        {{ $attorney_data->sufname }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Gender:</strong>
                                    @if (isset($attorney_data->gender))
                                        {{ $attorney_data->gender }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                    
                                    <strong>Attorney Title:</strong>
                                    @if (isset($attorney_data->attorneytitle))
                                        {{ $attorney_data->attorneytitle }}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Insured:</strong>
                                    @if (isset($attorney_data->insured))
                                        {{ $attorney_data->insured }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                    
                                    <strong>Admission Date:</strong>
                                    @if (isset($attorney_data->admissiondate))
                                        {{ date('m-d-Y', strtotime($attorney_data->admissiondate))}}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>How Admitted:</strong>
                                    @if (isset($attorney_data->howadmitted))
                                        {{ $attorney_data->howadmitted }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">
                                    
                                    <strong>Birth Date:</strong>
                                    @if (isset($attorney_data->birthdate))
                                        {{ date('m-d-Y', strtotime($attorney_data->birthdate))}}
                                    @endif
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">


                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Current Status:</strong>
                                    @if (isset($attorney_data->currentstatus))
                                        {{ $attorney_data->currentstatus }}
                                    @endif
                                       
                                </div>


                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Roles:</strong>

                                    @if(!empty($user->getRoleNames()))

                                        @foreach($user->getRoleNames() as $v)

                                            <label class="badge badge-success">{{ $v }}</label>

                                        @endforeach

                                    @endif

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Number of cases registered by this attorney:</strong>
                                    @if (isset($attorney_data->number_of_cases_registered_by_attorney))
                                        {{ $attorney_data->number_of_cases_registered_by_attorney }}
                                    @endif
                                </div>

                            </div>

                            <h5 class="mt-3 col-xs-12 col-sm-12 col-md-12">State Seat Licenses</h5>

                            @if(isset($attorney_state_seat_license_transaction_history) && count($attorney_state_seat_license_transaction_history))
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <table class="table table-bordered seat-license-transaction-history-table">
                                    <thead>
                                        <tr>

                                            <th>Sno.</th>

                                            <th>State Name</th>

                                            <th>State Reg Num</th>
                                       
                                            <th>Amount</th>
                                            
                                            <th>Transaction ID</th>
                                       
                                            <th>Payment Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=0; ?>
                                    @foreach($attorney_state_seat_license_transaction_history as $transactions)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $transactions->state }}</td>
                                            <td>{{ $transactions->state_reg_num }}</td>
                                            <td>${{ $transactions->amount }}</td>
                                            <td>{{ $transactions->stripe_transaction_id }}</td>
                                            <td>{{ date('m-d-Y H:i:s', strtotime($transactions->created_at))}} </td>
                                        </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                            @else
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <p> No State Seat License Transactions by Attorney.</p>
                            </div>
                            @endif

                        </div>

                </div>    
            </div>   
        </div>
    </div>
</div>            

@endsection