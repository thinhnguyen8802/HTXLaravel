@extends('manager.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="orders">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý đơn hàng</h3>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th>Ngày đặt hàng</th>
                            <th>Người dặt</th>
                            <th>Số điện thoại</th>
                            <th>địa chỉ</th>
                            <th>Thành tiền</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    {{ $item->name }} -
                                    SĐT: {{ $item->phone }} -
                                    địa chỉ: {{ $item->address }},
                                    {{ $item->wards->name }},
                                    {{ $item->district->name }},
                                    {{ $item->province->name }}
                                </td>
                                <td>{{ number_format($item->total) }}</td>
                                <td style="width: 120px">
                                    <div class="text-status"
                                        style="background-color: {{ \App\Models\Order::$statusColors[$item->status] }}">
                                        {{ \App\Models\Order::$statusLabels[$item->status] }}
                                    </div>
                                </td>
                                <td class="operation">
                                    <a href="{{ route('manager.editOrder', $item->id) }}"><i
                                            class="far fa-edit btn-edit"></i></a>
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
                order: [[0, 'desc']],
                responsive: true,
            });
        });
    </script>
@endsection
