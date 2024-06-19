@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="products">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý sản phẩm
                        <span>
                            <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-info"><i
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
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Shop</th>
                            <th>Giá gốc</th>
                            <th>Giá bán</th>
                            <th>Số lượng kho</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-left"><img src="{{ asset('storage') . '/' . $item->thumbnail }}"
                                        alt="{{ $item->name }}" class="image-80 image-80-v"></td>
                                <td>{{ $item->code }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->store->name ?? '' }}</td>
                                <td>{{ $item->formatMoney($item->price_origin) }}</td>
                                <td>{{ $item->formatMoney($item->price_sale) }}</td>
                                <td>{{ $item->quantity_stock }}</td>
                                <td class="text-center">{!! $item->status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-ban text-danger"></i>' !!}</td>
                                <td class="operation">
                                    <a href="{{ route('products.edit', $item->id) }}"><i
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
            });
        });
    </script>
@endsection
