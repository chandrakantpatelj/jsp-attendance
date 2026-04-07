@extends('layouts.app')

@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('employee.sidebar')

        <div class="layout-page">
            @include('employee.header')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Page header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="fw-bold py-3 mb-0">Dashboard</h4>
                    </div>

                    <!-- Stats Cards with Real Data -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="card-text text-muted mb-1">Total Days (This Month)</p>
                                            <h3 class="fw-bold mb-0">{{ $daysInMonth ?? 0 }}</h3>
                                        </div>
                                        <div class="avatar avatar-lg rounded-circle bg-label-primary p-3">
                                            <i class="ti ti-calendar-stats fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="card-text text-muted mb-1">Present Days (This Month)</p>
                                            <h3 class="fw-bold mb-0 text-success">{{ $totalPresent ?? 0 }}</h3>
                                        </div>
                                        <div class="avatar avatar-lg rounded-circle bg-label-success p-3">
                                            <i class="ti ti-user-check fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="card-text text-muted mb-1">Absent Days (This Month)</p>
                                            <h3 class="fw-bold mb-0 text-danger">{{ $totalAbsent ?? 0 }}</h3>
                                        </div>
                                        <div class="avatar avatar-lg rounded-circle bg-label-danger p-3">
                                            <i class="ti ti-user-x fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="card-text text-muted mb-1">Leave Requests</p>
                                            <h3 class="fw-bold mb-0">{{ $totalLeaveRequests ?? 0 }}</h3>
                                        </div>
                                        <div class="avatar avatar-lg rounded-circle bg-label-warning p-3">
                                            <i class="ti ti-logout fs-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Time Tracker, Attendance Summary, Calendar -->
                    <div class="row">
                        <!-- Time Tracker Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="card-title mb-0">Time Tracker</h5>
                                    <small class="text-muted">Today</small>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <div class="text-center mb-3">
                                        <h2 id="currentTime" class="display-6 fw-bold text-primary"></h2>
                                    </div>

                                    <!-- Punch In/Out Display -->
                                    <div class="row text-center mb-3">
                                        <div class="col-6">
                                            <div class="p-2 bg-light rounded">
                                                <span class="d-block text-muted small mb-1">Punch In</span>
                                                <h5 class="fw-bold mb-0" id="punchInTime">{{ $punchInTime ?? '--:--' }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-2 bg-light rounded">
                                                <span class="d-block text-muted small mb-1">Punch Out</span>
                                                <h5 class="fw-bold mb-0" id="punchOutTime">{{ $punchOutTime ?? '--:--' }}</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Progress bar for worked hours -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted small">Today's Worked</span>
                                            <span class="fw-bold" id="workedHours">{{ $workedHours ?? '0h 0m' }}</span>
                                        </div>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $workPercentage ?? 0 }}%;"></div>
                                        </div>
                                    </div>

                                    <!-- Punch Buttons -->
                                    <div class="mt-auto">
                                        <div class="d-grid gap-2">
                                            @if(!($isPunchedIn ?? false))
                                            <button class="btn btn-primary" id="punchInBtn">
                                                <i class="ti ti-login me-2"></i>Punch In
                                            </button>
                                            @else
                                            <button class="btn btn-danger" id="punchOutBtn">
                                                <i class="ti ti-logout me-2"></i>Punch Out
                                            </button>
                                            @endif
                                        </div>

                                        <!-- Details table -->
                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm table-borderless mb-0">
                                                <tr>
                                                    <td class="ps-0 small">Punch in time</td>
                                                    <td class="text-end fw-bold small" id="punchInDetail">{{ $punchInTime ?? '--:--' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 small">Punch out time</td>
                                                    <td class="text-end fw-bold small" id="punchOutDetail">{{ $punchOutTime ?? '--:--' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="ps-0 small">Total hours</td>
                                                    <td class="text-end fw-bold small" id="totalHoursDetail">{{ $workedHours ?? '0h 0m' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Summary Card -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Attendance Summary</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Present Days -->
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="avatar me-3 bg-success bg-opacity-10 p-3 rounded">
                                            <i class="ti ti-circle-check fs-3 text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Present Days</h6>
                                                    <small class="text-muted">This month</small>
                                                </div>
                                                <h3 class="mb-0 text-success fw-bold">{{ $totalPresent ?? 0 }}</h3>
                                            </div>
                                            <div class="progress mt-2" style="height: 6px;">
                                                @php
                                                $presentPercent = $daysInMonth > 0 ? round(($totalPresent / $daysInMonth) * 100) : 0;
                                                @endphp
                                                <div class="progress-bar bg-success" style="width: {{ $presentPercent }}%;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Absent Days -->
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="avatar me-3 bg-danger bg-opacity-10 p-3 rounded">
                                            <i class="ti ti-circle-x fs-3 text-danger"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Absent Days</h6>
                                                    <small class="text-muted">This month</small>
                                                </div>
                                                <h3 class="mb-0 text-danger fw-bold">{{ $totalAbsent ?? 0 }}</h3>
                                            </div>
                                            <div class="progress mt-2" style="height: 6px;">
                                                @php
                                                $absentPercent = $daysInMonth > 0 ? round(($totalAbsent / $daysInMonth) * 100) : 0;
                                                @endphp
                                                <div class="progress-bar bg-danger" style="width: {{ $absentPercent }}%;"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pending Leaves -->
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-3 bg-warning bg-opacity-10 p-3 rounded">
                                            <i class="ti ti-clock fs-3 text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">Pending Leaves</h6>
                                                    <small class="text-muted">Awaiting approval</small>
                                                </div>
                                                <h3 class="mb-0 text-warning fw-bold">{{ $pendingLeaves ?? 0 }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Card -->
                        <div class="col-xl-4 col-md-12 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Calendar</h5>
                                    <span class="badge bg-label-primary" id="calendarTime">{{ now()->format('h:i A') }}</span>
                                </div>
                                <div class="card-body">
                                    @php
                                    $today = new DateTime();
                                    $month = $today->format('F Y');
                                    $daysInMonth = $today->format('t');
                                    $firstDay = new DateTime($today->format('Y-m-01'));
                                    $startDay = $firstDay->format('w'); // 0 = Sunday
                                    @endphp

                                    <div class="text-center mb-3">
                                        <h6 class="fw-bold">{{ $month }}</h6>
                                    </div>

                                    <div class="calendar-container">
                                        <table class="calendar-table">
                                            <thead>
                                                <tr>
                                                    <th>Su</th>
                                                    <th>Mo</th>
                                                    <th>Tu</th>
                                                    <th>We</th>
                                                    <th>Th</th>
                                                    <th>Fr</th>
                                                    <th>Sa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $day = 1;
                                                $totalCells = $startDay + $daysInMonth;
                                                $rows = ceil($totalCells / 7);
                                                @endphp

                                                @for($row = 0; $row < $rows; $row++)
                                                    <tr>
                                                    @for($col = 0; $col < 7; $col++)
                                                        @php
                                                        $cellIndex = $row * 7 + $col;
                                                        @endphp

                                                        @if($cellIndex < $startDay || $cellIndex >= $startDay + $daysInMonth)
                                                        <td class="empty-cell"></td>
                                                        @else
                                                        @if($day == $today->format('j'))
                                                        <td class="today-cell">{{ $day++ }}</td>
                                                        @else
                                                        <td>{{ $day++ }}</td>
                                                        @endif
                                                        @endif
                                                        @endfor
                                                        </tr>
                                                        @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 3: Monthly Present vs Absent Bar Chart -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Monthly Attendance</h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            {{ $selectedYear ?? date('Y') }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($years ?? [] as $yr)
                                            <li><a class="dropdown-item" href="?year={{ $yr }}">{{ $yr }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px;">
                                        <canvas id="monthlyAttendanceChart"></canvas>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3 gap-4">
                                        <div><span class="badge bg-success me-2">&nbsp;&nbsp;&nbsp;</span> Present</div>
                                        <div><span class="badge bg-danger me-2">&nbsp;&nbsp;&nbsp;</span> Absent</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 4: Recent Activity -->
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <h5 class="card-title mb-0">Recent Activity</h5>
                                    <a href="{{ url('employee/my-leave') }}" class="text-primary">View all</a>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group list-group-flush">
                                        @forelse($recentActivities ?? [] as $activity)
                                        <li class="list-group-item px-0">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar flex-shrink-0 me-3">
                                                    <span class="avatar-initial rounded-circle bg-label-{{ $activity['color'] }}">
                                                        <i class="ti ti-{{ $activity['icon'] }}"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <p class="mb-0 fw-semibold">{{ $activity['title'] }}</p>
                                                    <small class="text-muted">{{ $activity['time'] }}</small>
                                                </div>
                                                <span class="badge bg-label-{{ $activity['badgeColor'] }}">{{ $activity['status'] }}</span>
                                            </div>
                                        </li>
                                        @empty
                                        <li class="list-group-item text-center text-muted">No recent activities</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>

<style>
    /* Calendar Styles */
    .calendar-container {
        width: 100%;
        overflow-x: auto;
    }

    .calendar-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        border: 1px solid #dee2e6;
        background-color: white;
    }

    .calendar-table th {
        text-align: center;
        padding: 8px 0;
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid #dee2e6;
        width: 14.28%;
    }

    .calendar-table td {
        text-align: center;
        padding: 8px 0;
        border: 1px solid #dee2e6;
        font-size: 0.85rem;
        width: 14.28%;
    }

    .calendar-table td.today-cell {
        background-color: rgb(241, 94, 48) !important;
        color: white !important;
        font-weight: bold;
    }

    .calendar-table td.empty-cell {
        background-color: #f8f9fa;
    }

    .card-body {
        padding: 1rem;
    }

    #calendarTime {
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    /* Progress Bars */
    .progress {
        background-color: #e9ecef !important;
        border-radius: 10px;
    }

    .progress-bar {
        color: white !important;
        font-weight: bold !important;
        border-radius: 10px;
    }

    /* Make all cards same height */
    .h-100 {
        height: 100% !important;
    }

    @media (max-width: 768px) {

        .calendar-table th,
        .calendar-table td {
            padding: 6px 0;
            font-size: 0.75rem;
        }
    }
</style>
@endsection

@push('script')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $(document).ready(function() {
        console.log('Dashboard script loaded');

        // ===== LIVE CLOCK for Time Tracker and Calendar ONLY =====
        function updateDateTime() {
            const now = new Date();

            // For Time Tracker (HH:MM format)
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}`;

            // For Calendar (HH:MM AM/PM format)
            const ampmHours = now.getHours() % 12 || 12;
            const ampm = now.getHours() >= 12 ? 'PM' : 'AM';
            const ampmTimeString = `${ampmHours.toString().padStart(2, '0')}:${minutes} ${ampm}`;

            // Update ONLY the time displays we want to keep
            $('#currentTime').text(timeString);
            $('#calendarTime').text(ampmTimeString);
        }
        updateDateTime();
        setInterval(updateDateTime, 60000);

        // ===== PUNCH DATA FROM CONTROLLER =====
        @if(isset($punchData))
        let punchData = @json($punchData);
        console.log('Punch Data:', punchData);

        let isPunchedIn = punchData.isPunchedIn;
        let punchInTime = punchData.punchInTime;
        let punchOutTime = punchData.punchOutTime;
        let workingHours = punchData.workingHours;

        // Update display with existing data
        if (punchInTime) {
            $('#punchInTime, #punchInDetail').text(punchInTime);
        }
        if (punchOutTime) {
            $('#punchOutTime, #punchOutDetail').text(punchOutTime);
        }
        if (workingHours) {
            $('#workedHours, #totalHoursDetail').text(workingHours);
        }
        @endif

        // ===== PUNCH IN FUNCTIONALITY =====
$('#punchInBtn').click(function(e) {
    e.preventDefault();
    console.log('Punch In clicked');

    $.ajax({
        url: '{{ route("employee.punch-in") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            timestamp: new Date().toISOString()
        },
        dataType: 'json',
        beforeSend: function() {
            $('#punchInBtn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>Processing...');
        },
        success: function(response) {
            console.log('Punch In response:', response);
            if (response.success) {
                location.reload();
            } else {
                alert(response.message || 'Punch in failed');
                $('#punchInBtn').prop('disabled', false).html('<i class="ti ti-login me-2"></i>Punch In');
            }
        },
        error: function(xhr, status, error) {
            console.error('Punch In error:', error);
            console.error('Response:', xhr.responseText);
            alert('Punch In failed. Please try again.');
            $('#punchInBtn').prop('disabled', false).html('<i class="ti ti-login me-2"></i>Punch In');
        }
    });
});

// ===== PUNCH OUT FUNCTIONALITY =====
$('#punchOutBtn').click(function(e) {
    e.preventDefault();
    console.log('Punch Out clicked');

    $.ajax({
        url: '{{ route("employee.punch-out") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            timestamp: new Date().toISOString()
        },
        dataType: 'json',
        beforeSend: function() {
            $('#punchOutBtn').prop('disabled', true).html('<i class="ti ti-loader me-2"></i>Processing...');
        },
        success: function(response) {
            console.log('Punch Out response:', response);
            if (response.success) {
                // Update the display immediately without reload
                if (response.working_hours) {
                    $('#workedHours, #totalHoursDetail').text(response.working_hours);
                }
                if (response.punch_out_time) {
                    $('#punchOutTime, #punchOutDetail').text(response.punch_out_time);
                }
                // Change button back to Punch In
                $('.punchOutBtn').replaceWith(`
                    <button class="btn btn-primary" id="punchInBtn">
                        <i class="ti ti-login me-2"></i>Punch In
                    </button>
                `);
                alert('Punched out successfully!');
            } else {
                alert(response.message || 'Punch out failed');
                $('#punchOutBtn').prop('disabled', false).html('<i class="ti ti-logout me-2"></i>Punch Out');
            }
        },
        error: function(xhr, status, error) {
            console.error('Punch Out error:', error);
            alert('Punch Out failed. Please try again.');
            $('#punchOutBtn').prop('disabled', false).html('<i class="ti ti-logout me-2"></i>Punch Out');
        }
    });
});

        // ===== MONTHLY ATTENDANCE CHART =====
        const ctx = document.getElementById('monthlyAttendanceChart');
        if (ctx) {
            @if(isset($monthlyPresentData) && isset($monthlyAbsentData))
            const presentData = @json($monthlyPresentData);
            const absentData = @json($monthlyAbsentData);

            const presentArray = Array.isArray(presentData) ? presentData : [0,0,0,0,0,0,0,0,0,0,0,0];
            const absentArray = Array.isArray(absentData) ? absentData : [0,0,0,0,0,0,0,0,0,0,0,0];

            new Chart(ctx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                            label: 'Present',
                            data: presentArray,
                            backgroundColor: '#28a745',
                            borderRadius: 6,
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        },
                        {
                            label: 'Absent',
                            data: absentArray,
                            backgroundColor: '#dc3545',
                            borderRadius: 6,
                            barPercentage: 0.7,
                            categoryPercentage: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Days'
                            }
                        }
                    }
                }
            });
            @endif
        }
    });
</script>
@endpush