@extends('client.layouts.master')
@section('content')
    <input type="text" id="login" value="{{ Auth::check() ? 1 : 0 }}" hidden>
    <input type="text" value="{{ Auth::check() ? Auth::user()->id : 0 }}" hidden id="user_id">
    <div class="content w100">
        <section class="block" id="left">
            <div class="block-e">
                <div class="box-image">
                    <img src="{{ asset('storage') . '/' . $product->thumbnail }}">
                </div>
                <div class="mt-4">
                    <p class="title">Thông tin chi tiết:</p>
                    <div style="font-size: 14px">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>
        </section>
        <section class="block" id="center" style="background: transparent">
            <div style="background: #fff">
                <div class="d-flex align-items-center mb-3" style="gap: 8px">
                    <img src="/common/image/legit.png" alt="" height="24px">
                    <img src="/common/image/topdeal.png" alt="" height="24px">
                    <span>Danh mục: <a href="#">{{ $product->category->name }}</a></span>
                </div>
                <h1 class="name-product">{{ $product->name }}</h1>
                <div> Mã sản phẩm: {{$product->code}}</div>
                <div class="d-flex">
                    <span>5.0</span>
                    <div class="rate">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                </div>
                <div class="prices mt-3" style="justify-content: flex-start">
                    <span class="price-new" style="font-size: 24px;">{{ number_format($product->price_sale) }}đ </span><span>/{{$product->pcs}}</span>
                    <span class="price-old">{{ number_format($product->price_origin) }}đ</span>
                </div>
                <p>Mô tả: {{ $product->short_desc }}</p>
            </div>
            <div class="block">
                <p class="title">Sản phẩm liên quan</p>
                <div class="list-item">
                    @foreach ($relatedProduct as $item)
                        <a href="{{ route('product.detail', $item->id) }}" class="item">
                            <img class="thumbnail" src="{{ asset('storage') . '/' . $item->thumbnail }}" alt=""
                                style="aspect-ratio: 9/10;">
                            <div class="box-info">
                                <h4 class="name-product txt-2-line">{{ $item->name }}</h4>
                                <div class="rate">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                                <div class="prices">
                                    <span class="price-new">{{ $item->formatMoney($item->price_sale) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="block" id="right">
            <div class="block-e">
                <div class="info-store">
                    <img src="{{asset('storage').'/'.$store->logo}}" alt="" class="logo-store" style="border-radius: 4px; border:1px solid #ddd">
                    <div>
                        <h3 class="name-store">{{ $product->store->name }}</h3>
                    </div>
                    <span>4.7 <i class="fas fa-star text-warning"></i></span>

                </div>
                <div class="product-quantity">
                    <form action="{{ route('buyNow') }}" method="POST">
                        @csrf
                        <label for="quantity">Số Lượng</label>
                        <div class="quantity-controls">
                            <button type="button" id="decrease" class="quantity-button">-</button>
                            <input type="text" value="{{ $product->id }}" name = "id" hidden>
                            <input type="text" name="quantity" id="quantity" value="1">
                            <button type="button" id="increase" class="quantity-button">+</button>
                        </div>
                        <div class="subtotal">
                            <span style="font-size: 16px">Tạm tính</span>
                            <span id="subtotal"></span>
                        </div>
                        <div class="buttons">
                            <button class="buy-now btn btn-danger">Mua ngay</button>
                            <button type="button" class="add-to-cart btn btn-outline-primary mt-2">Thêm vào giỏ</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('include-js')
    <script>
        $(document).ready(function() {
            var login = $("#login").val();
            $(".add-to-cart").on("click", function() {
                if (login == 0) {
                    // Chuyển đến trang login
                    window.location.href = '/login';
                    return;
                }
                var id = {{ $product->id }};
                var user_id = $("#user_id").val();
                var quantity = $("#quantity").val();
                $.ajax({
                    url: "/api/add-to-cart",
                    type: "POST",
                    data: {
                        id: id,
                        user_id: user_id,
                        quantity: quantity,
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            $(".quantity-cart-psa").html((res.count))
                            toastSuccess(res.msg);
                        } else {
                            toastError(res.msg);
                        }
                    },
                    error: function(data) {
                        toastError("Đã xảy ra lỗi!!!");
                    }
                })
            })



            const pricePerUnit = {{ $product->price_sale }};

            function updateSubtotal(quantity) {
                const subtotal = pricePerUnit * quantity;
                $('#subtotal').text(subtotal.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }));
            }

            function validateQuantity(quantity) {
                quantity = parseInt(quantity);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                }
                return quantity;
            }

            $('#decrease').on('click', function() {
                let quantity = validateQuantity($('#quantity').val());
                if (quantity > 1) {
                    quantity--;
                    $('#quantity').val(quantity);
                    updateSubtotal(quantity);
                }
            });

            $('#increase').on('click', function() {
                let quantity = validateQuantity($('#quantity').val());
                quantity++;
                $('#quantity').val(quantity);
                updateSubtotal(quantity);
            });

            $('#quantity').on('input', function() {
                let quantity = validateQuantity($(this).val());
                $(this).val(quantity);
                updateSubtotal(quantity);
            });

            // Khởi tạo subtotal khi tải trang
            updateSubtotal(validateQuantity($('#quantity').val()));
        });
    </script>
@endsection
