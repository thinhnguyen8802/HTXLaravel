@extends('manager.layouts.master')
@section('content')
    <div class="row" data-active-menu="statistical" id="menu-active">
        <div class="d-flex mt-3 mb-3 align-items-center">
            <label for="daterange" style=" cursor: pointer; width:200px;">Lọc theo
                ngày:</label>
            <input type="text" name="daterange" class="form-control" id="daterange" value="01/01/2022 - 01/15/2022" />
        </div>
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title title-chart"><span>Biểu đồ doanh thu <span><i
                                    class="fas fa-chart-area"></i></span></span> </h4>
                    <canvas id="areaChart" width="590" height="200" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title title-chart"><span>Số lượng sản phẩm đã bán</span> <span><i
                                class="fas fa-chart-bar"></i></span></h4>
                    <canvas id="barChart" class="height_auto" style="height: 236px; display: block; width: 472px;"
                        width="590" height="200" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
        <div class="col-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <h4 class="card-title">Thống kê đơn hàng</h4>
                    <canvas id="doughnutChart" style="height: 236px; display: block; width: 472px;" width="590"
                        height="295" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('include-js')
    <script src="/../common/js/Chart.min.js"></script>
    <script>
        //date range picker
        var startDate;
        var endDate;
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var start = moment().startOf('month');
            var end = moment().endOf('month');

            function cb(start, end) {
                $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#daterange').daterangepicker({
                startDate: start,
                endDate: end,
                minDate: '01/01/2022',
                maxDate: '12/31/2030',
                showDropdowns: true,
                // showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                autoApply: true,
                ranges: {
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    'Tuần này': [moment().startOf('week').add(1, 'day'), moment().endOf('week').add(1,
                        'day')],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                locale: {
                    applyLabel: 'Submit',
                    fromLabel: 'From',
                    toLabel: 'To',
                    format: 'DD/MM/YYYY ',
                    customRangeLabel: 'Chọn ngày',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                    ],
                    firstDay: 1
                }
            }, cb);
            cb(start, end);
        });

        var x_day = {{ Js::from($listDayIsMonth) }};
        var y_total = {{ Js::from($list_total_order) }};
        var x_name = {{ Js::from($listPName) }};
        var y_count = {{ Js::from($listPCount) }};
        var rate_order = {{ Js::from($rateOrder) }};
        $(function() {
            if ($("#areaChart").length) {
                var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
                var areaChart = new Chart(areaChartCanvas, {
                    type: 'line',
                    data: {
                        labels: x_day,
                        datasets: [{
                            label: 'Doanh thu',
                            data: y_total,
                            backgroundColor: 'rgba(80, 235, 149, 0.4)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1,
                            fill: true, // 3: no fill
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(value, index, values) {
                                        return value.toLocaleString('vi', {
                                            style: 'currency',
                                            currency: 'VND'
                                        });
                                    }
                                }
                            }]
                        }
                    }
                });
            }

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var from_date = (picker.startDate.format('YYYY/MM/DD'));
                var to_date = (picker.endDate.format('YYYY/MM/DD'));
                $.ajax({
                    url: "{{ url('/manager/filter-by-date') }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(res) {
                        var chart_labels = res.listDayIsMonth;
                        var temp_dataset = res.list_total_order;
                        var data = areaChart.config.data;
                        data.datasets[0].data = temp_dataset;
                        data.labels = chart_labels;
                        areaChart.update();
                    }
                });
            });

            var data = {
                labels: x_name,
                datasets: [{
                    label: 'Đã bán',
                    data: y_count,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',

                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    fill: false
                }]
            };
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            };
            if ($("#barChart").length) {
                var barChartCanvas = $("#barChart").get(0).getContext("2d");
                var barChart = new Chart(barChartCanvas, {
                    type: 'bar',
                    data: data,
                    options: options
                });
            }
            var doughnutPieData = {
                datasets: [{
                    data: rate_order,
                    backgroundColor: [
                        'rgba(35, 251, 02, 0.5)',
                        'RGBA( 231, 135, 34, 0.5 )',
                        'RGBA(255, 228, 34, 0.5 )',
                        'rgba(255, 80, 25, 0.5)',
                        'rgba(230, 25, 25, 0.5)',

                    ],
                    borderColor: [
                        'rgba(35, 231, 132, 0.5)',
                        'RGBA( 231, 135, 34, 0.5 )',
                        'RGBA(255, 228, 34, 0.5 )',
                        'rgba(255, 80, 25, 0.5)',
                        'rgba(230, 25, 25, 0.5)',
                    ],
                }],
                labels: [
                    'Thành công',
                    'Đang xử lý',
                    'Mới',
                    'Hủy',
                    'Thất bại',
                ]
            };
            var doughnutPieOptions = {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            };
            if ($("#doughnutChart").length) {
                var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
                var doughnutChart = new Chart(doughnutChartCanvas, {
                    type: 'doughnut',
                    data: doughnutPieData,
                    options: doughnutPieOptions
                });
            }
        });
    </script>
@endsection
