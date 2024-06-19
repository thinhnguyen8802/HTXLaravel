@extends('backend.layouts.master')
@section('content')
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
                            <h3>{{ $storeCount }}</h3>

                            <p>Hợp tác xã</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('stores.index') }}" class="small-box-footer">Xem thêm <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 id="total-revenue">{{ number_format($orderCount) }}đ</h3>

                            <p>Tổng doanh thu</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $customerCount }}</h3>

                            <p>Khách hàng</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $productCount }}</h3>

                            <p>Tổng sản phẩm</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card" style="width: 100%">
        <div class="card-header">
            <h3 class="card-title">Phân bố các hợp tác xã theo khu vực</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Khu vực</th>
                        <th>Số lượng HTX đăng ký</th>
                        <th>Danh sách HTX</th>
                    </tr>
                </thead>
                @foreach ($provinces as $index => $province)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $province->name }}</td>
                        <td>{{ $province->htxs_count }}</td>
                        <td style="width:60%">
                            <div class="d-flex" style="gap: 8px">
                                @foreach ($province->htxs as $htx)
                                    <a href="{{ route('htx', $htx->id) }}" target="_blank" title="{{ $htx->name }}">
                                        <span><img src="{{ asset('storage') . '/' . $htx->logo }}"
                                                style="width: 48px; height: 48px;"></span>
                                        {{-- <span class="ml-2 text-dark" ></span> --}}
                                    </a>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
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
        const table = $('#dataTable').DataTable({
            language: {
                url: '/../common/json/datatable-vi.json',
            },
            lengthMenu: [10, 20, 300, 500, 100],
            searching: true
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
