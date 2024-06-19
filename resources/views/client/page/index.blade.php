@extends('client.layouts.master')

@section('content')
    <div class="sidebar">@include('client.includes.sidebar')</div>
    <div class="content">
        <section class="block" id="banner">
            <div class="slider-banner">
                @foreach ($banners as $item)
                    <a href="#"> <img src="{{ asset('storage') . '/' . $item->image }}" alt=""> </a>
                @endforeach
            </div>
        </section>

        {{-- <section class="block" id="quick-link">
            @for ($i = 1; $i < 6; $i++)
                <a href="#">
                    <img src="/../common/image/topdeal1.png" alt="">
                    <span>Top Deals</span>
                </a>
            @endfor
        </section> --}}

        <section class="block products" id="widget">
            <a href="#" class="title">Sản phẩm bán chạy</a>
            <div class="list-item slider">
                @foreach ($topProducts as $item)
                    <a href="{{ route('product.detail', $item->product->id) }}" class="item position-relative">
                        <img class="logo-store-in-product"
                            src="{{ asset('storage') . '/' . $item->product->store->logo }}" />
                        <img class="thumbnail" src="{{ asset('storage') . '/' . $item->product->thumbnail }}" alt=""
                            width="300px">
                        <div class="tags">
                            <img src="/common/image/topdeal.png" alt="">
                            <img src="/common/image/legit.png" alt="">
                        </div>
                        <div class="box-info">
                            <h4 class="name-product txt-2-line font-weight-bold">{{ $item->product->name }} </h4>
                            <div class="rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span style="font-size: 12px; font-style:italic">(đã bán:
                                    {{ $item->total_quantity }})</span>
                            </div>
                            <div class="prices">
                                <div>
                                    <span
                                        class="price-new">{{ $item->product->formatMoney($item->product->price_sale) }}</span>
                                    <span>/{{ $item->product->pcs }}</span>
                                </div>
                                <span
                                    class="price-old">{{ $item->product->formatMoney($item->product->price_origin) }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        <section class="block bgc " id="top-shop">
            <a href="#" class="title">Hợp tác xã</a>
            <div class="list-item htx ">
                @foreach ($stores as $store)
                    <div class="item ">
                        <a href="{{ route('htx', $store->id) }}" class="left">
                            <img class="thumbnail" src="{{ asset('storage') . '/' . $store->logo }}" alt="">
                        </a>
                        <div class="right">
                            <div class="top">
                                <span class="name-store text-2-line"><a
                                        href="{{ route('htx', $store->id) }}">{{ $store->name }}</a></span>
                                <p class="slogan">Địa chỉ: {{ $store->address }}, {{ $store->wards->name }},
                                    {{ $store->district->name }}, {{ $store->province->name }}</p>
                            </div>
                            <div class="bottom">
                                <p class="title">Sản phẩm</p>
                                <div class="list slider-sm">
                                    @foreach ($store->products as $item)
                                        <a href="{{ route('product.detail', $item->id) }}" title="{{ $item->name }}">
                                            <img src="{{ asset('storage') . '/' . $item->thumbnail }}" alt=""
                                                style="width: 60px; height:60px">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <section class="block " id="questions">
            <a href="#" class="title">Tin mới</a>
            <div class="list-item">
                @foreach ($questions as $item)
                    <a href="{{ route('blog', $item->id) }}" class="item">
                        <span class="it-header"><img src="/../common/image/cart.png" alt=""> Mua sắm</span>
                        <span class="it-content text-3-line">{{ $item->title }}</span>
                        <span class="it-footer"><i class="fas fa-arrow-right"></i></span>
                    </a>
                @endforeach

            </div>
        </section>
        <section class="block products" id="all-product">
            <div class="list-item">
                @foreach ($products as $item)
                    <a href="{{ route('product.detail', $item->id) }}" class="item">
                        <img class="thumbnail" src="{{ asset('storage') . '/' . $item->thumbnail }}" alt=""
                            width="300px">
                        <div class="tags">
                            <img src="/common/image/topdeal.png" alt="">
                            <img src="/common/image/legit.png" alt="">
                        </div>
                        <div class="box-info">
                            <h4 class="name-product txt-2-line font-weight-bold">{{ $item->name }} </h4>
                            <div class="rate">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>

                            </div>
                            <div class="prices">
                                <span class="price-new">{{ $item->formatMoney($item->price_sale) }}</span>
                                <span class="price-old">{{ $item->formatMoney($item->price_origin) }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>
@endsection
@section('include-js')
    <script>
        // slide sản phẩm
        $('.slider').slick({
            slidesToShow:4,
            slidesToScroll: 3,
            autoplay: true,
            autoplaySpeed: 2000,
            infinite: true,
            speed: 300,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        //slide htx
        $('.htx').slick({
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
            speed: 300,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('.slider-banner').slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    </script>
@endsection
