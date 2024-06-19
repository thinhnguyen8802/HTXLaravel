<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route("manager.editShop")}}" class="brand-link">
        <img src="{{ asset('storage') . '/' . Auth::user()->store->logo }}" alt="AdminLTE Logo"
            class="brand-image elevation-3" style="opacity: .8; width: 40px; height: 40px">
        <span class="brand-text font-weight-light">{{ Auth::user()->store->name }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if (Auth::check())
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name ?? '' }}</a>
                </div>
                <form method="post" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button class="btn_logout btn btn-sm btn-outline-light" title="đăng xuất">
                        <i class="fas fa-sign-out-alt me-sm-1" aria-hidden="true"></i>
                    </button>
                </form>
            @endif
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('manager.index') }}" class="nav-link" data-menu="dashboard">
                        <i class="fab fa-dashcube"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link" data-menu="products">
                        <i class="fab fa-product-hunt"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manager.orders') }}" class="nav-link" data-menu="orders">
                        <i class="fab fa-product-hunt"></i>
                        <p>
                            Quản lý đơn hàng
                            <span class="right badge badge-danger">{{ $orderNew }} mới</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('statistical') }}" class="nav-link" data-menu="statistical">
                        <i class="fab fa-product-hunt"></i>
                        <p>
                            Thống kê
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
