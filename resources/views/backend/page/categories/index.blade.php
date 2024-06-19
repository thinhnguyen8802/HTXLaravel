@extends('backend.layouts.master')
@section('content')
    <div class="col-12" id="menu-active" data-active-menu="categories">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h3>Quản lý danh mục
                        <span>
                            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-outline-info"><i
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
                            <th>Danh mục cha</th>
                            <th>Danh mục con</th>
                            <th>Thứ tự hiển thị</th>
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
                                <td>
                                    {!! $item->status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-ban text-danger"></i>' !!}
                                    {{ $item->name }}
                                    {{-- <img src="{{ asset('storage') . '/' . $item->image }}" alt="{{ $item->name }}"
                                        class="image-42"> --}}

                                </td>
                                <td class="d-flex flex-column" style="gap: 6px">
                                    @foreach ($item->children as $child)
                                        <div class="d-flex align-items-md-center " style="gap: 6px">
                                            {!! $child->status == 1 ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-ban text-danger"></i>' !!}
                                            {{ $child->name }}
                                            {{-- <img src="{{ asset('storage') . '/' . $child->image }}"
                                                alt="{{ $child->name }}" class="image-42"> --}}
                                            <span><a href="{{ route('categories.edit', $child->id) }}"><i
                                                        class="far fa-edit "></i></a></span>
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-center">{{ $item->status}}</td>
                                <td class="operation">
                                    <a href="{{ route('categories.edit', $item->id) }}"><i
                                            class="far fa-edit btn-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <td class="text-center"><img src="{{ asset('storage') . '/' . $item->image }}"
                            alt="{{ $item->name }}" class="image-banner-sm"></td> --}}
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
