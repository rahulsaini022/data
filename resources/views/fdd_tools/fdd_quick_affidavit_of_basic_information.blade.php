@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('FDD Quick Affidavit of Basic Information, Income, and Expenses') }}</strong>
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
                            <label class="fdd-tools-main-label">FDD Quick Family Law Affidavit</label>
                            <form method="POST" action="{{route('show_affidavit_of_basic_information_sheet_form')}}" id="affidavit_form">
                                @csrf
                                <input type="hidden" id="selected_state" value="{{$attorney_data->state_id}}">
                                <input type="hidden" name="state_id" value="35">
                                <div class="row">
                                    <!-- <div class="col-sm-4 column-box-width">    
                                        <select id="affidavit_state" name="state_id" class="form-control" required="" autofocus="">
                                            <option value="">Choose State</option>
                                        </select>           
                                    </div> -->
                                    <!-- <div class="col-sm-4 column-box-width prefill-check">        
                                        <input type="checkbox" name="chk_prefill" id="chk_prefill" value="1" checked=""><label for="chk_prefill" class="chk_prefill" >Prefill with my last affidavit submission.</label>
                                    </div>   -->
                                    <div class="col-sm-4 column-box-width">        
                                        <input type="submit" id="affidavit-btn" class="btn btn-success btn-affidavit new-btn new-btn-green" value="New FDD Quick Family Law Affidavit">       
                                    </div>
                                </div>  
                            </form>
                        </div>
                        <h4 class="mt-2"> List of previous affidavit submissions </h4>
                        <div class="col-sm-12 mt-2">
                            @if(Request::segment(2) =='active')
                                <a class="btn btn-info" href="{{ route('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses', ['show' => 'all']) }}">All Worksheets</a>
                                <a class="btn btn-success ml-3" href="{{ route('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses', ['show' => 'active']) }}">Just Active Worksheets</a>
                            @else
                                <a class="btn btn-success" href="{{ route('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses', ['show' => 'all']) }}">All Worksheets</a>
                                <a class="btn btn-info ml-3" href="{{ route('fdd_tools.fdd_quick_affidavit_of_basic_information_income_and_expenses', ['show' => 'active']) }}">Just Active Worksheets</a>
                            @endif
                            
                            
                            <h5 class="mt-2"> Choose to Prefill from previous affidavit submissions </h5>
                        </div>
                    </div>   
                    <table class="table table-bordered fdd-affidavits-list-table">
                        <thead>
                            <tr>

                              <!-- <th>Sno.</th> -->

                              <th>Last Modified</th>

                              <th>State</th>

                              <th>Top Party</th>
                              
                              <th>Bottom Party</th>

                              <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=0; ?>
                            @foreach ($affidavit_sheet_submissions_data as $key => $affidavit)

                            <tr>

                              <!-- <td>{{ ++$i }}</td> -->

                              <td>{{ date('m/d/y H:i:s', strtotime($affidavit->updated_at)) }}</td>

                              <td>{{ $affidavit->state }}</td>

                              <td>{{ $affidavit->topparty_name }}</td>

                              <td>{{ $affidavit->bottomparty_name }}</td>

                              <td>
                                 @if($affidavit->active=='1')
                                    <a class="btn btn-danger mb-1 confirm-deactivate"  onclick="return ConfirmDeActivate();" href="{{ route('affidavit_sheet.deactivate',$affidavit->id) }}">Deactivate</a>

                                    <form method="POST" action="{{route('show_affidavit_of_basic_information_sheet_form')}}" id="affidavit_form">
                                        @csrf
                                        <input type="hidden" name="state_id" value="{{$affidavit->state_id}}">
                                        <input type="hidden" name="prefill_selected_affidavit" value="{{$affidavit->id}}">       
                                        <input type="submit" id="affidavit-btn" class="btn btn-success btn-affidavit new-btn new-btn-green" value="Prefill Affidavit">   
                                    </form>
                                 @else
                                    <a class="btn btn-success mb-1 confirm-activate"  onclick="return ConfirmActivate();" href="{{ route('affidavit_sheet.activate',$affidavit->id) }}">Activate</a>
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

    function ConfirmDeActivate()
    {
        var x = confirm("Are you sure you want to deactivate this record?");
        if (x)
              return true;
        else
            return false;
    }

    function ConfirmActivate()
    {
        var x = confirm("Are you sure you want to activate this record?");
        if (x)
              return true;
        else
            return false;
    }

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

        $('.fdd-affidavits-list-table').DataTable({
            pageLength: 50,
            responsive: true
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
                        $('#affidavit_state').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_state=$('#selected_state').val();
                    $('#affidavit_state option[value="'+selected_state+'"]').prop('selected', true);
                }
            }
        });  
    });
</script>    
@endsection