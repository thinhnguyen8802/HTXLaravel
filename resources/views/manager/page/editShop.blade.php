@extends('manager.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="stores">
        <div class="card">
            <div class="card-header ">
                <h3 class="card-title">Chỉnh sửa thông tin</h3>
            </div>
            <form method="post" action="{{ route('manager.editShop') }}" enctype="multipart/form-data">
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
                    @component('components.input', ['name' => 'map', 'labelText' => 'link google map', 'editData' => $data])
                    @endcomponent
                    @component('components.ckeditor', ['name' => 'description', 'labelText' => 'Mô tả chi tiết', 'editData' => $data])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image'])
                    @slot('editData', $data->logo)
                @endcomponent
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
