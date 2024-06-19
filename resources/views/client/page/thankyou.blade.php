@extends('client.layouts.master')
@section('content')
    <div class="content cart-page" style="width:100%">
        <div class="steps">
            <ul class="list">
                <li class="">
                    <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    <div class="text">Giỏ hàng</div>
                </li>
                <li class="">
                    <div class="icon"><i class="fa-solid fa-money-bill thanhtoan"></i></div>
                    <div class="text">Thanh toán</div>
                </li>
                <li class="active">
                    <div class="icon"><i class="fa-solid fa-check"></i></div>
                    <div class="text">Hoàn tất</div>
                </li>
            </ul>
        </div>
        <div class="text-center">
            <h4>Cảm ơn bạn đã đặt hàng!</h4>
            <p>Để theo dõi tiến trình giao hàng, bạn có thể xem <a class="text-primary" href="{{route('profile')}}">ở đây</a></p>
        </div>
    </div>
@endsection
@section('include-js')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
