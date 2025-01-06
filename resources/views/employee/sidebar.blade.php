<aside class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo ">
                <img src="{{ asset('assets/img/header-logo.png') }}" alt="Header Logo">
            </span>
        </a>

        <!-- <a href=" javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a> -->
    </div>

    <!-- <div class="menu-inner-shadow"></div> -->
    <ul class="menu-inner py-1">
        <li class="menu-item">
            <a href="{{ route('employee.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-home"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('attendance-regularization') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                <div data-i18n="Attendance Regularization">Attendance Regularization</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('my-leave') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-logout"></i>
                <div data-i18n="My leave">My leave</div>
            </a>
        </li>
    </ul>
</aside>