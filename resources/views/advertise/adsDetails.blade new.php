@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/Ads_style.css') }}" rel="stylesheet">
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
      >
    </script> --}}
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">
        </div>
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
        <div class="card">
            <div class="card-header">
                <strong>Ads Details</strong>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('attorney.filter-back') }}">Back</a>
                </div>
            </div>
            <div class=" row">
                {{-- <div class="header">Ads Details</div> --}}
                <!-- card left -->
                <div class="col-md-6 mt-3">
                
                    <div id="custCarousel" class="carousel slide" data-ride="carousel" align="center">
                        <!-- slides -->
                    
                        <div class="carousel-inner">
                            @if (isset($images[0]))
                             @php
                              $t=0;
                            @endphp
                                @foreach ($images as $image)

                                    <div class="carousel-item @if ($images[0]->id==$image->id) {{'active'}} @endif" id="{{$image->id}}"  data-slide-number="{{$t++}}" >
                                        <img src="{{ asset('uploads/AD_images/' . $image->image) }}" alt="Hills">
                                    </div>
                                @endforeach
                            @else
                                <img src="{{ asset('images/placeholder.png') }}" alt="shoe image">
                            @endif
                        </div>
                        <!-- Left right -->
                        <a class="carousel-control-prev" href="#custCarousel" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>                                                                                                                                      
                        <a class="carousel-control-next" href="#custCarousel" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                        <!-- Thumbnails -->
                        <ol class="carousel-indicators list-inline">
                            @if (isset($images) && $images->count() <=> 1)
                            @php
                              $i=0;
                            @endphp
                                @foreach ($images as $image)
                                    <li class="list-inline-item @if ($images[0]->id==$image->id) {{'active'}} @endif">
                                        <a href="#{{$image->id}}" id="carousel-selector-{{$i}}" class="@if ($images[0]->id==$image->id) {{'selected'}} @endif"
                                            data-slide-to="{{$i++}}" data-target="#custCarousel">
                                            <img src="{{ asset('uploads/AD_images/' . $image->image) }}"
                                                class="img-fluid">
                                        </a>
                                    </li>
                                  
                                @endforeach
                            @endif
                        </ol>
                    </div>
                </div>
                <!-- card right -->
                <div class="col-md-6">
                    <div class="product-content">
                        <h2 class="product-title">{{ $ads_data->title }}</h2>
                        <div class="product-price">
                            {{-- <p class = "last-price">Old Price: <span>$257.00</span></p> --}}
                            <p class="new-price"> Price: $<span>{{ number_format($ads_data->AD_price, 2) }}</span></p>
                        </div>
                        <div class="product-detail">
                            <ul>
                                <li>County: <span>{{ $county }}</span></li>
                                <li>Category: <span>{{ $category }}</span></li>
                                <li>Sub Category: <span>{{ $services }}</span></li>
                                <li>Advertiser name : <span>{{ $advertiser->full_name }}</span></li>
                                <li>Email: <span>{{ $advertiser->email }}</span></li>
                                <li>Phone No. : <span>{{ $advertiser->telephone }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="product-desc">
                        <h2>Descriptions </h2>
                        <p>{!! nl2br($ads_data->description) !!}</p>
                        {{-- <ul>
                              <li>County: <span>{{$county}}</span></li>
                              <li>Category: <span>{{$category}}</span></li>
                              <li>Sub Category: <span>{{$services}}</span></li>
                              <li>Advertiser name : <span>{{$advertiser->full_name}}</span></li>
                              <li>Email: <span>{{$advertiser->email}}</span></li>
                              <li>Phone No. : <span>{{$advertiser->telephone}}</span></li>
                            </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <script>
        const imgs = document.querySelectorAll('.list-inline-item a');
        const imgBtns = [...imgs];
        let imgId = 1;
        imgBtns.forEach((imgItem) => {
            imgItem.addEventListener('click', (event) => {
                event.preventDefault();
                imgId = imgItem.dataset.id;
                slideImage();
            });
        });

        function slideImage() {
            const displayWidth = document.querySelector('.carousel-inner div img:first-child').clientWidth;
            document.querySelector('.carousel-inner').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        }
        window.addEventListener('resize', slideImage);
    </script>
@endsection
