@extends('layouts.app')

@section('auth-content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('employee.sidebar')
        <div class="layout-page">
            @include('employee.header')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">Attendance Regularization</h5>
                        <a href="{{ route('employee.attendance-regularization.csv') }}" class="btn btn-outline-danger btn-sm rounded-pill">
                            <i class="ti ti-file-analytics me-1"></i> CSV Export
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">All Attendance Records</h5>
                            
                            @if($attendances->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Punch In</th>
                                            <th>Punch Out</th>
                                            <th>Working Hours</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($attendances as $attendance)
                                        @php
                                            // Check if already has approved or pending request
                                            $hasRequest = \App\Models\Regularization::where('attendance_id', $attendance->id)
                                                ->where('user_id', auth()->id())
                                                ->exists();
                                        @endphp
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }} ({{ \Carbon\Carbon::parse($attendance->attendance_date)->format('l') }})</td>
                                            <td>{{ $attendance->punch_in_time ?? '--:-- --' }}</td>
                                            <td>{{ $attendance->punch_out_time ?? '--:-- --' }}</td>
                                            <td>{{ $attendance->display_working_hours ?? ($attendance->working_hours ?? '00:00:00') }}</td>
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
                                                <span class="badge bg-{{ $statusClass }}">{{ ucfirst($attendance->status) }}</span>
                                             </td>
                                            <td>
                                                @if($hasRequest)
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        <i class="ti ti-clock-edit me-1"></i> Requested
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-primary" 
                                                        onclick="openRequestModal({{ $attendance->id }}, '{{ \Carbon\Carbon::parse($attendance->attendance_date)->format('d M Y') }}')">
                                                        <i class="ti ti-clock-edit me-1"></i> Request
                                                    </button>
                                                @endif
                                             </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="ti ti-calendar-off fs-1 d-block mb-3 text-muted"></i>
                                <h6 class="text-muted">No attendance records found</h6>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="regularizationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request Regularization</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="regularizationForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Attendance Date</label>
                        <input type="text" class="form-control bg-light" id="modalAttendanceDate" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" required placeholder="Explain why you need to regularize this attendance..."></textarea>
                    </div>
                    <input type="hidden" name="attendance_id" id="modalAttendanceId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openRequestModal(attendanceId, attendanceDate) {
        $('#modalAttendanceId').val(attendanceId);
        $('#modalAttendanceDate').val(attendanceDate);
        $('#regularizationForm').attr('action', '{{ route("employee.attendance-regularization.store") }}');
        $('#regularizationModal').modal('show');
    }

    $(document).ready(function() {
        $('#regularizationForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#regularizationModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'Something went wrong';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg
                    });
                }
            });
        });
    });
</script>
@endsection