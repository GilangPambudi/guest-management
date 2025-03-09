<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link">
        <img src="logoQR.jpeg" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text">MANAGEMENT</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="info"><a href="{{ url('home') }}" class="d-block text-primary">DANIEL FOSTER</a></div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/couple') }}" class="nav-link {{ $activeMenu == 'couple' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>
                            Couple
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/guests') }}" class="nav-link {{ $activeMenu == 'guests' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Guests
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
