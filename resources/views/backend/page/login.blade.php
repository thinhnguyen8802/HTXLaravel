<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/../backend/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/../favicon.ico">
    <title>
        Đăng nhập Website HTX
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="/../backend/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/../backend/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="/../backend/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="/../common/css/argon.css" rel="stylesheet" />
</head>

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder text-center">
                                        <img src="/../common/image/logo.png" alt="" height="100px">
                                    </h4>
                                </div>
                                @if ($errors->has('message'))
                                    <div class="alert alert-danger" style="color:#201f1f">
                                        {{ $errors->first('message') }}
                                        @if ($errors->has('countdown'))
                                            <span id="countdown-timer">
                                                Vui lòng thử lại sau: <span id="countdown"
                                                    style="color:#fff; font-weight:bold;">{{ $errors->first('countdown') }}</span>
                                                giây
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="card-body">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <input id="login" type="text"
                                                class="form-control  form-control-lg{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                                placeholder="Username hoặc email" name="login"
                                                value="{{ old('login') }}" required autofocus>


                                        </div>
                                        <div class="mb-3">
                                            <input type="password" name="password" class="form-control form-control-lg"
                                                placeholder="Password" aria-label="Password">
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-center">
                                            <button type="submit"
                                                class="btn btn-lg btn-success btn-lg w-100 mt-4 mb-0">Đăng
                                                nhập</button>
                                                <p class="mt-3">Chưa có tài khoản? Đăng ký ngay <a class="text-info" href="{{ route('register') }}"> tại đây</a></p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('/../backend/assets/img/login.jpg');
          background-size: cover;">
                                <span class="mask bg-gradient-success opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">Hợp tác xã VNUA
                                </h4>
                                <p class="text-white position-relative">Tiếp nối và lan tỏa những điều tốt đẹp</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script src="/../frontend/assets/js/jquery.min.js"></script>
    <script>
        var seconds = parseInt($('#countdown').text());

        function updateCountdown() {
            if (seconds > 0) {
                seconds--;
                $('#countdown').text(seconds);
            } else {
                clearInterval(countdownInterval);
                $('.alert.alert-danger').fadeOut();
            }
        }

        // Gọi hàm updateCountdown mỗi giây
        var countdownInterval = setInterval(updateCountdown, 1000);
    </script>
</body>

</html>
