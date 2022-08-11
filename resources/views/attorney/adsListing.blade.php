@extends('layouts.app')
@section('content')
    <style>
        .view-group {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: row;
            flex-direction: row;
            padding-left: 0;
            margin-bottom: 0;
        }

        .thumbnail {
            margin-bottom: 30px;
            padding: 0px;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
        }

        .item.list-group-item {
            float: none;
            width: 100%;
            background-color: #fff;
            margin-bottom: 30px;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
            padding: 0 1rem;
            border: 0;
        }

        .item.list-group-item .img-event {
            float: left;
            width: 30%;
        }

        .item.list-group-item .list-group-image {
            margin-right: 10px;
        }

        .list-group-item-text {
            margin-bottom: 0;
            line-height: 18px;
            margin: 0 0 11px;
            letter-spacing: -0.1px;
            /* height: 75px; */
            text-align: justify;
        }

        h4.group.card-title.inner.list-group-item-heading a {
            color: #000;
        }

        .list-group-item-heading {
            margin-top: 0;
            margin-bottom: 5px;
            font-size: 25px;
        }

        .item.list-group-item .thumbnail {
            margin-bottom: 0px;
            display: -webkit-box;
        }

        .item.list-group-item .caption {
            float: left;
            width: 70%;
            margin: 0;
        }

        .item.list-group-item:before,
        .item.list-group-item:after {
            display: table;
            content: " ";
        }

        .item.list-group-item:after {
            clear: both;
        }

        .image {
            max-width: 100%;
            width: auto;
            max-height: 184px;
            margin: auto;
        }

        .caption.card-body {
            min-height: 220px;
        }

        .thumbnail.card {
            height: 381px;
        }

        img.d-block.card-img-top {
            max-height: 239px;
            max-width: 100%;
            margin: auto;
            height: 206px;
            width: auto;
        }

        .custom-btn {
            border: 1px solid #ced4da;
            color: #494b4c;
            border-radius: 0px 4px 4px 0px !important;
        }
    </style>

    {{--  --}}
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
            <div class="col-md-12">
                <div class="card" style="background: #fff!important;">
                    <div class="card-header"><strong>Services And Products</strong>
                        <div class="pull-right">
                            @if (request()->is('services&products'))
                                
                                @else
                               <a class="btn btn-primary"
                                 href="{{ url('services&products') }}">Back</a>
                            @endif
                            
                              
                        </div>
                    </div>
                    <div class="card-body table-sm table-responsive">
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

                        <div class="col-sm-12 filter-section">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="POST" action="{{ route('attorney.listfilter') }}"
                                        id="computation_sheet_form">
                                        @csrf
                                        <div class="row filter">
                                            <input type="hidden" name="sheet_state" value="35">

                                            <div class="col-sm-3 mb-2">
                                                <select id="sheet_state" name="county" class="form-control" autofocus="">
                                                    <option @if ($county == '') {{ 'selected' }} @endif
                                                        value=" ">All Counties</option>
                                                    @if (!$counties->contains($county))
                                                        <option @if ($county == Auth::user()->attorney_county[0]->id) {{ 'selected' }} @endif
                                                            value="{{ Auth::user()->attorney->county_id }}">
                                                            {{ Auth::user()->attorney_county[0]->county_name }}</option>
                                                    @endif
                                                    @foreach ($counties as $key => $val)
                                                        <option value="{{ $val->id }}" <?php if (isset($county) && $county != '' && $county == $val->id) {
                                                            echo 'selected';
                                                        } ?>>
                                                            {{ $val->county_name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="col-sm-3 mb-2">
                                                <select id="sheet_custody" name="category" class="form-control"
                                                    autofocus="">
                                                    <option value=""> All Categories</option>

                                                    @foreach ($categories as $key => $val)
                                                        <option value="{{ $val->id }}" <?php if (isset($category) && $category != '' && $category == $val->id) {
                                                            echo 'selected';
                                                        } ?>>
                                                            {{ $val->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-3 mb-2">

                                    <div class="input-group ">

                                        <input class="form-control py-2" name="search" type="search"
                                            value="@if (isset($search)) {{ $search }} @endif" 
                                            placeholder="search" id="example-search-input">
                                        {{-- <span class="input-group-append">
                                                <button class="btn btn-outline-secondary custom-btn" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button> --}}
                                        </span>
                                        <span class="error-search"> </span>

                                    </div>

                                </div>
                                <div class="col-sm-2 text-center">
                                    <input style="width:100px" type="submit" id="computation-btn"
                                        class="btn btn-success btn-computation new-btn new-btn-green" value="Search">
                                </div>
                                            <!-- <div class="col-sm-3  prefill-check">
                                                                <input type="checkbox" name="chk_prefill" id="chk_prefill" value="1" checked=""><label for="chk_prefill" class="chk_prefill" >Prefill with my last submission.</label>
                                                            </div>  -->
                                            <input type="hidden" name="chk_prefill" value="0">

                                        </div>

                                </div>
                                
                                </form>
                            </div>


                           
                                <div class="row">
                                    <div class="col-lg-12 my-3">
                                        <div class="pull-right">
                                            <div class="btn-group">
                                                {{-- <button class="btn btn-info" id="list">
                                                <i id="fa" class="fa fa-list    "></i>
                                            </button> --}}

                                            </div>
                                        </div>
                                         @if (isset($listing[0]))
                                    <div id="products" class="row view-group">
                                        @foreach ($listing as $service)
                                            <div class="item col-xs-4 col-lg-4  col-md-6 col-sm-6">
                                                <div class="thumbnail card">
                                                    <div class="img-event">

                                                        @if (isset($service->image[0]))
                                                            @foreach ($service->image as $key => $image)
                                                                @if ($key == 0)
                                                                    <a href="{{ route('ads_details', $service->id) }}">
                                                                        <img src="{{ asset('uploads/AD_images/' . $image->image) }}"
                                                                            class="d-block  card-img-top"></a>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            <a href="{{ route('ads_details', $service->id) }}"> <img
                                                                    src="{{ asset('images/placeholder.png') }}"
                                                                    class="d-block  card-img-top
                                                    "
                                                                    alt="..."></a>
                                                        @endif


                                                    </div>
                                                    <div class="caption card-body ">
                                                        <h4 class="group card-title inner list-group-item-heading">
                                                            <a
                                                                href="{{ route('ads_details', $service->id) }}">{{ $service->title }}</a>
                                                        </h4>
                                                        <p class="group inner list-group-item-text w-100">
                                                            @php
                                                                $desc = strip_tags($service->description);
                                                            @endphp
                                                            {!! substr($desc, 0, 100) . '.....' !!}
                                                        </p>
                                                        <div class="row">

                                                            <p class="lead">
                                                                ${{number_format($service->AD_price,2)}}</p>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div class="pagination-div">

                                        {!! $listing->links() !!}

                                        {{-- @php echo str_replace('/?', '?',  $listing->appends($qs)->links() )@endphp --}}
                                    </div>
                                @else
                                    <p class="text-center">No data Found</p>
                                @endif
                                    </div>
                                </div>
                            


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                $('#list').click(function(event) {
                    event.preventDefault();
                    $("#fa").toggleClass("fa-list fa-th");
                    $('#products .item').toggleClass('list-group-item');



                });
                //         $("#searchForm").validate({
                //              rules: {
                //                 search: {
                //                     lettersonly: true
                //                 }   
                //             },
                //             message:{

                //             }
                //             errorElement : 'span',
                // errorLabelContainer: '.error-search'

                //         });

            });
        </script>
    @endsection
