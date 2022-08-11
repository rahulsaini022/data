@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Create New Advertiser Services') }}</strong>
                    <div class="pull-right">

                        <a class="btn btn-primary" href="{{ url()->previous() }}"> Back</a>

                    </div>
                </div>
                <div class="card-body">
                    @if (count($errors) > 0)

                      <div class="alert alert-danger">

                        <strong>Whoops!</strong> There were some problems with your input.<br><br>

                        <ul>

                           @foreach ($errors->all() as $error)

                             <li>{{ $error }}</li>

                           @endforeach

                        </ul>

                      </div>

                    @endif

                    {!! Form::open(array('route' => 'advertiser-services.store','method'=>'POST')) !!}
                     
                    {{-- {!! Form::model(['method' => 'POST  ','route' => 'advertiser-services.store']) !!} --}}

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Name:</strong>

                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Fees:</strong>

                                {!! Form::text('service_list_fee', null, array('placeholder' => 'Fees','class' => 'form-control')) !!}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                                <strong>Description:</strong>
                          
                             <textarea class="form-control"  name="description" id="description" rows="3"></textarea>
                           
                                {{-- {!! Form::text('description', array('placeholder' => 'description','class' => 'form-control')) !!} --}}

                            </div>

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">

                             <div class="form-group">

                                <strong>Parent Service</strong>

                              <div class="form-group">
                                <label for=""></label>
                                <select class="form-control" name="parent_id" id="">
                                    <option value="0">Select Parent service</option>
                                    @foreach ($advertiser_services as $service )
                                  <option value="{{$service->id}}">{{$service->name}}</option>
                                  
                                 @endforeach
                                </select>
                              </div>

                            </div> 

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">

                            <div class="form-group">

                               <strong> Service Term</strong>

                             <div class="form-group">
                               <label for=""></label>
                               <select class="form-control" name="service_list_term" id="">
                                   <option value="">Select service term</option>
                                   <option value="One Month">One Month</option>
                                   <option value="Three Month">Three Month</option>
                                   <option value="Six Month">Six Month</option>
                                   <option value="One Year">One Year</option>

                                  
                                 
                              
                               </select>
                             </div>

                           </div> 

                       </div>
                       

                        <div class="col-xs-12 col-sm-12 col-md-12">

                            {{-- <div class="form-group">

                                <strong>Credits:</strong>

                                {!! Form::number('credits', null, array('placeholder' => 'Credits','class' => 'form-control')) !!}

                            </div> --}}

                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                            <button type="submit" class="btn btn-primary">Submit</button>

                        </div>

                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>                




@endsection