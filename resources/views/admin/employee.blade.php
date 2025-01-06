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
                                <form id="employeeForm"
                                    action="{{ isset($employee->id) ? route('employee.update', $employee->id) : route('employee.store') }}"
                                    method="POST">
                                    @csrf
                                    @if(isset($employee->id))
                                    @method('PUT')
                                    <!-- Update method for existing employee -->
                                    @else
                                    @method('POST')
                                    <!-- Create method for new employee -->
                                    @endif
                                    <div class="mb-4">
                                        <label for="name" class="form-label custom_lable ">Employee
                                            name</label>

                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter your employee name" name="name"
                                            value="{{ old('name', $employee->name ?? '') }}" required
                                            autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label custom_lable">Email</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $employee->email ?? '') }}" placeholder="Enter email"
                                            required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label custom_lable">Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter password" name="password" autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="password-confirm" class="form-label custom_lable">Confirm
                                            Password</label>
                                        <input id="password-confirm" type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            placeholder="Confirm password" name="password_confirmation"
                                            autocomplete="new-password">

                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label class="custom_lable">Department</label>
                                        <select name="role_id" id="role_id" class="form-control" required>
                                            <option value="">Select Role</option>
                                            <option value="1"
                                                {{ (old('role_id', $employee->role_id ?? '') == 1) ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="2"
                                                {{ (old('role_id', $employee->role_id ?? '') == 2) ? 'selected' : '' }}>
                                                Employee
                                            </option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-check-label custom_lable" for="status">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input @error('status') is-invalid @enderror"
                                                type="checkbox" id="status" name="status" value="1"
                                                {{ old('status', $employee->status ?? 0) == 1 ? 'checked' : '' }} />
                                        </div>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($employee->id) ? __('Update') : __('Register') }}
                                        </button>
                                    </div>
                                </form>
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
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th style="text-align: end;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <tr>
                                            <td></td>
                                            <td>{{ $employee->name }}</td>
                                            <td>{{ $employee->designation }}</td>
                                            <td>{{ $employee->status }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#employeeModal"
                                                    onclick="loadEmployeeData({{ $employee->id }})"><i
                                                        class="ti ti-pencil me-1"></i></button>


                                                <form action="{{ route('employee.destroy', $employee->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="ti ti-trash me-1"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>


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
<script src="/assets/js/app-ecommerce-category-list.js"></script>
<script src="/assets/js/app-ecommerce-product-list.js"></script>