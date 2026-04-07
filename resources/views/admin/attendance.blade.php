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
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Attendance Management</h4>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Punch In</th>
                                            <th>Punch Out</th>
                                            <th>Working Hours</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->employee->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d-m-Y') }}</td>
                                            <td>{{ $attendance->punch_in_time ?? '--' }}</td>
                                            <td>{{ $attendance->punch_out_time ?? '--' }}</td>
                                            <td>{{ $attendance->working_hours ?? '--' }}</td>
                                            <td>
                                                @if($attendance->status == 'present')
                                                    <span class="badge bg-success">Present</span>
                                                @elseif($attendance->status == 'absent')
                                                    <span class="badge bg-danger">Absent</span>
                                                @elseif($attendance->status == 'half-day')
                                                    <span class="badge bg-info">Half Day</span>
                                                @elseif($attendance->status == 'leave')
                                                    <span class="badge bg-warning">Leave</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $attendance->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.employee-attendance', ['month' => \Carbon\Carbon::parse($attendance->attendance_date)->month, 'year' => \Carbon\Carbon::parse($attendance->attendance_date)->year]) }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-calendar"></i> View Month
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No attendance records found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $attendances->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection