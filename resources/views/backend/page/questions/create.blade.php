@extends('backend.layouts.master')
@section('content')
    <div class="col-md-10 center pt-5" id="menu-active" data-active-menu="questions">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Tạo mới bài đăng</h3>
            </div>
            <form method="post" action="{{ route('questions.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            @component('components.input', ['name' => 'title', 'labelText' => 'Tiêu đề'])
                            @endcomponent
                            @component('components.ckeditor', ['name' => 'description', 'labelText' => 'Mô tả chi tiết'])
                            @endcomponent
                        </div>
                        <div class="col-md-3">
                            @component('components.upload-file', ['name' => 'image'])
                            @endcomponent
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Lưu bài</button>
                </div>
            </form>
        </div>
    </div>
@endsection
{{-- @component('components.toggle-switch', [
    'name' => 'status',
    'value0' => 'Ẩn',
    'value1' => 'Hiện',
]) --}}
{{-- @endcomponent
@component('components.upload-file', ['name' => 'image'])
@endcomponent

@component('components.ckeditor', ['name' => 'description', 'labelText' => 'Mô tả chi tiết'])
@endcomponent --}}
