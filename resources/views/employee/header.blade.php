<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme px-4" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>
    <div class="navbar-nav-right d-flex gap-4 align-items-center justify-content-end" id="navbar-collapse">
        <ul class="navbar-nav flex-row gap-3 align-items-center">
            
            <!-- Bell icon and notifications completely removed -->
            
            <li>
                <div>
                    @if(Auth::check())
                    <div class="flex-grow-1">
                        <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                    </div>
                    @endif
                </div>
                <a class="btn bs-danger btn-logout mt-1" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="align-middle">{{ __('Log Out') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>
    <div class="search-input-wrapper d-none d-flex justify-content-end">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>