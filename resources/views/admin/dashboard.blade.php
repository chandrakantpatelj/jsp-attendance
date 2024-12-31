<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Dashboard - eCommerce | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />


    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>


</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.html" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                    fill="#7367F0" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                    fill="#161616" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                    fill="#161616" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                    fill="#7367F0" />
                            </svg>
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold">jsp infotech</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
                        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>
                <ul class="menu-inner py-1">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-mail"></i>
                            <div data-i18n="Dashboards">Dashboards</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('attendance-regularization') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-mail"></i>
                            <div data-i18n="Attendance Regularization">Attendance-regularization</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('my-leave') }}" class="menu-link">
                            <i class="menu-icon tf-icons ti ti-mail"></i>
                            <div data-i18n="My Leave">My Leave</div>
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
                    <div class="navbar-nav-right  d-flex gap-4 align-items-center justify-content-end"
                        id="navbar-collapse">
                        <ul class="navbar-nav flex-row gap-3 align-items-center  ">
                            <li>
                                <div>
                                    <span class="menu-header-text punchin-time">
                                        00:00
                                    </span>
                                </div>
                            </li>
                            <li>
                                <button class="btn btn-danger  punch_button" type="button">
                                    Punch in
                                </button>
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
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Mark all as read"><i class="ti ti-mail-opened fs-4"></i></a>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container  ">
                                        <ul class="list-group list-group-flush ">
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
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
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
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
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
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
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
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
                                <button class="btn btn-logout mt-1" type="button">
                                    Log Out
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- Search Small Screens -->
                    <div class=" search-input-wrapper d-none d-flex justify-content-end">
                        <input type="text" class="form-control search-input container-xxl border-0"
                            placeholder="Search..." aria-label="Search..." />
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

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/app-ecommerce-dashboard.js"></script>
    <script src="/assets/js/dashboards-crm.js"></script>
    <script src="/assets/js/charts-apex.js"></script>
    <script src="/assets/js/app-calendar.js"></script>
    <script src="/assets/js/app-calendar-events.js"></script>

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