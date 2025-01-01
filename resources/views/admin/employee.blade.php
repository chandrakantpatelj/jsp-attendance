@extends('layouts.app')
@section('auth-content')
<div class="container">
    <h1>Employee Management</h1>

    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#employeeModal">
        Create Employee
    </button>

    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Create Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

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

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $employee->name ?? '') }}" required
                                    autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email', $employee->email ?? '') }}" required
                                    autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role_id"
                                class="col-md-4 col-form-label text-md-end">{{ __('Select role') }}</label>

                            <div class="col-md-6">
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
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($employee->id) ? __('Update') : __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    @foreach($employees as $employee)
    <div class="employee">
        <span>{{ $employee->name }}</span>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#employeeModal"
            onclick="loadEmployeeData({{ $employee->id }})">Edit</button>


        <form action="{{ route('employee.destroy', $employee->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
    @endforeach
</div>
@endsection
<script src="../../assets/js/main.js"></script>
<script>
function loadEmployeeData(employeeId) {
    $.ajax({
        url: '/employee/' + employeeId + '/edit',
        method: 'GET',
        success: function(data) {
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#role_id').val(data.role_id);
            $('#password').val('');
            $('#password-confirm').val('');

            $('#employeeForm button[type="submit"]').text('Update');

            $('#employeeForm').attr('action', '/employee/' + employeeId + '/update');

            $('#employeeModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching employee data:', error);
            alert('Failed to load employee data.');
        }
    });
}
</script>
@push('script')

@endpush