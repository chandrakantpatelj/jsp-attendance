
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
                @include('admin.header')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="page-header d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0">Employee</h5>
                        <div class="d-flex align-items-center justify-content-end">
                            <button class="btn btn-primary add-leave-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" id="createEmployeeBtn" onclick="createEmployee();">
                                <i class="ti ti-plus"></i> Add new Employee
                            </button>

                            <!-- Add New Employee Drawer -->
                            <div class="offcanvas offcanvas-end custom-offcanvas"  data-bs-backdrop="static" tabindex="-1" id="offcanvasRight"
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
                                        <input type="hidden" name="role_id" value="2">
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
                                            <label for="email" class="form-label custom_lable">Personal Email</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email', $employee->email ?? '') }}"
                                                placeholder="Enter email" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="business_email" class="form-label custom_lable">Working Email</label>
                                            <input id="business_email" type="email"
                                                class="form-control @error('business_email') is-invalid @enderror" name="business_email"
                                                value="{{ old('business_email', $employee->business_email ?? '') }}"
                                                placeholder="Enter Working email" required autocomplete="business_email">

                                            @error('business_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label custom_lable">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter password" name="password"
                                                autocomplete="new-password">

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
                                            <label class="designation">Department</label>
                                            <select name="designation" id="designation" class="form-control custom_lable @error('designation') is-invalid @enderror" >
                                                <option value="">Select Designation</option>
                                                <option value="UIUX Design" {{ (old('designation', $employee->designation ?? '') == 'UIUX Design') ? 'selected' : '' }}>UIUX Design</option>
                                                <option value="Developer" {{ (old('designation', $employee->designation ?? '') == 'Developer') ? 'selected' : '' }}>Developer</option>
                                                <option value="Designer" {{ (old('designation', $employee->designation ?? '') == 'Designer') ? 'selected' : '' }}>Designer</option>
                                            </select>

                                            @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                       <div class="mb-4">
                                            <label class="form-check-label custom_lable" for="status">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input @error('status') is-invalid @enderror"
                                                       type="checkbox" id="status" name="status" value="active"
                                                       {{ old('status', $employee->status ?? 'active') == 'active' ? 'checked' : '' }} />
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
                                                <th>Business Mail</th>
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
                                                <td>{{ $employee->business_email }}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input type="checkbox" class="form-check-input" id="statusSwitch{{ $employee->id }}" {{ $employee->status === 'active' ? 'checked' : '' }} >
                                                        <label class="form-check-label" for="statusSwitch{{ $employee->id }}">
                                                            {{-- $employee->status === 'active' ? 'Active' : 'Inactive' --}}
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning" data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasRight"
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
                        <div class="d-flex justify-content-end mt-3">
                            {{ $employees->links() }}
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
    <script src="{{ env('APP_URL') . '/public/assets/js/main.js' }}"></script>
    <script>
    function loadEmployeeData(employeeId) {
        $.ajax({
            url: '/admin/employee/' + employeeId + '/edit',
            method: 'GET',
            success: function(data) {
                console.log('data.designation',data.designation);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#designation').val(data.designation);
                $('#business_email').val(data.business_email);
                $('#status').prop('checked', data.status === 'active');

                $('#employeeForm').attr('action', '/admin/employee/' + employeeId + '/update');
                $('#employeeForm').find('input[name="_method"]').remove();
                $('#employeeForm').append('<input type="hidden" name="_method" value="PUT">');

                $('#employeeForm button[type="submit"]').text('Update');

                $('#offcanvasRight').offcanvas('show');
                
            },
            error: function(xhr, status, error) {
                console.error('Error fetching employee data:', error);
                alert('Failed to load employee data.');
            }
        });
    }
    function createEmployee(){
        $('#employeeForm')[0].reset();
        $('#employeeForm').attr('action', '{{ route('employee.store') }}');
        $('#employeeForm').find('input[name="_method"]').remove();
        $('#employeeForm button[type="submit"]').text('Register');
    }

    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            try {
                var offcanvasEl = document.getElementById('offcanvasRight');
                if (offcanvasEl) {
                    var instance = bootstrap.Offcanvas.getOrCreateInstance(offcanvasEl);
                    instance.show();
                }
            } catch (e) {
            }
        });
    @endif
    </script>
    @push('script')
    <script>
    
    </script>
    @endpush
    <script src="{{ env('APP_URL') . '/public/assets/js/app-ecommerce-category-list.js' }}"></script>
    <script src="{{ env('APP_URL') . '/public/assets/js/app-ecommerce-product-list.js' }}"></script>    