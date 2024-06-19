@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="stores">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Danh sách các hợp tác xã
                        {{-- <span>
                            <a href="{{ route('stores.create') }}" class="btn btn-sm btn-outline-info"><i
                                    class="fas fa-plus"></i> Thêm mới</a>
                        </span> --}}
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th class="text-left">Logo</th>
                            <th>Nhà bán hàng</th>
                            <th>Chủ sở hữu</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ngày tạo</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-left"><img src="{{ asset('storage') . '/' . $item->logo }}"
                                        alt="{{ $item->name }}" class="image-80"></td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item->status == 1 ? 'primary' : 'warning' }}">
                                        {{ $item->status == 1 ? 'Đã duyệt' : 'Chờ duyệt' }}
                                    </span>
                                </td>

                                <td class="operation">
                                    <a href="{{ route('stores.edit', $item->id) }}"><i class="far fa-edit btn-edit"></i></a>
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
                lengthMenu: [20, 50, 100, 300, 500],
                searching: true,
            });
        });
    </script>
@endsection
