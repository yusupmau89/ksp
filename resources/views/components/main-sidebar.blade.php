<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
        <img src="{{asset('img/AdminLTELogo.png')}}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{config('app.name', 'KSP')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview
                    {{
                    Request()->is('product') || Request()->is('product/*') ||
                    Request()->is('customer') || Request()->is('customer/*')
                    ? 'menu-open'
                    : ''
                    }}
                ">
                    <a href="#" class="nav-link
                        {{
                        Request()->is('product') || Request()->is('product/*') ||
                        Request()->is('customer') || Request()->is('customer/*')
                        ? 'active'
                        : ''
                        }}
                    ">
                        <i class="nav-icon fa fa-server"></i>
                        <p>
                        Master Data
                        <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                        <a href="{{route('product.index')}}" class="nav-link {{Request()->is('product') || Request()->is('product/*') ? 'active' : ''}}">
                            <i class="fas fa-pallet nav-icon"></i>
                            <p>Product</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="{{route('customer.index')}}" class="nav-link {{Request()->is('customer') || Request()->is('customer/*') ? 'active' : ''}}">
                            <i class="fas fa-id-card nav-icon"></i>
                            <p>Customer</p>
                        </a>
                        </li>
                        <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-id-card nav-icon"></i>
                            <p>Supplier</p>
                        </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Purchase Order
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                    Layout Options
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">6</span>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Top Navigation</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Top Navigation + Sidebar</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Boxed</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Sidebar</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Navbar</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Fixed Footer</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Collapsed Sidebar</p>
                    </a>
                    </li>
                </ul>
                </li>
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-calendar-alt"></i>
                    <p>
                    Calendar
                    <span class="badge badge-info right">2</span>
                    </p>
                </a>
                </li>
                <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <p>
                    Gallery
                    </p>
                </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="$('form#logout').submit();return false;">
                        <i class="nav-icon fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <form action="{{route('logout')}}" method="post" id="logout">
            @csrf
        </form>
        <!-- /.sidebar-menu -->
    </div>
<!-- /.sidebar -->
</aside>
