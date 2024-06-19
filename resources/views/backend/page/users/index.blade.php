@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="users">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý người dùng
                        <span>
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-outline-info"><i
                                    class="fas fa-plus"></i> Thêm mới</a>
                        </span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th class="text-left">Ảnh</th>
                            <th>Tài khoản</th>
                            <th>Email</th>
                            <th>Tên</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Vai trò</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-left"><img src="{{ asset('storage') . '/' . $item->image }}"
                                        alt="{{ $item->name }}" class="image-80"></td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    @if ($item->role_id == 1)
                                        Khách hàng
                                    @elseif($item->role_id == -1)
                                        Admin
                                    @else
                                        Đối tác
                                    @endif
                                </td>
                                <td class="operation">
                                    <a href="{{ route('users.edit', $item->id) }}"><i class="far fa-edit btn-edit"></i></a>
                                    <form action="{{ route('users.destroy', $item->id) }}" method="post"
                                        class="frm-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm" title="Xóa" type="submit"
                                            onclick="return confirm('Bạn có muốn xóa {{ $item->email }} khỏi hệ thống')"><i
                                                class="fas fa-trash-alt"></i> </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('include-js')
    <script>
        $(function() {
            $("#datatable").DataTable({
                "language": {
                    url: '/../common/json/datatable-vi.json',
                },
            });
        });
    </script>
@endsection
