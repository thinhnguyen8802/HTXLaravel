@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="users">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Sửa thông tin người dùng: <span class="text-dark">{{ $data->username }} |
                        {{ $data->email }}</span></h3>
            </div>
            <form method="post" action="{{ route('users.update', $data->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-item">
                        <select name="role_id" id="" class="form-control mb-4">
                            <option value="1" {{$data->role_id == 1 ? "selected" : ""}}>Khách hàng</option>
                            <option value="0" {{$data->role_id == 0 ? "selected" : ""}}>Chủ cửa hàng</option>
                            <option value="-1" {{$data->role_id == -1 ? "selected" : ""}}>Admin</option>
                        </select>
                        <label for="role_id" class>Vai trò:</label>
                    </div>
                    @component('components.input', [
                        'name' => 'phone',
                        'labelText' => 'Số điện thoại',
                        'type' => 'tel',
                        'editData' => $data,
                    ])
                    @endcomponent
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên', 'editData' => $data])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image', 'id' => 'user'])
                        @slot('editData', $data->image)
                    @endcomponent
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    @endsection
