@extends('backend.layouts.master')
@section('content')
    <div class="col-md-6 center pt-5" id="menu-active" data-active-menu="users">
        <div class="card card-primary ">
            <div class="card-header">
                <h3 class="card-title">Thêm mới người dùng</h3>
            </div>
            <form method="post" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-item">
                        <select name="role_id" id="" class="form-control mb-4">
                            <option value="1" >Khách hàng</option>
                            <option value="0" >Chủ cửa hàng</option>
                            <option value="-1" >Admin</option>
                        </select>
                        <label for="role_id" class>Vai trò:</label>
                    </div>
                    @component('components.input', ['name' => 'username', 'labelText' => 'Tên tài khoản'])
                    @endcomponent
                    @component('components.input', ['name' => 'email', 'labelText' => 'Email', 'type' => 'email'])
                    @endcomponent
                    @component('components.input', ['name' => 'password', 'labelText' => 'Mật khẩu', 'type' => 'password'])
                    @endcomponent
                    @component('components.input', ['name' => 'phone', 'labelText' => 'Số điện thoại', 'type' => 'tel'])
                    @endcomponent
                    @component('components.input', ['name' => 'name', 'labelText' => 'Tên'])
                    @endcomponent
                    @component('components.upload-file', ['name' => 'image', 'id' => 'user'])
                    @endcomponent
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
@endsection
