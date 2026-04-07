<nav class="layout-navbar  navbar navbar-expand-xl  align-items-center bg-navbar-theme px-4" id="layout-navbar ">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>
    <div class="navbar-nav-right  d-flex gap-4 align-items-center justify-content-end" id="navbar-collapse">
        <ul class="navbar-nav flex-row gap-3 align-items-center  ">
            <!--<li>-->
            <!--    <div class="flex-grow-1 input-group input-group-merge  custom-search">-->
            <!--        <span class="input-group-text custom-search" id="basic-addon-search31"><i-->
            <!--                class="ti ti-search"></i></span>-->
            <!--        <input type="text" class="form-control chat-search-input custom-search" placeholder="Search here..."-->
            <!--            aria-label="Search..." aria-describedby="basic-addon-search31" />-->
            <!--    </div>-->
            <!--</li>-->
            
            <!-- Bell icon and notifications completely removed -->
            
            <li>
                <div>
                    <a class="menu-header-text email-text" href="#">
                        <div class="d-flex">
                            <!--<div class="flex-shrink-0 me-3">-->
                            <!--    <div class="avatar avatar-online">-->
                                    <!--<img src="<//?= (!empty(Auth::user()->image)) ? url('storage/app/'. Auth::user()->image) : asset_url('img/avatars/1.png'); ?>" alt class="h-auto rounded-circle" />-->
                            <!--    </div>-->
                            <!--</div>-->
                            @if(Auth::check())
                            <div class="flex-grow-1">
                                <span class="fw-medium d-block">{{ Auth::user()->name }}</span>
                            </div>
                            @endif
                        </div>
                    </a>
                    <!--<span class="menu-header-text email-text" data-i18n="admin.jspinfotech@gmail.com">-->
                    <!--    admin.jspinfotech@gmail.com-->
                    <!--</span>-->
                </div>
                <a class="btn bs-danger btn-logout mt-1" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <!--<i class="ti ti-logout me-2 ti-sm"></i>-->
                    <span class="align-middle">{{ __('Log Out') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

            </li>
        </ul>
    </div>
    <!-- Search Small Screens -->
    <div class=" search-input-wrapper d-none d-flex justify-content-end">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..."
            aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>
<script>
$(document).ready(function() {
    let timerInterval;
    let startTime;
    let isPunchIn = false;

    function updateTimerDisplay(currentTime) {
        let hours = currentTime.getHours();
        const minutes = currentTime.getMinutes();
        const seconds = currentTime.getSeconds();

        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        $('#timer').text(padZero(hours) + ':' + padZero(minutes) + ':' + padZero(seconds) +
            ' ' + ampm);
    }

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    $('#punch-in').click(function() {
        if (!isPunchIn) {
            isPunchIn = true;

            startTime = new Date();
            let currentTime = new Date(startTime);

            timerInterval = setInterval(function() {
                currentTime.setSeconds(currentTime.getSeconds() +
                    1);
                updateTimerDisplay(currentTime);
            }, 1000);

            $('#punch-in').hide();
            $('#punch-out').show();
        }
    });

    $('#punch-out').click(function() {
        if (isPunchIn) {
            clearInterval(timerInterval);
            isPunchIn = false;

            $('#punch-out').hide();
            $('#punch-in').show();
        }
    });
});
</script>