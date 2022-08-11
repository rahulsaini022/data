@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-registration">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('FDD Advertiser Update') }}</div>
                <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('adviserdashboard') }}">Back</a>
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
                
                    	<form role="form" id="multistep_case_form" method="POST" action="{{route('advertise.update')}}" autocomplete="off">
                    			@csrf
                                <input type="hidden" name="id" value="{{ $advertiser->AD_CR_Id }}">
                    	<div class="form-group row">

                            
                             <div class="col-md-6">
                                    <label for="case_county" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" name="selected_case_state" class="selected_case_state" value="<?php if(isset($advertiser->listing_county)){ echo $advertiser->listing_county; } ?>">
                                        <select id="case_county" name="listing_county" class="form-control case_county_inputs" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>    
                                    </div>
                                </div>

                            
                            <label for="Full_Name" class="col-md-2 col-form-label text-md-left attorney_reg_1_num_label">{{ __('Company or Your Full Name*') }}</label>
                            <div class="col-md-4 attorney_reg_1_num_label">
                                <input id="Full_Name" type="text" class="form-control @error('Full_Name') is-invalid @enderror" name="Full_Name" value="{{ ($advertiser->Full_Name) ? $advertiser->Full_Name : '' }}" autocomplete="Full_Name" required="" autofocus="">

                                @error('Full_Name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="contact_full_name" class="col-md-2 col-form-label text-md-left">{{ __('Contact person Full Name*') }}</label>

                            <div class="col-md-4">
                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" name="contact_full_name" value="{{ ($advertiser->contact_full_name) ? $advertiser->contact_full_name : '' }}" required autocomplete="contact_full_name" autofocus>

                                @error('contact_full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                           <label for="" class="col-md-2 col-form-label text-md-left">{{ __('Telephone')}}</label>
                            <div class="col-md-4">
                                <input id="Telephone" type="text" class="form-control has-pattern-one" name="Telephone" value="{{($advertiser->
                                Telephone) ? $advertiser->Telephone : '' }}" autofocus="" placeholder="XXX-XXX-XXXX">
                                @error('Telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>
                        <div class="form-group row">
                        	
                        	 <label for="clzip" class="col-md-2 col-form-label text-md-left">{{ __('ZIP*') }}</label>
                        	<div class="col-md-4">
                                <p class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</p>
                                   <input type="text" class="form-control" id="clzip" name="ZIP_Code" autofocus="" required="" value="{{($advertiser->ZIP_Code) ? $advertiser->ZIP_Code : '' }}">
                                    
                                </div>
                                @error('ZIP_Code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                <label class="col-md-2 col-form-label text-md-left">{{ __('Street Address*') }}</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="Street_Address" name="Street_Address"  autofocus="" required="" value="{{ ($advertiser->Street_Address) ? $advertiser->Street_Address : ''}}">
                                @error('Street_Address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                        	
                        	<label class="col-md-2 col-form-label text-md-left">Suite/Unit, if any:</label>
                        	<div class="col-md-4">
                        		<input type="text" class="form-control" id="Suite_Unit" name="Suite_Unit" value="{{ ($advertiser->Suite_Unit) ? $advertiser->Suite_Unit : '' }}" />
                        		
                        	</div>

                            <div class="col-md-6">
                                    <label for="clstate" class="col-md-4 col-form-label text-md-left">State*</label>
                                    <div class="col-md-8">
                                      <input type="hidden" name="selected-state-cl"  class="selected-state-cl" value="{{ ($advertiser->State) ? $advertiser->State : '' }}">
                                        <select id="clstate" name="State" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>    
                                    </div>
                                </div>

                        </div>

                        <div class="form-group row">
                        	

                                <div class="col-md-6">
                                    <label for="clcounty" class="col-md-4 col-form-label text-md-left">County*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" value="{{ ($advertiser->County) ? $advertiser->County : ''}}" class="selected-cl-county"  >
                                        <select id="clcounty" name="County" class="form-control cl-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="clcity" class="col-md-4 col-form-label text-md-left">City*</label>
                                    <div class="col-md-8">
                                        <input type="hidden" value="{{ ($advertiser->City) ? $advertiser->City : ''}}">
                                        <select id="clcity" name="City" class="form-control cl-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                    </div>
                                </div>
                        </div>
                        <div class="form-group row">
                        	

                                <div class="col-md-6">
                                    <label for="website" class="col-md-4 col-form-label text-md-left">Website</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" id="" name="website" autofocus="" value="{{ ($advertiser->website) ? $advertiser->website : ''}}">

                                    </div>
                                </div>
                        </div>
                       
                        <div class="col-md-12">
                        <p> Check which services you provide: </p>
                        <div class="col-md-6">
                                
                                <div class="form-check">
                        			<input type="checkbox" class="form-check-input" id="" name="Oral_Depositions" value="1" <?php if($advertiser->Oral_Depositions ==1){ echo "checked";} ?>><label for="Oral_Depositions" class="form-check-label">Oral Depositions</label><br/>

                        			<input type="checkbox" class="form-check-input" id="" name="Video_Depositions" value="1" <?php if($advertiser->Video_Depositions ==1){ echo "checked"; } ?>><label for="Video Depositions" class="form-check-label">Video Depositions</label><br/>


                        			<input type="checkbox" class="form-check-input" id="" name="Audio_Transcriptions" value="1"<?php if($advertiser->Audio_Transcriptions ==1){ echo "checked"; } ?>><label for="Audio_Transcriptions" class="form-check-label">Audio Transcriptions</label><br/>

                        			</div>
                        </div>
                        <div class="col-md-6">
                        	<input type="checkbox" id="" class="form-check-input" name="Conference_Room" value="1" <?php if($advertiser->Conference_Room ==1){ echo "checked"; } ?>><label for="Conference Room" class="form-check-label">Conference Room</label><br/>

                        	<input type="checkbox" class="form-check-input" id="" name="Process_Service" value="1"<?php if($advertiser->Process_Service ==1){ echo "checked"; } ?>><label for="Process Service" class="form-check-label">Process Service</label><br/>

                        	<input type="checkbox" class="form-check-input" id="" name="Court_Runner" value="1"<?php if($advertiser->Court_Runner ==1){ echo "checked"; } ?> ><label for="Court Runner" class="form-check-label">Court Runner</label>

                        </div>
                        <br/>
                       
                    <p>
                    	The listing fee for Court Reporters is  ${{ $Court_Reporters_List_Fee }} for a term of {{ $Court_Reporters_List_Term }}. This fee gets your information on the list when a
						legal professional is seeking a Court Reporter offering your services in (listing county) County. There are
						additional ways you can control where you appear on that list for an additional charge after paying the
						listing fee, but you don’t have to pay anything more if you’re satisfied just being on the list.
                    </p>
              
                </div>
                    <button type="submit" class="btn btn-success pull-right"> Update</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function () {

    $('#multistep_case_form').validate({
    	 rules: {
            Telephone: {
                pattern: /[0-9]{3}-[0-9]{3}-[0-9]{4}/
            }
        }
    });

	state_id = 35;
    // to fecth counties on basis of state
    // var state_id=$(".selected_case_state").val();
    var token= $('input[name=_token]').val();
    
        $.ajax({
            url:"{{route('ajax_get_counties_by_state')}}",
            method:"POST",
            dataType: 'json',
            data:{
                id: state_id, 
                _token: token, 
            },
            success: function(data){
                // console.log(data);
                if(data==null || data=='null'){
                } else {
                    $.each(data, function (key, val) {
                        $('#case_county').append('<option value='+key+'>'+val+'</option>');
                    });
                    var selected_case_county=$('.selected_case_state').val();
                   if(selected_case_county){
                        $('#case_county option[value='+selected_case_county+']').attr('selected','selected');
                    }

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
            if( zip != '' && zip != null){
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


                }
            }
        });

        if($('#clzip').val() != ''){

            $('#clzip').val('{{ $advertiser->ZIP_Code }}').trigger('input');
        } 
    

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
        if( zip != '' && zip != null){
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
});
</script>    
@endsection