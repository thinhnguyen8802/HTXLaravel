@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="categories">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin banner </h3>
            </div>
            <form method="post" action="{{ route('categories.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="card-body">
                        @component('components.input', ['name' => 'name', 'labelText' => 'Tên danh mục','editData' => $data ])
                        @endcomponent
                        <select name="parent_id" id="parent_id" class="form-control mb-4 select2">
                            <option value="">Chọn danh mục cha</option>
                            @foreach ($cateP as $item)
                                <option value="{{$item->id}}" {{$item->id == $data->parent_id ? "selected" : ""}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @component('components.toggle-switch', [
                            'name' => 'status',
                            'value0' => 'Tắt',
                            'value1' => 'Bật',
                            'editData' => $data
                        ])
                        @endcomponent
                        @component('components.upload-file', ['name' => 'image'])
                            @slot('editData', $data->image)
                        @endcomponent
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
