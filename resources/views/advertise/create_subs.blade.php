@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Advertise Now') }}</strong>
                     <div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('advertise') }}">Back</a>
                    </div>
                </div>
                <div class="card-body">
                     @if ($message = Session::get('success'))

                    <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <p>{{ $message }}</p>

                    </div>

                    @endif

                    @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button> 
                              <strong>{{ $message }}</strong>
                      </div>
                    @endif

                    <div class="row"> 
                        <div class="col-md-12">
                         <form method="post"  action="{{route('advertise.subscription',['id'=>$user->id,'category_id'=>$request->category_id])}}"> 

                                <div class="row form-group">
                                    <div class="col-md-6">
                                       
                                        <div class="col-md-12">
                                             <label for="case_county" class="col-form-label text-md-left">Listing
                                            County*</label>
                                            <select id="case_county" name="listing_county"
                                                class="form-control advertiser_county_inputs" autofocus="" required>
                                               <option value="">Choose County</option>
                                                @foreach ($county as $key => $val)
                                                    <option value="{{ $val->id }}">{{ $val->county_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       
                                        <div class="col-md-12">
                                             <label for="advertiser_category_inputs" class=" col-form-label text-md-left">Choose
                                            Catgory*</label>
                                            <select id="advertiser_category_inputs" name="advertising_catgory"
                                                class="form-control " autofocus="" required>
                                               <option value="">Choose Category</option>
                                                @foreach ($category_data as $key => $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                              <button type="submit" class="btn btn-primary">submit</button>

                                </div>
                         </form>
                                
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection