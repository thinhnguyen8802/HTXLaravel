@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="stores">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Thêm mới nhà bán hàng</h3>
            </div>
            <form method="post" action="{{ route('stores.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên nhà bán hàng'])
                    @endcomponent
                    @component('components.input', ['name' => 'description', 'labelText' => 'Mô tả Shop'])
                    @endcomponent
                    @component('components.input', ['name' => 'address', 'labelText' => 'Đia chỉ'])
                    @endcomponent
                    @component('components.input', ['name' => 'phone', 'labelText' => 'Số điện thoại', 'type' => 'tel'])
                    @endcomponent
                    @component('components.input', ['name' => 'tax_code', 'labelText' => 'Mã số thuế'])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image'])
                    @endcomponent
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
