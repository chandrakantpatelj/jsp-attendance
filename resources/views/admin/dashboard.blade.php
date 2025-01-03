@extends('layouts.app')
@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

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
                    <a href="#" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-home"></i>
                        <div data-i18n="Dashboards">Dashboards</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('employee.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                        <div data-i18n="Employee">Employee</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('attendance.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ti ti-logout"></i>
                        <div data-i18n="Leave management">Leave management</div>
                    </a>
                </li>
            </ul>
        </aside>


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
                            <a class="btn btn-logout  mt-1" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ti ti-logout me-2 ti-sm"></i>
                                <span class="align-middle">{{ __('Log Out') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf
                            </form>

                            <a class="btn btn-logout  mt-1" href="/login">
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

            <!-- / Navbar -->


            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="calendar-header">
                    <h5 class="mb-0">Dashboard</h5>
                </div>

                <div class="container-xxl flex-grow-1 ">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span><i class="ti ti-truck"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">75</h2>
                                        <h5 class="mb-0 ">Total days</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span><i class="ti ti-truck"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">03</h2>
                                        <h5 class="mb-0 ">Total leave request</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span><i class="ti ti-truck"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">09</h2>
                                        <h5 class="mb-0 ">Today present days</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span><i class="ti ti-truck"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">02</h2>
                                        <h5 class="mb-0 ">Today absent days</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-5 mb-4">
                            <div class="card dashbord_card">
                                <div class="card-header d-flex justify-content-between">

                                    <h5 class="mb-0">Leave</h5>

                                    <div class="dropdown">
                                        <button type="button" class="btn btn-label-primary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Monthly
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">January</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">February</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">March</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">April</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">May</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">June</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">July</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">August</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">September</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">October</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">November</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">December</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content p-0 ms-0 ms-sm-2">
                                        <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
                                            <div id="earningReportsTabsOrders"></div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
                                            <div id="earningReportsTabsSales"></div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
                                            <div id="earningReportsTabsProfit"></div>
                                        </div>
                                        <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
                                            <div id="earningReportsTabsIncome"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-4 mb-4">
                            <div class="card dashbord_card">
                                <div class="card-header ">
                                    <h5 class="mb-0">Attendance</h5>
                                </div>
                                <div class="px-3">
                                    <div class="chart-container">
                                        <div class="chartlable">
                                            <h5 class="mb-0">Late</h5>
                                            <h5 class="mb-0">30%</h5>
                                        </div>
                                        <div id="chart"></div>
                                    </div>
                                    <div class="chart-container">
                                        <div class="chartlable">
                                            <h5 class="mb-0">Present</h5>
                                            <h5 class="mb-0">90%</h5>
                                        </div>
                                        <div id="radialchart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-xl-3 mb-4">
                            <div class="card dashbord_card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="mb-0">December 2024</h5>
                                    <div class="col app-calendar-sidebar border-end" id="app-calendar-sidebar">
                                        <div class="border-bottom p-6 my-sm-0 mb-4">

                                        </div>
                                        <div class="px-3 pt-2">
                                            <!-- inline calendar (flatpicker) -->
                                            <div class="inline-calendar"></div>
                                        </div>
                                    </div>
                                    <div class="col app-calendar-sidebar" id="app-calendar-sidebarr">
                                        <div class="border-bottom p-4 my-sm-0 mb-3">
                                            <div class="d-grid">
                                                <!-- <button class="btn btn-primary btn-toggle-sidebar"
                                                        data-bs-toggle="offcanvas" data-bs-target="#addEventSidebar"
                                                        aria-controls="addEventSidebar">
                                                        <i class="ti ti-plus me-1"></i>
                                                        <span class="align-middle">Add Event</span>
                                                    </button> -->
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <!-- inline calendar (flatpicker) -->
                                            <div class="inline-calendar"></div>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <!-- inline calendar (flatpicker) -->
                                        <div class="inline-calendar"></div>

                                        <hr class="container-m-nx mb-4 mt-3" />

                                        <!-- Filter -->
                                        <!-- <div class="mb-3 ms-3">
                                                    <small
                                                        class="text-small text-muted text-uppercase align-middle">Filter</small>
                                                </div>

                                                <div class="form-check mb-2 ms-3">
                                                    <input class="form-check-input select-all" type="checkbox"
                                                        id="selectAll" data-value="all" checked />
                                                    <label class="form-check-label" for="selectAll">View All</label>
                                                </div> -->

                                        <!-- <div class="app-calendar-events-filter ms-3">
                                            <!-- <div class="app-calendar-events-filter ms-3">
                                                    <div class="form-check form-check-danger mb-2">
                                                        <input class="form-check-input input-filter" type="checkbox"
                                                            id="select-personal" data-value="personal" checked />
                                                        <label class="form-check-label"
                                                            for="select-personal">Personal</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input input-filter" type="checkbox"
                                                            id="select-business" data-value="business" checked />
                                                        <label class="form-check-label"
                                                            for="select-business">Business</label>
                                                    </div>
                                                    <div class="form-check form-check-warning mb-2">
                                                        <input class="form-check-input input-filter" type="checkbox"
                                                            id="select-family" data-value="family" checked />
                                                        <label class="form-check-label"
                                                            for="select-family">Family</label>
                                                    </div>
                                                    <div class="form-check form-check-success mb-2">
                                                        <input class="form-check-input input-filter" type="checkbox"
                                                            id="select-holiday" data-value="holiday" checked />
                                                        <label class="form-check-label"
                                                            for="select-holiday">Holiday</label>
                                                        div
                                                    </div>
                                                    <div class="form-check form-check-info">
                                                        <input class="form-check-input input-filter" type="checkbox"
                                                            id="select-etc" data-value="etc" checked />
                                                        <label class="form-check-label" for="select-etc">ETC</label>
                                                    </div>
                                                </div> -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->
@endsection
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->



<script>
// jQuery(document).ready(function ($) {
//     $('#app-calendar-sidebar').fullCalendar({
//         header: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'month,agendaWeek,agendaDay'
//         },
//         events: [{
//             title: 'Event 1',
//             start: '2024-12-31'
//         },
//         {
//             title: 'Event 2',
//             start: '2024-12-25'
//         },
//         {
//             title: 'Event 3',
//             start: '2024-12-30'
//         }
//         ]
//     });
// });
</script>
</script>
<script>
// jQuery(document).ready(function ($) {
//     $('#app-calendar-sidebar').fullCalendar({
//         header: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'month,agendaWeek,agendaDay'
//         },
//         events: [{
//             title: 'Event 1',
//             start: '2024-12-31'
//         },
//         {
//             title: 'Event 2',
//             start: '2024-12-25'
//         },
//         {
//             title: 'Event 3',
//             start: '2024-12-30'
//         }
//         ]
//     });
// });
</script>
</script>


</body>

</html>