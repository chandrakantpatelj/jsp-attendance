<nav class="layout-navbar  navbar navbar-expand-xl  align-items-center bg-navbar-theme px-4" id="layout-navbar ">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>
    <div class="navbar-nav-right  d-flex gap-4 align-items-center justify-content-end" id="navbar-collapse">
        <ul class="navbar-nav flex-row gap-3 align-items-center  ">
            <li>
                <div>
                    <span class="menu-header-text punchin-time" id="timer">00:00</span>
                </div>
            </li>
            <li>
                <button class="btn btn-danger punch_button" id="punch-in" type="button">
                    Punch In
                </button>
                <button class="btn btn-success punch_button" id="punch-out" type="button" style="display: none;">
                    Punch Out
                </button>
            </li>
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1 ">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                    <div class="icon-box">
                        <i class="ti ti-bell"></i>
                    </div>
                    <span class="badge bg-danger rounded-pill badge-notifications" style="margin-top: 6px;">5</span>

                </a>
                <ul class="dropdown-menu dropdown-menu-end py-0 notifications-card">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h5 class="text-body mb-0 me-auto">Notification</h5>
                            <a href="javascript:void(0)" class="dropdown-notifications-all text-body"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                    class="ti ti-mail-opened fs-4"></i></a>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container  ">
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-grow-1 ">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy.</h6>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">1h ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy.</h6>
                                        <!-- <p class="mb-0">Accepted your connection</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">12hr ago</small>
                                        </div>

                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">You have new message from Natalie</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">1h ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">ACME Inc. made new order $1,154</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">1h ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">Your ABC project application has been approved.
                                                        </p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">2h ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">July monthly financial report is generated</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">3 day ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">Peter sent you connection request</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">4 days ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">Your have new message from Jane</p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">5 days ago</small>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                            <li
                                class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                                <div class="d-flex">

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">Lorem Ipsum is simply dummy text of the
                                            printing & typesetting industry. Lorem Ipsum has been the
                                            industry's standard dummy .</h6>
                                        <!-- <p class="mb-0">CPU Utilization Percent is currently at 88.63%,
                                                        </p> -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span></span>
                                            <small class="text-muted">1 days ago</small>
                                        </div>

                                    </div>
                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                        <a href="javascript:void(0)" class="dropdown-notifications-read"></a>
                                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span
                                                class="ti ti-x"></span></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown-menu-footer border-top">
                        <a href="javascript:void(0);"
                            class="dropdown-item d-flex justify-content-center text-primary p-2 h-px-40 mb-1 align-items-center">
                            View all notifications
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <div>
                    <span class="menu-header-text email-text" data-i18n="admin.jspinfotech@gmail.com">
                        admin.jspinfotech@gmail.com
                    </span>
                </div>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ti ti-logout me-2 ti-sm"></i>
                    <span class="align-middle">{{ __('Log Out') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>

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

<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
</script>
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
        $('#timer').text(padZero(hours) + ':' + padZero(minutes) + ':' + padZero(seconds) + ' ' + ampm);
    }

    function padZero(num) {
        return num < 10 ? '0' + num : num;
    }

    function sendPunchData(action, timestamp) {

        $.ajax({
            url: '/save-punch-data',
            method: 'POST',
            data: {
                action: action,
                timestamp: timestamp,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    console.log('Success:', response.message);
                }
                if (response.working_hours) {
                    $('#timer').html(response.working_hours);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
            }
        });
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
            sendPunchData('punch_in', startTime);
        }
    });

    $('#punch-out').click(function() {
        if (isPunchIn) {
            clearInterval(timerInterval);
            isPunchIn = false;

            $('#punch-out').hide();
            $('#punch-in').show();
            const punchOutTime = new Date();
            sendPunchData('punch_out', punchOutTime);
        }
    });
});
</script>