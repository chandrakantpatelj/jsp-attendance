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
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Employee Management</h5>
                        <div class="d-flex align-items-center justify-content-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" id="createEmployeeBtn">
                                <i class="ti ti-plus"></i> Add New Employee
                            </button>

                            <!-- Add/Edit Employee Drawer -->
                            <div class="offcanvas offcanvas-end custom-offcanvas" data-bs-backdrop="static" tabindex="-1" id="offcanvasRight"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel">Add New Employee</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                   
                                    <form id="employeeForm" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" id="methodField" value="POST">
                                        <input type="hidden" name="role_id" value="2">
                                        <input type="hidden" name="employee_id" id="employeeId">
                                        
                                        <div class="mb-4">
                                            <label for="name" class="form-label">Employee Name</label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Enter employee name" name="name"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="email" class="form-label">Personal Email</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}"
                                                placeholder="Enter personal email" required>
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="business_email" class="form-label">Work Email</label>
                                            <input id="business_email" type="email"
                                                class="form-control @error('business_email') is-invalid @enderror" name="business_email"
                                                value="{{ old('business_email') }}"
                                                placeholder="Enter work email" required>
                                            @error('business_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter password" name="password">
                                            <small class="text-muted">Leave blank to keep current password when editing</small>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="mb-4">
                                            <label for="password-confirm" class="form-label">Confirm Password</label>
                                            <input id="password-confirm" type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Confirm password" name="password_confirmation">
                                            @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label">Department</label>
                                            <select name="designation" id="designation" class="form-control @error('designation') is-invalid @enderror" required>
                                                <option value="">Select Designation</option>
                                                <option value="UIUX Design">UIUX Design</option>
                                                <option value="Developer">Developer</option>
                                                <option value="Designer">Designer</option>
                                            </select>
                                            @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label" for="status">Status</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input @error('status') is-invalid @enderror"
                                                       type="checkbox" id="status" name="status" value="active" checked>
                                                <label class="form-check-label" for="status">Active</label>
                                            </div>
                                            @error('status')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                        <div class="d-flex gap-3 justify-content-end mt-4">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                                            <button type="submit" class="btn btn-primary" id="submitBtn">Create Employee</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- CSV Export Button -->
                            <a href="{{ route('admin.employee.csv') }}" class="btn btn-outline-danger ms-3">
                                <i class="ti ti-file-analytics me-2"></i>CSV Export
                            </a>
                        </div>
                    </div>
                    
                    <div class="container-xxl flex-grow-1 mt-4">
                        <div class="card">
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Department</th>
                                                <th>Work Email</th>
                                                <th>Status</th>
                                                <th style="text-align: end;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($employees as $index => $employee)
                                            <tr>
                                                <td>{{ $employees->firstItem() + $index }}</td>
                                                <td>{{ $employee->name }}</td>
                                                <td>{{ $employee->designation ?? 'N/A' }}</td>
                                                <td>{{ $employee->business_email ?? 'N/A' }}</td>
                                                <td>
                                                    @if($employee->status === 'active')
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-warning" 
                                                        onclick="editEmployee({{ $employee->id }})">
                                                        <i class="ti ti-edit"></i> Edit
                                                    </button>

                                                    <form action="{{ route('admin.employee.destroy', $employee->id) }}"
                                                        method="POST" style="display:inline;" 
                                                        onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="ti ti-users-off fs-1 d-block mb-2"></i>
                                                    No employees found
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    {{ $employees->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- SweetAlert for popups -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Reset form when opening for new employee
        $('#createEmployeeBtn').on('click', function() {
            resetForm();
            $('#employeeForm').attr('action', '{{ route("admin.employee.store") }}');
            $('#methodField').val('POST');
            $('#submitBtn').text('Create Employee');
            $('#offcanvasRightLabel').text('Add New Employee');
        });

        // Handle form submission with AJAX for update/create
        $('#employeeForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            var isUpdate = form.find('input[name="_method"]').val() === 'PUT';

            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        // Show success popup
                        Swal.fire({
                            title: 'Success!',
                            text: isUpdate ? 'Employee updated successfully!' : 'Employee created successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        // Show error if response indicates failure
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'An error occurred.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Validation errors
                        var errors = xhr.responseJSON.errors;
                        displayErrors(errors);
                        // Also show a general error popup
                        Swal.fire({
                            title: 'Validation Error',
                            text: 'Please check the form for errors.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An unexpected error occurred. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });

    function resetForm() {
        $('#employeeForm')[0].reset();
        $('#employeeForm').find('.is-invalid').removeClass('is-invalid');
        $('#employeeForm').find('.invalid-feedback').remove();
        $('#employeeId').val('');
        $('#status').prop('checked', true);
        $('#password').val('');
        $('#password-confirm').val('');
    }

    function displayErrors(errors) {
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        // Display new errors
        $.each(errors, function(field, messages) {
            var input = $('[name="' + field + '"]');
            input.addClass('is-invalid');
            input.after('<span class="invalid-feedback" role="alert"><strong>' + messages[0] + '</strong></span>');
        });
    }

    function editEmployee(employeeId) {
        $.ajax({
            url: '/admin/employee/' + employeeId + '/edit',
            method: 'GET',
            success: function(data) {
                resetForm();
                
                // Fill form with employee data
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#business_email').val(data.business_email);
                $('#designation').val(data.designation);
                $('#status').prop('checked', data.status === 'active');
                $('#employeeId').val(data.id);
                // Clear password fields for security
                $('#password').val('');
                $('#password-confirm').val('');

                // Set form for update
                $('#employeeForm').attr('action', '/admin/employee/' + employeeId + '/update');
                $('#methodField').val('PUT');
                $('#submitBtn').text('Update Employee');
                $('#offcanvasRightLabel').text('Edit Employee');

                // Open offcanvas
                var offcanvas = new bootstrap.Offcanvas($('#offcanvasRight')[0]);
                offcanvas.show();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching employee data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load employee data.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    }

    @if ($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var offcanvas = new bootstrap.Offcanvas($('#offcanvasRight')[0]);
        offcanvas.show();
    });
    @endif
</script>
@endpush