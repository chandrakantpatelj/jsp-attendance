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

            @include('include.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('include.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="calendar-header  d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0">My Leave</h5>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-warning add-leave-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ti ti-plus"></i> Add new leave
                            </button>

                            <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel"> Add new leave</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="mb-4">
                                        <label class="custom_lable">Leave type</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>Select leave type</option>
                                            <option value="1">First half</option>
                                            <option value="2">Second half</option>
                                            <option value="3">Full day</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="flatpickr-date" class="form-label custom_lable ">Start date</label>
                                        <input type="date" class="form-control" placeholder="Select start date"
                                            id="flatpickr-date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="flatpickr-date" class="form-label custom_lable ">End date</label>
                                        <input type="date" class="form-control" placeholder="Select End date"
                                            id="flatpickr-date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput1" class="form-label custom_lable">Total
                                            day’s</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter day’s">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput1"
                                            class="form-label custom_lable">Reason</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Your Reason">
                                    </div>

                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn">Cancel</button>
                                        <button type="button" class="btn btn-warning">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-csvfile ms-3">
                                <h5 class="mb-0">CSV files</h5>
                            </div>
                        </div>


                    </div>


                    <div class="container-xxl flex-grow-1">
                        <ul class="nav nav-tabs  custom_tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-new" aria-controls="navs-justified-new"
                                    aria-selected="true">
                                    All Leave
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-link-preparing"
                                    aria-controls="navs-justified-link-preparing" aria-selected="false">
                                    Pending
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-link-shipping"
                                    aria-controls="navs-justified-link-shipping" aria-selected="false">
                                    Approved
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-justified-link-rejected"
                                    aria-controls="navs-justified-link-rejected" aria-selected="false">
                                    Rejected
                                </button>
                            </li>
                        </ul>
                        <div class="card ">
                            <div class="p-0">
                                <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                    <div class="btn-group search_leave">
                                        <button type="button" class="btn btn-label-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Search leave type
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Another
                                                    action</a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Something
                                                    else here</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li><a class="dropdown-item" href="javascript:void(0);">Separated
                                                    link</a></li>
                                        </ul>
                                    </div>
                                    <div class="info-container ">
                                        <small class="d-block border-top fw-normal text-uppercase text-muted "></small>
                                        <div class="d-flex justify-content-between leave_list ">
                                            <ul class="list-unstyled  mb-0">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Leave type:</span>
                                                    <span>Full day</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Start date:</span>
                                                    <span>30/12/2024</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">End date:</span>
                                                    <span>01/01/2025</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Total days:</span>
                                                    <span>03 days</span>
                                                </li>

                                                <li>
                                                    <span class="fw-medium me-2">Reason type:-</span>
                                                    <span> I have to attend a family function so I need to
                                                        leave</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column justify-content-between">
                                                <div class="d-flex">


                                                    <!-- <button type="button" class="bg-transparent border-0"><i
                                                            class="ti ti-trash"></i> </button> -->

                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="bg-transparent border-0"
                                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        <i class="ti ti-trash"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade " id="exampleModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <div class="modal-body ">
                                                                    <button type="button" class=" deleteicon-btn">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                    <h3 class="text-center">Are you sure!</h3>
                                                                    <h5 class="text-center mb-0">Are you sure want to
                                                                        delete this leave?</h5>
                                                                    <div
                                                                        class="modal-btns d-flex gap-4 justify-content-center ">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="button"
                                                                            class="btn btn-danger">Delete</button>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="bg-transparent border-0"
                                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvaseditRight"
                                                        aria-controls="offcanvasRight"><i class="ti ti-edit"></i>
                                                    </button>

                                                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1"
                                                        id="offcanvaseditRight" aria-labelledby="offcanvasRightLabel">
                                                        <div class="offcanvas-header">
                                                            <h2 id="offcanvasRightLabel"> Edit leave</h2>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body">
                                                            <div class="mb-4">
                                                                <label class="custom_lable">Leave type</label>
                                                                <select class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>Select leave type</option>
                                                                    <option value="1">First half</option>
                                                                    <option value="2">Second half</option>
                                                                    <option value="3">Full day</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">Start date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select start date"
                                                                    id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">End date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select End date" id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Total
                                                                    day’s</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter day’s">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Reason</label>
                                                                <input type="text" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter Your Reason">
                                                            </div>

                                                            <div class="d-flex gap-3 justify-content-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary from_btn">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-warning">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h5 class="text-danger">pending</h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="info-container">
                                        <small class="d-block  border-top fw-normal text-uppercase text-muted "></small>
                                        <div class="d-flex justify-content-between leave_list ">
                                            <ul class="list-unstyled  mb-0">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Leave type:</span>
                                                    <span>First half day</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Start date:</span>
                                                    <span>09/12/2024</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">End date:</span>
                                                    <span>09/12/2024</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Total days:</span>
                                                    <span>0.5 days</span>
                                                </li>

                                                <li>
                                                    <span class="fw-medium me-2">Reason type:-</span>
                                                    <span> I have to attend a family function so I need to
                                                        leave</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column justify-content-between">
                                                <div class="d-flex">
                                                    <button type="button" class="bg-transparent border-0"><i
                                                            class="ti ti-trash"></i> </button>
                                                    <button type="button" class="bg-transparent border-0"
                                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvaseditRight"
                                                        aria-controls="offcanvasRight"><i class="ti ti-edit"></i>
                                                    </button>

                                                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1"
                                                        id="offcanvaseditRight" aria-labelledby="offcanvasRightLabel">
                                                        <div class="offcanvas-header">
                                                            <h2 id="offcanvasRightLabel"> Edit leave</h2>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body">
                                                            <div class="mb-4">
                                                                <label class="custom_lable">Leave type</label>
                                                                <select class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>Select leave type</option>
                                                                    <option value="1">First half</option>
                                                                    <option value="2">Second half</option>
                                                                    <option value="3">Full day</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">Start date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select start date"
                                                                    id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">End date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select End date" id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Total
                                                                    day’s</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter day’s">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Reason</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter Your Reason">
                                                            </div>

                                                            <div class="d-flex gap-3 justify-content-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary from_btn">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-warning">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <h5 class="text-success">Approve</h5>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="info-container">
                                        <small class="d-block  border-top fw-normal text-uppercase text-muted"></small>
                                        <div class="d-flex justify-content-between leave_list ">
                                            <ul class="list-unstyled  mb-0">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Leave type:</span>
                                                    <span>Full day</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Start date:</span>
                                                    <span>30/12/2024</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">End date:</span>
                                                    <span>31/12/2024</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Total days:</span>
                                                    <span>02 days</span>
                                                </li>

                                                <li>
                                                    <span class="fw-medium me-2">Reason type:-</span>
                                                    <span> I have to attend a family function so I need to
                                                        leave</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column justify-content-between">
                                                <div class="d-flex">
                                                    <button type="button" class="bg-transparent border-0"><i
                                                            class="ti ti-trash"></i> </button>
                                                    <button type="button" class="bg-transparent border-0"
                                                        data-bs-toggle="offcanvas" data-bs-target="#offcanvaseditRight"
                                                        aria-controls="offcanvasRight"><i class="ti ti-edit"></i>
                                                    </button>

                                                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1"
                                                        id="offcanvaseditRight" aria-labelledby="offcanvasRightLabel">
                                                        <div class="offcanvas-header">
                                                            <h2 id="offcanvasRightLabel"> Edit leave</h2>
                                                            <button type="button" class="btn-close text-reset"
                                                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                        </div>
                                                        <div class="offcanvas-body">
                                                            <div class="mb-4">
                                                                <label class="custom_lable">Leave type</label>
                                                                <select class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>Select leave type</option>
                                                                    <option value="1">First half</option>
                                                                    <option value="2">Second half</option>
                                                                    <option value="3">Full day</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">Start date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select start date"
                                                                    id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="flatpickr-date"
                                                                    class="form-label custom_lable ">End date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Select End date" id="flatpickr-date" />
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Total
                                                                    day’s</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter day’s">
                                                            </div>
                                                            <div class="mb-4">
                                                                <label for="exampleFormControlInput1"
                                                                    class="form-label custom_lable">Reason</label>
                                                                <input type="email" class="form-control"
                                                                    id="exampleFormControlInput1"
                                                                    placeholder="Enter Your Reason">
                                                            </div>

                                                            <div class="d-flex gap-3 justify-content-end">
                                                                <button type="button"
                                                                    class="btn btn-outline-secondary from_btn">Cancel</button>
                                                                <button type="button"
                                                                    class="btn btn-warning">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <h5 class="text-success">Approve</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
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
    <script src="../../assets/vendor/libs/fullcalendar/fullcalendar.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
    <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
    <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/assets/js/app-ecommerce-dashboard.js"></script>
    <script src="/assets/js/dashboards-crm.js"></script>
    <script src="/assets/js/charts-apex.js"></script>
    <script src="/assets/js/app-calendar.js"></script>
    <script src="/assets/js/app-calendar-events.js"></script>
    <script src="/assets/js/app-ecommerce-category-list.js"></script>
    <script src="/assets/js/app-ecommerce-product-list.js"></script>


</body>

</html>