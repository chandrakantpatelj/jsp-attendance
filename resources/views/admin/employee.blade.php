@extends('layouts.app')
@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('admin.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            <nav class="layout-navbar  navbar navbar-expand-xl  align-items-center bg-navbar-theme px-4"
                id="layout-navbar ">
                <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                        <i class="ti ti-menu-2 ti-sm"></i>
                    </a>
                </div>
                <div class="navbar-nav-right  d-flex gap-4 align-items-center justify-content-end" id="navbar-collapse">
                    <ul class="navbar-nav flex-row gap-3 align-items-center  ">
                        <li>
                            <div class="flex-grow-1 input-group input-group-merge  custom-search">
                                <span class="input-group-text custom-search" id="basic-addon-search31"><i
                                        class="ti ti-search"></i></span>
                                <input type="text" class="form-control chat-search-input custom-search"
                                    placeholder="Search here..." aria-label="Search..."
                                    aria-describedby="basic-addon-search31" />
                            </div>
                        </li>
                        <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1 ">
                            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <div class="icon-box">
                                    <i class="ti ti-bell"></i>
                                </div>
                                <span class="badge bg-danger rounded-pill badge-notifications"
                                    style="margin-top: 6px;">5</span>

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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-read"></a>
                                                    <a href="javascript:void(0)"
                                                        class="dropdown-notifications-archive"><span
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
                            <a class="btn bs-danger btn-logout mt-1" href="/login">
                                Log Out
                            </a>

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
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="page-header d-flex justify-content-between align-items-center ">
                    <h5 class="mb-0">Employee</h5>
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-primary add-leave-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="ti ti-plus"></i> Add new leave
                        </button>

                        <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <div class="offcanvas-header">
                                <h2 id="offcanvasRightLabel"> Add new employee</h2>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">

                                <div class="mb-4">
                                    <label for="flatpickr-date" class="form-label custom_lable ">Employee
                                        name</label>
                                    <input type="text" class="form-control" placeholder="Enter your employee name"
                                        id="exampleFormControlInput1" />
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1" class="form-label custom_lable">Email</label>
                                    <input type="email" class="form-control" id="exampleFormControlInput1"
                                        placeholder="Enter email">
                                </div>
                                <div class="mb-4">
                                    <label for="exampleFormControlInput1"
                                        class="form-label custom_lable">Password</label>
                                    <input type="password" class="form-control" id="inputPassword"
                                        placeholder="Enter password">
                                </div>
                                <div class="mb-4">
                                    <label class="custom_lable">Department</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select leave type</option>
                                        <option value="1">First half</option>
                                        <option value="2">Second half</option>
                                        <option value="3">Full day</option>
                                    </select>
                                </div>
                                <label class="form-check-label  custom_lable"
                                    for="flexSwitchCheckChecked">Status</label>
                                <div class="form-check form-switch mb-4">

                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked"
                                        checked />

                                </div>

                                <div class="d-flex gap-3 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary from_btn">Cancel</button>
                                    <button type="button" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="calendar-csvfile ms-3">
                            <h5 class="mb-0">CSV files</h5>
                        </div>
                    </div>
                </div>
                <div class="container-xxl flex-grow-1">
                    <div class="card ">
                        <div class="p-0">
                            <!-- <div class="btn-group search_leave">
                                    <button type="button" class="btn btn-label-secondary " data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Search by name
                                    </button>
                                </div>
                                <div class="btn-group search_leave">
                                    <button type="button" class="btn btn-label-secondary " data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Search by department
                                    </button>
                                </div> -->
                            <div class="card-datatable table-responsive">
                                <table class="datatables-products table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th style="text-align: end;">Actions</th>
                                        </tr>
                                    </thead>


                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="d-flex justify-content-between mt-4">
                            <h5> Showing 03 entries</h5>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <button class="page-link bg-transparent" aria-label="Previous">
                                            <span aria-hidden="true"><i class="ti ti-chevron-left"></i></span>
                                        </button>
                                    </li>
                                    <li class="page-item"><a class="page-link bg-transparent" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link  bg-warning text-white" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link bg-transparent" href="#">3</a></li>
                                    <li class="page-item">
                                        <button class="page-link bg-transparent" aria-label="Next">
                                            <span aria-hidden="true"><i class="ti ti-chevron-right"></i></span>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>
</div>
@endsection