@extends('layouts.app')
@section('auth-content')
<style>
    #offcanvasRight {
        overflow-y: auto;
        height: 100vh;
    }
</style>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->

        @include('employee.sidebar')
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('employee.header')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="page-header  d-flex justify-content-between align-items-center ">
                    <h5 class="mb-0">My Leave</h5>
                    <div class="d-flex align-items-center justify-content-end">
                        <button class="btn btn-primary add-leave-btn" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="ti ti-plus"></i> Add new leave
                        </button>
                        <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight"
                            aria-labelledby="offcanvasRightLabel">
                            <form id="leaveForm"
                                  action="{{ isset($editLeave) ? route('my-leave.update', $editLeave->id) : route('my-leave.store') }}"
                                  method="POST">
                                @csrf
                                @if(isset($editLeave))
                                    @method('PUT')
                                @endif
                                <input type="hidden" name="leaves_id" id="modalLeavesId">
                            
                                <div class="offcanvas-header border-bottom py-3">
                                    <h5 class="mb-0 fw-semibold" id="offcanvasRightLabel">{{ isset($editLeave) ? 'Edit Leave' : 'Add New Leave' }}</h5>
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
                                                <select class="form-select leavestatus" name="leavestatus[]" id="leavestatus" required>
                                                    <option value="" disabled selected>Select leave type</option>
                                                    <option value="1" {{ in_array('1', old('leavestatus', [])) ? 'selected' : '' }}>First half</option>
                                                    <option value="2" {{ in_array('2', old('leavestatus', [])) ? 'selected' : '' }}>Second half</option>
                                                    <option value="3" {{ in_array('3', old('leavestatus', [])) ? 'selected' : '' }}>Full day</option>
                                                </select>
                                                 @error('leavestatus.*')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="leaveStartDate" class="form-label custom_lable">Start date</label>
                                                <input type="date" name="leaveStartDate[]" class="form-control leaveStartDate" placeholder="Select start date" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="leaveEndDate" class="form-label custom_lable">End date</label>
                                                <input type="date" name="leaveEndDate[]" class="form-control leaveEndDate" placeholder="Select end date" required>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-danger remove-leave">Remove</button>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="addLeaveRequest" class="btn btn-primary w-100 mt-2">Add Another Leave Request</button>
                                    <div class="mb-3 mt-3">
                                            <label for="leaveTotalDay" class="form-label custom_lable">Total
                                                day’s</label>
                                            <input type="text" name="leaveTotalDay"
                                                class="form-control @error('leaveTotalDay') is-invalid @enderror"
                                                placeholder="Enter day’s" id="leaveTotalDay"
                                                value="{{ old('leaveTotalDay', isset($editLeave) ? (((float) $editLeave->total_days == (int) $editLeave->total_days) ? (int) $editLeave->total_days : $editLeave->total_days) : '') }}"
                                                required autofocus readonly/>
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
                                                value="{{ old('leaveReason', isset($editLeave) ? $editLeave->reason : '') }}"
                                                required autofocus />
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
                        <div class="calendar-csvfile ms-3">
                            <h5 class="mb-0"> <i class="ti ti-file-analytics"></i>CSV files</h5>
                        </div>
                    </div>


                </div>


                <div class="container-xxl flex-grow-1">
                    <ul class="nav nav-tabs  custom_tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ empty($status) ? 'active' : '' }}" href="{{ route('my-leave', array_filter(['leave_type' => $leaveType ?? null])) }}">All Leave</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'pending' ? 'active' : '' }}" href="{{ route('my-leave', array_filter(['status' => 'pending', 'leave_type' => $leaveType ?? null])) }}">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'approved' ? 'active' : '' }}" href="{{ route('my-leave', array_filter(['status' => 'approved', 'leave_type' => $leaveType ?? null])) }}">Approved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($status ?? null) === 'rejected' ? 'active' : '' }}" href="{{ route('my-leave', array_filter(['status' => 'rejected', 'leave_type' => $leaveType ?? null])) }}">Rejected</a>
                        </li>
                    </ul>
                    <div class="card ">
                        <div class="p-0">
                            <div class="tab-pane fade show active" id="navs-justified-new" role="tabpanel">
                                <div class="btn-group search_leave">
                                    <button type="button" class="btn btn-label-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ $leaveType ?? 'Search leave type' }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my-leave', array_filter(['status' => $status ?? null])) }}">All</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'First half'])) }}">First half</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'Second half'])) }}">Second half</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('my-leave', array_filter(['status' => $status ?? null, 'leave_type' => 'Full day'])) }}">Full day</a>
                                        </li>
                                    </ul>

                                </div>
                                <div class="info-container ">
                                    
                                    @if($leaves->isEmpty())
                                        <div class="text-center text-muted py-4">No leave records found.</div>
                                    @else
                                    @foreach($leaves as $leave)
                                    @php
                                        $leaveDates = is_array($leave->leave_dates) ? $leave->leave_dates : [];
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
                                    <div class="d-flex justify-content-between align-items-start leave_list ">
                                        <div>
                                            <div class="fw-medium">{{ $displayLeaveType }}</div>
                                            <div class="text-muted small">{{ $displayStartDate }} to {{ $displayEndDate }}</div>
                                            <div class="small">Total days: <span class="fw-medium">{{ $leave->total_days }}</span></div>
                                            <div class="small">Reason: <span class="fw-medium">{{ $leave->reason }}</span></div>
                                        </div>
                                        <div class="d-flex flex-column align-items-end gap-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <button type="button" class="bg-transparent border-0 p-0"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $leave->id }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade " id="deleteModal-{{ $leave->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel-{{ $leave->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">

                                                            <div class="modal-body ">
                                                                <button type="button" class=" deleteicon-btn">
                                                                    <i class="ti ti-trash"></i>
                                                                </button>
                                                                <h3 class="text-center">Are you sure!</h3>
                                                                <h5 class="text-center mb-0">Are you sure want to
                                                                    delete this leave?</h5>
                                                                <div class="modal-btns d-flex gap-3 justify-content-center mt-4">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form method="POST" action="{{ route('my-leave.destroy', $leave->id) }}" class="m-0 d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                                    </form>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="bg-transparent border-0 p-0" href="{{ route('my-leave.edit', $leave->id) }}">
                                                    <i class="ti ti-edit"></i>
                                                </a>
                                            </div>
                                            @php
                                                $badgeClass = 'bg-label-secondary';
                                                if ($leave->status === 'pending') $badgeClass = 'bg-label-warning';
                                                if ($leave->status === 'approved') $badgeClass = 'bg-label-success';
                                                if ($leave->status === 'rejected') $badgeClass = 'bg-label-danger';
                                            @endphp
                                            <span class="badge {{ $badgeClass }} text-uppercase">{{ $leave->status }}</span>
                                        </div>
                                    </div>
                                    <small class="d-block border-top fw-normal text-uppercase text-muted "></small>
                                    @endforeach
                                    @endif
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
    </div>
    @endsection
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

@if(isset($editLeave))
@php
    $leaveTypeMap = [
        'first half' => '1',
        'second half' => '2',
        'full day' => '3',
    ];

    $leaveData = collect($editLeave->leave_dates ?? [])->map(function ($item) use ($leaveTypeMap) {
        $start = $item['start_date'] ?? null;
        $end = $item['end_date'] ?? null;
        $typeKey = strtolower(trim((string) ($item['leave_type'] ?? 'full day')));

        return [
            'leavestatus' => $leaveTypeMap[$typeKey] ?? '3',
            'leaveStartDate' => $start ? \Carbon\Carbon::parse($start)->format('Y-m-d') : null,
            'leaveEndDate' => $end ? \Carbon\Carbon::parse($end)->format('Y-m-d') : null,
        ];
    })->values();
@endphp
<script>
    window.leaveData = @json($leaveData);

    document.addEventListener('DOMContentLoaded', function () {
        var offcanvasEl = document.getElementById('offcanvasRight');
        if (!offcanvasEl) return;
        var offcanvas = new bootstrap.Offcanvas(offcanvasEl);
        offcanvas.show();
    });
</script>
@endif
    <script>
    $(document).ready(function () { 
        // const calculateDays = function () { alert();
        //     const leaveTypeValue = $('#leavestatus').val();
        //     const startDate = new Date($('#leaveStartDate').val());
        //     const endDate = new Date($('#leaveEndDate').val());

        //     if (!leaveTypeValue || isNaN(startDate.getTime()) || isNaN(endDate.getTime()) || endDate < startDate) {
        //         $('#leaveTotalDay').val('');
        //         return;
        //     }

        //     let totalDays = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;

        //     if (leaveTypeValue === '1' || leaveTypeValue === '2') {
        //         totalDays -= 0.5;
        //     }

        //     $('#leaveTotalDay').val(totalDays.toFixed(1));
        // };

        // $(document).on('change', '#leavestatus, #leaveStartDate, #leaveEndDate', calculateDays);
        
        // $(document).on('change', '.leaveStartDate, .leaveEndDate', function () {
        //     calculateTotalDays();
        // });

        // function calculateTotalDays() {
        //     let totalDays = 0;
        //     $('.leave-request').each(function () {
        //         let startDate = $(this).find('.leaveStartDate').val();
        //         let endDate = $(this).find('.leaveEndDate').val();

        //         if (startDate && endDate) {
        //             let start = new Date(startDate);
        //             let end = new Date(endDate);
        //             let days = (end - start) / (1000 * 60 * 60 * 24) + 1;
        //             totalDays += days > 0 ? days : 0;
        //         }
        //     });

        //     $('#leaveTotalDay').val(totalDays);
        // }
        const calculateDays = function () {
            let totalDays = 0; 
        
            $('.leave-request').each(function () {
                const leaveTypeValue = $(this).find('.leavestatus').val();
                const startDate = new Date($(this).find('.leaveStartDate').val());
                const endDate = new Date($(this).find('.leaveEndDate').val());
        
                if (leaveTypeValue && !isNaN(startDate.getTime()) && !isNaN(endDate.getTime()) && endDate >= startDate) {
                    let days = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1;
        
                    if (leaveTypeValue === '1' || leaveTypeValue === '2') {
                        days -= 0.5;
                    }
                    if (leaveTypeValue === '3') {
                        days = Math.max(days, 1);
                    }
        
                    totalDays += days;
                }
            });

            const roundedTotal = Math.round(totalDays * 10) / 10;
            const displayTotal = Number.isInteger(roundedTotal)
                ? String(roundedTotal)
                : roundedTotal.toFixed(1);

            $('#leaveTotalDay').val(displayTotal);
        }  
        
        $(document).on('change', '.leavestatus, .leaveStartDate, .leaveEndDate', calculateDays);
        
        
        $('#addLeaveRequest').on('click', function () {
            let leaveRepeater = $('#leaveRepeater');
            let newLeaveRequest = $('.leave-request').first().clone(); // Clone the first request
    
            // Clear input fields in the cloned request
            newLeaveRequest.find('input').val('');
            newLeaveRequest.find('select').val('');
            leaveRepeater.append(newLeaveRequest); // Append the cloned request
        });
    
        // Remove leave request
        $(document).on('click', '.remove-leave', function () {
            if ($('.leave-request').length > 1) {
                $(this).closest('.leave-request').remove();
            } else {
                alert('At least one leave request must remain.');
            }
        });
    
        // Populate form in edit mode (example JSON from backend)
        if (typeof leaveData !== 'undefined' && leaveData.length > 0) {
            leaveData.forEach(function (leave, index) {
                if (index > 0) $('#addLeaveRequest').click(); 
                let lastRequest = $('.leave-request').last();
                lastRequest.find('.leavestatus').val(leave.leavestatus);
                lastRequest.find('.leaveStartDate').val(leave.leaveStartDate);
                lastRequest.find('.leaveEndDate').val(leave.leaveEndDate);
            });
        }

    });
</script>