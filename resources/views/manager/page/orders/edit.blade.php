@extends('manager.layouts.master')
@section('content')
    <div class="col-md-10 center pt-5" id="menu-active" data-active-menu="products">
        <form method="post" action="{{ route('manager.updateOrder', $data->id) }}">
            @csrf
            @method('PATCH')
            <div class="card card-primary ">
                <div class="card-header">
                    <h3 class="card-title">
                        <span> Thông tin đơn hàng</span>
                    </h3>
                    <div class="float-right">
                        <div class="d-flex align-items-center">
                            <label style="white-space:nowrap" class="mr-3">Trạng thái: </label>
                            <select name="status" class="form-control select2">
                                @if ($data->status == 0)
                                    <option value="-1">Huỷ đơn</option>
                                @endif
                                @foreach (App\Models\Order::$statusLabels as $status => $label)
                                    @if ($status >= $data->status)
                                        <option value="{{ $status }}"
                                            {{ $data->status == $status ? 'selected' : '' }}>{{ $label }}</option>
                                        {{ $label }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-6 border-right">
                            <p class="title text-center">Thông tin khách hàng</p>
                            <p><span class="label">Họ tên:</span> {{ $data->name }}</p>
                            <p><span class="label">SĐT:</span> {{ $data->phone }}</p>
                            <p><span class="label">Thời gian đặt hàng:</span>
                                {{ $data->created_at->format('d/m/Y H:i:s') }}
                            </p>
                            <p><span class="label">Địa chỉ:</span>
                                {{ $data->address }},
                                {{ $data->wards->name }},
                                {{ $data->district->name }},
                                {{ $data->province->name }}
                            </p>
                        </div>
                        <div class="col col-md-6">
                            <p class="title text-center">Thông tin đơn hàng</p>
                            @foreach ($data->orderdetails as $item)
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <img src="{{ asset('storage') . '/' . $item->product->thumbnail }}" alt=""
                                            class="thumbnail">
                                        <span>({{ $item->product->code }})</span>
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                    <div class="d-flex " style="gap: 50px">
                                        <span>SL: {{ $item->quantity }}</span>
                                        <span>Đơn giá: {{ number_format($item->price) }}đ</span>
                                    </div>
                                </div>
                            @endforeach
                            <div class="pt-4 border-top d-flex justify-content-between text-danger font-weight-bold"
                                style="font-size: 20px">
                                <span>Tổng tiền hàng: </span>
                                <span>{{ number_format($data->total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Cập nhật</button>
                </div>
        </form>
    </div>
@endsection
