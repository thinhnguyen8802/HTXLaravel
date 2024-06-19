<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang quản trị cửa hàng</title>
    <link rel="icon" type="image/x-icon" href="/../frontend/img/favicon.png">

    <!-- Google Font: Source Sans Pro -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/../backend/assets/fontawesome-free/css/all.min.css">
    <!-- Datatable -->
    <link rel="stylesheet" href="/../backend/assets/datatable/datatable.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/../backend/assets/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/../backend/assets/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/../backend/assets/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/../dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/../backend/assets/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/../backend/assets/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/../backend/assets/summernote/summernote-bs4.min.css">
    <!-- CSS custom -->
    <link rel="stylesheet" href="/../dist/css/style.css">
    <link rel="stylesheet" href="/../common/css/style.css">
    @yield('include-css')
    <!-- jQuery -->
    <script src="/../backend/assets/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Toast -->
        @include('common.toast')

        <!-- Preloader -->
        @include('common.preloader')
        <!-- Preloader -->


        <!-- Navbar -->
        @include('manager.includes.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('manager.includes.sidebar')
        <!-- Main Sidebar Container -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header " hidden>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>


            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('manager.includes.footer')


    </div>
    <!-- ./wrapper -->


    <!-- jQuery UI 1.11.4 -->
    <script src="/../backend/assets/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="/../backend/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="/../backend/assets/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="/../backend/assets/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="/../backend/assets/jqvmap/jquery.vmap.min.js"></script>
    <script src="/../backend/assets/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="/../backend/assets/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="/../backend/assets/moment/moment.min.js"></script>
    <script src="/../backend/assets/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/../backend/assets/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="/../backend/assets/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/../backend/assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/../dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/../dist/js/demo.js"></script>
    <!-- Datatable -->
    <script src="/../backend/assets/datatable/datatable.js"></script>
    <script src="/../common/js/main.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="/../dist/js/pages/dashboard.js"></script> --}}
    <script>
        $(function() {
            // Summernote
            $('.ckeditor-cus').summernote()

            // $(".select2").select2();

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
    @yield('include-js')
</body>

</html>
