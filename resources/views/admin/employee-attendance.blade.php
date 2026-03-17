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

        .attendance-day-cell .status-badge {
            display: inline-block;
            min-width: 28px;
            padding: 2px 6px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .attendance-day-cell .status-present {
            color: #198754;
            background: rgba(25, 135, 84, 0.08);
        }

        .attendance-day-cell .status-halfday {
            color: #0d6efd;
            background: rgba(13, 110, 253, 0.08);
        }

        .attendance-day-cell .status-absent {
            color: #dc3545;
            background: rgba(220, 53, 69, 0.08);
        }

        .attendance-day-cell .status-off {
            color: #6c757d;
            background: rgba(108, 117, 125, 0.12);
        }

        .attendance-modal .modal-content {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
        }

        .attendance-modal .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
        }

        .attendance-modal .modal-header .close {
            padding: 0.75rem 1rem;
            margin: -0.75rem -1rem -0.75rem auto;
            border: 0;
            background: transparent;
            line-height: 1;
            opacity: 0.6;
        }

        .attendance-modal .modal-header .close:hover {
            opacity: 1;
        }

        .attendance-modal .modal-header .close span {
            font-size: 1.25rem;
        }

        .attendance-modal .stat-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 12px;
            background: #fff;
        }

        .regularize-punch-card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            padding: 12px;
            background: #f8f9fa;
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
                                <h4 class="mb-0">All Employees Attendance Regularization</h4>
                                <a class="btn btn-outline-danger btn-sm rounded-pill" href="{{ route('employee-attendance.csv', ['month' => $month, 'year' => $year]) }}">Download CSV</a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="attendance-navigation d-flex flex-wrap align-items-center gap-2 mb-3">
                            <form method="GET" action="{{ route('employee-attendance') }}" class="d-inline">
                                <input type="hidden" name="month" value="{{ $month - 1 <= 0 ? 12 : $month - 1 }}">
                                <input type="hidden" name="year" value="{{ $month - 1 <= 0 ? $year - 1 : $year }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Previous</button>
                            </form>

                            <form method="GET" action="{{ route('employee-attendance') }}" class="d-inline">
                                <input type="hidden" name="month" value="{{ $month + 1 > 12 ? 1 : $month + 1 }}">
                                <input type="hidden" name="year" value="{{ $month + 1 > 12 ? $year + 1 : $year }}">
                                <button type="submit" class="btn btn-outline-secondary btn-sm">Next</button>
                            </form>

                            <form method="GET" action="{{ route('employee-attendance') }}" class="d-inline d-flex gap-2 align-items-center">
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
                                <div class="table-responsive text-nowrap">
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
                                            <td class="text-center align-middle">
                                                <a href="javascript:void(0);" class="employee-name"
                                                    data-employee="{{ $emp->name }}"
                                                    data-absent="0"
                                                    data-present="0"
                                                    data-off="0">
                                                    {{ $emp->name }}
                                                </a>
                                            </td>

                                            @for ($i = 1; $i <= \Carbon\Carbon::create($year, $month)->daysInMonth; $i++)
                                                @php
                                                    $targetDateString = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                    $date = \Carbon\Carbon::create($year, $month, $i);
                                                    $isWeekend = $date->isWeekend();
                                                    $isSecondSaturday =
                                                        $date->isSaturday() && $date->day > 7 && $date->day <= 14;

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

                                                    if ($hasLeave) {
                                                        $cellCode = 'A';
                                                        $cellClass = 'status-absent';
                                                    } elseif ($hasHalfDay) {
                                                        $cellCode = 'P(H)';
                                                        $cellClass = 'status-halfday';
                                                    } elseif ($isWeekend && !$isSecondSaturday) {
                                                        $cellCode = 'O';
                                                        $cellClass = 'status-off';
                                                    } elseif ($dayRecords->count() > 0) {
                                                        $cellCode = 'P';
                                                        $cellClass = 'status-present';
                                                    } else {
                                                        $cellCode = 'A';
                                                        $cellClass = 'status-absent';
                                                    }

                                                @endphp
                                                <td class="text-center align-middle attendance-day-cell" data-employee-id="{{ $emp->id }}" data-date="{{ $targetDateString }}" data-code="{{ $cellCode }}">
                                                    <span class="status-badge {{ $cellClass }}">{{ $cellCode }}</span>
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade attendance-modal" id="attendanceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0">Attendance Details</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="text-muted small">Employee</div>
                        <div class="fw-semibold" id="modal-employee-name"></div>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-sm-4">
                            <div class="stat-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">Present</div>
                                    <span class="badge bg-success-subtle text-success">P</span>
                                </div>
                                <div class="fs-4 fw-bold" id="modal-present"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="stat-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">Absent</div>
                                    <span class="badge bg-danger-subtle text-danger">A</span>
                                </div>
                                <div class="fs-4 fw-bold" id="modal-absent"></div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="stat-card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">Off</div>
                                    <span class="badge bg-secondary-subtle text-secondary">O</span>
                                </div>
                                <div class="fs-4 fw-bold" id="modal-off"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade attendance-modal" id="regularizeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0">Regularize Attendance</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="text-muted small">Employee</div>
                        <div class="fw-semibold" id="regularizeEmployee">-</div>
                        <div class="text-muted small" id="regularizeDate">-</div>
                    </div>

                    <input type="hidden" id="regularizeEmployeeId" />
                    <input type="hidden" id="regularizeDateValue" />

                    <div class="mb-2">
                        <label class="form-label mb-1">Status</label>
                        <select class="form-select" id="regularizeStatus">
                        <option value="present">Present (P)</option>
                        <option value="half-day">Half-day Leave (P(H))</option>
                        <option value="leave">Full-day Leave (A)</option>
                        </select>
                    </div>

                    <div id="regularizePunchWrap" style="display:none;">
                        <div class="regularize-punch-card mt-3">
                            <div class="row g-3">
                                <div class="col-12 col-sm-6">
                                    <label class="form-label mb-1">Punch In Time</label>
                                    <input type="time" class="form-control" id="regularizePunchIn" />
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label mb-1">Punch Out Time</label>
                                    <input type="time" class="form-control" id="regularizePunchOut" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label mb-1">Total</label>
                                    <input type="text" class="form-control" id="regularizeTotal" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-danger small mt-2" id="regularizeError" style="display:none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="regularizeSave">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var regularizeTimer = null;

            function clearRegularizeTimer() {
                if (regularizeTimer) {
                    clearInterval(regularizeTimer);
                    regularizeTimer = null;
                }
            }

            $('.employee-name').on('click', function() {
                var row = $(this).closest('tr'); // Row select કરો
                var employeeName = $(this).text().trim(); // Employee name મેળવો

                var presentCount = row.find('td.attendance-day-cell[data-code="P"]').length;
                var halfDayCount = row.find('td.attendance-day-cell[data-code="P(H)"]').length;
                var absentCount = row.find('td.attendance-day-cell[data-code="A"]').length;
                var offCount = row.find('td.attendance-day-cell[data-code="O"]').length;

                // Modal માં ડેટા Set કરો
                $('#modal-employee-name').text(employeeName);
                $('#modal-present').text(presentCount + halfDayCount + offCount);
                $('#modal-absent').text(absentCount);
                $('#modal-off').text(offCount);

                // Modal Show કરો
                $('#attendanceModal').modal('show');
            });

            $(document).on('click', '.attendance-day-cell', function() {
                var employeeId = $(this).data('employee-id');
                var date = $(this).data('date');
                var code = $(this).data('code');
                var employeeName = $(this).closest('tr').find('.employee-name').text().trim();

                $('#regularizeError').hide().text('');
                $('#regularizeEmployee').text(employeeName || '-');
                $('#regularizeDate').text(date);
                $('#regularizeEmployeeId').val(employeeId);
                $('#regularizeDateValue').val(date);

                $('#regularizePunchIn').val('');
                $('#regularizePunchOut').val('');
                $('#regularizeTotal').val('');
                clearRegularizeTimer();

                if (code === 'P(H)') {
                    $('#regularizeStatus').val('half-day');
                } else if (code === 'P') {
                    $('#regularizeStatus').val('present');
                } else {
                    $('#regularizeStatus').val('leave');
                }

                function updatePunchUI() {
                    var status = $('#regularizeStatus').val();
                    var requirePunch = (status === 'present' || status === 'half-day');
                    if (requirePunch) {
                        $('#regularizePunchWrap').show();
                        $('#regularizePunchIn').prop('required', true);
                        $('#regularizePunchOut').prop('required', true);
                    } else {
                        $('#regularizePunchWrap').hide();
                        $('#regularizePunchIn').prop('required', false);
                        $('#regularizePunchOut').prop('required', false);
                        $('#regularizePunchIn').val('');
                        $('#regularizePunchOut').val('');
                        $('#regularizeTotal').val('');
                    }
                }

                function computeTotal() {
                    var inVal = $('#regularizePunchIn').val();
                    var outVal = $('#regularizePunchOut').val();
                    if (!inVal || !outVal) {
                        $('#regularizeTotal').val('');
                        return;
                    }

                    var inParts = inVal.split(':');
                    var outParts = outVal.split(':');
                    if (inParts.length < 2 || outParts.length < 2) {
                        $('#regularizeTotal').val('');
                        return;
                    }

                    var inMinutes = (parseInt(inParts[0], 10) * 60) + parseInt(inParts[1], 10);
                    var outMinutes = (parseInt(outParts[0], 10) * 60) + parseInt(outParts[1], 10);
                    if (Number.isNaN(inMinutes) || Number.isNaN(outMinutes)) {
                        $('#regularizeTotal').val('');
                        return;
                    }

                    var diffMinutes = outMinutes - inMinutes;
                    if (diffMinutes < 0) diffMinutes += (24 * 60);

                    var hours = Math.floor(diffMinutes / 60);
                    var mins = diffMinutes % 60;
                    var total = String(hours).padStart(2, '0') + ':' + String(mins).padStart(2, '0') + ':00';
                    $('#regularizeTotal').val(total);
                }

                function startLiveTotalTimer() {
                    clearRegularizeTimer();

                    regularizeTimer = setInterval(function() {
                        var inVal = $('#regularizePunchIn').val();
                        var outVal = $('#regularizePunchOut').val();
                        var status = $('#regularizeStatus').val();

                        if (status !== 'present' && status !== 'half-day') {
                            clearRegularizeTimer();
                            return;
                        }

                        if (!inVal || outVal) {
                            clearRegularizeTimer();
                            return;
                        }

                        var inParts = inVal.split(':');
                        if (inParts.length < 2) return;

                        var inMinutes = (parseInt(inParts[0], 10) * 60) + parseInt(inParts[1], 10);
                        if (Number.isNaN(inMinutes)) return;

                        var now = new Date();
                        var nowMinutes = (now.getHours() * 60) + now.getMinutes();
                        var diffMinutes = nowMinutes - inMinutes;
                        if (diffMinutes < 0) diffMinutes += (24 * 60);

                        var hours = Math.floor(diffMinutes / 60);
                        var mins = diffMinutes % 60;
                        var secs = now.getSeconds();
                        var total = String(hours).padStart(2, '0') + ':' + String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
                        $('#regularizeTotal').val(total);
                    }, 1000);
                }

                function updateTotalDisplayMode() {
                    var status = $('#regularizeStatus').val();
                    if (status !== 'present' && status !== 'half-day') {
                        clearRegularizeTimer();
                        $('#regularizeTotal').val('');
                        return;
                    }

                    var inVal = $('#regularizePunchIn').val();
                    var outVal = $('#regularizePunchOut').val();
                    if (inVal && !outVal) {
                        startLiveTotalTimer();
                        return;
                    }

                    clearRegularizeTimer();
                    computeTotal();
                }

                function fetchPunchData() {
                    if (!employeeId || !date) return;
                    $.ajax({
                        url: '{{ route('employee-attendance.punch') }}',
                        type: 'GET',
                        data: {
                            employee_id: employeeId,
                            date: date
                        },
                        success: function(resp) {
                            if (!resp || resp.success !== true) return;

                            if (resp.punch_in_time) {
                                $('#regularizePunchIn').val(resp.punch_in_time);
                            }
                            if (resp.punch_out_time) {
                                $('#regularizePunchOut').val(resp.punch_out_time);
                            }
                            if (resp.working_hours) {
                                $('#regularizeTotal').val(resp.working_hours);
                            } else {
                                updateTotalDisplayMode();
                            }

                            updateTotalDisplayMode();
                        }
                    });
                }

                $('#regularizeStatus').off('change.regPunch').on('change.regPunch', function() {
                    updatePunchUI();
                    updateTotalDisplayMode();
                });

                $('#regularizePunchIn').off('change.regPunch keyup.regPunch').on('change.regPunch keyup.regPunch', updateTotalDisplayMode);
                $('#regularizePunchOut').off('change.regPunch keyup.regPunch').on('change.regPunch keyup.regPunch', updateTotalDisplayMode);

                updatePunchUI();
                fetchPunchData();

                $('#regularizeModal').modal('show');
            });

            $('#regularizeModal').on('hidden.bs.modal', function() {
                clearRegularizeTimer();
            });

            $('#regularizeSave').on('click', function() {
                var employeeId = $('#regularizeEmployeeId').val();
                var date = $('#regularizeDateValue').val();
                var status = $('#regularizeStatus').val();
                if (!employeeId || !date || !status) return;

                var punchIn = $('#regularizePunchIn').val();
                var punchOut = $('#regularizePunchOut').val();
                if (status === 'present' || status === 'half-day') {
                    if (!punchIn || !punchOut) {
                        $('#regularizeError').show().text('Punch In Time and Punch Out Time are required for Present / Half-day.');
                        return;
                    }
                } else {
                    punchIn = null;
                    punchOut = null;
                }

                $('#regularizeSave').prop('disabled', true);
                $('#regularizeError').hide().text('');

                $.ajax({
                    url: '{{ route('employee-attendance.regularize') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        employee_id: employeeId,
                        date: date,
                        status: status,
                        punch_in_time: punchIn,
                        punch_out_time: punchOut
                    },
                    success: function() {
                        window.location.reload();
                    },
                    error: function(xhr) {
                        var msg = 'Failed to update.';
                        if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $('#regularizeError').show().text(msg);
                    },
                    complete: function() {
                        $('#regularizeSave').prop('disabled', false);
                    }
                });
            });
        });
    </script>
@endsection
