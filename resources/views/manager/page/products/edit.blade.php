@extends('manager.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="products">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin sản phẩm </h3>
            </div>
            <form method="post" action="{{ route('products.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <input type="text" name="store_id" value="{{Auth::user()->store->id}}" hidden>
                    <div class="form-item">
                        <select name="cate_id" id="" class="form-control mb-4 select2">
                            @foreach ($cates as $item)
                                <option value="{{$item->id}}" {{$item->id == $data->cate_id ? "selected" : ""}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        <label for="role_id" class>Danh mục</label>
                    </div>
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên sản phẩm', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'code', 'labelText' => 'Mã sản phẩm', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'short_desc', 'labelText' => 'Mô tả ngắn', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'price_origin', 'labelText' => 'Giá gốc', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'price_sale', 'labelText' => 'Giá bán', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'pcs', 'labelText' => 'Đơn vị tính', 'editData' => $data])
                    @endcomponent
                    @component('components.toggle-switch', [
                        'name' => 'status',
                        'value0' => 'Ẩn',
                        'value1' => 'Hiện',
                        'editData' => $data,
                    ])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image'])
                        @slot('editData', $data->thumbnail)
                    @endcomponent

                    @component('components.ckeditor', ['name' => 'description', 'labelText' => 'Mô tả chi tiết', 'editData' => $data])
                    @endcomponent

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
