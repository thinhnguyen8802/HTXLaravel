@extends('client.layouts.master')
@section('content')

    @if ($store)
        <div class="content page-store ">
            <div class="info-store">
                <img src="{{ asset('storage' . '/' . $store->logo) }}" alt="logo" class="logo">
                <div>
                    <h3 class="title">{{ $store->name }}
                    </h3>
                    <div><img src="/../common/image/official.png" alt="" class="bage">
                        <span style="color: #fff"><i class="fa-solid fa-star text-warning"></i> 5/5</span>
                    </div>
                </div>
            </div>

            <div class="block-products">
                <div class="sidebar">
                    <div class="title">Danh mục sản phẩm</div>
                    <ul>
                        <li class="select-cate-id" data-cate-id="">Tất cả</li>
                        @foreach ($categories as $item)
                            <li class="select-cate-id" data-cate-id="{{ $item->id }}">{{ $item->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="products">
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

            </div>
        </div>
    @else
        <div class="sidebar">@include('client.includes.sidebar')</div>
        <div class="content">
            <section class="text-center mb-4 mt-2" style="font-size: 18px; color: #000; font-style:italic">
                Đã tìm thấy: {{ $count }} sản phẩm
                @if ($nameCate != '')
                    <p>thuộc danh mục: {{ $nameCate }}</p>
                @endif
                @if ($keyword != '')
                    <p>Từ khóa: {{ $keyword }}</p>
                @endif
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
    @endif

@endsection
@section('include-js')
@endsection
