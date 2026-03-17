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
                    <div class="page-header  d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0">Leave management</h5>
                        <div class="d-flex align-items-center justify-content-end">
                            <!-- <button class="btn btn-warning add-leave-btn" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                <i class="ti ti-plus"></i> Add new leave
                            </button> -->

                            <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                                aria-labelledby="offcanvasRightLabel">
                                <div class="offcanvas-header">
                                    <h2 id="offcanvasRightLabel"> Add new leave</h2>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <div class="mb-4">
                                        <label class="custom_lable">Leave type</label>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>Select leave type</option>
                                            <option value="1">First half</option>
                                            <option value="2">Second half</option>
                                            <option value="3">Full day</option>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="flatpickr-date" class="form-label custom_lable ">Start date</label>
                                        <input type="date" class="form-control" placeholder="Select start date"
                                            id="flatpickr-date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="flatpickr-date" class="form-label custom_lable ">End date</label>
                                        <input type="date" class="form-control" placeholder="Select End date"
                                            id="flatpickr-date" />
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput1" class="form-label custom_lable">Total
                                            day’s</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter day’s">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput1"
                                            class="form-label custom_lable">Reason</label>
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Your Reason">
                                    </div>

                                    <div class="d-flex gap-3 justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary from_btn">Cancel</button>
                                        <button type="button" class="btn btn-warning">Add</button>
                                    </div>
                                </div>
                            </div>
                            <div class="calendar-csvfile ms-3">
                                <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm rounded-pill">CSV files</a>
                            </div>
                        </div>


                    </div>


                    <div class="container-xxl flex-grow-1">
                        <ul class="nav nav-tabs  custom_tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link {{ empty($status) ? 'active' : '' }}" href="{{ route('attendance.index', array_filter(['leave_type' => $leaveType ?? null, 'name' => $name ?? null])) }}">All Leave</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($status ?? null) === 'pending' ? 'active' : '' }}" href="{{ route('attendance.index', array_filter(['status' => 'pending', 'leave_type' => $leaveType ?? null, 'name' => $name ?? null])) }}">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($status ?? null) === 'approved' ? 'active' : '' }}" href="{{ route('attendance.index', array_filter(['status' => 'approved', 'leave_type' => $leaveType ?? null, 'name' => $name ?? null])) }}">Approved</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ ($status ?? null) === 'rejected' ? 'active' : '' }}" href="{{ route('attendance.index', array_filter(['status' => 'rejected', 'leave_type' => $leaveType ?? null, 'name' => $name ?? null])) }}">Rejected</a>
                            </li>
                        </ul>
                        <div class="card ">
                            <div class="p-0">
                                <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                    <div class="d-flex flex-wrap align-items-center gap-2 px-3 pt-3">
                                        <div class="btn-group search_leave">
                                            <button type="button" class="btn btn-label-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $leaveType ?? 'Search leave type' }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('attendance.index', array_filter(['status' => $status ?? null, 'name' => $name ?? null])) }}">All</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('attendance.index', array_filter(['status' => $status ?? null, 'leave_type' => 'First half', 'name' => $name ?? null])) }}">First half</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('attendance.index', array_filter(['status' => $status ?? null, 'leave_type' => 'Second half', 'name' => $name ?? null])) }}">Second half</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('attendance.index', array_filter(['status' => $status ?? null, 'leave_type' => 'Full day', 'name' => $name ?? null])) }}">Full day</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <form method="GET" action="{{ route('attendance.index') }}" class="ms-auto" style="min-width: 280px;">
                                            <input type="hidden" name="status" value="{{ $status ?? '' }}">
                                            <input type="hidden" name="leave_type" value="{{ $leaveType ?? '' }}">
                                            @php
                                                $clearUrl = route('attendance.index', array_filter([
                                                    'status' => $status ?? null,
                                                    'leave_type' => $leaveType ?? null,
                                                ]));
                                            @endphp
                                            <div class="d-flex align-items-stretch gap-2">
                                                <div class="input-group input-group-sm">
                                                    <input type="text" name="name" class="form-control form-control-sm" placeholder="Search employee name" value="{{ $name ?? '' }}">
                                                    <button class="btn btn-primary btn-sm" type="submit">Search</button>
                                                </div>
                                                <a class="btn btn-outline-secondary btn-sm {{ empty($name) ? 'disabled' : '' }}" href="{{ $clearUrl }}" {{ empty($name) ? 'aria-disabled=true tabindex=-1' : '' }}>Clear</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="info-container ">
                                        @if($leaves->count() === 0)
                                            <div class="text-center text-muted py-4">No leave records found.</div>
                                        @else
                                        @foreach($leaves as $leave)
                                        @php
                                        $leaveDates = $leave->leave_dates;
                                            $datesWithTags = [];
                                            foreach ($leaveDates as $leaveDate) {
                                                $startDate = \Carbon\Carbon::parse($leaveDate['start_date']);
                                                $endDate = \Carbon\Carbon::parse($leaveDate['end_date']);
                                                $leaveType = $leaveDate['leave_type'];
                                    
                                                 while ($startDate->lte($endDate)) {
                                                    $datesWithTags[] = [
                                                        'date' => $startDate->format('d-M-Y'),
                                                        'leave_type' => $leaveType,
                                                        'status' => $leaveDate['status'],
                                                        'start_date' => $startDate->format('Y-m-d')
                                                    ];
                                                    $startDate->addDay();
                                                }
                                            }
                                        @endphp
                                        <small class="d-block border-top fw-normal text-uppercase text-muted "></small>
                                        <div class="d-flex justify-content-between leave_list " data-employee-id="{{ $leave->employee_id }}"  data-status="{{ $leave->leave_dates[0]['status'] }}">
                                            <ul class="list-unstyled  mb-0">
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Name:-</span>
                                                    <span>{{ $leave->employee->name }}</span>
                                                </li>
                                                @php
                                                    $displayLeaveType = $leave->leave_type ?? ($leaveDates[0]['leave_type'] ?? '');
                                                    $displayStartDate = $leave->start_date;
                                                    $displayEndDate = $leave->end_date;
                                                    if ((empty($displayStartDate) || empty($displayEndDate)) && !empty($leaveDates)) {
                                                        $startCandidates = collect($leaveDates)->pluck('start_date')->filter();
                                                        $endCandidates = collect($leaveDates)->pluck('end_date')->filter();
                                                        $displayStartDate = $displayStartDate ?: $startCandidates->first();
                                                        $displayEndDate = $displayEndDate ?: $endCandidates->last();
                                                    }
                                                @endphp
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Designation:-</span>
                                                    <span>{{ $leave->employee->designation }}</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Leave type:-</span>
                                                    <span>{{ $displayLeaveType }}</span>
                                                </li>
                                                <li class="mb-2">
                                                    <span class="fw-medium me-2">Range:-</span>
                                                    <span>{{ $displayStartDate }} to {{ $displayEndDate }}</span>
                                                </li>
                                                <li class="mb-2 d-flex align-items-start gap-2">
                                                    <span class="fw-medium">Date:-</span>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach($datesWithTags as $dateTag)
                                                            <div>
                                                                <input type="checkbox" 
                                                                       class="date-checkbox" 
                                                                       data-date="{{ $dateTag['start_date'] }}" 
                                                                       data-leave-type="{{ $dateTag['leave_type'] }}" 
                                                                       data-status="{{ $dateTag['status'] }}" 
                                                                       id="checkbox-{{ $dateTag['start_date'] }}" hidden>
                                                                @php
                                                                    $dateBadgeClass = 'bg-label-warning';
                                                                    if (($dateTag['status'] ?? 'pending') === 'approved') $dateBadgeClass = 'bg-label-success';
                                                                    if (($dateTag['status'] ?? 'pending') === 'rejected') $dateBadgeClass = 'bg-label-danger';
                                                                @endphp
                                                                <label for="checkbox-{{ $dateTag['start_date'] }}" class="badge {{ $dateBadgeClass }}">
                                                                    {{ $dateTag['date'] }} ({{ $dateTag['leave_type'] }})
                                                                </label>
                                                                <div class="dropdown mt-2" style="opacity: 0;" id="dropdown-{{ $dateTag['start_date'] }}">
                                                                    <ul class="dropdown-menu" style="display: block;">
                                                                        <li><a class="dropdown-item" href="#" data-status="pending">Pending</a></li>
                                                                        <li><a class="dropdown-item" href="#" data-status="approved">Approved</a></li>
                                                                        <li><a class="dropdown-item" href="#" data-status="rejected">Rejected</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </li>
                                                <li>
                                                    <span class="fw-medium me-2">Reason type:-</span>
                                                    <span>{{ $leave->reason }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column justify-content-between">
                                                <div class="d-flex">
                                                    <!-- Modal -->
                                                    <div class="modal fade " id="exampleModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <div class="modal-body ">
                                                                    <button type="button" class=" deleteicon-btn">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                    <h3 class="text-center">Are you sure!</h3>
                                                                    <h5 class="text-center mb-0">Are you sure want to
                                                                        reject this leave?</h5>
                                                                    <div
                                                                        class="modal-btns d-flex gap-4 justify-content-center ">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancel</button>
                                                                        <button type="button"
                                                                            class="btn btn-danger">Reject</button>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="demo-inline-spacing">
                                                    <button type="button" class="btn btn-secondary leave-balance-btn" data-employee-id="{{ $leave->employee_id }}" data-bs-toggle="modal" data-bs-target="#leaveBalanceModal">Leave
                                                        balance</button>
                                                   <button type="button" class="btn btn-success approve-btn" data-id="{{ $leave->id }}" {{ $leave->status === 'approved' ? 'disabled' : '' }}>Approve</button>

                                                    <button type="button" class="btn btn-danger reject-btn" data-id="{{ $leave->id }}" {{ $leave->status === 'rejected' ? 'disabled' : '' }}>Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4 px-3 pb-3">
                            <h6 class="mb-0">
                                @if($leaves->total() > 0)
                                    Showing {{ $leaves->firstItem() }} to {{ $leaves->lastItem() }} of {{ $leaves->total() }} entries
                                @else
                                    No entries to show
                                @endif
                            </h6>
                            <div>
                                {{ $leaves->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
</div>

        <div class="modal fade" id="leaveBalanceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mb-0">Leave balance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="text-muted small">Employee</div>
                            <div class="fw-semibold" id="leaveBalanceEmployee">-</div>
                            <div class="text-muted small" id="leaveBalanceDesignation"></div>
                        </div>

                        <div class="row g-2">
                            <div class="col-12 col-sm-4">
                                <div class="border rounded-3 p-3">
                                    <div class="text-muted small">Approved days</div>
                                    <div class="fs-4 fw-bold" id="leaveBalanceApprovedDays">0</div>
                                    <div class="text-muted small">Requests: <span id="leaveBalanceApprovedReq">0</span></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="border rounded-3 p-3">
                                    <div class="text-muted small">Pending days</div>
                                    <div class="fs-4 fw-bold" id="leaveBalancePendingDays">0</div>
                                    <div class="text-muted small">Requests: <span id="leaveBalancePendingReq">0</span></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="border rounded-3 p-3">
                                    <div class="text-muted small">Rejected days</div>
                                    <div class="fs-4 fw-bold" id="leaveBalanceRejectedDays">0</div>
                                    <div class="text-muted small">Requests: <span id="leaveBalanceRejectedReq">0</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-muted small">Total requests: <span id="leaveBalanceTotalReq">0</span></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Layout wrapper -->

   @endsection
@push('script')
<script>
$(document).ready(function(){
      $(document).on('click', '.date-checkbox', function() {
            var date = $(this).data('date');
            var leaveType = $(this).data('leave-type');
            var currentStatus = $(this).data('status');
    
            var dropdown = $('#dropdown-' + date);
            dropdown.css('opacity', dropdown.css('opacity') === '1' ? '0' : '1');
    
            $('#dropdown-' + date + ' .dropdown-item').each(function() {
                if ($(this).data('status') === currentStatus) {
                    $(this).addClass('active'); 
                } else {
                    $(this).removeClass('active');
                }
            });
        });
    $(document).on('click', '.info-container .dropdown-item', function() {
        var newStatus = $(this).data('status');
        var date = $(this).closest('li.d-inline-block').find('.date-checkbox').data('date');
        var leaveType = $(this).closest('li.d-inline-block').find('.date-checkbox').data('leave-type');
        var employeeId = $(this).closest('.leave_list').data('employee-id');
        
        $('#checkbox-' + date).data('status', newStatus);

        var label = $('#checkbox-' + date).siblings('label');
        label.removeClass('bg-label-success bg-label-warning bg-label-danger');
        if (newStatus === 'approved') {
            label.addClass('bg-label-success');
        } else if (newStatus === 'rejected') {
            label.addClass('bg-label-danger');
        } else {
            label.addClass('bg-label-warning');
        }

        $(this).closest('.dropdown').css('opacity', '0');

        $.ajax({
            url: '/admin/update-leave-status',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                employee_id: employeeId,
                date: date,
                leave_type: leaveType,
                status: newStatus
            },
            success: function(response) {
                console.log('Status updated successfully!');
            },
            error: function(xhr, status, error) {
                console.log('Error updating status: ' + error);
                alert('Error updating status');
            }
        });
    });
});
</script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    $(document).ready(function () {
        const formatNumber = function (value) {
            const n = Number(value || 0);
            return Number.isInteger(n) ? String(n) : n.toFixed(1);
        };

        $(document).on('click', '.leave-balance-btn', function () {
            const employeeId = $(this).data('employee-id');
            if (!employeeId) return;

            $('#leaveBalanceEmployee').text('Loading...');
            $('#leaveBalanceDesignation').text('');
            $('#leaveBalanceApprovedDays').text('...');
            $('#leaveBalancePendingDays').text('...');
            $('#leaveBalanceRejectedDays').text('...');
            $('#leaveBalanceTotalReq').text('...');
            $('#leaveBalanceApprovedReq').text('...');
            $('#leaveBalancePendingReq').text('...');
            $('#leaveBalanceRejectedReq').text('...');

            $.ajax({
                url: '/admin/leave-balance/' + employeeId,
                type: 'GET',
                success: function (response) {
                    $('#leaveBalanceEmployee').text(response?.employee?.name || '-');
                    $('#leaveBalanceDesignation').text(response?.employee?.designation || '');

                    $('#leaveBalanceApprovedDays').text(formatNumber(response?.days?.approved));
                    $('#leaveBalancePendingDays').text(formatNumber(response?.days?.pending));
                    $('#leaveBalanceRejectedDays').text(formatNumber(response?.days?.rejected));

                    $('#leaveBalanceTotalReq').text(response?.requests?.total ?? 0);
                    $('#leaveBalanceApprovedReq').text(response?.requests?.approved ?? 0);
                    $('#leaveBalancePendingReq').text(response?.requests?.pending ?? 0);
                    $('#leaveBalanceRejectedReq').text(response?.requests?.rejected ?? 0);
                },
                error: function () {
                    $('#leaveBalanceEmployee').text('Failed to load');
                    $('#leaveBalanceDesignation').text('');
                    $('#leaveBalanceApprovedDays').text('0');
                    $('#leaveBalancePendingDays').text('0');
                    $('#leaveBalanceRejectedDays').text('0');
                    $('#leaveBalanceTotalReq').text('0');
                    $('#leaveBalanceApprovedReq').text('0');
                    $('#leaveBalancePendingReq').text('0');
                    $('#leaveBalanceRejectedReq').text('0');
                }
            });
        });

        $(document).on('click', '.approve-btn', function () {
            var leaveId = $(this).data('id');
            if (!confirm('Approve this leave?')) return;

            $.ajax({
                url: '/admin/leave/approve/' + leaveId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        window.location.reload();
                    } else {
                        alert(response.message || 'Failed to approve');
                    }
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        });

        $(document).on('click', '.reject-btn', function () {
            var leaveId = $(this).data('id');
            if (!confirm('Reject this leave?')) return;

            $.ajax({
                url: '/admin/leave/reject/' + leaveId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        window.location.reload();
                    } else {
                        alert(response.message || 'Failed to reject');
                    }
                },
                error: function () {
                    alert('Something went wrong!');
                }
            });
        });
    });

</script>
@endpush