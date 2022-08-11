@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Quick Child Support Worksheets') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('fdd_tools') }}"> Back</a>
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

                    <div class="row"> 
                        <div class="col-sm-12 fdd-quick-child-support-section">
                            <label class="fdd-tools-main-label">FDD Quick Child Support</label>
                            <form method="POST" action="#" id="computation_sheet_form">
                                @csrf
                                <input type="hidden" id="selected_state" value="{{$attorney_data->state_id}}">
                                 <input type="hidden" name="sheet_state" value="35">
                                <div class="row">
                                    <!-- div class="col-sm-3 column-box-width">    
                                        <select id="sheet_state" name="sheet_state" class="form-control" required="" autofocus="">
                                            <option value="">Choose State</option>
                                        </select>           
                                    </div> -->
                                    <div class="col-sm-3 column-box-width">    
                                        <select id="sheet_custody" name="sheet_custody" class="form-control" required="" autofocus="">
                                            <option value="">Choose Custody</option>
                                            <option value="sole">Sole</option>
                                            <option value="shared">Shared</option>
                                            <option value="split">Split</option>
                                        </select>
                                    </div>
                                    <!-- <div class="col-sm-3 column-box-width prefill-check">        
                                        <input type="checkbox" name="chk_prefill" id="chk_prefill" value="1" checked=""><label for="chk_prefill" class="chk_prefill" >Prefill with my last submission.</label>
                                    </div>  --> 
                                    <input type="hidden" name="chk_prefill" value="0">
                                    <div class="col-sm-4 column-box-width">        
                                        <input type="submit" id="computation-btn" style="width: auto!important;" class="btn btn-success btn-computation new-btn new-btn-green " value="FDD Quick
                                        Child Computation Worksheet">       
                                    </div>
                                </div>  
                            </form>
                        </div>
                        <h4 class="mt-2"> List of previous Quick Child Support Worksheets </h4>
                        <div class="col-sm-12 mt-2">
                            @if(Request::segment(2) =='active')
                                <a class="btn btn-info" href="{{ route('fdd_tools.fdd_quick_child_support_worksheets', ['show' => 'all']) }}">All Worksheets</a>
                                <a class="btn btn-success ml-3" href="{{ route('fdd_tools.fdd_quick_child_support_worksheets', ['show' => 'active']) }}">Just Active Worksheets</a>
                            @else
                                <a class="btn btn-success" href="{{ route('fdd_tools.fdd_quick_child_support_worksheets', ['show' => 'all']) }}">All Worksheets</a>
                                <a class="btn btn-info ml-3" href="{{ route('fdd_tools.fdd_quick_child_support_worksheets', ['show' => 'active']) }}">Just Active Worksheets</a>
                            @endif
                            
                            
                            <h5 class="mt-2"> Choose to Prefill from previous Worksheet </h5>
                        </div>                        
                    </div>
                    <table  class="table table-bordered fdd-computations-list-table table-responsive " >
                        <thead>
                            <tr>

                              <!-- <th>Sno.</th> -->
                              
                              <th>Last Modified</th>

                              <th>State</th>

                              <th>Obligor or ParentA</th>

                              <th>Obligee or ParentB</th>

                              <th>Custody</th>
                              
                              <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            <!-- to show sole/shared sheet data -->

                            @foreach ($users_attorney_submissions_data[0] as $computation_sheet)
                            <tr>
                              <!-- <td>{{ ++$i }}</td> -->
                                <td class="wid" >{{ date('m/d/y H:i:s', strtotime($computation_sheet->sole_shared_submissions_updated_at)) }}</td>

                                <td>{{ $computation_sheet->state }}</td>
                                
                                <td>{{ $computation_sheet->obligee_name }}</td>

                                <td>{{ $computation_sheet->obligor_name }}</td>

                                <td>{{ $computation_sheet->form_custody }}</td>

                              <td class="wid">
                                 @if($computation_sheet->active=='1')
                                    <a class="btn btn-danger  confirm-deactivate"  onclick="return ConfirmStatus(event);" href="{{ route('computations_sheet.deactivate',$computation_sheet->id) }}">Deactivate</a>
                                    
                                    <form method="POST" action="{{route('computations.sole-shared')}}" id="computation_form" class="d-inline-flex">
                                        @csrf
                                        <input type="hidden" name="sheet_state" value="{{$computation_sheet->form_state}}">
                                        <input type="hidden" name="sheet_custody" value="{{$computation_sheet->form_custody}}">
                                        <input type="hidden" name="chk_prefill" value="1">
                                        <input type="hidden" name="prefill_selected_computation" value="{{$computation_sheet->id}}">       
                                        <input type="submit" id="prefill-computation" style="width: auto!important;" class="btn btn-success " value="Prefill computation">   
                                    </form>
                                 @else
                                    <a class="btn btn-success confirm-activate"  onclick="return ConfirmStatus(event);" href="{{ route('computations_sheet.activate',$computation_sheet->id) }}">Activate</a>
                                 @endif
                              </td>

                            </tr>
                            @endforeach

                            <!-- to show split sheet data -->
                            @foreach ($users_attorney_submissions_data[1] as $computation_sheet)

                            <tr>
                              <!-- <td>{{ ++$i }}</td> -->
                                <td class="wid">{{ date('m/d/y H:i:s', strtotime($computation_sheet->split_submissions_updated_at)) }}</td>

                                <td>{{ $computation_sheet->state }}</td>
                                
                                <td>{{ $computation_sheet->parenta_name }}</td>
                                
                                <td>{{ $computation_sheet->parentb_name }}</td>

                                <td>{{ $computation_sheet->form_custody }}</td>

                              <td class="wid">
                                 @if($computation_sheet->active=='1')
                                    <a class="btn btn-danger  confirm-deactivate"  onclick="return ConfirmDeActivate();" href="{{ route('computations_sheet.deactivate',$computation_sheet->id) }}">Deactivate</a>
                                        <form method="POST" action="{{route('computations.split')}}" id="computation_form" class="d-inline-flex">
                                        @csrf
                                        <input type="hidden" name="sheet_state" value="{{$computation_sheet->form_state}}">
                                        <input type="hidden" name="sheet_custody" value="{{$computation_sheet->form_custody}}">
                                        <input type="hidden" name="chk_prefill" value="1">
                                        <input type="hidden" name="prefill_selected_computation" value="{{$computation_sheet->id}}">       
                                        <input type="submit" id="prefill-computation" style="width: auto!important;" class="btn btn-success " value="Prefill computation">   
                                    </form>
                                 @else
                                    <a class="btn btn-success confirm-activate"  onclick="return ConfirmActivate();" href="{{ route('computations_sheet.activate',$computation_sheet->id) }}">Activate</a>
                                 @endif
                              </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/polyfiller.js') }}"></script>

<script type="text/javascript">
 

    $(document).ready(function(){
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
              event.preventDefault();
              return false;
            }
        });

        $(".hasDatepicker").datepicker({
            startDate: "01/01/1901",
            // endDate: '+0d',
        });

        $('.fdd-computations-list-table').DataTable({
            pageLength: 50,
            // responsive: true
        });

        $('#computation-btn').click(function(){
            var state=$('#sheet_state').val();
            var type=$('#sheet_custody').val();
            
            if(type=='sole' || type=='shared')    
            {
                type='sole-shared';
            }    
            else
            {
                type='split';
            }

            // if($('#chk_prefill').prop("checked") == true){
            //      var prefill='1';
            // } else {
                 var prefill='0';
            // }
            
            $('#computation_sheet_form').attr('action', '/computations/'+type);
        });

        $.ajax({
            url:"{{route('ajax_get_active_states')}}",
            method:"GET",
            dataType: 'json',
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#sheet_state').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_state=$('#selected_state').val();
                    $('#sheet_state option[value="'+selected_state+'"]').prop('selected', true);
                }
            }
        });  
    });
</script>    
@endsection