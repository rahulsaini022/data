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

                                    @if ($fullname[0])
                                        {{ $fullname[0] }}
                                    @endif
                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Last Name:</strong>

                                    @if ($fullname[1])
                                        {{ $fullname[1] }}
                                    @endif

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Middle Name:</strong>

                                    {{ $attorney_data->mname }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Document Sig/Name:</strong>

                                    {{ $attorney_data->document_sign_name }}

                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Email:</strong>

                                    {{ $user->email }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Special Practice Type:</strong>

                                    {{ $attorney_data->special_practice }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #1 State:</strong>

                                    {{ $attorney_data->attorney_attorney_reg_1_state_id }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #1:</strong>

                                    {{ $attorney_data->attorney_reg_1_num }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #2 State:</strong>

                                    {{ $attorney_data->attorney_attorney_reg_2_state_id }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #2:</strong>

                                    {{ $attorney_data->attorney_reg_2_num }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #3 State:</strong>

                                    {{ $attorney_data->attorney_attorney_reg_3_state_id }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Attorney Reg #3:</strong>

                                    {{ $attorney_data->attorney_reg_3_num }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Name:</strong>

                                    {{ $attorney_data->firm_name }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Street Address:</strong>

                                    {{ $attorney_data->firm_street_address }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm City:</strong>

                                    {{ $attorney_data->firm_city }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm State:</strong>

                                    {{ $attorney_data->firm_state }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm County:</strong>

                                    {{ $attorney_data->firm_county }}

                                </div>

                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Zip Code:</strong>

                                    {{ $attorney_data->firm_zipcode }}
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">


                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Firm Telephone:</strong>

                                    {{ $attorney_data->firm_telephone }}
                                </div>


                                <div class="form-group col-xs-6 col-sm-6 col-md-6">

                                    <strong>Roles:</strong>

                                    @if(!empty($user->getRoleNames()))

                                        @foreach($user->getRoleNames() as $v)

                                            <label class="badge badge-success">{{ $v }}</label>

                                        @endforeach

                                    @endif

                                </div>

                            </div>

                        </div>

                </div>    
            </div>   
        </div>
    </div>
</div>            

@endsection