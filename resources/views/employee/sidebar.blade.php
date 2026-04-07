<aside class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('employee.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo ">
                <img src="{{ asset('assets/img/Header-logo.png') }}" alt="Header Logo" style="max-width: 188px; width: 100%; height: auto; display: block;">
            </span>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('employee.dashboard') ? 'active' : '' }}">
            <a href="{{ route('employee.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboards">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('employee/attendance-regularization*') ? 'active' : '' }}">
            <a href="{{ url('employee/attendance-regularization') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                <div data-i18n="Attendance Regularization">Attendance Regularization</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('employee/my-leave*') ? 'active' : '' }}">
            <a href="{{ url('employee/my-leave') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="My leave">My leave</div>
            </a>
        </li>
    </ul>
</aside>