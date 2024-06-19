@extends('manager.layouts.master')
@section('content')
    <h3>{{ $store->name }}</h3>
    <div class="card mt-4" style="width:100%">
        <div class="card-header">
            <div class="d-flex align-items-center" style="gap: 20px">
                <span>Thống kê cửa hàng</span>
                <div class="d-flex align-items-center" style="gap: 8px; white-space: nowrap">
                    <span>Từ ngày</span> <input type="date" id="startDate" name="start_date" class="form-control">
                    <span>đến ngày</span> <input type="date" id="endDate" name="end_date" class="form-control">
                    <button type="button" class="btn btn-primary" id="btn-filter"> Lọc </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-6" id="menu-active" data-active-menu="dashboard">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $orders }} </h3>
                            <p>Đơn hàng <span class="right badge badge-danger">{{ $orderNew }} đơn mới</span></p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('manager.orders') }}" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="total-revenue">{{ number_format($totalMoney) }}<sup style="font-size: 20px">đ</sup></h3>
                            <p>Doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $totalUniqueUsers }}</h3>
                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $products }}</h3>

                            <p>Tổng sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('products.index') }}" class="small-box-footer">Xem thêm <i
                            class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="card col">
            <div class="card-header">
                <div class="title">Sản phẩm bán chạy</div>
            </div>
            <div class="card-body">
                <table class="table table-boredered">
                    <thear>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng bán</th>
                            <th>Doanh thu sản phẩm</th>
                            <th>Giá bán hiện tại</th>
                        </tr>
                    </thear>
                    <tbody>
                        @if ($topSelling->count() > 0)
                            @foreach ($topSelling as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset('storage') . '/' . $item->thumbnail }}" alt=""
                                            style="width: 60px; height: 80px">
                                        <span>{{ $item->name }}</span>
                                    </td>
                                    <td>{{ $item->order_details_count }}</td>
                                    <td>{{ number_format($item->totalRevenue) }} đ</td>
                                    <td>{{ number_format($item->price_sale) }} đ/{{ $item->pcs }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>chưa có dữ liệu</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="card col">
            <div class="card-header">
                <div class="title">Khách hàng thân thiết</div>
            </div>
            <div class="card-body">
                <table class="table table-boredered">
                    <thear>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Doanh thu từ khách hàng</th>
                            <th>Số đơn đã đặt</th>
                        </tr>
                    </thear>
                    <tbody>
                        @if ($topCustomers->count() > 0)
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($topCustomers as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ number_format($item->totalSpent) }} đ</td>
                                    <td>{{ number_format($item->orders_count) }} đơn hàng</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>chưa có dữ liệu</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="card col">
            <div class="card-header">
                <div class="title">Sản phẩm tồn kho</div>
            </div>
        </div>
    </div>
@endsection

@section('include-js')
    <script>
         $(document).ready(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        });
        let today = new Date();
        // Ngày đầu tháng hiện tại
        let firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 2);
        // Ngày cuối tháng hiện tại
        let lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
        // Định dạng ngày thành YYYY-MM-DD
        let firstDayFormatted = firstDayOfMonth.toISOString().split('T')[0];
        let lastDayFormatted = lastDayOfMonth.toISOString().split('T')[0];
        // Thiết lập giá trị cho các trường input
        document.getElementById('startDate').value = firstDayFormatted;
        document.getElementById('endDate').value = lastDayFormatted;
        // Định nghĩa một hàm để gửi yêu cầu Ajax và xử lý kết quả
        function fetchDataAndDisplayRevenue() {
            var startDate = $("#startDate").val();
            var endDate = $("#endDate").val();
            if (startDate && endDate) {
                $.ajax({
                    url: "api/get-revenue",
                    type: "POST",
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                    },
                    success: function(d) {
                        if (d.error == 0) {
                            var totalRevenue = d.total;
                            var formattedRevenue = new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(totalRevenue);
                            $("#total-revenue").html(formattedRevenue);

                        } else {
                            alert(d.message);
                        }
                    },
                    error: function(e) {
                        alert("Đã xảy ra lỗi!")
                    }
                });
            } else {
                alert("Vui lòng chọn thời gian cần kiểm tra");
            }
        }

        // Gọi hàm fetchDataAndDisplayRevenue sau khi trang đã tải xong
        $(document).ready(function() {
            fetchDataAndDisplayRevenue();
        });

        // Xử lý sự kiện khi người dùng nhấn nút "Lọc"
        $("#btn-filter").on("click", function() {
            fetchDataAndDisplayRevenue();
        });
    </script>
@endsection
