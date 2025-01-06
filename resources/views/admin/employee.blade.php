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
    <link rel="stylesheet" href="../../assets/vendor/libs/fullcalendar/fullcalendar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/app-calendar.css" />
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

            @include('admin.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('admin.header')

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

                            <!-- Add New Employee Drawer -->
                            <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel"> Add new employee</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">

                                    <div class="mb-4">
                                        <label for="employeename" class="form-label custom_lable ">Employee
                                            name</label>
                                        <input type="text" class="form-control" placeholder="Enter your employee name"
                                            id="employeename" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label custom_lable">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label custom_lable">Password</label>
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
                                    <label class="form-check-label  custom_lable" for="status">Status</label>
                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" id="status" checked />
                                    </div>
                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                        <button type="button" class="btn btn-primary">Add</button>
                                    </div>
                                </div>
                            </div>
                            <!-- <button class="btn btn-sm btn-icon" data-bs-target="#offcanvasRight"
                                data-bs-toggle="offcanvas" href="javascript:;">
                                <i class="ti ti-edit"></i>
                            </button> -->

                            <!-- Edit Employee Drawer -->
                            <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="editemployeedrawer"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel">Edit employee</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="mb-4">
                                        <label for="employeename" class="form-label custom_lable">Employee
                                            name</label>
                                        <input type="text" class="form-control" placeholder="Enter your employee name"
                                            id="employeename" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label custom_lable">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email">
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label custom_lable">Password</label>
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
                                    <label class="form-check-label custom_lable" for="status">Status</label>
                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" id="status" checked />
                                    </div>
                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn "
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                        <button type="button" class="btn btn-primary">Update</button>
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