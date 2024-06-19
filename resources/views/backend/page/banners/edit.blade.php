@extends('backend.layouts.master')
@section('content')
<style>
    #preview_image{
        width: 500px;
        height: 300px;
        aspect-ratio: 4/3;
        border-radius: 8px;
    }
</style>
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="banners">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin banner </h3>
            </div>
            <form method="post" action="{{ route('banners.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên banner', 'editData' => $data])
                    @endcomponent
                    @component('components.input', ['name' => 'link', 'labelText' => 'Link liên kết', 'editData' => $data])
                    @endcomponent
                    @component('components.toggle-switch', [
                        'name' => 'status',
                        'value0' => 'Ẩn',
                        'value1' => 'Hiện',
                        'editData' => $data
                    ])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image'])
                    @slot('editData', $data->image)
                    @endcomponent
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
