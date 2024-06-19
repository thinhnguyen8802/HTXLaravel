<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Hợp tác xã Vnua</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon" href="/../frontend/img/favicon.png"> -->
    <link rel="shortcut icon" href="/../frontend/img/favicon.png" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/../frontend/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="/../frontend/css/animate.css">
    <!-- owl carousel CSS -->
    {{-- <link rel="stylesheet" href="/../frontend/css/owl.carousel.min.css"> --}}
    <link rel="stylesheet" href="/../frontend/css/lightslider.min.css">
    <!-- nice select CSS -->
    <link rel="stylesheet" href="/../frontend/css/nice-select.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="/../frontend/css/all.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="/../frontend/css/flaticon.css">
    <link rel="stylesheet" href="/../frontend/css/themify-icons.css">
    <link rel="stylesheet" href="/../frontend/css/fontawesome-6_2_1.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="/../frontend/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="/../frontend/css/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Datatable -->
    <link rel="stylesheet" href="/../backend/assets/datatable/datatable.css">
    <link rel="stylesheet" href="/../frontend/css/price_rangs.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="/../frontend/css/style.css">
    <link rel="stylesheet" href="/../frontend/css/mytoast.css">
    <link rel="stylesheet" href="/../frontend/css/sweetalert.css">
    <link rel="stylesheet" href="/../frontend/css/style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <!-- jquery plugins here-->
    <script src="/../frontend/js/jquery-1.12.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>

<body>
    @include('common.toast')
    {{-- @include('client.includes.efffect') --}}
    @include('client.includes.header')
    @include('client.toast.menuClick')
    <div id="root">
        {{-- @include('client.toast.menuClick') --}}
        @yield('content')

    </div>

    {{-- @include('client.includes.footer') --}}


    <!-- popper js -->
    <script src="/../frontend/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="/../frontend/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="/../frontend/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="/../frontend/js/lightslider.min.js"></script>
    <script src="/../frontend/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="/../frontend/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    {{-- <script src="/../frontend/js/owl.carousel.min.js"></script> --}}
    <script src="/../frontend/js/jquery.nice-select.min.js"></script>
    <!-- slick js -->
    <script src="/../frontend/js/slick.min.js"></script>
    <script src="/../frontend/js/jquery.counterup.min.js"></script>
    <script src="/../frontend/js/waypoints.min.js"></script>
    <script src="/../frontend/js/contact.js"></script>
    <script src="/../frontend/js/jquery.ajaxchimp.min.js"></script>
    <script src="/../frontend/js/jquery.form.js"></script>
    <script src="/../frontend/js/jquery.validate.min.js"></script>
    <script src="/../frontend/js/mail-script.js"></script>
    <script src="/../frontend/js/stellar.js"></script>
    <script src="/../frontend/js/price_rangs.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Datatable -->
    <script src="/../backend/assets/datatable/datatable.js"></script>
    <!-- custom js -->
    <script src="/../frontend/js/theme.js"></script>
    <script src="/../frontend/js/sweetalert.js"></script>
    <script src="/../frontend/js/mytoast.js"></script>
    {{-- <script src="/../frontend/js/custom.js"></script> --}}
    {{-- <script src="/../frontend/js/add-cart.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        });
        // $(window).load(function() {
        //     $('#preloading').hide();
        // });
        $(".select-cate-id").on("click",function(){
            var cateId = $(this).attr('data-cate-id');
            $("#cate_id").val(cateId);
            $("#seach-form").submit();
        })
        $(".select-store-id").on("click",function(){
            var storeId = $(this).attr('data-store-id');
            $("#store_id").val(storeId);
            $("#seach-form").submit();
        })
        function initSelect2(prefix) {
            $(`#${prefix}provinceId`).select2({
                ajax: {
                    url: '/api/provinces',
                    dataType: 'json'
                },
                placeholder: "Tỉnh thành",
            }).on("change", function() {
                $(`#${prefix}districtId`).val(null).trigger('change');
                $(`#${prefix}districtId`).select2({
                    ajax: {
                        url: '/api/districts/' + $(this).val(), // url
                        dataType: 'json'
                    },
                    placeholder: "Quận huyện",
                }).on("change", function() {
                    $(`#${prefix}wardsId`).val(null).trigger('change');
                    $(`#${prefix}wardsId`).select2({
                        ajax: {
                            url: '/api/wards/' + $(this).val(), // url
                            dataType: 'json'
                        },
                        placeholder: "Phường xã",
                    })
                })
            })
        }

        function toastSuccess(msg) {
            $.toast({
                text: msg,
                showHideTransition: 'slide',
                bgColor: '#33ca32',
                textColor: '#000',
                allowToastClose: true,
                hideAfter: 5000,
                stack: 5,
                textAlign: 'left',
                position: 'top-right'
            })
        }

        function toastError(msg) {
            $.toast({
                text: msg,
                showHideTransition: 'slide',
                bgColor: '#e8423b',
                textColor: '#fff',
                allowToastClose: true,
                hideAfter: 5000,
                stack: 5,
                textAlign: 'left',
                position: 'top-right'
            })
        }
    </script>


    @yield('include-js')
</body>
{{-- <div class="preloading" id="preloading">
    <div class="center111">
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
    </div>
</div> --}}

</html>
