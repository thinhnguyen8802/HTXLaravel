@extends('backend.layouts.master')
@section('content')
    <div class="col-md-10 center pt-5" id="menu-active" data-active-menu="products">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin bài viết </h3>
            </div>
            <form method="post" action="{{ route('questions.update',$data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            @component('components.input', ['name' => 'title', 'labelText' => 'Tiêu đề', 'editData' => $data])
                            @endcomponent
                            @component('components.ckeditor', ['name' => 'description', 'labelText' => 'Mô tả chi tiết', 'editData' => $data])
                            @endcomponent
                        </div>
                        <div class="col-md-3">
                            @component('components.upload-file', ['name' => 'image'])
                                @slot('editData', $data->image)
                            @endcomponent
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
