<header class="main_menu home_menu">
    {{-- <div class="banner_header">
        <img src="/../frontend/img/banner_header.jpg" alt="">
    </div> --}}
    <div class="box_menu">
        <div class="container-ct">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="/"> <img src="/../common/image/logo.png" alt="logo"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>
                        <form action="{{ route('search.result') }}" method="GET" id="seach-form" style="width:100%">
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <div class=" d-flex justify-content-center" style="width:100%;">
                                    <div class="position-relative" style="width: calc(100% - 100px)">
                                        <i class="fas fa-search icon-search"></i>
                                        <input type="number" name="cate_id" id="cate_id" hidden
                                            value="{{ request('cate_id') }}">
                                        <input type="number" name="store_id" id="store_id" hidden
                                            value="{{ request('store_id') }}">
                                        <input type="search" name="search" id="input-search" class="form-control"
                                            placeholder="Bạn tìm gì hôm nay" value="{{ request('search') }}">
                                        <button class="btn btn-filter">Tìm kiếm</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        {{-- //Giỏ hàng --}}
                        <div class="hearer_icon d-flex" style="width: 120px">
                            <div class="dropdown cart ">
                                <a class="quantity-cart d-flex" href="{{ route('home.cart') }}" id="navbarDropdown3"
                                    role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cart-plus" style="font-size: 24px"></i>
                                    <span class="quantity-cart-psa">{{ $cartNumber }}</span>
                                </a>
                            </div>
                            <div class="dropdown cart user user-pc positon-relative">
                                <div class="dropdown-toggle d-flex" id="navbarDropdown3" role="button"
                                    aria-haspopup="true" aria-expanded="false">
                                    @if (Auth::check())
                                        <div class="avatar-user">
                                            <img src="{{ asset('/storage') . '/' . Auth::user()->image }}"
                                                alt="profile">
                                        </div>
                                        <!-- data-toggle="dropdown" delete art -->
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown"
                                            style="left:-150px;">
                                            <div class="select-option">
                                                @if (Auth::user()->role_id == -1)
                                                    <div><a href="{{ route('admin.dashboard') }}">Đến trang Admin <i
                                                                class="ti-drupal"></i></a>
                                                    </div>
                                                @elseif(Auth::user()->role_id == 0)
                                                    <div><a href="{{ route('manager.index') }}">Đến trang Qlý HTX <i
                                                                class="ti-drupal"></i></a>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('profile') }}">
                                                        Tài khoản của tôi
                                                        <i class="ti-user"></i>
                                                    </a>
                                                </div>
                                                <div>
                                                    <form method="post" action="{{ route('logout') }}" class="ml-4">
                                                        @csrf
                                                        <button title="đăng xuất"
                                                            style="background: transparent; border: 0px;"> Đăng xuất
                                                            <i class="fas fa-sign-out-alt me-sm-1"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}" id="navbarDropdown3" class="text-login">
                                            Đăng nhập
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
