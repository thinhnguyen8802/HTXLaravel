@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="categories">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Thêm mới banner</h3>
            </div>
            <form method="post" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên danh mục'])
                    @endcomponent
                    <select name="parent_id" id="parent_id" class="form-control mb-4 select2">
                        <option value="">Chọn danh mục cha</option>
                        @foreach ($cateP as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                    @component('components.toggle-switch', [
                        'name' => 'status',
                        'value0' => 'Tắt',
                        'value1' => 'Bật',
                    ])
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
