<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">UT MAINTENANCE</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">UT</a>
        </div>
        <ul class="sidebar-menu">
            <!-- Dashboard Menu -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-home"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ url('home') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>

            <!-- Users Menu -->
            @role(['admin', 'supervisor'])
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-user"></i><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('user.index') }}">User List</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('unit.index') }}">Unit List</a>
                    </li>
                </ul>
            </li>
            @endrole

            <li class="nav-item dropdown ">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-tools"></i><span>Item-list</span></a>
                <ul class="dropdown-menu">
                @role(['admin', 'supervisor'])
                    <li>
                        <a class="nav-link" href="{{ route('vhms.index') }}">VHMS</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('analisa_pap.index') }}">Analisa PAP</a>
                    </li>
                @endrole
                    <li>
                        <a class="nav-link" href="{{ route('magnetic_plucks.index') }}">Magnetic Plug</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('cutting_filters.index') }}">Cutting Filter</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('strainer.index') }}">Strainer</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('swing_circles.index') }}">Swing Circle</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('wheel-brakes.index') }}">Wheel Brakes</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
