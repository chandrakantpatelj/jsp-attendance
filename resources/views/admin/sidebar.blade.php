<aside class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo ">
                <img src="{{ asset('assets/img/Header-logo.png') }}" alt="Header Logo" style="max-width: 188px; width: 100%; height: auto; display: block;">
            </span>
        </a>
    </div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/employee*') ? 'active' : '' }}">
            <a href="{{ url('admin/employee') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                <div data-i18n="Employee">Employee</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/attendance*') ? 'active' : '' }}">
            <a href="{{ url('admin/attendance') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="Attendance management">Attendance management</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/employee-attendance*') ? 'active' : '' }}">
            <a href="{{ url('admin/employee-attendance') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="Employee Attendance">Employee Attendance</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/leave-approvals*') ? 'active' : '' }}">
            <a href="{{ url('admin/leave-approvals') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-checklist"></i>
                <div data-i18n="Leave Approvals">Leave Approvals</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('admin/regularizations*') ? 'active' : '' }}">
            <a href="{{ url('admin/regularizations') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-adjustments-horizontal"></i>
                <div data-i18n="Regularizations">Regularizations</div>
            </a>
        </li>
    </ul>
</aside>