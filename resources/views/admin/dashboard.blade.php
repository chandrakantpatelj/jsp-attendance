@extends('layouts.app')

@section('auth-content')
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('admin.sidebar')

        <div class="layout-page">
            @include('admin.header')

            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Page Header with Stats Summary -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold py-3 mb-0">HR Dashboard</h4>
                            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name }}</p>
                        </div>
                        <div class="d-flex gap-3 align-items-center">
                            <span class="badge bg-label-primary px-3 py-2 rounded-pill">
                                <i class="ti ti-calendar me-1"></i> {{ now()->format('l, d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats Cards - ALL IN ONE ROW (6 cards) - NO BORDERS -->
                    <div class="row g-3 mb-4">
                        <!-- Total Employees -->
                        <div class="col">
                            <div class="card compact-card h-100">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-muted small mb-1">Total Employees</p>
                                        <h5 class="fw-bold mb-0">{{ $totalEmployees ?? 0 }}</h5>
                                    </div>
                                    <div class="avatar bg-label-primary rounded-circle">
                                        <i class="ti ti-users"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Present Today -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted text-uppercase small fw-semibold">PRESENT</span>
                                            <h3 class="fw-bold mt-1 mb-0">{{ $presentToday ?? 0 }}</h3>
                                            <small class="text-success">{{ $presentPercentage ?? 0 }}%</small>
                                        </div>
                                        <div class="avatar rounded-circle bg-success bg-opacity-10 p-2">
                                            <i class="ti ti-user-check fs-5 text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- On Leave Today -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted text-uppercase small fw-semibold">ON LEAVE</span>
                                            <h3 class="fw-bold mt-1 mb-0">{{ $onLeaveToday ?? 0 }}</h3>
                                            <small class="text-warning">{{ $leavePercentage ?? 0 }}%</small>
                                        </div>
                                        <div class="avatar rounded-circle bg-warning bg-opacity-10 p-2">
                                            <i class="ti ti-calendar-off fs-5 text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Absent Today -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted text-uppercase small fw-semibold">ABSENT</span>
                                            <h3 class="fw-bold mt-1 mb-0">{{ $absentToday ?? 0 }}</h3>
                                        </div>
                                        <div class="avatar rounded-circle bg-danger bg-opacity-10 p-2">
                                            <i class="ti ti-user-x fs-5 text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pending Approvals -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted text-uppercase small fw-semibold">PENDING</span>
                                            <h3 class="fw-bold mt-1 mb-0">{{ $pendingLeaves ?? 0 }}</h3>
                                            <small class="text-info">{{ $pendingLeavesPercentage ?? 0 }}%</small>
                                        </div>
                                        <div class="avatar rounded-circle bg-info bg-opacity-10 p-2">
                                            <i class="ti ti-clipboard-list fs-5 text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Regularizations -->
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="text-muted text-uppercase small fw-semibold">REGULAR</span>
                                            <h3 class="fw-bold mt-1 mb-0">{{ $pendingRegularizations ?? 0 }}</h3>
                                            <small class="text-warning">{{ $pendingRegPercentage ?? 0 }}%</small>
                                        </div>
                                        <div class="avatar rounded-circle bg-warning bg-opacity-10 p-2">
                                            <i class="ti ti-adjustments-horizontal fs-5 text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Attendance Chart -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0">
                                    <h5 class="card-title mb-0 fw-semibold">
                                        Monthly Attendance Overview - {{ $selectedYear }}
                                    </h5>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                            <i class="ti ti-calendar me-1"></i> {{ $selectedYear }}
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            @foreach($years as $yr)
                                            <li><a class="dropdown-item {{ $yr == $selectedYear ? 'active' : '' }}" href="?year={{ $yr }}">{{ $yr }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div style="height: 400px; width: 100%;">
                                        <canvas id="monthlyAttendanceChart"></canvas>
                                    </div>
                                    
                                    <!-- Legend -->
                                    <div class="d-flex justify-content-center mt-4 gap-4">
                                        <div class="d-flex align-items-center">
                                            <span style="display: inline-block; width: 20px; height: 16px; background-color: #28a745; border-radius: 4px; margin-right: 8px;"></span>
                                            <span class="fw-medium">Present</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="display: inline-block; width: 20px; height: 16px; background-color: #ffc107; border-radius: 4px; margin-right: 8px;"></span>
                                            <span class="fw-medium">On Leave</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span style="display: inline-block; width: 20px; height: 16px; background-color: #dc3545; border-radius: 4px; margin-right: 8px;"></span>
                                            <span class="fw-medium">Absent</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 border-0">
                                    <h5 class="card-title mb-0 fw-semibold">
                                        Recent Activities
                                    </h5>
                                    <a href="{{ route('admin.regularizations') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        View All
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Recent Leave Requests -->
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="ti ti-calendar-stats me-2 text-warning"></i>
                                                Recent Leave Requests
                                            </h6>
                                            @forelse($recentLeaves ?? [] as $leave)
                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <div>
                                                    <p class="mb-0 fw-medium">{{ $leave->employee->name }}</p>
                                                    <small class="text-muted">{{ $leave->leave_type }} • {{ \Carbon\Carbon::parse($leave->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M') }}</small>
                                                </div>
                                                <span class="badge bg-label-warning rounded-pill px-3">{{ ucfirst($leave->status) }}</span>
                                            </div>
                                            @empty
                                            <p class="text-muted text-center py-3">No recent leave requests</p>
                                            @endforelse
                                        </div>
                                        
                                        <!-- Recent Regularization Requests -->
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="ti ti-adjustments-horizontal me-2 text-info"></i>
                                                Recent Regularization Requests
                                            </h6>
                                            @forelse($recentRegularizations ?? [] as $reg)
                                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                                <div>
                                                    <p class="mb-0 fw-medium">{{ $reg->user->name }}</p>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($reg->created_at)->format('d M, h:i A') }}</small>
                                                </div>
                                                <span class="badge bg-label-info rounded-pill px-3">Pending</span>
                                            </div>
                                            @empty
                                            <p class="text-muted text-center py-3">No recent regularization requests</p>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
}
.border-0 {
    border: none !important;
}
.card-header.border-0 {
    border-bottom: none !important;
}
</style>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('monthlyAttendanceChart');
    if (ctx) {
        const presentData = @json($monthlyPresent);
        const absentData = @json($monthlyAbsent);
        const leaveData = @json($monthlyLeave);

        const maxValue = Math.max(...presentData, ...leaveData, ...absentData, {{ $totalEmployees ?? 20 }});
        const yAxisMax = Math.ceil(maxValue / 5) * 5;

        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Present',
                        data: presentData,
                        backgroundColor: '#28a745',
                        borderRadius: 6,
                        barThickness: 22,
                        maxBarThickness: 28,
                        borderSkipped: false
                    },
                    {
                        label: 'On Leave',
                        data: leaveData,
                        backgroundColor: '#ffc107',
                        borderRadius: 6,
                        barThickness: 22,
                        maxBarThickness: 28,
                        borderSkipped: false
                    },
                    {
                        label: 'Absent',
                        data: absentData,
                        backgroundColor: '#dc3545',
                        borderRadius: 6,
                        barThickness: 22,
                        maxBarThickness: 28,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#e2e8f0',
                        padding: 10,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 12, weight: '600' },
                            maxRotation: 0
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: yAxisMax,
                        ticks: { stepSize: 5 },
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        title: {
                            display: true,
                            text: 'Number of Employees',
                            font: { size: 12, weight: '600' }
                        }
                    }
                },
                layout: {
                    padding: { top: 20, bottom: 10, left: 10, right: 10 }
                }
            }
        });
    }
});
</script>
@endpush