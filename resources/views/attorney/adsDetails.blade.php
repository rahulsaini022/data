@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/Ads_style.css') }}" rel="stylesheet">
    <div class="container">
        <div class="row justify-content-center attorney-dashboard">



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


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Ads Details</strong>
                        <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('attorney.filter-back') }}">Back</a>
                </div>
                    </div>
                    <div class="row">
                        {{-- <div class="header">Ads Details</div> --}}
                        <!-- card left -->
                        <div class="col-md-6">
                            <div class="product-imgs">
                                <div class="img-display">
                                    <div class="img-showcase">
                                        @if (isset($images[0]))
                                            @foreach ($images as $image)
                                                <img src="{{ asset('uploads/AD_images/' . $image->image) }}"
                                                    alt="shoe image">
                                            @endforeach
                                        @else
                                            <img src="{{ asset('images/placeholder.png') }}" alt="shoe image">
                                        @endif
                                    </div>
                                </div>
                                <div class="img-select">
                                    @if (isset($images) && $images->count() <=> 1)
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($images as $image)
                                            <div class="img-item">
                                                <a href="#" data-id="{{ $i++ }}">
                                                    <img src="{{ asset('uploads/AD_images/' . $image->image) }}"
                                                        alt="shoe image">
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product-content">
                                <h2 class="product-title">{{ $ads_data->title }}</h2>
                                <div class="product-price">
                                    {{-- <p class = "last-price">Old Price: <span>$257.00</span></p> --}}
                                    <p class="new-price"> Price: $<span>{{ number_format($ads_data->AD_price, 2) }}</span>
                                    </p>
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

    <script>
        const imgs = document.querySelectorAll('.img-select a');
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
            const displayWidth = document.querySelector('.img-showcase img:first-child').clientWidth;

            document.querySelector('.img-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        }

        window.addEventListener('resize', slideImage);
    </script>
@endsection
