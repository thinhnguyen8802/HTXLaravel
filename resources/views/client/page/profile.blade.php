@extends('client.layouts.master')
@section('content')
    <div class="sidebar">
        <div class="block categories">
            @if ($user->store)
                @if ($user->store->status == 1)
                    <p class="title">
                        <a href="{{ route('manager.index') }}" class="text-primary">
                            <i class="fa-solid fa-store mr-2"></i>
                            {{ $user->store->name ?? '' }}

                            @if ($user->store->is_banned == 1)
                                <span class="badge badge-success">Hoạt động</span>
                            @else
                                <span class="badge badge-danger">Bị khóa</span>
                            @endif
                        </a>
                    </p>
                @else
                    <p class="title text-danger" style="font-size: 12px">Đang đợi duyệt yêu cầu</p>
                @endif
            @endif
            <ul>
                <li><i class="fa-solid fa-eye"></i><a class="smooth-scroll" href="#list-order">Theo dõi đơn hàng</a></li>
                <li><i class="fa-solid fa-user"></i> <a class="smooth-scroll" href="#form-info-user">Thông tin cá nhân</a>
                </li>
                <li><i class="fas fa-home"></i><a class="smooth-scroll" href="#shippings">Địa chỉ nhận hàng</a></li>
                <li><i class="fa-solid fa-key"></i><a class="smooth-scroll" href="#change-password">Thay đổi mật khẩu</a>
                </li>
                @if (!$user->store)
                    <li class="text-danger show-modal" data-id-modal="modal-store"><i class="fa-solid fa-store"></i>
                        <span class="text-danger">Bạn muốn giới thiệu sản phẩm của htx</span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <div class="content">
        <input type="text" value="{{ $user->id }}" id="user_id" hidden>

        <section class="block" id="list-order">
            <div class="card">
                <div class="card-header text-primary"><span class="title"><i class="fas fa-shipping-fast"></i> Theo dõi
                        đơn
                        hàng</span></div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ nhận hàng</th>
                                <th>Thời gian đặt hàng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer"></div>
            </div>
        </section>
        <section class="block" id="form-info-user">
            <div class="card">
                <div class="card-header">
                    <span class="title text-primary"><i class="far fa-user"></i> Thông tin cá nhân</span>
                    <button class="btn btn-sm btn-outline-danger float-right" id="edit-info-user"><i
                            class="fas fa-user-edit"></i> Sửa</button>
                    <button class="btn btn-sm btn-outline-secondary float-right cancel" style="display:none">Hủy bỏ</button>
                </div>
                <div class="card-body row" id="info-user">
                    <div class="col col-md-9">
                        <div class="from-group in-row">
                            <label for="u_name" class="">Họ tên</label>
                            <input type="text" id="u_name" class="form-control " value="{{ $user->name ?? '' }}">
                        </div>
                        <div class="from-group in-row mt-3">
                            <label for="u_email" class="">Địa chỉ email</label>
                            <input type="text" id="u_email" class="form-control notEdit" disabled
                                value="{{ $user->email ?? '' }}">
                        </div>
                        <div class="from-group in-row mt-3">
                            <label for="u_phone" class="">Số điện thoại</label>
                            <input type="text" id="u_phone" class="form-control " value="{{ $user->phone ?? '' }}">
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="avatar">
                            <img src="{{ asset('storage') . '/' . $user->image ?? '' }}" alt="">
                            <input type="file" name="image" id="file_image" class="form-control"
                                style="display: none;">
                            <button type="button" class="btn btn-info btn-sm mt-3" id="edit_image">Chọn
                                ảnh khác</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-submit" style="display:none">Cập
                        nhật</button>
                </div>
            </div>
        </section>

        <section class="block" id="shippings">
            <div class="card">
                <div class="card-header">
                    <div class="title text-primary">
                        <i class="fas fa-home"></i> Địa chỉ nhận hàng
                        <button type="button" class="btn btn-sm btn-primary float-right show-modal"
                            data-id-modal="modal-shippings">Thêm mới</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tableShipping">
                        <thead>
                            <tr>
                                <th>Họ tên</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="block" id="change-password">
            <div class="card">
                <div class="card-header text-primary"><span class="title"><i class="fas fa-key"></i> Thay đổi mật
                        khẩu</span></div>
                <div class="card-body">
                    <div class="form-group position-relative">
                        <label for="">Mật khẩu hiện tại</label>
                        <input type="password" id="current_password" class="form-control">
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                    <div class="form-group position-relative">
                        <label for="">Mật khẩu mới</label>
                        <input type="password" id="new_password" class="form-control"><i
                            class="toggle-password fas fa-eye"></i>
                    </div>
                    <div class="form-group position-relative">
                        <label for="">Nhập lại mật khẩu</label>
                        <input type="password" id="re_password" class="form-control">
                        <i class="toggle-password fas fa-eye"></i>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary btn-submit">Cập nhật</button>
                </div>
            </div>
        </section>
        {{-- Modal đăng ký mở tài khoản hợp tác xã --}}
        <div class="modal " id="modal-store">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 600px">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex justify-content-between align-items-center" style="width: 100%">
                            <span>Đăng ký mở tài khoản hợp tác xã</span>
                            <button type="button" class="btn" data-dismiss="modal"><i
                                    class="fas fa-times"></i></button>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="from-group">
                            <label for="shopName">Tên hợp tác xã</label>
                            <input type="text" id="shopName" class="form-control">
                        </div>
                        <div class="row mt-3">
                            <div class="from-group col col-md-4">
                                <label for="provinceId">Tỉnh thành</label>
                                <select id="provinceId" class="form-select select2"></select>
                            </div>
                            <div class="from-group col col-md-4">
                                <label for="districtId">Quận huyện</label>
                                <select id="districtId" class="form-select select2"></select>
                            </div>
                            <div class="from-group col col-md-4">
                                <label for="wardsId">Xã phường</label>
                                <select id="wardsId" class="form-select select2"></select>
                            </div>
                        </div>
                        <div class="from-group mt-3">
                            <label for="shopAddress">Địa chỉ</label>
                            <input type="text" id="shopAddress" class="form-control">
                        </div>
                        <div class="from-group mt-3">
                            <label for="map">Link google map</label>
                            <input type="link" id="map" class="form-control">
                        </div>
                        <div class="from-group mt-3">
                            <input type="checkbox" class="form-checkbox" id="agree">
                            <label for="agree">Đồng ý với các <a href="#" class="text-primary">điều khoản</a>
                                của
                                website</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary btn-submit">Gửi yêu cầu</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal cập nhật địa chỉ shipping --}}
        <div class="modal" id="modal-shippings">
            <div class="modal-dialog">
                <div class="modal-content" style="width: 600px">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex justify-content-between align-items-center" style="width: 100%">
                            <span>Địa chỉ giao hàng</span>
                            <button type="button" class="btn" data-dismiss="modal"><i
                                    class="fas fa-times"></i></button>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="sp_id" value="0" class="form-control" hidden>
                        <div class="from-group">
                            <label for="sp_name">Tên người nhận</label>
                            <input type="text" id="sp_name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="from-group mt-3">
                            <label for="sp_phone">Số điện thoại</label>
                            <input type="text" id="sp_phone" class="form-control" value="{{ $user->phone }}">
                        </div>
                        <div class="row mt-3">
                            <div class="from-group col col-md-4">
                                <label for="sp_provinceId">Tỉnh thành</label>
                                <select id="sp_provinceId" class="form-select select2"></select>
                            </div>
                            <div class="from-group col col-md-4">
                                <label for="sp_districtId">Quận huyện</label>
                                <select id="sp_districtId" class="form-select select2"></select>
                            </div>
                            <div class="from-group col col-md-4">
                                <label for="sp_wardsId">Xã phường</label>
                                <select id="sp_wardsId" class="form-select select2"></select>
                            </div>
                        </div>
                        <div class="from-group mt-3">
                            <label for="sp_address">Địa chỉ</label>
                            <input type="text" id="sp_address" class="form-control">
                        </div>
                        <div class="from-group mt-3">
                            <input type="checkbox" class="form-checkbox" id="default">
                            <label for="default">Đặt làm địa chỉ mặc định</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary btn-submit" style="width:120px">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" id="modal-order">
            <div class="modal-dialog" style="width: 900px; max-width: 900px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title d-flex justify-content-between align-items-center" style="width: 100%">
                            <span>Chi tiết đơn hàng</span>
                            <button type="button" class="btn" data-dismiss="modal"><i
                                    class="fas fa-times"></i></button>
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="info-order">
                            <p><strong>Trạng thái:</strong> <span class="order-recipient-status"></span></p>
                            <p><strong>Tên người nhận:</strong> <span class="order-recipient-name"></span></p>
                            <p><strong>Số điện thoại:</strong> <span class="order-recipient-phone"></span></p>
                            <p><strong>Địa chỉ nhận hàng:</strong> <span class="order-recipient-address"></span></p>
                        </div>
                        <div class="row">
                            <table class="table table-bodered table-hover" id="table-view-order">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Đơn giá</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('include-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var user_id = $("#user_id").val();
        var countShippings = '{{ count($shippings) }}';
        if (countShippings == 0) {
            $("#modal-shippings").modal("toggle")
        }
        //table địa chỉ giao hàng
        const tableShipping = $('#tableShipping').DataTable({
            ajax: {
                url: '/api/get-shippings?id=' + user_id,
                type: 'GET', // Sử dụng phương thức GET để gọi API
                dataSrc: 'data' // Định rõ trường dữ liệu chứa dữ liệu cần hiển thị trong bảng
            },
            language: {
                url: '/../common/json/datatable-vi.json',
            },
            columns: [{
                    data: 'name',
                    title: 'Họ tên'
                },
                {
                    data: 'phone',
                    title: 'Số điện thoại'
                },
                {
                    data: 'address',
                    title: 'Địa chỉ'
                },
                {
                    title: 'Thao tác',
                    render: function(data, type, row) {
                        // Tạo nút hoặc các thao tác khác ở đây
                        return '<button class="btn btn-sm btn-info" onclick="editShipping(' + row.id +
                            ')">Chỉnh sửa</button>';
                    }
                }
            ],
            lengthMenu: [20, 50, 100, 300, 500],
            searching: true
        });


        // table đơn hàng
        const table = new DataTable('#dataTable', {
            ajax: {
                url: '/api/get-list-order',
                type: 'POST',
                data: function(d) {
                    delete d.columns;
                    d.orderColumn = d.order[0].column; // Lấy chỉ số cột dựa vào yêu cầu của DataTables
                    d.orderDir = d.order[0].dir; // Lấy hướng sắp xếp (asc/desc) dựa vào yêu cầu của DataTables
                },
            },
            language: {
                url: '/../common/json/datatable-vi.json',
            },
            columns: [{
                    data: 'products',
                    name: 'products',
                    orderable: false,
                    render: function(data, type, row) {
                        var html = "<div>";
                        $.each(data, function(index, product) {
                            html += `<div class="mb-1">
                                    <img class="" src = "/storage/${product.thumbnail}" width="42px" height="54px">
                                    <span>${product.name}</span>
                                </div>`;
                        });
                        html += "</div>"
                        return html;
                    }
                },

                {
                    data: 'total',
                    name: 'total',
                    render: function(data, type, row) {
                        // Định dạng ngày tháng
                        return parseInt(data).toLocaleString() + " VNĐ";
                    }
                },
                {
                    data: 'phone',
                    name: 'phone',

                },
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        // Định dạng ngày tháng
                        return moment(data).format('DD/MM/YYYY H:mm');
                    }
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        return '<button class="btn btn-sm btn-info" onclick="viewOrder(' + row.id +
                            ')">Xem</button>';
                    }
                },
            ],
            lengthMenu: [5, 10, 15, 20, 30],
            searching: true, // Cho phép tìm kiếm
            processing: true, // Hiển thị thông báo "processing" khi đang tải dữ liệu
            serverSide: true, // Bật chế độ server-side processing
            responsive: true, // Cho phép responsive design cho bảng
            scrollX: true, // Cho phép cuộn ngang khi bảng quá rộng
            order: [
                [0, 'asc']
            ] // Sắp xếp mặc định theo cột thứ nhất (index 0) và chiều tăng dần
        });

        toggleDisabledForm("#info-user", true);
        $("#edit-info-user").on("click", function() {
            toggleDisabledForm("#info-user", false);
            $(this).hide();
            $("#form-info-user .btn-submit").show()
            $(this).siblings(".cancel").show();
        })
        $(".cancel").on("click", function() {
            toggleDisabledForm("#info-user", true);
            $(this).hide();
            $("#form-info-user .btn-submit").hide()
            $("#edit-info-user").show();
        })
        $("#form-info-user .btn-submit").on("click", function() {
            var name = $("#form-info-user #u_name").val();
            var phone = $("#form-info-user #u_phone").val();
            var provinceId = $("#form-info-user #u_provinceId").val();
            var districtId = $("#form-info-user #u_districtId").val();
            var wardsId = $("#form-info-user #u_wardsId").val();
            var address = $("#form-info-user #u_address").val();
            var formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('image', $('#file_image')[0].files[0]); // Thêm hình ảnh vào FormData
            if (!name || !phone) {
                toastError("Vui lòng điền đủ thông tin cá nhân!");
                return;
            }
            $.ajax({
                url: "/api/update-user",
                type: "POST",
                data: formData,
                processData: false, // Không xử lý dữ liệu
                contentType: false, // Không thiết lập kiểu nội dung
                success: function(res) {
                    if (res.error == 0) {
                        $("header .avatar-user img").attr("src", "/storage/" + res.url)
                        $("#form-info-user .btn-submit").hide()
                        $("#form-info-user .cancel").hide();
                        $("#form-info-user #edit-info-user").show();
                        toggleDisabledForm("#info-user", true);
                        toastSuccess(res.msg);

                    } else {
                        toastError(res.msg);
                    }
                },
                error: function(err) {
                    toastError("Đã xảy ra lỗi!");
                }
            });
        });

        function toggleDisabledForm(el, status) {
            $(el).find('input:not(.notEdit)').prop("disabled", status);
            $(el).find('select').prop("disabled", status);
            $(el).find('button').prop("disabled", status);
        }

        function viewOrder(id) {
            $.ajax({
                url: "/api/view-order",
                type: "GET",
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.error == 0) {
                        var data = res.data;
                        var table = $("#table-view-order")
                        // Điền thông tin người nhận vào các phần tử HTML trong modal
                        $("#modal-order .info-order .order-recipient-status").text(data.status_text);
                        $("#modal-order .info-order .order-recipient-name").text(data.name);
                        $("#modal-order .info-order .order-recipient-phone").text(data.phone);
                        $("#modal-order .info-order .order-recipient-address").text(data.address + ", " + data
                            .wards.name + ", " + data.district.name + ", " + data.province.name);
                        var cancelButton = $("#modal-order .modal-footer .btn-cancel-order");
                        if (cancelButton.length > 0) {
                            cancelButton.remove(); // Xóa nút cũ nếu có
                        }
                        // Hiển thị nút hủy đơn hàng chỉ khi trạng thái là 0
                        if (data.status === 0) {
                            var cancelButton = $("<button>")
                                .addClass("btn btn-danger btn-cancel-order")
                                .text("Hủy đơn hàng")
                                .click(function() {
                                    cancelOrder(id);
                                });
                            $("#modal-order .modal-footer").append(cancelButton);
                        }
                        // điền thông tin người nhận
                        table.find('tbody').empty();
                        // Duyệt qua mảng sản phẩm trong đơn hàng và thêm vào bảng
                        $.each(data.order_details, function(index, item) {
                            var row = "<tr>" +
                                "<td>" +
                                "<img width='48px' height='60px' src='/storage/" + item.product
                                .thumbnail +
                                "' alt='Product Image' class='img-thumbnail' style='max-width: 48px;'>" +
                                "<span class='ml-2'>" + item.product.name + "</span>" +
                                "</td>" +
                                "<td>" + item.quantity + "</td>" +
                                "<td>" + parseInt(item.price).toLocaleString() + " VNĐ" + "</td>" +
                                "<td>" + parseInt(item.quantity * item.price).toLocaleString() +
                                " VNĐ" + "</td>" +
                                "</tr>";
                            table.find('tbody').append(row);
                        });
                        $("#modal-order").modal("toggle")
                    } else {
                        toastError(res.msg);
                    }
                },
                error: function(d) {
                    toastError("Đã xảy ra lỗi!");
                }
            })
        }

        function cancelOrder(id) {
            $.ajax({
                url: "/api/cancel-order",
                type: "GET",
                data: {
                    id: id
                },
                success: function(res) {
                    if (res.error == 0) {
                        table.ajax.reload();
                        toastSuccess(res.msg);
                    } else {
                        toastError(res.msg);
                    }
                },
                error: function(d) {

                }
            })
        }
        //Thay đổi mật khẩu
        $("#change-password .btn-submit").on("click", function() {
            var current_password = $("#change-password #current_password").val();
            var new_password = $("#change-password #new_password").val();
            var re_password = $("#change-password #re_password").val();
            var formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('current_password', current_password);
            formData.append('new_password', new_password);
            formData.append('re_password', re_password);
            if (!current_password || !new_password || !re_password) {
                if (!current_password) {
                    $("#change-password #current_password").focus();
                    toastError("Vui lòng nhập mật hiện tại!");
                } else if (!new_password) {
                    $("#change-password #new_password").focus();
                    toastError("Vui lòng nhập mật khẩu mới!");
                } else if (!re_password) {
                    $("#change-password #re_password").focus();
                    toastError("Vui lòng nhập lại mật khẩu!");
                }
                return;
            }
            if (new_password != re_password) {
                toastError("Mật khẩu không trùng khớp!");
                return;
            }
            $.ajax({
                url: "/api/change-password",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.error == 0) {
                        toastSuccess(res.msg);
                        resetForm("#change-password")
                    } else {
                        toastError(res.msg);
                    }
                },
            })
        })

        $(".select2").select2();
        initSelect2("sp_")
        initSelect2("u_")
        initSelect2("")

        //Form cập nhật địa chỉ nhận hàng
        $("#modal-shippings .btn-submit").on("click", function() {
            updateShipping();
        })

        function editShipping(id) {
            $.ajax({
                url: "/api/get-data-shipping/" + id,
                type: "GET",
                success: function(res) {
                    $("#modal-shippings #sp_id").val(res.data.id);
                    $("#modal-shippings #sp_name").val(res.data.name);
                    $("#modal-shippings #sp_phone").val(res.data.phone);
                    $("#modal-shippings #sp_address").val(res.data.address);
                    $("#modal-shippings #default").prop('checked', res.data.default == 1 ? true :
                        false);
                    $("#sp_provinceId").val(res.data.provinceId).trigger("change")
                    $("#modal-shippings").modal('show');
                }
            })
            //    tableShipping.ajax.reload();
        }
        $(".edit-shipping").on("click", function() {
            var id = $(this).closest("li").attr('data-sp-id');
            var nameProvince = $(this).closest("li").attr('data-province-name');
            var nameDistrict = $(this).closest("li").attr('data-district-name');
            var nameWards = $(this).closest("li").attr('data-wards-name');
            $.ajax({
                url: "/api/get-data-shipping/" + id,
                type: "GET",
                success: function(res) {
                    if (res.error == 0) {
                        $("#modal-shippings #sp_id").val(res.data.id);
                        $("#modal-shippings #sp_name").val(res.data.name);
                        $("#modal-shippings #sp_phone").val(res.data.phone);
                        $("#modal-shippings #sp_address").val(res.data.address);
                        $("#modal-shippings #default").prop('checked', res.data.default == 1 ? true :
                            false);
                        renderSelect2("#sp_provinceId", "/api/provinces", res.data.provinceId,
                            nameProvince);
                        renderSelect2("#sp_districtId", "/api/districts/" + res.data.provinceId, res
                            .data.districtId, nameDistrict);
                        renderSelect2("#sp_wardsId", "/api/wards/" + res.data.districtId, res.data
                            .wardsId, nameWards);
                        $("#modal-shippings").modal('show');
                    }
                },
                error: function(e) {

                }
            })
        })

        function renderSelect2(el, url, id, name) {
            $(el).select2({
                ajax: {
                    url: url,
                    dataType: 'json'
                },
            });
            if (provinceId) {
                var option = new Option(name, id, true, true);
                $(el).append(option).trigger('change');
            }
        }

        function updateShipping() {
            var id = $("#modal-shippings #sp_id").val();
            var name = $("#modal-shippings #sp_name").val();
            var phone = $("#modal-shippings #sp_phone").val();
            var province_id = $("#modal-shippings #sp_provinceId").val();
            var district_id = $("#modal-shippings #sp_districtId").val();
            var ward_id = $("#modal-shippings #sp_wardsId").val();
            var address = $("#modal-shippings #sp_address").val();
            var defaultValue = $('#modal-shippings #default').prop('checked') ? 1 : 0;
            if (name && phone && province_id && district_id && ward_id && address) {
                $.ajax({
                    url: "/api/update-shipping",
                    type: "POST",
                    data: {
                        user_id: user_id,
                        default: defaultValue,
                        id: id,
                        name: name,
                        phone: phone,
                        provinceId: province_id,
                        districtId: district_id,
                        wardsId: ward_id,
                        address: address,
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            $("#modal-shippings").modal("toggle")
                            resetForm("#modal-shippings");
                            tableShipping.ajax.reload();
                            toastSuccess(res.msg);
                        } else {
                            toastError(res.msg);
                        }
                    },
                    error: function(e) {
                        toastError("Có lỗi xảy ra");
                    }

                })
            } else {
                toastError("Vui lòng nhập đầy đủ thông tin!");
            }
        }



        //Form đăng ký cửa hàng
        $(".show-modal").on("click", function() {
            var idModal = $(this).attr("data-id-modal");
            console.log(idModal)
            $(`#${idModal}`).modal("toggle");
        })
        $("#modal-store .btn-submit").on("click", function() {
            var shopName = $("#shopName").val();
            var provinceId = $("#provinceId").val();
            var districtId = $("#districtId").val();
            var wardsId = $("#wardsId").val();
            var shopAddress = $("#shopAddress").val();
            var map = $("#map").val();
            var agree = $('#agree').prop('checked')
            if (!agree) {
                toastError("Vui lòng đồng ý với điều khoản trước khi đăng ký!");
                return;
            }
            if (shopName  && shopAddress && map && provinceId && districtId && wardsId) {
                $.ajax({
                    url: "/api/registerStore",
                    type: "POST",
                    data: {
                        user_id: user_id,
                        shopName: shopName,
                        provinceId: provinceId,
                        districtId: districtId,
                        wardsId: wardsId,
                        shopAddress: shopAddress,
                        map: map,
                    },
                    success: function(res) {
                        if (res.error == 0) {
                            $("#modal-store").modal("toggle")
                            resetForm("#modal-store");
                            toastSuccess(res.msg);
                        } else {
                            toastError(res.msg);
                        }
                    },
                    error: function(e) {
                        toastError("Có lỗi xảy ra, vui lòng thử lại sau!");
                    }
                })
            } else {
                toastError("Vui lòng nhập đầy đủ thông tin!");
                return;
            }
        })
        //End đăng ký cửa hàng
        function resetForm(el) {
            $(el).find('input').val('');
            $(el).find('.select2').val(null).trigger('change');
        }
    </script>

    <script>
        function validatePassword(password) {
            var minLength = /.{8,}/;
            var upperCase = /[A-Z]/;
            var lowerCase = /[a-z]/;
            var specialChar = /[!@#$%^&*(),.?":{}|<>]/;
            var digit = /[0-9]/;

            return minLength.test(password) &&
                upperCase.test(password) &&
                lowerCase.test(password) &&
                specialChar.test(password) &&
                digit.test(password);
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(".avatar img").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('[name="image"]').change(function() {
            readURL(this);
        });

        $("#add_image,#edit_image").click(function(event) {
            $('[name="image"]').trigger("click");
        });

        $("#delete_image").click(function(event) {
            $('[name="image"]').val("");
            $("#preview_image").attr("src", "");
            $("#preview_image").hide();
            $("#delete_image").hide();
            $("#edit_image").hide();
            $("#add_image").show();
        });
    </script>
@endsection
