@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="stores">
        <div class="card">
            <div class="card-header ">
                @if ($data->status == 0)
                    <h3 class="card-title">Duyệt yêu cầu trở thành nhà bán hàng </h3>
                    <div class="float-right d-flex">
                        <form action="{{ route('api.approveRequest') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="text" hidden value="-1" name="status">
                            <input type="text" hidden value="{{ $data->id }}" name="id">
                            <button class="btn btn-sm btn-outline-danger mr-3">Từ chối</button>
                        </form>
                        <form action="{{ route('api.approveRequest') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="text" hidden value="1" name="status">
                            <input type="text" hidden value="{{ $data->id }}" name="id">
                            <button class="btn btn-sm btn-primary">Duyệt</button>
                        </form>
                    </div>
                @else
                    <h3 class="card-title">Chỉnh sửa thông tin</h3>
                @endif
            </div>
            <form method="post" action="{{ route('stores.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên nhà bán hàng', 'editData' => $data])
                    @endcomponent
                    @component('components.input', [
                        'name' => 'phone',
                        'labelText' => 'Số điện thoại',
                        'type' => 'tel',
                        'editData' => $data,
                    ])
                    @endcomponent
                    <div class="form-item">
                        <select name="provinceId" id="" class="form-control mb-4">
                            <option value="{{ $data->provinceId }}">{{ $data->province->name }}</option>
                        </select>
                        <label for="role_id" class>Tỉnh thành</label>
                    </div>
                    <div class="form-item">
                        <select name="districtId" id="" class="form-control mb-4">
                            <option value="{{ $data->districtId }}">{{ $data->district->name }}</option>
                        </select>
                        <label for="role_id" class>Quận huyện</label>
                    </div>
                    <div class="form-item">
                        <select name="wardsId" id="" class="form-control mb-4">
                            <option value="{{ $data->wardsId }}">{{ $data->wards->name }}</option>
                        </select>
                        <label for="role_id" class>Phường xã</label>
                    </div>
                    @component('components.input', ['name' => 'address', 'labelText' => 'Đia chỉ', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'tax_code', 'labelText' => 'Mã số thuế', 'editData' => $data])
                    @endcomponent
                    @component('components.toggle-switch', [
                        'name' => 'is_banned',
                        'value0' => 'Cấm',
                        'value1' => 'Mở',
                        'editData' => $data,
                    ])
                    @endcomponent
                </div>
                <div class="card-footer">
                    @if ($data->status != 0)
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    @endif
                </div>
            </form>
        </div>
    @endsection
