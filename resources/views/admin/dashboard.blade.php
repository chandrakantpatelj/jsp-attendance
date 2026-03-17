@extends('layouts.app')
@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('admin.sidebar')

        <!-- Layout container -->
        <div class="layout-page">

            <!-- Navbar -->
            @include('admin.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="calendar-header">
                    <h5 class="mb-0">Dashboard Admin</h5>
                </div>

                <div class="container-xxl flex-grow-1 ">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span><i class="ti ti-users"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">80</h2>
                                        <h5 class="mb-0 ">Total days</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <span> <i class="menu-icon tf-icons ti ti-logout"></i></span>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">05</h2>
                                        <h5 class="mb-0 ">Total leave request</h5>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <img src="{{ asset('assets/img/presentIcon.png') }}" alt="Present Icon">
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">12</h2>
                                        <h5 class="mb-0 ">Today present days</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 mb-4">
                            <div class="card dashbord-card">
                                <div class="d-flex align-items-center ">
                                    <div class="avatar me-2">
                                        <div class="avatar me-2">
                                            <img src="{{ asset('assets/img/absentIcon.png') }}" alt="Absent Icon">
                                        </div>
                                    </div>
                                    <div>
                                        <h2 class=" mb-0 ">05</h2>
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