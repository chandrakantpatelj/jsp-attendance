@extends('layouts.app')

@section('auth-content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('admin.sidebar')
        <div class="layout-page">
            @include('admin.header')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold py-3 mb-0">Add Attendance Record</h4>
                        <a href="{{ route('admin.employee-attendance') }}" class="btn btn-outline-secondary">
                            <i class="ti ti-arrow-left me-1"></i> Back to Attendance
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.attendance.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="employee_id" value="{{ $employeeId ?? '' }}">
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Employee</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{ $employeeName ?? '' }}" readonly>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="attendance_date" class="form-control" value="{{ $date ?? '' }}" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Punch In Time</label>
                                    <div class="col-sm-9">
                                        <input type="time" name="punch_in_time" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Punch Out Time</label>
                                    <div class="col-sm-9">
                                        <input type="time" name="punch_out_time" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Status</label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control" required>
                                            <option value="present">Present</option>
                                            <option value="absent">Absent</option>
                                            <option value="half-day">Half Day</option>
                                            <option value="leave">Leave</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ti ti-device-floppy me-1"></i> Save Attendance
                                        </button>
                                        <a href="{{ route('admin.employee-attendance') }}" class="btn btn-secondary ms-2">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection