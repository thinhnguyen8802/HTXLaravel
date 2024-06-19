@extends('client.layouts.master')
@section('content')
    <div class="content cart-page" style="width:100%">
        <div class="steps">
            <ul class="list">
                <li class="">
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="text">Giỏ hàng</div>
                </li>
                <li class="active">
                    <div class="icon"><i class="fa-solid fa-money-bill thanhtoan"></i></div>
                    <div class="text">Thanh toán</div>
                </li>
                <li>
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Hoàn tất</div>
                </li>
            </ul>
        </div>
        <form action="{{ route('api.create_order') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col col-md-6 border-right">
                    <div class="title">Thông tin khách hàng</div>
                    <div class="form-group">
                        <label for="">Người nhận</label>
                        <input type="text" name="name" id="name" class="form-control"
                            value="{{ $shipping->name ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{ $shipping->phone ?? '' }}">
                    </div>
                    <div class="row">
                        <div class="col c0l-md-4 form-group">
                            <label for="">Tỉnh thành</label>
                            <select name="provinceId" id="provinceId" class="select2 form-control">
                                <option value="{{ $shipping->province->id ?? '' }}" selected>
                                    {{ $shipping->province->name ?? '' }}
                                </option>
                            </select>
                        </div>
                        <div class="col c0l-md-4 form-group">
                            <label for="">Quận huyện</label>
                            <select name="districtId" id="districtId" class="select2 form-control">
                                <option value="{{ $shipping->district->id ?? '' }}" selected>
                                    {{ $shipping->district->name ?? '' }}
                                </option>
                            </select>
                        </div>
                        <div class="col c0l-md-4 form-group">
                            <label for="">Xã phường</label>
                            <select name="wardsId" id="wardsId" class="select2 form-control">
                                <option value="{{ $shipping->wards->id ?? '' }}" selected>{{ $shipping->wards->name ?? '' }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Địa chỉ</label>
                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ $shipping->address ?? '' }}">
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="title">Thông tin đơn hàng</div>
                    <ul class="d-flex flex-column" style="gap: 12px">
                        @foreach ($carts as $item)
                            <li class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage') . '/' . $item->product->thumbnail }}" alt=""
                                        style="width: 60px; aspect-ratio: 1/1">
                                    <p style="width: 150px" class="ml-3">{{ $item->product->name }}</p>
                                </div>
                                <span>x {{ $item->quantity }}</span>
                                <span>{{ number_format($item->product->price_sale * $item->quantity) }}đ</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-3">
                        @php
                            $total = 0;
                            foreach ($carts as $item) {
                                if ($item->status == 1) {
                                    $total += $item->product->price_sale * $item->quantity;
                                }
                            }
                        @endphp
                        <div class="title">Phương thức thanh toán</div>
                        <div class="payments d-flex align-items-center" style="gap:50px">
                            <div class="mr-4">
                                <input type="radio" name="payment" value="cod" id="cod" checked>
                                <label for="cod"><span><img src="/../common/image/cod.png" alt=""
                                            width="40px"></span>Thanh toán khi nhận hàng</label>
                            </div>
                            <div title="Giá trị đơn hàng phải lớn hơn 10.000đ">
                                <input type="radio" name="payment" value="vnpay" id="vnpay" @if ($total < 10000) disabled @endif>
                                <label for="vnpay"><span><img src="/../common/image/vnpay.png" alt=""
                                            width="70px"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="block mt-4 ">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="title">Tổng tiền</h4>
                            <div class="prices">
                                <div class="price-new">

                                    {{ number_format($total) }}đ
                                </div>
                            </div>
                        </div>
                        <div class="buttons">
                            <button class="btn btn-danger w100 mt-3" id="btn-buy">Thanh toán</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    </div>
@endsection
@section('include-js')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
            $("#provinceId").select2({
                ajax: {
                    url: '/api/provinces',
                    dataType: 'json'
                },
                placeholder: "Tỉnh thành",
            }).on("change", function() {
                $("#districtId").val(null).trigger('change');
                $("#districtId").select2({
                    ajax: {
                        url: '/api/districts/' + $(this).val(), // url
                        dataType: 'json'
                    },
                    placeholder: "Quận huyện",
                }).on("change", function() {
                    $("#wardsId").val(null).trigger('change');
                    $("#wardsId").select2({
                        ajax: {
                            url: '/api/wards/' + $(this).val(), // url
                            dataType: 'json'
                        },
                        placeholder: "Phường xã",
                    })
                })
            })

            // $("#btn-buy").click(function() {
            //     var payment = $("input[name=payment]:checked").val();
            //     var name = $("#name").val()
            //     var phone = $("#phone").val()
            //     var provinceId = $("#provinceId").val()
            //     var districtId = $("#districtId").val()
            //     var wardsId = $("#wardsId").val()
            //     var address = $("#address").val()
            //     if (name && phone && provinceId && districtId && wardsId && address) {
            //         $.ajax({
            //             url: '/api/order',
            //             type: 'POST',
            //             data: {
            //                 name: name,
            //                 phone: phone,
            //                 provinceId: provinceId,
            //                 districtId: districtId,
            //                 wardsId: wardsId,
            //                 address: address,
            //                 payment: payment,
            //             },
            //             success: function(res) {
            //                 if (res.error == 0) {
            //                     window.location.href = `${res.url}`;
            //                 } else {
            //                     toastError(res.msg);
            //                 }
            //             },
            //             error: function(data) {
            //                 toastError("Đã xảy ra lỗi!");
            //             }
            //         })
            //     } else {
            //         toastError("Vui lòng điền đầy dủ thông tin");
            //     }
            // })

        });
    </script>
@endsection
