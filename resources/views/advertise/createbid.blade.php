@extends('layouts.app')

@section('content')
<style type="text/css">
    table.formatHTML5 tr.selected {
    background-color:  yellow !important;
    color:#000;
    vertical-align: middle;
    padding: 1.5em;
}
 table.formatHTML5 tbody tr
        {
            cursor:pointer;
            /* add gradient */
          
        }

</style>
<div class="container">
    <div class="row justify-content-center attorney-registration">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('FDD  Create bid') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertise.new_listing')}}">Back</a>
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
                
                    	<form role="form" id="multistep_case_form" method="POST" action="{{route('advertise.checkout')}}" autocomplete="off">
                    			@csrf
                    	<div class="form-group row">

                            
                             <div class="col-md-6">
                                    <label for="county" class="col-md-4 col-form-label text-md-left"><b>Listing County : {{ $county_name }}</b> </label>
                                   
                                     <label for="Full_Name" class="col-md-4 col-form-label text-md-left attorney_reg_1_num_label"><b>{{ __('Which Listing type') }} : {{ $category_name }}</b></label>
                                    
                                </div>
                            </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                            <table id=bids border="1" style="width: 60%;" class="formatHTML5 table table-hover">
                                <thead>
                                <tr>
                                    <th>Listing Priority</th>
                                    <th>Premium Bid</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bids as $key=>$val)
                                <tr>
                                    <td class="l">{{ $val->listing_priority}}</td>
                                    <td class="b">$ {{ $val->bid_amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        </div>
                       <div class="form-group row">
                           <label for="Full_Name" class="col-md-2 col-form-label text-md-left attorney_reg_1_num_label">{{ __('Increase your listing Premium Bid to:') }}</label>
                            <div class="col-md-4 attorney_reg_1_num_label">
                                <input id="increase_bid_amount" type="text" class="form-control" value="" autocomplete="increase_bid_amount" autofocus="">
                       </div>
                   </div>
                   <div class="form-group row">
                       <p>
                           The Default primary ranking is by the time you’ve had this listing but, secondarily, by your Premium Bid
                            amount. Premium Bid amounts change all the time, so you should check your listing priority often.
                            When you make or change your Premium Bid, it operates as an extension so the change is effective for
                            one year and will include any increases in the corresponding listing fee. However, your current listing fee
                            and premium bid are credited, pro-rata to the date of the change, and you are charged only the difference.
                            The net amount due will be calculated before you need to commit your credit card charge.
                       </p>
                   </div>
                    
                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                    <input type="hidden" name="adviser_id" value="{{ $adviser_id}}" id="adviser_id">
                    <input type="hidden" name="listing_id" value="{{ $listing_id }}" id="listing_id">
                    <input type="hidden" name="listing_priority" id="listing_priority">
                    <input type="hidden" name="bid_amount" id="bid_amount">
                    <button type="submit" class="btn btn-success pull-right"> Checkout</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).on('click', 'tbody tr',function () {
           
            $('.selected').removeClass('selected');
            $(this).addClass("selected");
           
            var listing_priority = $(this).closest('tr').find('.l').text();
            var bid_amount =$(this).closest('tr').find('.b').text();
            $("#listing_priority").val(listing_priority);
            $("#bid_amount").val(bid_amount);
            
        });
</script>    
@endsection