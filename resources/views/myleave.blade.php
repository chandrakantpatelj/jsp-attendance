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

                    <div class="navbar-nav-right  d-flex gap-4 align-items-center justify-content-end"
                        id="navbar-collapse">
                        <ul class="navbar-nav flex-row gap-3 align-items-center  ">
                            <li>

                            </li>
                            <li>
                                <button class="btn btn-danger  punch_button" type="button">
                                    Punch in
                                </button>
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
                <div class="layout-container">
                    <!-- Sidebar -->


                    <!-- Main Content -->
                    <main class="content">
                        <!-- Top Bar -->


                        <!-- Leave Section -->
                        <div class="header">
                            <h1>My Leave</h1>
                            <div class="buttons">
                                <button class="button add-leave">+ Add new leave</button>
                                <button class="button csv-files">CSV files</button>
                            </div>
                        </div>
                        <div class="tabs">
                            <button class="tab active">All Leave</button>
                            <button class="tab">Pending</button>
                            <button class="tab">Approved</button>
                            <button class="tab">Rejected</button>
                        </div>

                        <!-- Filters -->
                        <div class="full-size">
                            <div class="search-box">
                                <select>
                                    <option>Search leave type</option>
                                </select>
                                <input type="date">
                            </div>

                            <!-- Leave List -->
                            <div class="leave-list">
                                <div class="leave-item pending">
                                    <div class="leave-details">
                                        <p><strong>Leave type:</strong> Full day</p>
                                        <p><strong>Start date:</strong> 09/12/2024</p>
                                        <p><strong>End date:</strong> 12/12/2024</p>
                                        <p><strong>Total days:</strong> 4 days</p>
                                        <p><strong>Reason:</strong> I have to attend a family function so I need to
                                            leave</p>
                                    </div>
                                    <span class="status">Pending</span>
                                    <div class="actions">
                                        <button>Edit</button>
                                        <button>Delete</button>
                                    </div>
                                </div>

                                <div class="leave-item approved">
                                    <div class="leave-details">
                                        <p><strong>Leave type:</strong> First half day</p>
                                        <p><strong>Start date:</strong> 09/12/2024</p>
                                        <p><strong>Start date:</strong> 09/12/2024</p>
                                        <p><strong>Total days:</strong> 1days</p>
                                        <p><strong>Reason:</strong> I have to attend a family function so I need to
                                            leave</p>
                                    </div>
                                    <span class="status">Approved</span>
                                    <div class="actions">
                                        <button>Edit</button>
                                        <button>Delete</button>
                                    </div>
                                </div>


                                <div class="leave-item approved">
                                    <div class="leave-details">
                                        <p><strong>Leave type:</strong> Full day</p>
                                        <p><strong>Start date:</strong> 09/12/2024</p>
                                        <p><strong>Start date:</strong> 09/12/2024</p>
                                        <p><strong>Total days:</strong> 1days</p>
                                        <p><strong>Reason:</strong> I have to attend a family function so I need to
                                            leave</p>
                                    </div>
                                    <span class="status">Approved</span>
                                    <div class="actions">
                                        <button>Edit</button>
                                        <button>Delete</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Pagination -->
                        <div class="pagination">
                            <button>&laquo;</button>
                            <button>1</button>
                            <button class="active">2</button>
                            <button>3</button>
                            <button>&raquo;</button>
                        </div>
                        </section>
                    </main>
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
</body>

</html>