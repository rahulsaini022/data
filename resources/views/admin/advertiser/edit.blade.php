    @extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit service') }}</strong>
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


                    {!! Form::model($service, ['method' => 'PATCH','route' => ['advertiser-services.update', $service->id]]) !!}

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
                          
                             <textarea class="form-control"  name="description" id="description" rows="3">{{$service->description}}</textarea>
                           
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
                                   @foreach ($advertiser_services as $services )
                                 <option  @if($service->parent_id == $services->id) selected @endif value="{{$services->id}}">{{$services->name}}</option>
                                 
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
                                  <option >Select service term</option>
                                  <option @if ($service->service_list_term == 'One Month') selected @endif value="One Month">One Month</option>
                                  <option @if ($service->service_list_term == 'Three Month') selected @endif  value="Three Month">Three Month</option>
                                  <option @if ($service->service_list_term == 'Six Month') selected @endif value="Six Month">six Month</option>
                                  <option @if ($service->service_list_term == 'One Year') selected @endif value="One Year">one Year</option>

                                 
                                
                             
                              </select>
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