@extends('layouts.app')

@section('auth-content')
<style>
    #offcanvasRight {
        overflow-y: auto;
        height: 100vh;
    }

    .leave_list {
        padding: 1rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .leave_list:last-child {
        border-bottom: none;
    }
</style>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('employee.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
            @include('employee.header')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="page-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Leave</h5>
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <button class="btn btn-primary add-leave-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="ti ti-plus"></i> Add new leave
                        </button>

                        <!-- Offcanvas Form -->
                        <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <form id="leaveForm"
                                action="{{ route('employee.my-leave.store') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="leaves_id" id="modalLeavesId">

                                <div class="offcanvas-header border-bottom py-3">
                                    <h5 class="mb-0 fw-semibold" id="offcanvasRightLabel">
                                        Add New Leave
                                    </h5>
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>

                                <div class="offcanvas-body pt-3">
                                    <!-- Repeater container for leave requests -->
                                    <div id="leaveRepeater">
                                        <!-- Template for a single leave request -->
                                        <div class="leave-request border rounded-3 p-3 mb-3">
                                            <div class="mb-3">
                                                <label class="custom_lable">Leave type</label>
                                                <select class="form-select leavestatus" name="leavestatus[]" required>
                                                    <option value="" disabled selected>Select leave type</option>
                                                    <option value="1">First half</option>
                                                    <option value="2">Second half</option>
                                                    <option value="3">Full day</option>
                                                </select>
                                                @error('leavestatus.*')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label custom_lable">Start date</label>
                                                <input type="date" name="leaveStartDate[]" class="form-control leaveStartDate" placeholder="Select start date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label custom_lable">End date</label>
                                                <input type="date" name="leaveEndDate[]" class="form-control leaveEndDate" placeholder="Select end date" required>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-danger remove-leave">Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="addLeaveRequest" class="btn btn-primary w-100 mt-2">
                                        Add Another Leave Request
                                    </button>

                                    <div class="mb-3 mt-3">
                                        <label for="leaveTotalDay" class="form-label custom_lable">Total day's</label>
                                        <input type="text" name="leaveTotalDay"
                                            class="form-control @error('leaveTotalDay') is-invalid @enderror"
                                            placeholder="Enter day's" id="leaveTotalDay"
                                            value="{{ old('leaveTotalDay') }}"
                                            required readonly />
                                        @error('leaveTotalDay')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="leaveReason" class="form-label custom_lable">Reason</label>
                                        <input type="text" name="leaveReason"
                                            class="form-control @error('leaveReason') is-invalid @enderror"
                                            placeholder="Enter Your Reason" id="leaveReason"
                                            value="{{ old('leaveReason') }}"
                                            required />
                                        @error('leaveReason')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <!-- Submit form -->
                                    <div class="d-flex gap-3 justify-content-end mt-4">
                                        <button type="button" class="btn btn-outline-secondary from_btn" data-bs-dismiss="offcanvas">Cancel</button>
                                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- CSV Files Button -->
                        <a href="{{ url('employee/my-leave/csv') }}" class="btn btn-outline-secondary add-leave-btn">
                        <i class="ti ti-file-analytics me-1"></i>CSV
                        </a>
                    </div>
                </div>

                <div class="container-xxl flex-grow-1">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs custom_tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ empty($status) ? 'active' : '' }}"
                                href="{{ route('employee.my-leave', array_filter(['leave_type' => $leaveType ?? null])) }}">
                                All Leave
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'pending' ? 'active' : '' }}"
                                href="{{ route('employee.my-leave', array_filter(['status' => 'pending', 'leave_type' => $leaveType ?? null])) }}">
                                Pending
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'approved' ? 'active' : '' }}"
                                href="{{ route('employee.my-leave', array_filter(['status' => 'approved', 'leave_type' => $leaveType ?? null])) }}">
                                Approved
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'rejected' ? 'active' : '' }}"
                                href="{{ route('employee.my-leave', array_filter(['status' => 'rejected', 'leave_type' => $leaveType ?? null])) }}">
                                Rejected
                            </a>
                        </li>
                    </ul>

                    <!-- Leave List Card -->
                    <div class="card mt-3">
                        <div class="card-body p-0">
                            <!-- Search Filter -->
                            <div class="p-3 border-bottom">
                                <div class="btn-group search_leave">
                                    <button type="button" class="btn btn-label-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $leaveType ?? 'Search leave type' }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employee.my-leave', array_filter(['status' => $status ?? null])) }}">
                                                All
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employee.my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'First half'])) }}">
                                                First half
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employee.my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'Second half'])) }}">
                                                Second half
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('employee.my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'Full day'])) }}">
                                                Full day
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Leave Records -->
                            <div class="info-container p-3">
                                @if($leaves->isEmpty())
                                <div class="text-center text-muted py-5">
                                    <i class="ti ti-calendar-off fs-1 mb-3 d-block"></i>
                                    <h5>No leave records found</h5>
                                    <p>Click "Add new leave" to create your first leave request</p>
                                </div>
                                @else
                                @foreach($leaves as $leave)
                                @php
                                $displayLeaveType = $leave->leave_type;
                                $displayStartDate = \Carbon\Carbon::parse($leave->start_date)->format('d M Y');
                                $displayEndDate = \Carbon\Carbon::parse($leave->end_date)->format('d M Y');

                                $badgeClass = 'bg-label-secondary';
                                if ($leave->status === 'pending') $badgeClass = 'bg-label-warning';
                                if ($leave->status === 'approved') $badgeClass = 'bg-label-success';
                                if ($leave->status === 'rejected') $badgeClass = 'bg-label-danger';
                                @endphp

                                <div class="leave_list">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-semibold mb-2">{{ $displayLeaveType }}</h6>
                                            <div class="text-muted small mb-2">
                                                <i class="ti ti-calendar me-1"></i>
                                                {{ $displayStartDate }} to {{ $displayEndDate }}
                                            </div>
                                            <div class="small mb-2">
                                                <span class="text-muted">Total days:</span>
                                                <span class="fw-medium ms-1">{{ $leave->total_days }}</span>
                                            </div>
                                            <div class="small">
                                                <span class="text-muted">Reason:</span>
                                                <span class="fw-medium ms-1">{{ $leave->reason }}</span>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-column align-items-end gap-3">
                                            <!-- Delete Button Only -->
                                            <button type="button" class="bg-transparent border-0 p-0"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $leave->id }}">
                                                <i class="ti ti-trash fs-5 text-danger"></i>
                                            </button>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal-{{ $leave->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel-{{ $leave->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center p-4">
                                                            <div class="mb-3">
                                                                <span class="avatar-initial rounded-circle bg-label-danger p-3 d-inline-flex">
                                                                    <i class="ti ti-trash fs-2"></i>
                                                                </span>
                                                            </div>
                                                            <h4 class="mb-2">Are you sure?</h4>
                                                            <p class="text-muted mb-4">Do you really want to delete this leave request?</p>
                                                            <div class="d-flex gap-3 justify-content-center">
                                                                <button type="button" class="btn btn-outline-secondary px-4"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <form method="POST" action="{{ route('employee.my-leave.destroy', $leave->id) }}" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger px-4">Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Status Badge -->
                                            <span class="badge {{ $badgeClass }} text-uppercase px-3 py-2">
                                                {{ $leave->status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                            </div>

                            <!-- Pagination -->
                            @if($leaves->total() > 0)
                            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                <small class="text-muted">
                                    Showing {{ $leaves->firstItem() }} to {{ $leaves->lastItem() }} of {{ $leaves->total() }} entries
                                </small>
                                <div>
                                    {{ $leaves->links() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        console.log('Leave page loaded');

        // Calculate total days
        const calculateDays = function() {
            let totalDays = 0;

            $('.leave-request').each(function() {
                const leaveTypeValue = $(this).find('.leavestatus').val();
                const startDate = new Date($(this).find('.leaveStartDate').val());
                const endDate = new Date($(this).find('.leaveEndDate').val());

                if (leaveTypeValue && !isNaN(startDate.getTime()) && !isNaN(endDate.getTime()) && endDate >= startDate) {
                    let days = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;

                    if (leaveTypeValue === '1' || leaveTypeValue === '2') {
                        days = 0.5;
                    }

                    totalDays += days;
                }
            });

            const roundedTotal = Math.round(totalDays * 10) / 10;
            const displayTotal = Number.isInteger(roundedTotal) ? String(roundedTotal) : roundedTotal.toFixed(1);

            $('#leaveTotalDay').val(displayTotal);
        }

        // Listen for changes
        $(document).on('change', '.leavestatus, .leaveStartDate, .leaveEndDate', calculateDays);

        // Add new leave request
        $('#addLeaveRequest').on('click', function() {
            let leaveRepeater = $('#leaveRepeater');
            let newLeaveRequest = $('.leave-request').first().clone();

            newLeaveRequest.find('input').val('');
            newLeaveRequest.find('select').val('');
            leaveRepeater.append(newLeaveRequest);

            calculateDays();
        });

        // Remove leave request
        $(document).on('click', '.remove-leave', function() {
            if ($('.leave-request').length > 1) {
                $(this).closest('.leave-request').remove();
                calculateDays();
            } else {
                alert('At least one leave request must remain.');
            }
        });
    });
</script>
@endpush