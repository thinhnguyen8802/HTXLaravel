<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="/../dist/img/icon-logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">HTX VNUA</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @if (Auth::check())
                <div class="image">
                    <img src="{{ asset('storage') . '/' . Auth::user()->image }}" class="img-circle elevation-2"
                        alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ Auth::user()->name ?? '' }}</a>
                </div>
                <form method="post" action="{{route('logout')}}" class="ml-4">
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" data-menu="dashboard">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <span class="right badge badge-danger">New</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link" data-menu="users">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Tài khoản
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="{{ route('stores.index') }}" class="nav-link" data-menu="stores">
                        <i class="fas fa-store"></i>
                        <p>
                            Quản lý HTX
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('products.index') }}" class="nav-link" data-menu="products">
                        <i class="fab fa-product-hunt"></i>
                        <p>
                            Sản phẩm
                        </p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('banners.index') }}" class="nav-link" data-menu="banners">
                        <i class="fas fa-images"></i>
                        <p>
                            Quản lý banner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link" data-menu="categories">
                        <i class="fas fa-list"></i>
                        <p>
                            Quản lý danh mục
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('questions.index') }}" class="nav-link" data-menu="questions">
                        <i class="fas fa-list"></i>
                        <p>
                            Quản lý bài đăng
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
