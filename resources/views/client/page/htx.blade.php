@extends('client.layouts.master')
@section('content')
    <div class="content page-store ">
        <div class="info-store">

            <div>
                <h3 class="title">{{ $htx->name }}
                </h3>
                <div><img src="/../common/image/official.png" alt="" class="bage">
                    <span style="color: #fff"><i class="fa-solid fa-star text-warning"></i> 5/5</span>
                </div>
            </div>
        </div>

        <div class="block-products">
            <div class="sidebar">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('storage' . '/' . $htx->logo) }}" alt="logo" class="logo" >
                </div>
                <a href="{{$htx->map}}" target="_blank" class="text-primary"><i class="fas fa-map-marker-alt"></i> Địa chỉ: {{$htx->address}} {{$htx->wards->name}}, {{$htx->district->name}}, {{$htx->province->name}}</a>

                <h3 class="title">Giới thiệu chung</h3>
                <div class="decs">{!! $htx->description !!}</div>

            </div>
            <div class="products">
                @foreach ($htx->products as $item)
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
@endsection
@section('include-js')
@endsection
