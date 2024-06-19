@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="banners">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý banner
                        <span>
                            <a href="{{ route('banners.create') }}" class="btn btn-sm btn-outline-info"><i
                                    class="fas fa-plus"></i> Thêm mới</a>
                        </span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th class="text-left">STT</th>
                            <th>Tên banner</th>
                            <th>Link sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{ $item->name }}</td>
                                <td><a href="{{ $item->link }}">{{ $item->link }}</a></td>
                                <td class="text-center"><img src="{{ asset('storage') . '/' . $item->image }}"
                                        alt="{{ $item->name }}" class="image-banner-sm"></td>
                                <td class="text-center">{!! $item->status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-ban text-danger"></i>' !!}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                <td class="operation">
                                    <a href="{{ route('banners.edit', $item->id) }}"><i class="far fa-edit btn-edit"></i></a>
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
