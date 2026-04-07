@extends('layouts.app')

@section('content')
    <style>
        tbody td:first-child,
        thead th:first-child {
            position: sticky;
            left: 0;
            background: #fff !important;
            z-index: 1;
        }

        thead th:first-child {
            z-index: 2;
        }

        .attendance-navigation .btn,
        .attendance-navigation .form-select {
            height: 34px;
        }

        .attendance-table th,
        .attendance-table td {
            padding: 0.45rem 0.5rem;
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .attendance-table thead th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .attendance-table tbody td:first-child,
        .attendance-table thead th:first-child {
            min-width: 220px;
            box-shadow: 1px 0 0 rgba(0, 0, 0, 0.075);
        }

        .attendance-day-cell {
            cursor: pointer;
            user-select: none;
        }

        .status-badge {
            display: inline-block;
            min-width: 28px;
            padding: 2px 6px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .status-present {
            color: #198754;
            background: rgba(25, 135, 84, 0.08);
        }

        .status-halfday {
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.08);
        }

        .status-absent {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.08);
        }

        .status-off {
            color: #6c757d;
            background: rgba(108, 117, 125, 0.12);
        }

        .status-leave {
            color: #ffc107;
            background: rgba(255, 193, 7, 0.12);
        }

        .status-pending {
            color: #fd7e14;
            background: rgba(253, 126, 20, 0.12);
        }
    </style>
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
                    <div>
                        <div class="page-header mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <h4 class="mb-0">Employee Attendance - {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</h4>
                                <a class="btn btn-outline-danger btn-sm rounded-pill" href="{{ route('admin.employee-attendance.csv', ['month' => $month, 'year' => $year]) }}">Download CSV</a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="attendance-navigation d-flex flex-wrap align-items-center gap-2 mb-3">
                                    <form method="GET" action="{{ route('admin.employee-attendance') }}" class="d-inline">
                                        <input type="hidden" name="month" value="{{ $month - 1 <= 0 ? 12 : $month - 1 }}">
                                        <input type="hidden" name="year" value="{{ $month - 1 <= 0 ? $year - 1 : $year }}">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Previous</button>
                                    </form>

                                    <form method="GET" action="{{ route('admin.employee-attendance') }}" class="d-inline">
                                        <input type="hidden" name="month" value="{{ $month + 1 > 12 ? 1 : $month + 1 }}">
                                        <input type="hidden" name="year" value="{{ $month + 1 > 12 ? $year + 1 : $year }}">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm">Next</button>
                                    </form>

                                    <form method="GET" action="{{ route('admin.employee-attendance') }}" class="d-inline d-flex gap-2 align-items-center">
                                        <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create(null, $i)->format('F') }}
                                                </option>
                                            @endfor
                                        </select>
                                        <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                                            @for ($i = now()->year; $i >= now()->year - 10; $i--)
                                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </form>
                                </div>
                                
                                <div class="table-responsive text-nowrap" style="max-height: 600px; overflow-y: auto;">
                                    <table class="table table-bordered table-hover align-middle mb-0 attendance-table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                @for ($i = 1; $i <= \Carbon\Carbon::create($year, $month)->daysInMonth; $i++)
                                                    <th>{{ $i }}</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $emp)
                                                @php
                                                    $records = $attendance[$emp->id] ?? collect();
                                                @endphp
                                                <tr>
                                                    <td class="fw-semibold">
                                                        <span class="employee-name">{{ $emp->name }}</span>
                                                    </td>

                                                    @for ($i = 1; $i <= \Carbon\Carbon::create($year, $month)->daysInMonth; $i++)
                                                        @php
                                                            $targetDateString = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                            $date = \Carbon\Carbon::create($year, $month, $i);
                                                            $isWeekend = $date->isWeekend();
                                                            $isSecondSaturday = $date->isSaturday() && $date->day > 7 && $date->day <= 14;

                                                            $dayRecords = $records->filter(function ($item) use ($targetDateString) {
                                                                $itemDate = $item->attendance_date ?? null;
                                                                if (empty($itemDate)) return false;
                                                                return \Carbon\Carbon::parse($itemDate)->toDateString() === $targetDateString;
                                                            });

                                                            $hasLeave = $dayRecords->contains(function ($r) {
                                                                return ($r->status ?? null) === 'leave';
                                                            });

                                                            $hasHalfDay = $dayRecords->contains(function ($r) {
                                                                return ($r->status ?? null) === 'half-day';
                                                            });

                                                            $hasPresent = $dayRecords->contains(function ($r) {
                                                                return $r->punch_in_time !== null;
                                                            });

                                                            // Get the first record if exists
                                                            $firstRecord = $dayRecords->isNotEmpty() ? $dayRecords->first() : null;
                                                            $attendanceId = $firstRecord ? $firstRecord->id : '';

                                                            // Determine cell code and class
                                                            if ($hasLeave) {
                                                                $cellCode = 'L';
                                                                $cellClass = 'status-leave';
                                                                $title = 'On Leave';
                                                            } elseif ($hasHalfDay) {
                                                                $cellCode = 'P(H)';
                                                                $cellClass = 'status-halfday';
                                                                $title = 'Half Day';
                                                            } elseif ($hasPresent) {
                                                                $att = $firstRecord;
                                                                if ($att->punch_in_time && !$att->punch_out_time) {
                                                                    $cellCode = 'P*';
                                                                    $cellClass = 'status-pending';
                                                                    $title = 'Punched In - Not Out';
                                                                } else {
                                                                    $cellCode = 'P';
                                                                    $cellClass = 'status-present';
                                                                    $title = 'Present';
                                                                }
                                                            } elseif ($isWeekend && !$isSecondSaturday) {
                                                                $cellCode = 'O';
                                                                $cellClass = 'status-off';
                                                                $title = 'Weekend Off';
                                                            } else {
                                                                $cellCode = 'A';
                                                                $cellClass = 'status-absent';
                                                                $title = 'Absent';
                                                            }

                                                        @endphp
                                                        <td class="text-center align-middle attendance-day-cell" 
                                                            data-employee-id="{{ $emp->id }}" 
                                                            data-date="{{ $targetDateString }}" 
                                                            data-code="{{ $cellCode }}"
                                                            data-attendance-id="{{ $attendanceId }}"
                                                            title="{{ $title }}">
                                                            <span class="status-badge {{ $cellClass }}">{{ $cellCode }}</span>
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3 d-flex justify-content-start gap-3">
                                    <div><span class="status-badge status-present">P</span> Present</div>
                                    <div><span class="status-badge status-pending">P*</span> Punched In (No Out)</div>
                                    <div><span class="status-badge status-halfday">P(H)</span> Half Day</div>
                                    <div><span class="status-badge status-leave">L</span> Leave</div>
                                    <div><span class="status-badge status-absent">A</span> Absent</div>
                                    <div><span class="status-badge status-off">O</span> Weekend Off</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editAttendanceForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Employee</label>
                            <input type="text" class="form-control" id="edit_employee_name" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" id="edit_date" name="attendance_date" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Punch In Time</label>
                            <input type="time" class="form-control" id="edit_punch_in" name="punch_in_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Punch Out Time</label>
                            <input type="time" class="form-control" id="edit_punch_out" name="punch_out_time" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="half-day">Half Day</option>
                                <option value="leave">Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Debug: Check what data-attendance-id values are being set
    $('.attendance-day-cell').each(function() {
        var attId = $(this).data('attendance-id');
        var date = $(this).data('date');
        var empId = $(this).data('employee-id');
        if (attId) {
            console.log('Cell with record:', {empId: empId, date: date, attId: attId});
        }
    });
    
    // Handle clicking on attendance cell
    $('.attendance-day-cell').on('click', function() {
        var attendanceId = $(this).data('attendance-id');
        var employeeId = $(this).data('employee-id');
        var date = $(this).data('date');
        var code = $(this).data('code');
        var employeeName = $(this).closest('tr').find('.employee-name').text().trim();
        
        console.log('Clicked cell:', {attendanceId: attendanceId, employeeId: employeeId, date: date, code: code, employeeName: employeeName});
        
        if (!attendanceId) {
            alert('No attendance record found for this date. Please create one first.');
            return;
        }
        
        // Show loading state
        $('#edit_employee_name').val('Loading...');
        $('#edit_date').val(date);
        $('#edit_punch_in').val('');
        $('#edit_punch_out').val('');
        $('#edit_status').val('present');
        $('#editAttendanceModal').modal('show');
        
        // Set form action
        $('#editAttendanceForm').attr('action', '/admin/attendance/' + attendanceId + '/update');
        
        // Fetch attendance details via AJAX
        $.ajax({
            url: '{{ route("admin.employee-attendance.punch") }}',
            type: 'GET',
            data: {
                employee_id: employeeId,
                date: date
            },
            dataType: 'json',
            success: function(response) {
                console.log('AJAX success:', response);
                
                $('#edit_employee_name').val(employeeName);
                $('#edit_date').val(date);
                
                if (response.success) {
                    $('#edit_punch_in').val(response.punch_in_time);
                    $('#edit_punch_out').val(response.punch_out_time);
                    $('#edit_status').val(response.status || 'present');
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
                console.error('Response:', xhr.responseText);
                
                $('#edit_employee_name').val(employeeName);
                $('#edit_date').val(date);
                $('#edit_punch_in').val('');
                $('#edit_punch_out').val('');
                $('#edit_status').val('present');
            }
        });
    });
    
    // Handle form submission via AJAX
    $('#editAttendanceForm').on('submit', function(e) {
        e.preventDefault();
        
        var form = $(this);
        var url = form.attr('action');
        var data = form.serialize();
        
        // Show loading state
        var submitBtn = form.find('button[type="submit"]');
        var originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Saving...');
        
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    $('#editAttendanceModal').modal('hide');
                    
                    // Show success message
                    var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">';
                    alertHtml += response.message;
                    alertHtml += '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                    alertHtml += '</div>';
                    
                    $('.content-wrapper').prepend(alertHtml);
                    
                    // Reload the page after 1 second to show updated data
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert('Error: ' + response.message);
                    submitBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function(xhr) {
                var response = xhr.responseJSON;
                alert('Error: ' + (response ? response.message : 'Unknown error occurred'));
                submitBtn.prop('disabled', false).text(originalText);
            }
        });
    });
    
    // Reset form when modal is closed
    $('#editAttendanceModal').on('hidden.bs.modal', function() {
        $('#editAttendanceForm')[0].reset();
    });
});
</script>
@endpush