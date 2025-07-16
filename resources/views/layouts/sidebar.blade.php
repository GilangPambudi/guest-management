<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link text-warp">
        <img src="{{ asset('logoQR.png') }}" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text">QREW</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="user-panel mt-1 pb-1 mb-1 d-flex">
            <div class="info"><a href="{{ url('/dashboard') }}" class="d-block text-primary">Quick Response Elegant Wedding</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
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
                    <a href="{{ url('/guests') }}" class="nav-link {{ $activeMenu == 'guests' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Guests
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
                    <a href="{{ url('/wishes') }}" class="nav-link {{ request()->is('wishes*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>Wishes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/gifts') }}" class="nav-link {{ $activeMenu == 'gifts' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                            Gifts
                        </p>
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ url('/users') }}" class="nav-link {{ $activeMenu == 'users' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            User Management
                        </p>
                    </a>
                </li>
                @endif
                {{-- <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ $activeMenu == '' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Link
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
