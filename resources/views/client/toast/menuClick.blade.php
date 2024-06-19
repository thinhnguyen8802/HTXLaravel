{{-- <div id="menuClick">
  <ul class="menuClick-list">
    <li class="menuClick-item"><a href="{{route('home')}}"><i class="fas fa-home"></i>Trang chủ</a></li>
    @if (Auth::check())
      <li class="menuClick-item"><a href="{{route('profile.index',Auth::user() ->id)}}"><i class="fas fa-info"></i>Hồ sơ của tôi</a></li>
    @endif
    <li class="menuClick-item"><a href="{{route('cart')}}"><i class="fas fa-cart-plus"></i>Giỏ hàng</a></li>
    <li class="menuClick-item"><a href="{{ url()->previous() }}"><i class="fas fa-backward"></i>Trở lại</a></li>
    <li class="menuClick-item"><a href="{{route('frontend.logout')}}"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a></li>
  </ul>
 </div> --}}
