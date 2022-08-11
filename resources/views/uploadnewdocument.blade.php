@extends('layouts.app')
@section('content')
<style type="text/css">
    .error{
        color: red;
    }
</style>
<div class="container">
    <div class="row justify-content-center fdd-tools-main">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <strong>{{ __('Upload New Document') }}</strong>
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ url('orchard-search') }}"> Back</a>
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
                        
                        <div class="col-sm-12 annual-income-calculation-section">
                            <form method="POST" action="{{ route('uploaddocument')}}" enctype="multipart/form-data">
                              @csrf
                            <div class="row">
                                <div class="col-sm-5 column-box-width">
                                    <label>Document Title</label>
                                    <input type="text" class="form-control" maxlength="100" value="{{old('document_title')}}" id="document_title" name="document_title">
                                     @error('document_title') 
                                    <em class="error">{{ $message }}</em>
                                @enderror           
                                </div>
                                <div class="col-sm-5 column-box-width">
                                    <label>Document</label>
                                    <input type="file" name="upload_document" accept="" class="form-control-file">
                                    @error('upload_document') 
                                    <em class="error">{{ $message }}</em>
                                @enderror 
                                </div>
                                <div class="col-sm-2 column-box-width">
                                    <label></label>
                                    <button type="submit" class="btn btn-primary">Submit</button>       
                                </div>
                                
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