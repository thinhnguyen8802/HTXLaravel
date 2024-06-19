@extends('client.layouts.master')
@section('content')
    <div class="content cart-page">
        <div class="steps">
            <ul class="list">
                <li class="active">
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="text">Giỏ hàng</div>
                </li>
                <li class="">
                    <div class="icon"><i class="fa-solid fa-money-bill thanhtoan"></i></div>
                    <div class="text">Thanh toán</div>
                </li>
                <li>
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Hoàn tất</div>
                </li>
            </ul>
        </div>
        <div class="list-product">
            @if ($carts->count() > 0)
                @foreach ($stores as $store)
                    <h3 class="text-danger">{{ $store->name }}</h3>
                    <table class="table mb-4">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $item)
                                @if ($item->product->store_id == $store->id)
                                    <tr data-cart-id="{{ $item->id }}" data-product-id="{{ $item->product_id }}">
                                        <td>
                                            <div class="center"><input type="checkbox" class="checkbox-status"
                                                    @if ($item->status == 1) @checked(true) @endif>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage') . '/' . $item->product->thumbnail }}"
                                                    alt="" class="image-product">
                                                <a href="#" class="name-product">{{ $item->product->name }}</a>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="center">{{ $item->product->formatMoney($item->product->price_sale) }}</span>
                                        </td>
                                        <td>
                                            <div class="center">
                                                <div class="quantity-controls">
                                                    <button id="" class="quantity-button decrease">-</button>
                                                    <input type="number" class="quantity-input"
                                                        value="{{ $item->quantity }}" data-price="">
                                                    <button id="" class="quantity-button increase">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-size: 18px;font-weight: 700;">
                                            <div class="center">
                                                <span class="total-money-product">
                                                    @php
                                                        $total = $item->product->price_sale * $item->quantity;
                                                    @endphp
                                                    {{ $item->product->formatMoney($total) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class>
                                            <div class="center">
                                                <button class="btn btn-sm btn-outline-danger btn-remove-cart">Xóa</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                @endforeach
            @else
                <h3 class="text-center">Chưa có sản phẩm nào trong giỏ hàng</h3>
            @endif

        </div>
    </div>
    <div class="sidebar sidebar-cart">
        <div class="block">
            <h4 class="title">Tổng tiền</h4>
            <div class="prices">
                <div class="price-new">
                    @php
                        $total = 0;
                        foreach ($carts as $item) {
                            if ($item->status == 1) {
                                $total += $item->product->price_sale * $item->quantity;
                            }
                        }
                    @endphp
                    {{ number_format($total) }}đ
                </div>
            </div>
            <div class="buttons">
                <a href="{{ route('home.payment') }}" class="btn btn-danger w100 mt-3">Thanh toán</a>
                <a href="{{ route('home') }}" class="btn btn-outline-primary w100 mt-2">Tiếp tục mua hàng</a>
            </div>
        </div>
        <div class="block">
            <div class="title">Chính sách bán hàng</div>
            <div class="">
                <ul>
                    <li>- Bảo hành chính hãng
                    </li>
                    <li>- Bảo hành chính hãng
                    </li>
                    <li>- Bảo hành chính hãng
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('include-js')
    <script>
        $(document).ready(function() {
            var user_id = {{ Auth::user()->id }};
            $(".checkbox-status").on("click", function() {
                var id = $(this).closest("tr").attr("data-cart-id");
                var status = $(this).is(":checked") ? 1 : 0;
                $.ajax({
                    url: "/api/update-status-cart",
                    type: "POST",
                    data: {
                        id: id,
                        status: status,
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            $(".sidebar-cart .price-new").html(convertStringMoney(res.total))
                            // toastSuccess(res.msg);
                        } else {
                            // toastError(res.msg);
                        }
                    },
                    error: function(data) {}
                })
            })

            $(".quantity-input").on("change", function() {
                updateQuantity($(this));
            })

            $(".btn-remove-cart").on("click", function() {
                var input = $(this).closest("tr").find(".quantity-input")
                input.val(0);
                updateQuantity(input);
            })

            function updateQuantity(el) {
                var id = el.closest("tr").attr("data-product-id");
                var quantity = el.val();
                $.ajax({
                    url: "/api/update-cart",
                    type: "POST",
                    data: {
                        id: id,
                        user_id: user_id,
                        quantity: quantity,
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            if (quantity == 0) {
                                el.closest("tr").remove();
                            }
                            el.closest("tr").find('.total-money-product').html(convertStringMoney(res
                                .moneyProduct));
                            $(".sidebar-cart .price-new").html(convertStringMoney(res.total))
                            $(".quantity-cart-psa").html((res.count))
                            // toastSuccess(res.msg);
                        } else {
                            // toastError(res.msg);
                        }
                    },
                    error: function(data) {}
                })
            }
            // Sự kiện click cho nút tăng số lượng
            $('.increase').on('click', function() {
                var input = $(this).siblings('.quantity-input');
                console.log(input)
                var currentQuantity = parseInt(input.val());

                // Tăng số lượng lên 1
                input.val(currentQuantity + 1);
                updateQuantity(input);
            });

            // Sự kiện click cho nút giảm số lượng
            $('.decrease').on('click', function() {
                var input = $(this).siblings('.quantity-input');
                console.log(input)

                var currentQuantity = parseInt(input.val());

                // Giảm số lượng nhưng không nhỏ hơn 0
                if (currentQuantity > 0) {
                    input.val(currentQuantity - 1);
                    updateQuantity(input);
                }
            });

            function convertStringMoney(quantity) {
                return quantity.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            };
        });
    </script>
@endsection
