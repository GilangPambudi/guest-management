<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link text-warp">
        <img src="{{ asset('logoQR.jpeg') }}" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text">QREW</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="info"><a href="{{ url('home') }}" class="d-block text-primary">{{ config('app.name') }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/invitation') }}"
                        class="nav-link {{ $activeMenu == 'invitation' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            Invitation
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/scanner') }}" class="nav-link {{ $activeMenu == 'scanner' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>
                            QR Scanner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->is('kanban') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Link
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
