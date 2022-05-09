@php
    $prefix = \Illuminate\Support\Facades\Request::route()->getPrefix();
    $route = \Illuminate\Support\Facades\Route::current()->getName();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
        <img src="/backend/dist/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">LAPTOP88</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
        <!-- Bug -->
        <div class="os-resize-observer-host observed"><div class="os-resize-observer" style="left: 0px; right: auto;"></div></div>
        <!-- End Bug -->

        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 889px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="/backend/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="{{ route('backend.dashboard') }}" class="nav-link {{ ($route == 'backend.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Tổng quan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ env('URL_FRONTEND') }}" target="_blank" class="nav-link ">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Trang người mua</p>
                                </a>
                            </li>

                            <li class="nav-header">SẢN PHẨM</li>
                            <li class="nav-item {{ ($prefix == 'admin/trademark') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ ($prefix == 'admin/trademark') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cloud"></i>
                                    <p>Quản lý thương hiệu <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backend.trademark.create') }}" class="nav-link {{ ($route == 'backend.trademark.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tạo mới</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.trademark.index') }}" class="nav-link {{ ($route == 'backend.trademark.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item {{ ($prefix == 'admin/category') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ ($prefix == 'admin/category') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tree"></i>
                                    <p>Quản lý danh mục <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backend.category.create') }}" class="nav-link {{ ($route == 'backend.category.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tạo mới</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.category.index') }}" class="nav-link {{ ($route == 'backend.category.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item {{ ($prefix == 'admin/product') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ ($prefix == 'admin/product') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-flag"></i>
                                    <p>Quản lý sản phẩm <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backend.product.create') }}" class="nav-link {{ ($route == 'backend.product.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tạo mới</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.product.index') }}" class="nav-link {{ ($route == 'backend.product.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            {{-- <li class="nav-header">Nguồn hàng & Kho</li>
                            <li class="nav-item {{ ($prefix == 'admin/supplier') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ ($prefix == 'admin/supplier') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-thumbtack"></i>
                                    <p>Quản lý nhà cung cấp <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backend.supplier.create') }}" class="nav-link {{ ($route == 'backend.supplier.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tạo mới</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.supplier.index') }}" class="nav-link {{ ($route == 'backend.supplier.index') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Danh sách</p>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            {{-- <li class="nav-item {{ ($prefix == 'admin/purchase') ? 'menu-open' : '' }}">
                                <a href="#" class="nav-link {{ ($prefix == 'admin/purchase') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>Quản lý nhập hàng <i class="fas fa-angle-left right"></i></p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ route('backend.purchase.create') }}" class="nav-link {{ ($route == 'backend.purchase.create') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nhập hàng</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.purchase.cart') }}" class="nav-link {{ ($route == 'backend.purchase.cart') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Giỏ hàng</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('backend.purchase.order') }}" class="nav-link {{ ($route == 'backend.purchase.order') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Đơn hàng</p>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}

                            <li class="nav-item">
                                <a href="{{ route('backend.warehouse.index') }}" class="nav-link {{ ($prefix == 'admin/warehouse') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>Quản lý kho hàng</p>
                                </a>
                            </li>

                            @can('viewAny', \App\Models\User::class)
                                <li class="nav-header">NGƯỜI DÙNG</li>
                                <li class="nav-item {{ ($prefix == 'admin/user') ? 'menu-open' : '' }}">
                                    <a href="#" class="nav-link  {{ ($prefix == 'admin/user') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-user"></i>
                                        <p>Quản lý người dùng <i class="fas fa-angle-left right"></i></p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('backend.user.create') }}" class="nav-link {{ ($route == 'backend.user.create') ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Tạo mới</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('backend.user.index') }}" class="nav-link {{ ($route == 'backend.user.index') ? 'active' : '' }}">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Danh sách</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endcan

                            <li class="nav-header">ĐƠN HÀNG</li>
                            <li class="nav-item">
                                <a href="{{ route('backend.order.index') }}" class="nav-link {{ ($prefix == 'admin/order') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-drumstick-bite"></i>
                                    <p>Quản lý đơn hàng</p>
                                </a>
                            </li>

                            @can('viewAny', \App\Models\User::class)
                                <li class="nav-header">THỐNG KÊ</li>
                                <li class="nav-item">
                                    <a href="{{ route('backend.statistic.index') }}" class="nav-link {{ ($prefix == 'admin/statistic') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-chart-pie"></i>
                                        <p>Thống kê</p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 65.5859%; transform: translate(0px, 0px);"></div>
            </div>
        </div><div class="os-scrollbar-corner"></div>
    </div>
</aside>
