@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center case-registration-steps party-registration-main">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>{{ __('Party Registration') }}</strong>
                        <div class="pull-right">
                            @if (Session::get('has_third_party') && Session::get('redirect_to') && Session::get('pleading_id'))
                                <a class="btn btn-success mb-2"
                                    href="{{ route('cases.pleadings.pleadinghasaddedthirdparties', $case_id) }}">Back to
                                    Pleadings</a>
                            @endif
                            <a class="btn btn-primary mb-2" href="{{ route('cases.edit', $case_id) }}">Back</a>
                        </div>
                    </div>
                    <div class="card-body table-sm table-responsive">
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
                        $is_client_top_bottom = '';
                        if (isset($already_client_top) && $already_client_top == '1') {
                            $is_client_top_bottom = 'top';
                        }
                        if (isset($already_client_bottom) && $already_client_bottom == '1') {
                            $is_client_top_bottom = 'bottom';
                        }
                        if (isset($case_data->top_party_type)) {
                            $top_party_type = $case_data->top_party_type;
                            $bottom_party_type = $case_data->bottom_party_type;
                            $number_top_party_type = $case_data->number_top_party_type;
                            $number_bottom_party_type = $case_data->number_bottom_party_type;
                        } else {
                            $top_party_type = $case_data->original_top_party_type;
                            $bottom_party_type = $case_data->original_bottom_party_type;
                            $number_top_party_type = $case_data->original_number_top_party_type;
                            $number_bottom_party_type = $case_data->original_number_bottom_party_type;
                        }
                        // for third parties
                        $number_top_third_parties = 0;
                        $number_bottom_third_parties = 0;
                        if (isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint == 'Yes') {
                            $if_there_is_third_party_complaint = $case_data->if_there_is_third_party_complaint;
                            $number_top_third_parties = $case_data->number_top_third_parties;
                            $number_bottom_third_parties = $case_data->number_bottom_third_parties;
                        }
                        ?>
                        <?php $t1 = $case_data->total_top_parties;
                        $t1 = $t1 + 1; ?>
                        <h4>{{ $top_party_type }}@if ($top_party_type != 'Petitioner 1')
                                (s)
                                @endif @if ($case_data->total_top_parties < $number_top_party_type)
                                    <button type="button" id="top_party_check" style="margin-bottom: 15px;"
                                        class="show-party-form btn btn-primary float-right"
                                        data-is-client="{{ $is_client_top_bottom }}">Add {{ $top_party_type }}
                                        @if ($top_party_type != 'Petitioner 1')
                                            (#{{ $t1 }})
                                        @endif
                                    </button>
                                @endif
                        </h4>
                        @if (isset($top_party_data))
                            <table style="min-width:800px!important" class="table table-bordered top-party-table">
                                <tr>
                                    <th>Pleading Position</th>
                                    <th>Affiliation</th>
                                    <th>Name</th>
                                    <th>Telephone</th>
                                    <th>Email</th>
                                    <th>Attorneys</th>
                                    <th class="wid">Action</th>
                                </tr>
                                <?php $num_top = 1;
                                $i = 1; ?>
                                @foreach ($top_party_data as $key => $party)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $party->type }}</td>
                                        <td>{{ $party->name }}</td>
                                        <td>{{ $party->telephone }}</td>
                                        <td>{{ $party->email }}</td>
                                        <td>
                                            {{ $party->total_attornies }} of 3 &nbsp<a class="btn btn-primary mb-2"
                                                href="{{ route('cases.show_attorney_reg_form', ['party_id' => $party->id, 'case_id' => $case_id, 'number' => $num_top]) }}">
                                                @if ($party->total_attornies < 3)
                                                    Add New
                                                @else
                                                    View List
                                                @endif
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary mb-2"
                                                href="{{ route('cases.edit_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => $party->type, 'number' => $num_top]) }}">Edit</a>
                                            <a class="btn btn-danger mb-2" onclick="return ConfirmStatus(event);"
                                                href="{{ route('cases.delete_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => $party->type, 'party_group' => $party->party_group]) }}">Delete</a>
                                            <!-- activate/deactivate party button checks -->
                                            @if ($num_top == 1 && $case_data->payment_status == '1' && $case_data->case_payment_package_id == '14')
                                                <?php
                                                $is_active = \App\User::where('id', $party->id)
                                                    ->get()
                                                    ->pluck('active')
                                                    ->first();
                                                ?>
                                                @if ($is_active == '0')
                                                    <a class="btn btn-success mb-2" href=""
                                                        onclick="event.preventDefault(); document.getElementById('activate-form-{{ $party->id }}').submit();">Activate</a>
                                                    <form id="activate-form-{{ $party->id }}"
                                                        action="{{ route('cases.party.activate_deactivate') }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="case_id" value="{{ $case_id }}">
                                                        <input type="hidden" name="party_id" value="{{ $party->id }}">
                                                        <input type="hidden" name="active_status" value="1">
                                                    </form>
                                                @else
                                                    <a class="btn btn-secondary mb-2" href=""
                                                        onclick="event.preventDefault(); document.getElementById('deactivate-form-{{ $party->id }}').submit();">Deactivate</a>
                                                    <form id="deactivate-form-{{ $party->id }}"
                                                        action="{{ route('cases.party.activate_deactivate') }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        <input type="hidden" name="case_id" value="{{ $case_id }}">
                                                        <input type="hidden" name="party_id" value="{{ $party->id }}">
                                                        <input type="hidden" name="active_status" value="0">
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                    <?php ++$num_top; ?>
                                @endforeach
                            </table>
                        @endif
                        <?php $t2 = $case_data->total_bottom_parties;
                        $t2 = $t2 + 1; ?>
                        @if (isset($bottom_party_data))
                            <h4>{{ $bottom_party_type }}@if ($bottom_party_type != 'Petitioner 2')
                                    (s)
                                @endif
                                @endif @if ($case_data->total_bottom_parties < $number_bottom_party_type &&
                                    (isset($top_party_data) || isset($bottom_party_data)))
                                    <button type="button" id="bottom_party_check"style="margin-bottom: 15px;"
                                        class="show-party-form btn btn-primary  float-right"
                                        data-is-client="{{ $is_client_top_bottom }}">Add {{ $bottom_party_type }}
                                        @if ($bottom_party_type != 'Petitioner 2')
                                            (#{{ $t2 }})
                                        @endif
                                    </button>
                                @endif
                            </h4>
                            @if (isset($bottom_party_data))
                                <table style="min-width:800px!important" class="table table-bordered bottom-party-table">
                                    <tr>
                                        <th>Pleading Position</th>
                                        <th>Affiliation</th>
                                        <th>Name</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Attorneys</th>
                                        <th class="wid">Action</th>
                                    </tr>
                                    <?php $num_bottom = 1;
                                    $i = 1; ?>
                                    @foreach ($bottom_party_data as $key => $party)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $party->type }}</td>
                                            <td>{{ $party->name }}</td>
                                            <td>{{ $party->telephone }}</td>
                                            <td><?php if (isset($party->email) && strpos($party->email, 'unknown_' . $case_id . '_') === false) {
                                                echo $party->email;
                                            } ?></td>
                                            <td>
                                                {{ $party->total_attornies }} of 3 &nbsp<a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.show_attorney_reg_form', ['party_id' => $party->id, 'case_id' => $case_id, 'number' => $num_bottom]) }}">
                                                    @if ($party->total_attornies < 3)
                                                        Add New
                                                    @else
                                                        List
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.edit_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => $party->type, 'number' => $num_bottom]) }}">Edit</a>
                                                <a class="btn btn-danger mb-2" onclick="return ConfirmStatus(event);"
                                                    href="{{ route('cases.delete_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => $party->type, 'party_group' => $party->party_group]) }}">Delete</a>
                                                @if ($num_bottom == 1 && $case_data->payment_status == '1' && $case_data->case_payment_package_id == '14')
                                                    <?php
                                                    $is_active = \App\User::where('id', $party->id)
                                                        ->get()
                                                        ->pluck('active')
                                                        ->first();
                                                    ?>
                                                    @if ($is_active == '0')
                                                        <a class="btn btn-success mb-2" href=""
                                                            onclick="event.preventDefault(); document.getElementById('activate-form-{{ $party->id }}').submit();">Activate</a>
                                                        <form id="activate-form-{{ $party->id }}"
                                                            action="{{ route('cases.party.activate_deactivate') }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="case_id"
                                                                value="{{ $case_id }}">
                                                            <input type="hidden" name="party_id"
                                                                value="{{ $party->id }}">
                                                            <input type="hidden" name="active_status" value="1">
                                                        </form>
                                                    @else
                                                        <a class="btn btn-secondary mb-2" href=""
                                                            onclick="event.preventDefault(); document.getElementById('deactivate-form-{{ $party->id }}').submit();">Deactivate</a>
                                                        <form id="deactivate-form-{{ $party->id }}"
                                                            action="{{ route('cases.party.activate_deactivate') }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="case_id"
                                                                value="{{ $case_id }}">
                                                            <input type="hidden" name="party_id"
                                                                value="{{ $party->id }}">
                                                            <input type="hidden" name="active_status" value="0">
                                                        </form>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        <?php ++$num_bottom; ?>
                                    @endforeach
                                </table>
                            @endif
                            <!-- tables for third parties -->
                            <?php $t3 = $case_data->total_top_third_parties;
                            $t3 = $t3 + 1; ?>
                            @if (isset($top_third_party_data) && count($top_third_party_data) > 0)
                                <h4>Third-Party {{ $top_party_type }}(s)
                            @endif
                            @if ($case_data->total_top_third_parties < $number_top_third_parties && $case_data->total_top_parties > 0)
                                <div class="text-right"><button type="button" id="top_third_party_check"
                                        style="margin-bottom: 15px;" class="show-party-form btn btn-primary">Add
                                        Third-Party {{ $top_party_type }} @if ($top_party_type != 'Petitioner 1')
                                            (#{{ $t3 }})
                                        @endif
                                    </button>
                                </div>
                            @endif
                            </h4>
                            @if (isset($top_third_party_data) && count($top_third_party_data) > 0)
                                <table style="min-width:800px!important"
                                    class="table table-bordered top-third-party-table">
                                    <tr>
                                        <th>Pleading Position</th>
                                        <th>Affiliation</th>
                                        <th>Name</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Attorneys</th>
                                        <th class="wid">Action</th>
                                    </tr>
                                    <?php $num_top_third = 1;
                                    $i = 1; ?>
                                    @foreach ($top_third_party_data as $key => $party)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $party->type }}</td>
                                            <td>{{ $party->name }}</td>
                                            <td>{{ $party->telephone }}</td>
                                            <td>{{ $party->email }}</td>
                                            <td>
                                                {{ $party->total_attornies }} of 3 &nbsp<a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.show_attorney_reg_form', ['party_id' => $party->id, 'case_id' => $case_id, 'number' => $num_top_third]) }}">
                                                    @if ($party->total_attornies < 3)
                                                        Add New
                                                    @else
                                                        List
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.edit_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => 'third', 'number' => $num_top_third]) }}">Edit</a>
                                                <a class="btn btn-danger mb-2" onclick="return ConfirmStatus(event);"
                                                    href="{{ route('cases.delete_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => 'third', 'party_group' => $party->party_group]) }}">Delete</a>
                                            </td>
                                        </tr>
                                        <?php ++$num_top_third; ?>
                                    @endforeach
                                </table>
                            @endif
                            <?php $t4 = $case_data->total_bottom_third_parties;
                            $t4 = $t4 + 1; ?>
                            @if (isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                                <h4>Third-Party {{ $bottom_party_type }}(s)
                            @endif
                            @if ($case_data->total_bottom_third_parties < $number_bottom_third_parties && $case_data->total_top_parties > 0)
                                <div class="text-right"><button type="button" id="bottom_third_party_check"
                                        style="margin-bottom: 15px;" class="show-party-form btn btn-primary">Add
                                        Third-Party {{ $bottom_party_type }} @if ($bottom_party_type != 'Petitioner 2')
                                            (#{{ $t4 }})
                                        @endif
                                    </button>
                                </div>
                            @endif
                            </h4>
                            @if (isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                                <table style="min-width:800px!important"
                                    class="table table-bordered bottom-third-party-table">
                                    <tr>
                                        <th>Pleading Position</th>
                                        <th>Affiliation</th>
                                        <th>Name</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Attorneys</th>
                                        <th class="wid">Action</th>
                                    </tr>
                                    <?php $num_bottom_third = 1;
                                    $i = 1; ?>
                                    @foreach ($bottom_third_party_data as $key => $party)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $party->type }}</td>
                                            <td>{{ $party->name }}</td>
                                            <td>{{ $party->telephone }}</td>
                                            <td>{{ $party->email }}</td>
                                            <td>
                                                {{ $party->total_attornies }} of 3 &nbsp<a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.show_attorney_reg_form', ['party_id' => $party->id, 'case_id' => $case_id, 'number' => $num_bottom_third]) }}">
                                                    @if ($party->total_attornies < 3)
                                                        Add New
                                                    @else
                                                        List
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary mb-2"
                                                    href="{{ route('cases.edit_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => 'third', 'number' => $num_bottom_third]) }}">Edit</a>
                                                <a class="btn btn-danger mb-2" onclick="return ConfirmStatus(event);"
                                                    href="{{ route('cases.delete_party', ['user_id' => $party->id, 'case_id' => $case_id, 'type' => 'third', 'party_group' => $party->party_group]) }}">Delete</a>
                                            </td>
                                        </tr>
                                        <?php ++$num_bottom_third; ?>
                                    @endforeach
                                </table>
                            @endif
                            <!-- end of tables for third parties -->
                            @if (isset($top_party_data) || isset($bottom_party_data))
                                <div class="col-md-12">
                                    @if ($case_data->total_top_parties < $number_top_party_type ||
                                        $case_data->total_bottom_parties < $number_bottom_party_type)
                                        <!-- <div class="col-md-6" style="display: inline-block; float: left;">
                                <h4>Register New Party Type Below</h4>
                            </div> -->
                                    @endif
                                    @if ($case_data->payment_status == '0')
                                        <div class="col-md-6 pull-right"
                                            style="display: inline-block; text-align: right;">
                                            <a class="btn btn-primary"
                                                href="{{ route('cases.payment', $case_id) }}"><span>If done with
                                                    Registering Parties, Click here to proceed to Pay</span></a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if ($case_data->total_top_parties < $number_top_party_type ||
                                $case_data->total_bottom_parties < $number_bottom_party_type ||
                                $case_data->total_top_third_parties < $number_top_third_parties ||
                                $case_data->total_bottom_third_parties < $number_bottom_third_parties)
                                @if (isset($top_party_data))
                                    <form style="float: left; display: none;" role="form" id="multistep_case_form"
                                        method="POST" action="{{ route('cases.store_party') }}">
                                    @else
                                        <form style="float: left;" role="form" id="multistep_case_form"
                                            method="POST" action="{{ route('cases.store_party') }}">
                                @endif
                                @csrf
                                <input type="hidden" name="prospect_id" value="<?php if (isset($prospect_client->id) && $prospect_client->id != '') {
                                    echo $prospect_client->id;
                                } ?>" readonly="">
                                <div class="row form-group setup-content" id="step-2">
                                    <input id="case_id" type="hidden" class="form-control" name="case_id"
                                        value="{{ $case_id }}" autofocus="">
                                    <div class="col-md-12">
                                        <h4 id="title_for_top_party" style="display: none;">Register
                                            {{ $top_party_type }} @if ($top_party_type != 'Petitioner 1')
                                                (#{{ $t1 }})
                                            @endif
                                        </h4>
                                        <h4 id="title_for_bottom_party" style="display: none;">Register
                                            {{ $bottom_party_type }} @if ($bottom_party_type != 'Petitioner 2')
                                                (#{{ $t2 }})
                                            @endif
                                        </h4>
                                        <h4 id="title_for_top_third_party" style="display: none;">Register Third-Party
                                            {{ $top_party_type }} @if ($top_party_type != 'Petitioner 1')
                                                (#{{ $t3 }})
                                            @endif
                                        </h4>
                                        <h4 id="title_for_bottom_third_party" style="display: none;">Register Third-Party
                                            {{ $bottom_party_type }} @if ($bottom_party_type != 'Petitioner 2')
                                                (#{{ $t4 }})
                                            @endif
                                        </h4>
                                        <div class="col-md-8" style="display: none;">
                                            <label class="col-md-3 col-form-label text-md-left">Register Parties
                                                For*</label>
                                            @if ($case_data->total_top_parties < $number_top_party_type)
                                                <div class="col-md-4">
                                                    <input type="radio" id="top_party" name="party_group"
                                                        value="top" required="" checked>
                                                    <label for="top_party">Top Party {{ $top_party_type }}</label>
                                                </div>
                                            @endif
                                            @if ($case_data->total_bottom_parties < $number_bottom_party_type)
                                                <div class="col-md-4">
                                                    <input type="radio" id="bottom_party" name="party_group"
                                                        value="bottom" <?php if ($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties < $number_bottom_party_type) {
                                                            echo 'checked';
                                                        } ?>>
                                                    <label for="bottom_party">Bottom Party
                                                        {{ $bottom_party_type }}</label>
                                                </div>
                                            @endif
                                            <!-- for third parties -->
                                            @if ($case_data->total_top_third_parties < $number_top_third_parties)
                                                <div class="col-md-4">
                                                    <input type="radio" id="top_third_party" name="party_group"
                                                        value="top_third" required="" <?php if ($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties == $number_bottom_party_type && $case_data->total_top_third_parties < $number_top_third_parties) {
                                                            echo 'checked';
                                                        } ?>>
                                                    <label for="top_third_party">Top Third-Party
                                                        {{ $top_party_type }}</label>
                                                </div>
                                            @endif
                                            @if ($case_data->total_bottom_third_parties < $number_bottom_third_parties)
                                                <div class="col-md-4">
                                                    <input type="radio" id="bottom_third_party" name="party_group"
                                                        value="bottom_third" <?php if ($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties == $number_bottom_party_type && $case_data->total_top_third_parties == $number_top_third_parties && $case_data->total_bottom_third_parties < $number_bottom_third_parties) {
                                                            echo 'checked';
                                                        } ?>>
                                                    <label for="bottom_third_party">Bottom Third-Party
                                                        {{ $bottom_party_type }}</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label class="col-md-4 col-form-label text-md-left">Party Entity*</label>
                                            <div class="col-md-8">
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="individual" name="party_entity"
                                                        class="party_entity form-check-input" value="individual"
                                                        required="" checked="">
                                                    <label class="form-check-label "
                                                        for="individual">Individual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="organization_company"
                                                        class="party_entity form-check-input" name="party_entity"
                                                        value="organization_company">
                                                    <label class="form-check-label"
                                                        for="organization_company">Organization/Company</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 org_comp_name_main_div" style="display: none;">
                                            <div class="col">
                                                <label for="org_comp_name"
                                                    class=" col-form-label text-md-left">Organization/Company Name*</label>
                                                <input type="text" id="org_comp_name" class="form-control"
                                                    name="org_comp_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 party-type-div">
                                        <div class="col-md-6">
                                            <label class="col-md-4 col-form-label text-md-left">Party Type*</label>
                                            <div class="col-md-8">
                                                <input type="radio" id="party_type-client"
                                                    class="party_type party_type-client" name="party_type" value="client"
                                                    required="" checked="">
                                                <label for="party_type-client" class="party_type-client">Client</label>
                                                <input type="radio" id="party_type-opponent" class="party_type"
                                                    name="party_type" value="opponent">
                                                <label for="party_type-opponent">Opponent</label>
                                                <input type="radio" id="party_type-ally" class="party_type"
                                                    name="party_type" value="ally">
                                                <label for="party_type-ally">Ally</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 care_of_div" style="display: none;">
                                            <label class="col-md-4 col-form-label text-md-left">C/O*</label>
                                            <div class="col-md-8">
                                                <input type="radio" id="care_of-atty" name="care_of" value="atty">
                                                <label for="care_of-atty">Atty</label>
                                                <input type="radio" id="care_of-other" name="care_of" value="other">
                                                <label for="care_of-other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pauperis_div">
                                        <div class="col-md-6">
                                            <label class="col-md-4 col-form-label text-md-left">In <i>Forma
                                                    Pauperis</i>*</label>
                                            <div class="col-md-8">
                                                <input type="radio" id="pauperis-Yes" name="pauperis" class="pauperis"
                                                    value="Yes">
                                                <label for="pauperis-Yes"> Yes</label>
                                                <input type="radio" id="pauperis-No" class="pauperis" name="pauperis"
                                                    value="No" checked="">
                                                <label for="pauperis-No"> No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                    </div>
                                    <div class="col-md-12 designation-main-div">
                                        <div class="col-md-12 designation-num-div">
                                            <label class=" col-md-2 col-form-label text-md-left">Designation*</label>
                                            <div class="col-md-8">
                                                <label style="margin-right: 10px;" for="designation1"
                                                    class="party-designations">1. <input type="checkbox"
                                                        id="designation1" class="designation" name="designation1"
                                                        value="{{ $top_party_type }}"
                                                        style="margin-top: 4px; margin-right: 5px;" checked=""
                                                        readonly="" onclick="return false;" /><span
                                                        id="designation1_span"> {{ $top_party_type }}</span></label>
                                                <label style="margin-right: 10px;" for="designation2"
                                                    class="party-designations">2. <input type="checkbox"
                                                        id="designation2" class="designation" name="designation2"
                                                        value="Cross-claimant"
                                                        style="margin-top: 4px; margin-right: 5px;"> Cross-claimant</label>
                                                <label style="margin-right: 10px;" for="designation3"
                                                    class="party-designations">3. <input type="checkbox"
                                                        id="designation3" class="designation" name="designation3"
                                                        value="Cross-claim Defendant"
                                                        style="margin-top: 4px; margin-right: 5px;"> Cross-claim
                                                    Defendant</label>
                                                <?php if(isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint=='Yes'){ ?>
                                                <label style="margin-right: 10px;" for="designation4"
                                                    class="third-party-designations">4. <input type="checkbox"
                                                        id="designation4" class="designation" name="designation4"
                                                        value="Third-Party {{ $top_party_type }}"
                                                        style="margin-top: 4px; margin-right: 5px;">Third-Party
                                                    {{ $top_party_type }}</label>
                                                <label style="margin-right: 10px;" for="designation5"
                                                    class="third-party-designations">5. <input type="checkbox"
                                                        id="designation5" class="designation" name="designation5"
                                                        value="Third-Party {{ $bottom_party_type }}"
                                                        style="margin-top: 4px; margin-right: 5px;">Third-Party
                                                    {{ $bottom_party_type }}</label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 op_ally_div" style="display: none;">
                                        <div class="col-md-6">
                                            <label class="col-md-4 col-form-label text-md-left">Name Unknown*</label>
                                            <div class="col-md-8">
                                                <input type="radio" id="name_unknown-Yes" name="name_unknown"
                                                    class="name_unknown" value="Yes">
                                                <label for="name_unknown-Yes"> Yes</label>
                                                <input type="radio" id="name_unknown-No" class="name_unknown"
                                                    name="name_unknown" value="No" checked="">
                                                <label for="name_unknown-No"> No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 name_unknown_div" style="display: none;">
                                            <label for="gen_desc" class="col-md-4 col-form-label text-md-left">Gen
                                                Desc</label>
                                            <div class="col-md-10">
                                                <input id="gen_desc" type="text" class="form-control"
                                                    name="gen_desc" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 name_unknown_div" style="display: none;">
                                        <div class="col-md-6">
                                            <label class="col-md-4 col-form-label text-md-left">More than one Gen
                                                Desc</label>
                                            <div class="col-md-10">
                                                <input type="radio" id="is_multi_desc-Yes" name="is_multi_desc"
                                                    class="is_multi_desc" value="Yes">
                                                <label for="is_multi_desc-Yes"> Yes</label>
                                                <input type="radio" id="is_multi_desc-No" class="is_multi_desc"
                                                    name="is_multi_desc" value="No" checked="">
                                                <label for="is_multi_desc-No"> No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 more_gen_desc">
                                            <div class="col-md-10">
                                                <label for="more_gen_desc" class="col-form-label text-md-left">More Gen
                                                    Desc</label>
                                                <input id="more_gen_desc" type="text" class="form-control"
                                                    name="more_gen_desc" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clprefix" class="col-form-label text-md-left">Prefix</label>
                                                <select id="clprefix" name="clprefix" class="form-control"
                                                    autofocus="">
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
                                            <div class="col-md-10">
                                                <label for="clfname" class="col-form-label text-md-left">First
                                                    Name*</label>
                                                <input id="clfname" type="text" class="form-control" name="clfname"
                                                    value="<?php if (isset($prospect_client->prosp_fname) && $prospect_client->prosp_fname != '') {
                                                        echo $prospect_client->prosp_fname;
                                                    } ?>" required="" autofocus="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clmname" class=" col-form-label text-md-left">Middle
                                                    Name</label>
                                                <input id="clmname" type="text" class="form-control "
                                                    name="clmname" value="<?php if (isset($prospect_client->prosp_mname) && $prospect_client->prosp_mname != '') {
                                                        echo $prospect_client->prosp_mname;
                                                    } ?>" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="cllname" class=" col-form-label text-md-left">Last
                                                    Name*</label>
                                                <input id="cllname" type="text" class="form-control" name="cllname"
                                                    value="<?php if (isset($prospect_client->prosp_lname) && $prospect_client->prosp_lname != '') {
                                                        echo $prospect_client->prosp_lname;
                                                    } ?>" required="" autofocus="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clemail" class=" col-form-label text-md-left">Email<span
                                                        id="email_asterisk">*</span></label>
                                                <input id="clemail" type="email" class="form-control" name="clemail"
                                                    value="<?php if (isset($prospect_client->prosp_email) && $prospect_client->prosp_email != '') {
                                                        echo $prospect_client->prosp_email;
                                                    } ?>" autofocus="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clphone"
                                                    class=" col-form-label text-md-left">Telephone</label>
                                                <input id="clphone" maxlength="14"
                                                    onkeypress="return onlyNumber(event)" type="text"
                                                    class="form-control has-pattern-one" name="clphone"
                                                    value="<?php if (isset($prospect_client->prosp_phone) && $prospect_client->prosp_phone != '') {
                                                        echo $prospect_client->prosp_phone;
                                                    } ?>" autofocus=""
                                                    placeholder="(XXX) XXX-XXXX">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clsuffix" class=" col-form-label text-md-left">Suffix</label>
                                                <select id="clsuffix" name="clsuffix" class="form-control"
                                                    autofocus="">
                                                    <option value="">Choose Suffix Type</option>
                                                    <option value="Sr." <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'Sr.') {
                                                        echo 'selected';
                                                    } ?>>Sr.</option>
                                                    <option value="Jr." <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'Jr.') {
                                                        echo 'selected';
                                                    } ?>>Jr.</option>
                                                    <option value="I" <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'I') {
                                                        echo 'selected';
                                                    } ?>>I</option>
                                                    <option value="II" <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'II') {
                                                        echo 'selected';
                                                    } ?>>II</option>
                                                    <option value="III" <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'III') {
                                                        echo 'selected';
                                                    } ?>>III</option>
                                                    <option value="IV" <?php if (isset($prospect_client->prosp_sufname) && $prospect_client->prosp_sufname == 'IV') {
                                                        echo 'selected';
                                                    } ?>>IV</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clprefname" class=" col-form-label text-md-left">Preferred
                                                    Name</label>
                                                <input id="clprefname" type="text" class="form-control"
                                                    name="clprefname" value="" autofocus="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="short_name" class=" col-form-label text-md-left"
                                                    id="label_when_top_party">{{ $top_party_type }} @if ($top_party_type != 'Petitioner 1')
                                                        (#{{ $t1 }})
                                                    @endif Short Name for Pleadings/Motions</label>
                                                <label for="short_name" class=" col-form-label text-md-left"
                                                    id="label_when_bottom_party"
                                                    style="display: none;">{{ $bottom_party_type }} @if ($bottom_party_type != 'Petitioner 2')
                                                        (#{{ $t2 }})
                                                    @endif Short Name for Pleadings/Motions</label>
                                                <label for="short_name" class=" col-form-label text-md-left"
                                                    id="label_when_top_third_party" style="display: none;">Third-Party
                                                    {{ $top_party_type }} @if ($top_party_type != 'Petitioner 1')
                                                        (#{{ $t3 }})
                                                    @endif Short Name for Pleadings/Motions</label>
                                                <label for="short_name" class=" col-form-label text-md-left"
                                                    id="label_when_bottom_third_party" style="display: none;">Third-Party
                                                    {{ $bottom_party_type }} @if ($bottom_party_type != 'Petitioner 2')
                                                        (#{{ $t4 }})
                                                    @endif Short Name for Pleadings/Motions</label>
                                                <input id="short_name" type="text" class="form-control"
                                                    name="short_name" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 cldob-main-div">
                                            <div class="col-md-10">
                                                <label for="cldob" class="col-form-label text-md-left">Date of
                                                    Birth</label>
                                                <input type="text" class="form-control hasDatepicker" id="cldob"
                                                    name="cldob" placeholder="MM/DD/YYYY" value=""
                                                    autofocus="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        
                                     
                                        <div class="col-md-6 clssno_div">
                                            <div class="col-md-10">
                                                <label for="clssno" class="col-form-label text-md-left">Social Security
                                                    (Individual) Number</label>
                                                <input type="text" maxlength="11"
                                                    onkeypress="return onlyNumber(event)"
                                                    class="form-control has-pattern-two" id="clssno" name="clssno"
                                                    placeholder="XXX-XX-XXXX" value="" autofocus="">
                                            </div>
                                        </div>
                                        <div class="col-md-6 single-line-radio-div mt-4">
                                            <label class="col-md-4 col-form-label text-md-left">Gender*</label>
                                            <div class="col-md-6">
                                                <input type="radio" id="clgen-m" class="gender-input"
                                                    name="clgender" value="M" checked required="">
                                                <label for="clgen-m">M</label>
                                                <input type="radio" id="clgen-f" class="gender-input"
                                                    name="clgender" value="F">
                                                <label for="clgen-f">F</label>
                                                <input type="radio" id="clgen-n" class="gender-input"
                                                    name="clgender" value="N">
                                                <label for="clgen-n">N</label>
                                            </div>
                                            <p class=" col-md-12 gender-inpu-error float-left"></p>
                                        </div>
                                        <div class="col-md-6 employer_identification_div" style="display: none;">
                                            <div class="col-md-10">
                                                <label for="employer_identification"
                                                    class=" col-form-label text-md-left">Employer Identification (Org/Co)
                                                    Number</label>
                                                <input type="text" class="form-control" id="employer_identification"
                                                    name="employer_identification" placeholder="XX-XXXXXXX"
                                                    value="" autofocus="">
                                            </div>
                                        </div>
                                    
                                    @if ($hascaseid == 1)
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clssno" class=" col-form-label text-md-left">Relationship to
                                                    Child(ren)</label>
                                                <select id="relation_id" name="relation" class="form-control"
                                                    autofocus="" required="">
                                                    <option>Select Relation</option>
                                                    <option value="Mother">Mother</option>
                                                    <option value="Father">Father</option>
                                                    <option value="Maternal Grandmother">Maternal Grandmother</option>
                                                    <option value="Maternal Grandfather">Maternal Grandfather</option>
                                                    <option value="Paternal Grandmother">Paternal Grandmother</option>
                                                    <option value="Paternal Grandfather">Paternal Grandfather</option>
                                                    <option value="Maternal Aunt">Maternal Aunt</option>
                                                    <option value="Maternal Uncle">Maternal Uncle</option>
                                                    <option value="Paternal Aunt">Paternal Aunt</option>
                                                    <option value="Paternal Uncle">Paternal Uncle</option>
                                                    <option value="Sibling">Sibling</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    </div>
                                    <div class="col-md-6 client_relation_other_div"
                                        style="margin-top: 20px; display: none;">
                                        <div class="col-md-10">
                                            <label for="client_relation_other" class=" col-form-label text-md-left">Other
                                                Relation</label>
                                            <input type="text" class="form-control" id="relation_other"
                                                name="other_relation" value="" autofocus>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6 op_ally_div" style="display: none;">
                                            <label class="col-md-4 col-form-label text-md-left">Address Unknown*</label>
                                            <div class="col-md-10">
                                                <input type="radio" id="address_unknown-Yes" name="address_unknown"
                                                    class="address_unknown" value="Yes">
                                                <label for="address_unknown-Yes"> Yes</label>
                                                <input type="radio" id="address_unknown-No" class="address_unknown"
                                                    name="address_unknown" value="No" checked="">
                                                <label for="address_unknown-No"> No</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clzip" class=" col-form-label text-md-left">ZIP*</label>
                                                <input type="text" class="form-control" id="clzip" name="clzip"
                                                    value="<?php if (isset($prospect_client->prosp_zip) && $prospect_client->prosp_zip != '') {
                                                        echo $prospect_client->prosp_zip;
                                                    } ?>" autofocus="" required="">
                                                <span class="text-danger no-state-county-cl" style="display: none;">No
                                                    City, State, County found for this zipcode.</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clstate" class=" col-form-label text-md-left">State*</label>
                                                <input type="hidden" name="selected-state-cl"
                                                    value="<?php if (isset($prospect_client->prosp_state_id)) {
                                                        echo $prospect_client->prosp_state_id;
                                                    } ?>" class="selected-state-cl">
                                                <select id="clstate" name="clstate" class="form-control cl-state"
                                                    autofocus="" required="">
                                                    <option value="">Choose State</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clcounty" class=" col-form-label text-md-left">County*</label>
                                                <select id="clcounty" name="clcounty" class="form-control cl-county"
                                                    autofocus="" required="">
                                                    <option value="">Choose County</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clcity" class=" col-form-label text-md-left">City*</label>
                                                <input type="hidden" name="selected-city-cl"
                                                    value="<?php if (isset($prospect_client->prosp_city)) {
                                                        echo $prospect_client->prosp_city;
                                                    } ?>" class="selected-city-cl">
                                                <select id="clcity" name="clcity" class="form-control cl-city"
                                                    required="" autofocus="">
                                                    <option value="">Choose City</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clstreetad" class=" col-form-label text-md-left">Street
                                                    Address*</label>
                                                <input type="text" class="form-control" id="clstreetad"
                                                    name="clstreetad" value="<?php if (isset($prospect_client->prosp_street_ad) && $prospect_client->prosp_street_ad != '') {
                                                        echo $prospect_client->prosp_street_ad;
                                                    } ?>" autofocus=""
                                                    required="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="unit" class=" col-form-label text-md-left">Unit</label>
                                                <input id="unit" type="text" class="form-control "
                                                    name="unit" value="<?php if (isset($prospect_client->prosp_unit) && $prospect_client->prosp_unit != '') {
                                                        echo $prospect_client->prosp_unit;
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="pobox" class=" col-form-label text-md-left">PO Box</label>
                                                <input id="pobox" type="text" class="form-control" name="pobox"
                                                    value="<?php if (isset($prospect_client->prosp_pobox) && $prospect_client->prosp_pobox != '') {
                                                        echo $prospect_client->prosp_pobox;
                                                    } ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clfax" class=" col-form-label text-md-left">Fax</label>
                                                <input type="text" maxlength="14"
                                                    onkeypress="return onlyNumber(event)"
                                                    class="form-control has-pattern-one" id="clfax" name="clfax"
                                                    value="" autofocus="" placeholder="(XXX) XXX-XXXX">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-10">
                                                <label for="clprimlang" class=" col-form-label text-md-left">Primary
                                                    Language*</label>
                                                <select id="clprimlang" name="clprimlang"
                                                    class="form-control languages-select" autofocus="" required="">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 client_primlang_other_div"
                                            style="margin-top: 20px; display: none;">
                                            <div class="col-md-10">
                                                <label for="client_primlang_other"
                                                    class=" col-form-label text-md-left">Add Primary Language*</label>
                                                <input type="text" class="form-control" id="client_primlang_other"
                                                    name="client_primlang_other" value="" autofocus>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class=" col-md-4 single-line-radio-div">
                                            <label class="form-check-label">Requires Translator*</label>
                                            <input type="radio" id="clreqlangtrans-y" name="clreqlangtrans"
                                                value="Y" required="">
                                            <label for="clreqlangtrans-y">Y</label>
                                            <input type="radio" id="clreqlangtrans-n" name="clreqlangtrans"
                                                value="N" checked="">
                                            <label for="clreqlangtrans-n">N</label>
                                        </div>
                                        <div class="col-md-4 single-line-radio-div">
                                            <label class="form-check-label">Hearing Impaired*</label>
                                            <input type="radio" id="clhearingimpaired-y" name="clhearingimpaired"
                                                value="Y" required="">
                                            <label for="clhearingimpaired-y">Y</label>
                                            <input type="radio" id="clhearingimpaired-n" name="clhearingimpaired"
                                                value="N" checked="">
                                            <label for="clhearingimpaired-n">N</label>
                                        </div>
                                        <div class="col-md-4 single-line-radio-div">
                                            <label class="form-check-label">Requires Sign Language*</label>
                                            <input type="radio" id="clreqsignlang-y" name="clreqsignlang"
                                                value="Y" required="">
                                            <label for="clreqsignlang-y">Y</label>
                                            <input type="radio" id="clreqsignlang-n" name="clreqsignlang"
                                                value="N" checked="">
                                            <label for="clreqsignlang-n">N</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-md-center">
                                        <button class="btn btn-primary nextBtn" id="party_submit_btn"
                                            type="submit">Submit</button>
                                    </div>
                                </div>
                                </form>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#clphone").inputmask("(999) 999-9999");
            $("#clssno").inputmask("999-99-9999");
            $("#clfax").inputmask("(999) 999-9999");
            $('input[type=radio][name=clgender]').change(function() {
                if (this.value == 'M') {
                    $('#relation_id').each(function() {
                        $(this).val('Father').prop("selected", true);
                    });
                } else if (this.value == 'F') {
                    $('#relation_id').each(function() {
                        $(this).val('Mother').prop("selected", true);
                    });
                }
            });
            $('#multistep_case_form').validate({
                rules: {
                    clphone: {
                        pattern: (/\(?[0-9]{3}\) [0-9]{3}-[0-9]{4}$/)
                    },
                    clfax: {
                        pattern: (/\(?[0-9]{3}\) [0-9]{3}-[0-9]{4}$/)
                    },
                    clssno: {
                        pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
                    },
                    employer_identification: {
                        pattern: /[0-9]{2}-[0-9]{7}/
                    },
                    clemail: {
                        pattern: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
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
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") === "clgender") {
                        error.appendTo('.gender-inpu-error');
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $("#multistep_case_form").submit(function() {
                if ($("#multistep_case_form").valid()) {
                    $('#party_submit_btn').attr('disabled', 'disabled');
                    return true;
                }
                event.preventDefault();
                return false;
            });
            $(".hasDatepicker").datepicker({
                startDate: "01/01/1901",
                endDate: '+0d',
            });
            // $('#clzip').on('keyup', function() {
            $('#clzip').on('input', function() {
                var type = '';
                if (this.id == 'clzip') {
                    type = 'cl';
                }
                // if(this.id=='opzip'){
                //     type='op';
                // }
                $('.no-state-county-' + type + '').hide();
                $('.' + type + '-city').find('option').remove().end().append(
                    '<option value="">Choose City</option>');
                $('.' + type + '-state').find('option').remove().end().append(
                    '<option value="">Choose State</option>');
                $('.' + type + '-county').find('option').remove().end().append(
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
                                $('.no-state-county-' + type + '').show();
                                // $('.cl_no_zip').show();
                            } else {
                                $.each(data, function(key, val) {
                                    $('.' + type + '-city').append('<option value="' +
                                        data[key].city + '">' + data[key].city +
                                        '</option>');
                                    $('.' + type + '-state').append('<option value="' +
                                        data[key].state_id + '">' + data[key]
                                        .state + '</option>');
                                    $('.' + type + '-county').append('<option value="' +
                                        data[key].id + '">' + data[key]
                                        .county_name + '</option>');
                                });
                                var a = new Array();
                                $('.' + type + '-city').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('.' + type + '-state').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                var a = new Array();
                                $('.' + type + '-county').children("option").each(function(x) {
                                    test = false;
                                    b = a[x] = $(this).val();
                                    for (i = 0; i < a.length - 1; i++) {
                                        if (b == a[i]) test = true;
                                    }
                                    if (test) $(this).remove();
                                })
                                if ($('.' + type + '-city').children('option').length == '2') {
                                    $('.' + type + '-city').children('option').first().remove();
                                }
                                if ($('.' + type + '-state').children('option').length == '2') {
                                    $('.' + type + '-state').children('option').first()
                                .remove();
                                }
                                if ($('.' + type + '-county').children('option').length ==
                                    '2') {
                                    $('.' + type + '-county').children('option').first()
                                    .remove();
                                }
                                $('.no-state-county-cl').hide();
                            }
                        }
                    });
                }
            });
            // fetch languages
            $.ajax({
                url: "{{ route('ajax_get_languages') }}",
                method: "GET",
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    if (data == null || data == 'null') {} else {
                        $.each(data, function(key, val) {
                            $('.languages-select').append('<option value=' + val + '>' + val +
                                '</option>');
                        });
                    }
                }
            });
            // show language input box if selected language is OTHER
            // on client primary language change
            $('#clprimlang').on('change', function() {
                var primlang = this.value;
                if (primlang == 'OTHER') {
                    $('#client_primlang_other').prop('required', true);
                    $('.client_primlang_other_div').show();
                } else {
                    $('#client_primlang_other').prop('required', false);
                    $('.client_primlang_other_div').hide();
                }
            });
            // on party entity change
            $('.party_entity').on('change', function() {
                if (this.value == 'organization_company') {
                    $('#org_comp_name, #care_of-atty').prop('required', true);
                    $('#clfname, #cllname').prop('required', false);
                    $('.org_comp_name_main_div').show();
                    $('.gender-input').prop('checked', false);
                    $('#clgen-n').prop('checked', true);
                    $('#cldob').prop('required', false);
                    $('.cldob-main-div').hide();
                    $('.employer_identification_div, .care_of_div').show();
                    $('.clssno_div').hide();
                    if ($('#party_type-client').prop("checked") == true) {
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
            $('.show-party-form').on('click', function() {
                var is_client_top_bottom = $(this).data('is-client');
                if (is_client_top_bottom) {
                    if (is_client_top_bottom == 'top' && this.id == 'bottom_party_check') {
                        $('.party_type-client, #email_asterisk').hide();
                        $('input[name="party_group"]').prop('checked', false);
                        $('#party_type-opponent').prop('checked', true);
                        $('#clemail').prop('required', false);
                        $('.op_ally_div').show();
                        $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                            .prop('checked', false);
                        $('#gen_desc, #more_gen_desc').val('');
                        $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                    }
                }
                if (is_client_top_bottom) {
                    if (is_client_top_bottom == 'bottom' && this.id == 'top_party_check') {
                        $('.party_type-client, #email_asterisk').hide();
                        $('input[name="party_group"]').prop('checked', false);
                        $('#party_type-opponent').prop('checked', true);
                        $('#clemail').prop('required', false);
                        $('.op_ally_div').show();
                        $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                            .prop('checked', false);
                        $('#gen_desc, #more_gen_desc').val('');
                        $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                    }
                }
                if (is_client_top_bottom) {
                    if (is_client_top_bottom == 'top' && this.id == 'top_party_check') {
                        $('.party_type-client, #email_asterisk').show();
                        $('input[name="party_group"]').prop('checked', false);
                        $('#party_type-client').prop('checked', true);
                        $('#clemail').prop('required', true);
                        $('.op_ally_div, .name_unknown_div').hide();
                        $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                            .prop('checked', false);
                        $('#gen_desc, #more_gen_desc').val('');
                        $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                    }
                }
                if (is_client_top_bottom) {
                    if (is_client_top_bottom == 'bottom' && this.id == 'bottom_party_check') {
                        $('.party_type-client, #email_asterisk').show();
                        $('input[name="party_group"]').prop('checked', false);
                        $('#party_type-client').prop('checked', true);
                        $('#clemail').prop('required', true);
                        $('.op_ally_div, .name_unknown_div').hide();
                        $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                            .prop('checked', false);
                        $('#gen_desc, #more_gen_desc').val('');
                        $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                    }
                }
                $('#multistep_case_form').show();
                if (this.id == 'top_party_check') {
                    var top_party_type = "{{ $top_party_type }}";
                    $('#designation1').val(top_party_type);
                    $('#designation1_span').text(top_party_type);
                    $('input[name="party_group"]').prop('checked', false);
                    $('#top_party, #designation1').prop('checked', true);
                    $('#label_when_bottom_party, #title_for_bottom_party, #label_when_top_third_party, #title_for_top_third_party, #label_when_bottom_third_party, #title_for_bottom_third_party')
                        .hide();
                    $('#label_when_top_party, #title_for_top_party, .party-designations, .party-type-div')
                        .show();
                }
                if (this.id == 'bottom_party_check') {
                    var bottom_party_type = "{{ $bottom_party_type }}";
                    $('#designation1').val(bottom_party_type);
                    $('#designation1_span').text(bottom_party_type);
                    $('input[name="party_group"]').prop('checked', false);
                    $('#bottom_party, #designation1').prop('checked', true);
                    $('#label_when_top_party, #title_for_top_party, #label_when_top_third_party, #title_for_top_third_party, #label_when_bottom_third_party, #title_for_bottom_third_party')
                        .hide();
                    $('#label_when_bottom_party, #title_for_bottom_party, .party-designations, .party-type-div')
                        .show();
                }
                // for third parties
                if (this.id == 'top_third_party_check') {
                    $('input[name="party_group"], #designation1').prop('checked', false);
                    $('#top_third_party').prop('checked', true);
                    $('#label_when_top_party, #title_for_top_party, #label_when_bottom_party, #title_for_bottom_party, #label_when_bottom_third_party, #title_for_bottom_third_party, .party-designations, .party-type-div')
                        .hide();
                    $('#label_when_top_third_party, #title_for_top_third_party').show();
                }
                if (this.id == 'bottom_third_party_check') {
                    $('input[name="party_group"], #designation1').prop('checked', false);
                    $('#bottom_third_party').prop('checked', true);
                    $('#label_when_top_party, #title_for_top_party, #label_when_bottom_party, #title_for_bottom_party, #label_when_top_third_party, #title_for_top_third_party, .party-designations, .party-type-div')
                        .hide();
                    $('#label_when_bottom_third_party, #title_for_bottom_third_party').show();
                }
                $('html, body').animate({
                    scrollTop: $("#multistep_case_form").offset().top
                }, 1000);
                return false;
            });
            $('#clprefix').on('change', function() {
                if (this.value == 'Mr.') {
                    $('.gender-input').prop('checked', false);
                    $('#clgen-m').prop('checked', true);
                    $('#relation_id').each(function() {
                        $(this).val('Father').prop("selected", true);
                    });
                }
                if (this.value == 'Mrs.' || this.value == 'Ms.') {
                    $('.gender-input').prop('checked', false);
                    $('#clgen-f').prop('checked', true);
                    $('#relation_id').each(function() {
                        $(this).val('Mother').prop("selected", true);
                    });
                }
            });
            $('.party_type').on('change', function() {
                if (this.value == 'client') {
                    $('.care_of').prop('checked', false);
                    $('#care_of-atty').prop('checked', true);
                    $('#clemail').prop('required', true);
                    $('#email_asterisk').show();
                    $('.op_ally_div, .name_unknown_div').hide();
                    $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                        .prop('checked', false);
                    $('#gen_desc, #more_gen_desc').val('');
                    $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                } else {
                    $('.care_of').prop('checked', false);
                    $('#care_of-other').prop('checked', true);
                    $('#clemail').prop('required', false);
                    $('#email_asterisk').hide();
                    $('.op_ally_div').show();
                    $('input[name="name_unknown"], input[name="address_unknown"], input[name="is_multi_desc"]')
                        .prop('checked', false);
                    $('#gen_desc, #more_gen_desc').val('');
                    $('#name_unknown-No, #address_unknown-No, #is_multi_desc-No').prop('checked', true);
                    $('.name_unknown_div').hide();
                }
            });
            $('input[name="name_unknown"]').on('change', function() {
                if (this.value == 'Yes') {
                    $('#clfname, #cllname').prop('readonly', true);
                    $('#clfname').val('Name(s)');
                    $('#cllname').val('Unknown');
                    $('.name_unknown_div').show();
                    $('.more_gen_desc').hide();
                } else {
                    $('#clfname, #cllname').prop('readonly', false);
                    $('#clfname, #cllname, #gen_desc, #more_gen_desc').val('');
                    $('.name_unknown_div').hide();
                    $('input[name="is_multi_desc"]').prop('checked', false);
                    $('#is_multi_desc-No').prop('checked', true);
                }
            });
            $('input[name="is_multi_desc"]').on('change', function() {
                if (this.value == 'Yes') {
                    $('.more_gen_desc').show();
                } else {
                    $('.more_gen_desc').hide();
                    $('#more_gen_desc').val('');
                }
            });
            $('input[name="address_unknown"]').on('change', function() {
                if (this.value == 'Yes') {
                    $('#clzip, #clstreetad').val('');
                    $('#clzip, #clstreetad').prop('readonly', true);
                    $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', false);
                    $('#clstate, #clcounty, #clcity').empty();
                    $('#clstate').append('<option value="">Choose State</option>');
                    $('#clcounty').append('<option value="">Choose County</option>');
                    $('#clcity').append('<option value="">Choose City</option>');
                } else {
                    $('#clzip, #clstreetad').prop('readonly', false);
                    $('#clzip, #clstate, #clcounty, #clcity, #clstreetad').prop('required', true);
                }
            });
        });
        // confirm before deletion
      
        // client-opponent selected zip, city, state, county
        var cl = document.getElementById('clzip');
        test(cl);
        // var op=document.getElementById('opzip');
        // test(op);
        function test(t) {
            var type = '';
            if (t.id == 'clzip') {
                type = 'cl';
            }
            if (t.id == 'opzip') {
                type = 'op';
            }
            $('.no-state-county-' + type + '').hide();
            $('.' + type + '-city').find('option').remove().end().append('<option value="">Choose City</option>');
            $('.' + type + '-state').find('option').remove().end().append('<option value="">Choose State</option>');
            $('.' + type + '-county').find('option').remove().end().append('<option value="">Choose County</option>');
            var zip = t.value;
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
                            $('.no-state-county-' + type + '').show();
                            // $('.cl_no_zip').show();
                        } else {
                            // $('.cl_no_zip').hide();
                            $.each(data, function(key, val) {
                                $('.' + type + '-city').append('<option value="' + data[key].city +
                                    '">' + data[key].city + '</option>');
                                $('.' + type + '-state').append('<option value="' + data[key].state_id +
                                    '">' + data[key].state + '</option>');
                                $('.' + type + '-county').append('<option value="' + data[key].id +
                                    '">' + data[key].county_name + '</option>');
                            });
                            var a = new Array();
                            $('.' + type + '-city').children("option").each(function(x) {
                                test = false;
                                b = a[x] = $(this).val();
                                for (i = 0; i < a.length - 1; i++) {
                                    if (b == a[i]) test = true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('.' + type + '-state').children("option").each(function(x) {
                                test = false;
                                b = a[x] = $(this).val();
                                for (i = 0; i < a.length - 1; i++) {
                                    if (b == a[i]) test = true;
                                }
                                if (test) $(this).remove();
                            })
                            var a = new Array();
                            $('.' + type + '-county').children("option").each(function(x) {
                                test = false;
                                b = a[x] = $(this).val();
                                for (i = 0; i < a.length - 1; i++) {
                                    if (b == a[i]) test = true;
                                }
                                if (test) $(this).remove();
                            })
                            if ($('.' + type + '-city').children('option').length == '2') {
                                $('.' + type + '-city').children('option').first().remove();
                            }
                            if ($('.' + type + '-state').children('option').length == '2') {
                                $('.' + type + '-state').children('option').first().remove();
                            }
                            if ($('.' + type + '-county').children('option').length == '2') {
                                $('.' + type + '-county').children('option').first().remove();
                            }
                            $('.no-state-county-cl').hide();
                        }
                        var selected_city = $('.selected-city-' + type + '').val();
                        var selected_state = $('.selected-state-' + type + '').val();
                        var selected_county = $('.selected-county-' + type + '').val();
                        $('.' + type + '-city option:selected').removeAttr('selected');
                        $('.' + type + '-state option:selected').removeAttr('selected');
                        $('.' + type + '-county option:selected').removeAttr('selected');
                        $('.' + type + '-city option[value="' + selected_city + '"]').attr('selected',
                            'selected');
                        $('.' + type + '-state option[value="' + selected_state + '"]').attr('selected',
                            'selected');
                        $('.' + type + '-county option[value="' + selected_county + '"]').attr('selected',
                            'selected');
                    }
                });
            }
        }
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
