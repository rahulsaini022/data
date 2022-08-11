@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-registration">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('FDD Advertiser Registration') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertisenow')}}">Back</a>
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
                
                    	<form role="form" id="multistep_case_form" method="POST" action="{{route('courtreportersubmit')}}" autocomplete="off">
                    			@csrf
                    	<div class="form-group row">

                            
                             <div class="col-md-6">
                                      <div class="col-md-10 form-group">
                                
                                          <label for="case_county" class=" col-form-label text-md-left">Listing County*</label>
                                        <select id="case_county" name="listing_county" class="form-control case_county_inputs" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>    
                                      </div>
                                </div>

                            
                           
                            <div class="col-md-6 attorney_reg_1_num_label">
                                    <div class="col-md-10 form-group">
                                 <label for="Full_Name" class=" col-form-label text-md-left attorney_reg_1_num_label">{{ __('Company or Your Full Name*') }}</label>
                                <input id="Full_Name" type="text" class="form-control @error('Full_Name') is-invalid @enderror" name="Full_Name" value="{{ old('Full_Name') }}" autocomplete="Full_Name" required="" autofocus="">

                                @error('Full_Name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                            </div>

                     

                        
                           
                            <div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                 <label for="contact_full_name" class=" col-form-label text-md-left">{{ __('Contact person Full Name*') }}</label>

                                <input id="contact_full_name" type="text" class="form-control @error('contact_full_name') is-invalid @enderror" name="contact_full_name" value="{{ old('contact_full_name') }}" required autocomplete="contact_full_name" autofocus>

                                @error('contact_full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                            </div>

                            
                            <div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                <label for="email" class=" col-form-label text-md-left">{{ __('Email*') }}</label>

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus required>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                            </div>

                        
                        	<div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                <label for="" class=" col-form-label text-md-left">{{ __('Telephone')}}</label>
                        	
                        		<input id="Telephone" type="text"  maxlength="12" class="form-control has-pattern-one" name="Telephone" value="" autofocus="" placeholder="XXX-XXX-XXXX">
                        		@error('Telephone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                        	</div>
                        	
                               
    
                       
                        <div class="col-md-6">
                                <div class="col-md-10 form-group">
                            	<label class=" col-form-label text-md-left">{{ __('Street Address*') }}</label>
                        	
                        		<input type="text" class="form-control" id="Street_Address" name="Street_Address"  autofocus="" required="">
                        		@error('Street_Address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                        	</div>
                        <div class="col-md-6">
                                <div class="col-md-10 form-group">
                            	<label class=" col-form-label text-md-left">Suite/Unit, if any:</label>
                        	
                        		<input type="text" class="form-control" id="Suite_Unit" name="Suite_Unit" />
                                </div>
                        	</div>

 <div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                <label for="clzip" class=" col-form-label text-md-left">{{ __('ZIP*') }}   <span class="text-danger no-state-county-cl" style="display: none;">No City, State, County found for this zipcode.</span></label>
                        	
                              
                                   <input type="text" class="form-control" id="clzip" name="ZIP_Code" autofocus="" required="">
                                    @error('ZIP_Code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                                    </div>
                                </div>
                       
                        	<div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                      <label for="clstate" class="col-form-label text-md-left">State*</label>
                                   
                                      <input type="hidden" name="selected-state-cl"  class="selected-state-cl">
                                        <select id="clstate" name="State" class="form-control cl-state" autofocus="" required="">                                     
                                            <option value="">Choose State</option>
                                        </select>
                                    </div>    
                                    </div>
                              

                                <div class="col-md-6">
                                    <div class="col-md-10 form-group">
                                       <label for="clcounty" class="col-form-label text-md-left">County*</label>
                                  
                                        <select id="clcounty" name="County" class="form-control cl-county" autofocus="" required="">
                                            <option value="">Choose County</option>
                                        </select>
                                    
                                </div>
                        </div>
                        
                        	<div class="col-md-6">
                                   <div class="col-md-10 form-group">
                                       <label for="clcity" class="col-form-label text-md-left">City*</label>
                                    
                                        <select id="clcity" name="City" class="form-control cl-city" required="" autofocus="">
                                            <option value="">Choose City</option>
                                        </select>
                                   </div>
                                </div>

                                <div class="col-md-6">
                               <div class="col-md-10 form-group">
                                     <label for="website" class="col-form-label text-md-left">Website</label>
                                    
                                        <input type="text" class="form-control" id="" name="website" autofocus="" >
                               </div>
                                </div>
                        </div>
                    
                    <input type="hidden" name="category_id" value="{{ $id }}">
                    <div class="form-group col-12 text-center">
                        <button type="submit" class="btn btn-success px-3"> Register</button>
                    </div>
                    
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
    if(state_id) {
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
                    var selected_case_county=$('.selected_case_county').val();
                    $("#case_county").val(selected_case_county);
                }
            }
        });
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
});
var tele = document.querySelector('#Telephone');

tele.addEventListener('keydown', function(e){
  if (event.key != 'Backspace' && (tele.value.length === 3 || tele.value.length === 3)){
  tele.value += '-';
  }
  if (event.key != 'Backspace' && (tele.value.length === 7 || tele.value.length === 3)){
  tele.value += '-';
  }
});
</script>    
@endsection