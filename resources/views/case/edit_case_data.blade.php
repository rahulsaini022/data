@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center attorney-dashboard case-edit-data-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>{{ __('Edit Case Data') }}</strong>
                  <div class="pull-right">

                        <a class="btn btn-primary" href="{{ route('cases.index') }}"> Back</a>

                    </div>
                </div>
                <div class="card-body table-sm table-responsive case_data_outerbox">
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
                      <div class="col-sm-6 text-center">
                        <a class="btn btn-primary mb-2" href="{{ route('cases.edit',$case_id) }}">Edit Core Case Data</a>
                      </div>
                      <?php
                            $case_type_ids=$case_data->case_type_ids;
                            $case_type_ids=explode(",",$case_type_ids);
                            $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                            $hascaseid = !empty(array_intersect($array, $case_type_ids));
                      ?>
                      @if(isset($hascaseid) && $hascaseid=='1')
                          <div class="col-sm-6 text-center">
                            <a class="btn btn-primary mb-2" href="{{ route('cases.family_law_interview_tabs',$case_id) }}">Family Law Interview/Data</a>
                          </div>
                      @endif
                    </div>
                </div>
            </div>          
        </div>
    </div>
</div>
<script>
</script>        
@endsection