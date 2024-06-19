@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="questions">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý bài đăng
                        <span>
                            <a href="{{ route('questions.create') }}" class="btn btn-sm btn-outline-info"><i
                                    class="fas fa-plus"></i> Thêm mới</a>
                        </span>
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <table id="datatable" class="table table-bordered table-striped dataTable dtr-inline">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Ảnh</th>
                            <th>Tác giả</th>
                            <th>Ngày duyệt</th>
                            {{-- <th>Trạng thái</th> --}}
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $item->title }}</td>
                                <td class="text-left"><img src="{{ asset('storage') . '/' . $item->image }}"
                                        alt="{{ $item->name }}" class="image-banner-sm"></td>
                                <td>{{ $item->user->name ?? '' }}</td>
                                @if ($item->approved_at)
                                    <td>{{ \Carbon\Carbon::parse($item->approved_at)->format('d/m/Y H:m:s') }}</td>
                                @else
                                    <td></td>
                                @endif
                                {{-- <td class="text-center">
                                    <span class="badge badge-{{ $item->status == 1 ? 'primary' : 'warning' }}">
                                        {{ $item->status == 1 ? 'Đã duyệt' : 'Chờ duyệt' }}
                                    </span>
                                </td> --}}
                                <td class="operation">
                                    <a href="{{ route('questions.edit', $item->id) }}"><i
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
