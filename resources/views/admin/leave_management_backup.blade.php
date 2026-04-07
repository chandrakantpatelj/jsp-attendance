@extends('layouts.app')

@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Admin Sidebar -->
        @include('admin.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Admin Header -->
            @include('admin.header')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Page header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold py-3 mb-0">Attendance Management</h4>
                        <span class="badge bg-label-primary">{{ now()->format('l, d M Y') }}</span>
                    </div>

                    <!-- Employee Selection -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="employeeSelect" class="form-label">Select Employee</label>
                                    <select id="employeeSelect" class="form-select">
                                        <option value="" data-name="">Choose Employee</option>
                                        @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" data-name="{{ $employee->name }}">
                                            {{ $employee->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="button" class="btn btn-success" id="createAttendanceBtn">
                                        <i class="ti ti-plus me-1"></i> Create Attendance
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Create/Edit Attendance Modal -->
                    <div class="modal fade" id="createAttendance" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createAttendanceLabel">Create Attendance</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Employee:</strong> <span id="modalAttendanceName" class="fw-bold"></span></p>
                                    
                                    <form id="attendanceForm" method="POST">
                                        @csrf
                                        <input type="hidden" name="attendance_id" id="modalAttendanceId">
                                        <input type="hidden" name="employee_id" id="modalEmployeeId">

                                        <div class="mb-3">
                                            <label for="attendance_date" class="form-label">Date</label>
                                            <input type="date" name="attendance_date" id="attendance_date"
                                                class="form-control" required>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="punch_in_time" class="form-label">Punch In Time</label>
                                                <input type="time" name="punch_in_time" id="punch_in_time"
                                                    class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="punch_out_time" class="form-label">Punch Out Time</label>
                                                <input type="time" name="punch_out_time" id="punch_out_time"
                                                    class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" id="status" class="form-select" required>
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="half-day">Half-Day</option>
                                                <option value="leave">Leave</option>
                                            </select>
                                        </div>

                                        <div class="d-flex gap-3 justify-content-end mt-4">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Save Attendance</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Records Table -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Attendance Records</h5>
                            <span class="text-muted">Total Records: {{ $attendances->total() }}</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Employee</th>
                                            <th>Date</th>
                                            <th>Punch In</th>
                                            <th>Punch Out</th>
                                            <th>Status</th>
                                            <th>Working Hours</th>
                                            <th style="width: 150px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($attendances as $attendance)
                                        <tr>
                                            <td class="fw-semibold">{{ $attendance->user->name ?? 'N/A' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}</td>
                                            <td>{{ $attendance->punch_in_time ?? '--' }}</td>
                                            <td>{{ $attendance->punch_out_time ?? '--' }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match($attendance->status) {
                                                        'present' => 'success',
                                                        'absent' => 'danger',
                                                        'half-day' => 'warning',
                                                        'leave' => 'info',
                                                        default => 'secondary'
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}">
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $workingHours = $attendance->working_hours ?? '00:00:00';
                                                    
                                                    // If working hours contains negative or invalid values, calculate fresh
                                                    if (strpos($workingHours, '-') !== false || $workingHours == '00:00:00') {
                                                        if ($attendance->punch_in_time && $attendance->punch_out_time) {
                                                            try {
                                                                $punchIn = \Carbon\Carbon::parse($attendance->punch_in_time);
                                                                $punchOut = \Carbon\Carbon::parse($attendance->punch_out_time);
                                                                
                                                                if ($punchOut->lt($punchIn)) {
                                                                    $punchOut->addDay();
                                                                }
                                                                
                                                                $diffInMinutes = $punchOut->diffInMinutes($punchIn);
                                                                $hours = floor($diffInMinutes / 60);
                                                                $minutes = $diffInMinutes % 60;
                                                                $workingHours = sprintf('%02d:%02d:00', $hours, $minutes);
                                                            } catch (\Exception $e) {
                                                                $workingHours = '00:00:00';
                                                            }
                                                        } else {
                                                            $workingHours = '00:00:00';
                                                        }
                                                    }
                                                    
                                                    // Format to show only hours and minutes
                                                    $displayHours = substr($workingHours, 0, 5);
                                                @endphp
                                                {{ $displayHours }}
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-sm btn-warning" 
                                                        onclick="editAttendance({{ $attendance->id }})">
                                                        <i class="ti ti-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.attendance.destroy', $attendance->id) }}" 
                                                        method="POST" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="ti ti-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="ti ti-calendar-off fs-1 d-block mb-2"></i>
                                                No attendance records found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        @if($attendances->hasPages())
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small>Showing {{ $attendances->firstItem() }} to {{ $attendances->lastItem() }} of {{ $attendances->total() }} entries</small>
                            {{ $attendances->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function editAttendance(attendanceId) {
        $.ajax({
            url: '/admin/attendance/' + attendanceId + '/edit',
            method: 'GET',
            success: function(data) {
                $('#modalAttendanceName').text(data.user.name);
                $('#attendance_date').val(data.attendance_date);
                $('#punch_in_time').val(data.punch_in_time);
                $('#punch_out_time').val(data.punch_out_time);
                $('#status').val(data.status);
                $('#modalAttendanceId').val(data.id);
                $('#modalEmployeeId').val(data.employee_id);
                
                $('#attendanceForm').attr('action', '/admin/attendance/' + attendanceId + '/update');
                $('#attendanceForm button[type="submit"]').text('Update Attendance');
                $('#createAttendanceLabel').text('Edit Attendance');
                $('#createAttendance').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Failed to load attendance data.');
            }
        });
    }

    $(document).ready(function() {
        $('#createAttendanceBtn').on('click', function() {
            var selectedOption = $('#employeeSelect option:selected');
            var employeeId = selectedOption.val();
            var employeeName = selectedOption.data('name');

            if (!employeeId) {
                alert('Please select an employee first!');
                return;
            }

            // Reset form
            $('#attendanceForm')[0].reset();
            $('#attendanceForm').attr('action', '{{ route("admin.attendance.store") }}');
            $('#attendanceForm button[type="submit"]').text('Save Attendance');
            $('#createAttendanceLabel').text('Create Attendance');
            
            $('#modalAttendanceName').text(employeeName);
            $('#modalEmployeeId').val(employeeId);
            $('#attendance_date').val(new Date().toISOString().split('T')[0]);
            
            $('#createAttendance').modal('show');
        });

        // Handle form submission
        $('#attendanceForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var url = form.attr('action');
            var data = form.serialize();
            
            $.ajax({
                url: url,
                type: 'POST',
                data: data,
                success: function(response) {
                    $('#createAttendance').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON?.message || 'Failed to save attendance'));
                }
            });
        });
    });
</script>
@endpush