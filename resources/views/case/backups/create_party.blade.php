@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center case-registration-steps party-registration-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Party Registration') }}</strong>
                    <div class="pull-right">

                        @if (Session::get('has_third_party') && Session::get('redirect_to') && Session::get('pleading_id'))
                            <a class="btn btn-success mb-2" href="{{ route('cases.pleadings.pleadinghasaddedthirdparties',$case_id) }}">Back to Pleadings</a>
                        @endif

                        <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case_id) }}">Back</a>
                    </div>
                </div>
                <div class="card-body table-sm table-responsive">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <?php 
                        $is_client_top_bottom='';
                        if(isset($already_client_top) && $already_client_top=='1'){
                          $is_client_top_bottom='top';
                        }
                        if(isset($already_client_bottom) && $already_client_bottom=='1'){
                          $is_client_top_bottom='bottom';
                        }

                        if(isset($case_data->top_party_type)){
                            $top_party_type=$case_data->top_party_type;
                            $bottom_party_type=$case_data->bottom_party_type;

                            $number_top_party_type=$case_data->number_top_party_type;
                            $number_bottom_party_type=$case_data->number_bottom_party_type;
                        } else {
                            $top_party_type=$case_data->original_top_party_type;
                            $bottom_party_type=$case_data->original_bottom_party_type;

                            $number_top_party_type=$case_data->original_number_top_party_type;
                            $number_bottom_party_type=$case_data->original_number_bottom_party_type;
                        }
                        
                        // for third parties
                        $number_top_third_parties=0;
                        $number_bottom_third_parties=0;
                        if(isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint=='Yes'){
                            $if_there_is_third_party_complaint=$case_data->if_there_is_third_party_complaint;
                            $number_top_third_parties=$case_data->number_top_third_parties;
                            $number_bottom_third_parties=$case_data->number_bottom_third_parties;
                        }
                    ?>
                    <?php $t1=$case_data->total_top_parties;$t1=$t1+1; ?>
                    @if(isset($top_party_data))
                    
                    <h4>{{$top_party_type}}(s) @if($case_data->total_top_parties < $number_top_party_type)<div class="text-right"><button type="button" id="top_party_check" style="margin-bottom: 15px;" class="show-party-form btn btn-primary" data-is-client="{{ $is_client_top_bottom }}">Add {{$top_party_type}} (#{{$t1}})</button></div>@endif</h4>
                    <table class="table table-bordered top-party-table">

                     <tr>

                       <th>Pleading Position</th>
                       
                       <th>Affiliation</th>

                       <th>Name</th>

                       <th>Telephone</th>
                       
                       <th>Email</th>
                                                                     
                       <th>Attorneys</th>

                       <th>Action</th>

                     </tr>
                     <?php $num_top=1; $i=1; ?>
                     @foreach ($top_party_data as $key => $party)

                      <tr>

                        <td>{{ $i++ }}</td>
                        
                        <td>{{ $party->type }}</td>

                        <td>{{ $party->name }}</td>

                        <td>{{ $party->telephone }}</td>

                        <td>{{ $party->email }}</td>
                        
                        <td>
                            {{$party->total_attornies}} of 3 &nbsp<a class="btn btn-primary mb-2" href="{{ route('cases.show_attorney_reg_form',['party_id'=>$party->id, 'case_id' => $case_id, 'number' => $num_top]) }}">@if($party->total_attornies < 3) Add New @else View List @endif</a>
                        </td>

                        <td>
                           <a class="btn btn-primary mb-2" href="{{ route('cases.edit_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => $party->type, 'number' => $num_top]) }}">Edit</a>

                            <a class="btn btn-danger mb-2" onclick="return ConfirmDelete();" href="{{ route('cases.delete_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => $party->type, 'party_group' => $party->party_group]) }}">Delete</a>

                            @if($num_top==1 && $case_data->payment_status=='1' && $case_data->case_payment_package_id=='14')
                              <?php 
                                $is_active=\App\User::where('id', $party->id)->get()->pluck('active')->first();
                              ?>

                              @if($is_active=='0')
                                <a class="btn btn-success mb-2" href="" onclick="event.preventDefault(); document.getElementById('activate-form-{{ $party->id }}').submit();">Activate</a>
                                <form id="activate-form-{{ $party->id }}" action="{{ route('cases.party.activate_deactivate') }}" method="POST" style="display: none;">
                                  @csrf
                                  <input type="hidden" name="case_id" value="{{ $case_id }}">
                                  <input type="hidden" name="party_id" value="{{ $party->id }}">
                                  <input type="hidden" name="active_status" value="1">
                                </form>
                              @else
                                <a class="btn btn-warning mb-2" href="" onclick="event.preventDefault(); document.getElementById('deactivate-form-{{ $party->id }}').submit();">Deactivate</a>
                                <form id="deactivate-form-{{ $party->id }}" action="{{ route('cases.party.activate_deactivate') }}" method="POST" style="display: none;">
                                  @csrf
                                  <input type="hidden" name="case_id" value="{{ $case_id }}">
                                  <input type="hidden" name="party_id" value="{{ $party->id }}">
                                  <input type="hidden" name="active_status" value="0">
                                </form>
                              @endif
                              
                            @endif
                        </td>

                      </tr>
                      <?php ++$num_top;?>
                     @endforeach
                    </table>
                    @endif
                    <?php $t2=$case_data->total_bottom_parties;$t2=$t2+1; ?>
                    @if(isset($bottom_party_data))
                    
                    <h4>{{$bottom_party_type}}(s) @endif @if($case_data->total_bottom_parties < $number_bottom_party_type && (isset($top_party_data) || isset($bottom_party_data)))<div class="text-right"><button type="button" id="bottom_party_check"style="margin-bottom: 15px;" class="show-party-form btn btn-primary" data-is-client="{{ $is_client_top_bottom }}">Add {{$bottom_party_type}} (#{{$t2}})</button></div>@endif</h4>
                    @if(isset($bottom_party_data))
                    <table class="table table-bordered bottom-party-table">

                     <tr>

                       <th>Pleading Position</th>
                       
                       <th>Affiliation</th>

                       <th>Name</th>

                       <th>Telephone</th>
                       
                       <th>Email</th>
                                              
                       <th>Attorneys</th>

                       <th>Action</th>

                     </tr>
                     <?php $num_bottom=1; $i=1; ?>
                     @foreach ($bottom_party_data as $key => $party)

                      <tr>

                        <td>{{ $i++ }}</td>
                        
                        <td>{{ $party->type }}</td>

                        <td>{{ $party->name }}</td>

                        <td>{{ $party->telephone }}</td>

                        <td>{{ $party->email }}</td>

                        <td>
                            {{$party->total_attornies}} of 3 &nbsp<a class="btn btn-primary mb-2" href="{{ route('cases.show_attorney_reg_form',['party_id'=>$party->id, 'case_id' => $case_id, 'number' => $num_bottom]) }}">@if($party->total_attornies < 3) Add New @else List @endif</a>
                        </td>

                        <td>
                           <a class="btn btn-primary mb-2" href="{{ route('cases.edit_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => $party->type, 'number' => $num_bottom]) }}">Edit</a>

                            <a class="btn btn-danger mb-2" onclick="return ConfirmDelete();" href="{{ route('cases.delete_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => $party->type, 'party_group' => $party->party_group]) }}">Delete</a>
                            @if($num_bottom==1 && $case_data->payment_status=='1' && $case_data->case_payment_package_id=='14')
                              <?php 
                                $is_active=\App\User::where('id', $party->id)->get()->pluck('active')->first();
                              ?>

                              @if($is_active=='0')
                                <a class="btn btn-success mb-2" href="" onclick="event.preventDefault(); document.getElementById('activate-form-{{ $party->id }}').submit();">Activate</a>
                                <form id="activate-form-{{ $party->id }}" action="{{ route('cases.party.activate_deactivate') }}" method="POST" style="display: none;">
                                  @csrf
                                  <input type="hidden" name="case_id" value="{{ $case_id }}">
                                  <input type="hidden" name="party_id" value="{{ $party->id }}">
                                  <input type="hidden" name="active_status" value="1">
                                </form>
                              @else
                                <a class="btn btn-warning mb-2" href="" onclick="event.preventDefault(); document.getElementById('deactivate-form-{{ $party->id }}').submit();">Deactivate</a>
                                <form id="deactivate-form-{{ $party->id }}" action="{{ route('cases.party.activate_deactivate') }}" method="POST" style="display: none;">
                                  @csrf
                                  <input type="hidden" name="case_id" value="{{ $case_id }}">
                                  <input type="hidden" name="party_id" value="{{ $party->id }}">
                                  <input type="hidden" name="active_status" value="0">
                                </form>
                              @endif
                              
                            @endif
                        </td>

                      </tr>
                      <?php ++$num_bottom;?>
                     @endforeach
                    </table>
                    @endif

                    <!-- tables for third parties -->
                    <?php $t3=$case_data->total_top_third_parties;$t3=$t3+1; ?>
                    @if(isset($top_third_party_data) && count($top_third_party_data) > 0)                    
                    <h4>Third-Party {{$top_party_type}}(s) @endif
                    @if($case_data->total_top_third_parties < $number_top_third_parties && $case_data->total_top_parties > 0)<div class="text-right"><button type="button" id="top_third_party_check" style="margin-bottom: 15px;" class="show-party-form btn btn-primary">Add Third-Party {{$top_party_type}} (#{{$t3}})</button></div>@endif</h4>
                    @if(isset($top_third_party_data) && count($top_third_party_data) > 0)                    
                    <table class="table table-bordered top-third-party-table">

                     <tr>

                       <th>Pleading Position</th>
                       
                       <th>Affiliation</th>

                       <th>Name</th>

                       <th>Telephone</th>
                       
                       <th>Email</th>

                       <th>Attorneys</th>
                                                                     
                       <th>Action</th>

                     </tr>
                     <?php $num_top_third=1; $i=1; ?>
                     @foreach ($top_third_party_data as $key => $party)

                      <tr>

                        <td>{{ $i++ }}</td>
                        
                        <td>{{ $party->type }}</td>

                        <td>{{ $party->name }}</td>

                        <td>{{ $party->telephone }}</td>

                        <td>{{ $party->email }}</td>

                        <td>
                            {{$party->total_attornies}} of 3 &nbsp<a class="btn btn-primary mb-2" href="{{ route('cases.show_attorney_reg_form',['party_id'=>$party->id, 'case_id' => $case_id, 'number' => $num_top_third]) }}">@if($party->total_attornies < 3) Add New @else List @endif</a>
                        </td>

                        <td>
                           <a class="btn btn-primary mb-2" href="{{ route('cases.edit_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => 'third', 'number' => $num_top_third]) }}">Edit</a>

                            <a class="btn btn-danger mb-2" onclick="return ConfirmDelete();" href="{{ route('cases.delete_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => 'third', 'party_group' => $party->party_group]) }}">Delete</a>
                        </td>

                      </tr>
                      <?php ++$num_top_third;?>
                     @endforeach
                    </table>
                    @endif
                    <?php $t4=$case_data->total_bottom_third_parties;$t4=$t4+1; ?>
                    @if(isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                    
                    <h4>Third-Party {{$bottom_party_type}}(s) @endif 
                    @if($case_data->total_bottom_third_parties < $number_bottom_third_parties && $case_data->total_top_parties > 0)<div class="text-right"><button type="button" id="bottom_third_party_check" style="margin-bottom: 15px;" class="show-party-form btn btn-primary">Add Third-Party {{$bottom_party_type}} (#{{$t4}})</button></div>@endif</h4>
                    @if(isset($bottom_third_party_data) && count($bottom_third_party_data) > 0)
                    <table class="table table-bordered bottom-third-party-table">

                     <tr>

                       <th>Pleading Position</th>
                       
                       <th>Affiliation</th>

                       <th>Name</th>

                       <th>Telephone</th>
                       
                       <th>Email</th>

                       <th>Attorneys</th>
                                              
                       <th>Action</th>

                     </tr>
                     <?php $num_bottom_third=1; $i=1; ?>
                     @foreach ($bottom_third_party_data as $key => $party)

                      <tr>

                        <td>{{ $i++ }}</td>
                        
                        <td>{{ $party->type }}</td>

                        <td>{{ $party->name }}</td>

                        <td>{{ $party->telephone }}</td>

                        <td>{{ $party->email }}</td>

                        <td>
                            {{$party->total_attornies}} of 3 &nbsp<a class="btn btn-primary mb-2" href="{{ route('cases.show_attorney_reg_form',['party_id'=>$party->id, 'case_id' => $case_id, 'number' => $num_bottom_third]) }}">@if($party->total_attornies < 3) Add New @else List @endif</a>
                        </td>

                        <td>
                           <a class="btn btn-primary mb-2" href="{{ route('cases.edit_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => 'third', 'number' => $num_bottom_third]) }}">Edit</a>

                            <a class="btn btn-danger mb-2" onclick="return ConfirmDelete();" href="{{ route('cases.delete_party',['user_id'=>$party->id, 'case_id' => $case_id, 'type' => 'third', 'party_group' => $party->party_group]) }}">Delete</a>
                        </td>

                      </tr>
                      <?php ++$num_bottom_third;?>
                     @endforeach
                    </table>
                    @endif
                    <!-- end of tables for third parties -->


                    @if(isset($top_party_data) || isset($bottom_party_data))
                    <div class="col-md-12">
                        @if($case_data->total_top_parties < $number_top_party_type || $case_data->total_bottom_parties < $number_bottom_party_type)
                        <!-- <div class="col-md-6" style="display: inline-block; float: left;">
                            <h4>Register New Party Type Below</h4>
                        </div> -->
                        @endif
                        @if($case_data->payment_status=='0')
                        <div class="col-md-6 pull-right" style="display: inline-block; text-align: right;">
                            <a class="btn btn-primary" href="{{ route('cases.payment',$case_id) }}"><span>If done with Registering Parties, Click here to proceed to Pay</span></a>
                        </div>
                        @endif
                    </div>
                    @endif
                    @if($case_data->total_top_parties < $number_top_party_type || $case_data->total_bottom_parties < $number_bottom_party_type || $case_data->total_top_third_parties < $number_top_third_parties || $case_data->total_bottom_third_parties < $number_bottom_third_parties)
                    @if(isset($top_party_data))
                    <form style="float: left; display: none;" role="form" id="multistep_case_form" method="POST" action="{{route('cases.store_party')}}">
                    @else
                    <form style="float: left;" role="form" id="multistep_case_form" method="POST" action="{{route('cases.store_party')}}">
                    @endif    
                        @csrf
                        <div class="row form-group setup-content" id="step-2">
                            <input id="case_id" type="hidden" class="form-control" name="case_id" value="{{ $case_id }}" autofocus="">
                            <div class="col-md-12">
                                <h4 id="title_for_top_party" style="display: none;">Register {{$top_party_type}} (#{{$t1}})</h4>
                                <h4 id="title_for_bottom_party" style="display: none;">Register {{$bottom_party_type}} (#{{$t2}})</h4>

                                <h4 id="title_for_top_third_party" style="display: none;">Register Third-Party {{$top_party_type}} (#{{$t3}})</h4>
                                <h4 id="title_for_bottom_third_party" style="display: none;">Register Third-Party {{$bottom_party_type}} (#{{$t4}})</h4>

                                <div class="col-md-8" style="display: none;">
                                    <label class="col-md-3 col-form-label text-md-left">Register Parties For*</label>
                                    @if($case_data->total_top_parties < $number_top_party_type)
                                    <div class="col-md-4">
                                        <input type="radio" id="top_party" name="party_group" value="top" required="" checked>
                                        
                                        <label for="top_party">Top Party {{$top_party_type}}</label>
                                    </div>
                                    @endif
                                    @if($case_data->total_bottom_parties < $number_bottom_party_type)    
                                    <div class="col-md-4">
                                        <input type="radio" id="bottom_party" name="party_group" value="bottom" <?php if($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties < $number_bottom_party_type){ echo "checked"; } ?>>
                                        <label for="bottom_party">Bottom Party {{$bottom_party_type}}</label>
                                    </div>
                                    @endif

                                    <!-- for third parties -->
                                    @if($case_data->total_top_third_parties < $number_top_third_parties)
                                    <div class="col-md-4">
                                        <input type="radio" id="top_third_party" name="party_group" value="top_third" required="" <?php if($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties == $number_bottom_party_type && $case_data->total_top_third_parties < $number_top_third_parties){ echo "checked"; } ?>>
                                        
                                        <label for="top_third_party">Top Third-Party {{$top_party_type}}</label>
                                    </div>
                                    @endif
                                    @if($case_data->total_bottom_third_parties < $number_bottom_third_parties)    
                                    <div class="col-md-4">
                                        <input type="radio" id="bottom_third_party" name="party_group" value="bottom_third" <?php if($case_data->total_top_parties == $number_top_party_type && $case_data->total_bottom_parties == $number_bottom_party_type && $case_data->total_top_third_parties == $number_top_third_parties && $case_data->total_bottom_third_parties < $number_bottom_third_parties){ echo "checked"; } ?>>
                                        <label for="bottom_third_party">Bottom Third-Party {{$bottom_party_type}}</label>
                                    </div>
                                    @endif
                                </div>
                                
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label class="col-md-4 col-form-label text-md-left">Party Entity*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="individual" name="party_entity" class="party_entity" value="individual" required="" checked="">
                                        <label for="individual">Individual</label>
                                        <input type="radio" id="organization_company" class="party_entity" name="party_entity" value="organization_company">
                                        <label for="organization_company">Organization/Company</label>
                                    </div>
                                </div>

                                <div class="col-md-6 org_comp_name_main_div"  style="display: none;">
                                    <label for="org_comp_name" class="col-md-4 col-form-label text-md-left">Organization/Company Name*</label>
                                    <div class="col-md-8">
                                        <input type="text" id="org_comp_name" class="form-control" name="org_comp_name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 party-type-div">
                                <div class="col-md-6">
                                    <label class="col-md-4 col-form-label text-md-left">Party Type*</label>
                                    <div class="col-md-8">
                                        <input type="radio" id="party_type-client" class="party_type party_type-client" name="party_type" value="client" required="" checked="">
                                        <label for="party_type-client" class="party_type-client">Client</label>
                                        <input type="radio" id="party_type-opponent" class="party_type" name="party_type" value="opponent">
                                        <label for="party_type-opponent">Opponent</label>
                                        <input type="radio" id="party_type-ally" class="party_type" name="party_type" value="ally">
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
                            <div class="col-md-12 designation-main-div">
                                <div class="col-md-12 designation-num-div">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="col-form-label text-md-left">Designation*</label>
                                        </div>
                                        <div class="col-md-10">
                                            <label style="margin-right: 10px;"for="designation1" class="party-designations">1. <input type="checkbox" id="designation1" class="designation" name="designation1" value="{{$top_party_type}}" style="margin-top: 4px; margin-right: 5px;" checked="" readonly="" onclick="return false;"/><span id="designation1_span"> {{$top_party_type}}</span></label>
                                            <label style="margin-right: 10px;"for="designation2" class="party-designations">2. <input type="checkbox" id="designation2" class="designation" name="designation2" value="Cross-claimant" style="margin-top: 4px; margin-right: 5px;"> Cross-claimant</label>
                                            <label style="margin-right: 10px;"for="designation3" class="party-designations">3. <input type="checkbox" id="designation3" class="designation" name="designation3" value="Cross-claim Defendant" style="margin-top: 4px; margin-right: 5px;"> Cross-claim Defendant</label>
                                        <?php if(isset($case_data->if_there_is_third_party_complaint) && $case_data->if_there_is_third_party_complaint=='Yes'){ ?>
                                            <label style="margin-right: 10px;"for="designation4" class="third-party-designations">4. <input type="checkbox" id="designation4" class="designation" name="designation4" value="Third-Party {{$top_party_type}}" style="margin-top: 4px; margin-right: 5px;">Third-Party {{$top_party_type}}</label>
                                            <label style="margin-right: 10px;"for="designation5" class="third-party-designations">5. <input type="checkbox" id="designation5" class="designation" name="designation5" value="Third-Party {{$bottom_party_type}}" style="margin-top: 4px; margin-right: 5px;">Third-Party {{$bottom_party_type}}</label>
                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clprefix" class="col-md-4 col-form-label text-md-left">Prefix</label>
                                    <div class="col-md-8">
                                        <select id="clprefix" name="clprefix" class="form-control" autofocus="">
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
                                    <label for="clfname" class="col-md-4 col-form-label text-md-left">First Name*</label>
                                    <div class="col-md-8">
                                        <input id="clfname" type="text" class="form-control" name="clfname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clmname" class="col-md-4 col-form-label text-md-left">Middle Name</label>
                                    <div class="col-md-8">
                                        <input id="clmname" type="text" class="form-control " name="clmname" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="cllname" class="col-md-4 col-form-label text-md-left">Last Name*</label>
                                    <div class="col-md-8">
                                        <input id="cllname" type="text" class="form-control" name="cllname" value="" required=""  autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clemail" class="col-md-4 col-form-label text-md-left">Email*</label>
                                    <div class="col-md-8">
                                        <input id="clemail" type="email" class="form-control" name="clemail" value="" autofocus="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="clphone" class="col-md-4 col-form-label text-md-left">Telephone</label>
                                    <div class="col-md-8">
                                        <input id="clphone" type="text" class="form-control has-pattern-one" name="clphone" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clsuffix" class="col-md-4 col-form-label text-md-left">Suffix</label>
                                    <div class="col-md-8">
                                        <select id="clsuffix" name="clsuffix" class="form-control" autofocus="">
                                            <option value="">Choose Suffix Type</option>
                                            <option value="Sr.">Sr.</option>
                                            <option value="Jr.">Jr.</option>
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprefname" class="col-md-4 col-form-label text-md-left">Preferred Name</label>
                                    <div class="col-md-8">
                                        <input id="clprefname" type="text" class="form-control" name="clprefname" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="short_name" class="col-md-4 col-form-label text-md-left" id="label_when_top_party">{{$top_party_type}} (#{{$t1}}) Short Name for Pleadings/Motions</label>
                                    <label for="short_name" class="col-md-4 col-form-label text-md-left" id="label_when_bottom_party" style="display: none;">{{$bottom_party_type}} (#{{$t2}}) Short Name for Pleadings/Motions</label>

                                    <label for="short_name" class="col-md-4 col-form-label text-md-left" id="label_when_top_third_party" style="display: none;">Third-Party {{$top_party_type}} (#{{$t3}}) Short Name for Pleadings/Motions</label>
                                    <label for="short_name" class="col-md-4 col-form-label text-md-left" id="label_when_bottom_third_party" style="display: none;">Third-Party {{$bottom_party_type}} (#{{$t4}}) Short Name for Pleadings/Motions</label>
                                    <div class="col-md-8">
                                        <input id="short_name" type="text" class="form-control" name="short_name" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Gender*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clgen-m" class="gender-input" name="clgender" value="M" required=""  checked="">
                                        <label for="clgen-m">M</label>
                                        <input type="radio" id="clgen-f" class="gender-input" name="clgender" value="F">
                                        <label for="clgen-f">F</label>
                                        <input type="radio" id="clgen-n" class="gender-input" name="clgender" value="N">
                                        <label for="clgen-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-2" style="float: left;display: inline-block;"></div>

                                <div class="col-md-6 clssno_div">
                                    <label for="clssno" class="col-md-4 col-form-label text-md-left">Social Security (Individual) Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-two" id="clssno" name="clssno" placeholder="XXX-XX-XXXX" value="" autofocus="">
                                    </div>
                                </div>
                                <div class="col-md-6 employer_identification_div" style="display: none;">
                                    <label for="employer_identification" class="col-md-4 col-form-label text-md-left">Employer Identification (Org/Co) Number</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="employer_identification" name="employer_identification" placeholder="XX-XXXXXXX" value="" autofocus="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 cldob-main-div">
                                    <label for="cldob" class="col-md-4 col-form-label text-md-left">Date of Birth</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control hasDatepicker" id="cldob" name="cldob" placeholder="MM/DD/YYYY" value="" autofocus="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clzip" class="col-md-4 col-form-label text-md-left">ZIP*</label>
                                    <div class="col-md-8">
                                    <p class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</p>
                                        <input type="text" class="form-control" id="clzip" name="clzip" value="" autofocus="" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <label for="clstate" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                        <select id="clstate" name="clstate" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <select id="clcounty" name="clcounty" class="form-control cl-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>  

                            <div class="col-md-12">

                                <div class="col-md-6">
                                    <label for="clcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
                                        <select id="clcity" name="clcity" class="form-control cl-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clstreetad" class="col-md-4 col-form-label text-md-left">Street Address*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="clstreetad" name="clstreetad" value="" autofocus="" required="">
                                    </div>
                                </div>
                            </div>
                              

                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="unit" class="col-md-4 col-form-label text-md-left">Unit</label>
                                    <div class="col-md-8">
                                        <input id="unit" type="text" class="form-control " name="unit" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="pobox" class="col-md-4 col-form-label text-md-left">PO Box</label>
                                    <div class="col-md-8">
                                        <input id="pobox" type="text" class="form-control" name="pobox" value="">
                                    </div>
                                </div>
                            </div>
                              
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <label for="clfax" class="col-md-4 col-form-label text-md-left">Fax</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control has-pattern-one" id="clfax" name="clfax" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="clprimlang" class="col-md-4 col-form-label text-md-left">Primary Language*</label>
                                    <div class="col-md-8">
                                        <select id="clprimlang" name="clprimlang" class="form-control languages-select" autofocus="" required="">
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 client_primlang_other_div" style="margin-top: 20px; display: none;">
                                    <label for="client_primlang_other" class="col-md-4 col-form-label text-md-left">Add Primary Language*</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="client_primlang_other" name="client_primlang_other" value="" autofocus>
                                        </select>
                                    </div>
                                </div>
                            </div>    
                            <div class="col-md-12">
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Translator*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqlangtrans-y" name="clreqlangtrans" value="Y" required="">
                                        <label for="clreqlangtrans-y">Y</label>
                                        <input type="radio" id="clreqlangtrans-n" name="clreqlangtrans" value="N" checked="">
                                        <label for="clreqlangtrans-n">N</label>
                                    </div>
                                </div>

                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Hearing Impaired*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clhearingimpaired-y" name="clhearingimpaired" value="Y" required="">
                                        <label for="clhearingimpaired-y">Y</label>
                                        <input type="radio" id="clhearingimpaired-n" name="clhearingimpaired" value="N" checked="">
                                        <label for="clhearingimpaired-n">N</label>
                                    </div>
                                </div>
                                <div class="col-md-4 single-line-radio-div">
                                    <label class="col-md-6 col-form-label text-md-left">Requires Sign Language*</label>
                                    <div class="col-md-6">
                                        <input type="radio" id="clreqsignlang-y" name="clreqsignlang" value="Y" required="">
                                        <label for="clreqsignlang-y">Y</label>
                                        <input type="radio" id="clreqsignlang-n" name="clreqsignlang" value="N" checked="">
                                        <label for="clreqsignlang-n">N</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-md-center">
                                <button class="btn btn-primary nextBtn" type="submit">Submit</button>
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
$(document).ready(function () {

    $('#multistep_case_form').validate({
        rules: {
            clphone: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            clfax: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            },
            clssno: {
                pattern: /[0-9]{3}-[0-9]{2}-[0-9]{4}/
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

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
        }
    });

    $(".hasDatepicker").datepicker({
        startDate: "01/01/1901",
        endDate: '+0d',
    });
    // $('#clzip').on('keyup', function() {
    $('#clzip').on('input', function() {
        var type='';
        if(this.id=='clzip'){
            type='cl';
        }
        // if(this.id=='opzip'){
        //     type='op';
        // }
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

        } else {
            $('#org_comp_name, #care_of-atty').prop('required', false);
            $('#clfname, #cllname').prop('required', true);
            $('.org_comp_name_main_div').hide();
            // $('#cldob').prop('required', true);
            $('.cldob-main-div').show(); 
            $('.employer_identification_div, .care_of_div').hide(); 
            $('.clssno_div').show();   
            $('.care_of').prop('checked', false);   
        }
    });

    // show party reg form
    $('.show-party-form').on('click', function() {
        var is_client_top_bottom=$(this).data('is-client');

        if(is_client_top_bottom){
          if(is_client_top_bottom=='top' && this.id=='bottom_party_check'){
            $('.party_type-client').hide();
            $('input[name="party_group"]').prop('checked', false);
            $('#party_type-opponent').prop('checked', true);
          }
        }

        if(is_client_top_bottom){
          if(is_client_top_bottom=='bottom' && this.id=='top_party_check'){
            $('.party_type-client').hide();
            $('input[name="party_group"]').prop('checked', false);
            $('#party_type-opponent').prop('checked', true);
          }
        }

        if(is_client_top_bottom){
          if(is_client_top_bottom=='top' && this.id=='top_party_check'){
            $('.party_type-client').show();
            $('input[name="party_group"]').prop('checked', false);
            $('#party_type-client').prop('checked', true);
          }
        }

        if(is_client_top_bottom){
          if(is_client_top_bottom=='bottom' && this.id=='bottom_party_check'){
            $('.party_type-client').show();
            $('input[name="party_group"]').prop('checked', false);
            $('#party_type-client').prop('checked', true);
          }
        }

        $('#multistep_case_form').show();

        if(this.id=='top_party_check'){
            var top_party_type="{{$top_party_type}}";
            $('#designation1').val(top_party_type);
            $('#designation1_span').text(top_party_type);
            $('input[name="party_group"]').prop('checked', false);
            $('#top_party, #designation1').prop('checked', true);
            $('#label_when_bottom_party, #title_for_bottom_party, #label_when_top_third_party, #title_for_top_third_party, #label_when_bottom_third_party, #title_for_bottom_third_party').hide();     
            $('#label_when_top_party, #title_for_top_party, .party-designations, .party-type-div').show();      
        }

        if(this.id=='bottom_party_check'){
            var bottom_party_type="{{$bottom_party_type}}";
            $('#designation1').val(bottom_party_type);
            $('#designation1_span').text(bottom_party_type);
            $('input[name="party_group"]').prop('checked', false);
            $('#bottom_party, #designation1').prop('checked', true);
            $('#label_when_top_party, #title_for_top_party, #label_when_top_third_party, #title_for_top_third_party, #label_when_bottom_third_party, #title_for_bottom_third_party').hide();
            $('#label_when_bottom_party, #title_for_bottom_party, .party-designations, .party-type-div').show();      

        }

        // for third parties
        if(this.id=='top_third_party_check'){
            $('input[name="party_group"], #designation1').prop('checked', false);
            $('#top_third_party').prop('checked', true);
            $('#label_when_top_party, #title_for_top_party, #label_when_bottom_party, #title_for_bottom_party, #label_when_bottom_third_party, #title_for_bottom_third_party, .party-designations, .party-type-div').hide();      
            $('#label_when_top_third_party, #title_for_top_third_party').show();      
        }

        if(this.id=='bottom_third_party_check'){
            $('input[name="party_group"], #designation1').prop('checked', false);
            $('#bottom_third_party').prop('checked', true);
            $('#label_when_top_party, #title_for_top_party, #label_when_bottom_party, #title_for_bottom_party, #label_when_top_third_party, #title_for_top_third_party, .party-designations, .party-type-div').hide();      
            $('#label_when_bottom_third_party, #title_for_bottom_third_party').show();      

        }

        $('html, body').animate({
            scrollTop: $("#multistep_case_form").offset().top
        }, 1000);
        return false;
    });

    $('#clprefix').on('change', function() {
        if(this.value=='Mr.'){
            $('.gender-input').prop('checked', false);
            $('#clgen-m').prop('checked', true);
        }
        if(this.value=='Mrs.' || this.value=='Ms.'){
            $('.gender-input').prop('checked', false);
            $('#clgen-f').prop('checked', true);
        }
    });

    $('.party_type').on('change', function() {
        if(this.value=='client'){
            $('.care_of').prop('checked', false);
            $('#care_of-atty').prop('checked', true);
        }else{
            $('.care_of').prop('checked', false);
            $('#care_of-other').prop('checked', true);
        }
    });
});
// confirm before deletion
function ConfirmDelete()
{
  var x = confirm("Are you sure you want to delete this party.");
  if (x)
    return true;
  else
    return false;
}
</script>    
@endsection