@extends('layouts.app')

@section('auth-content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('admin.sidebar')
        <div class="layout-page">
            @include('admin.header')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Pending Leave Approvals</h4>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Total Days</th>
                                            <th>Reason</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($leaves as $leave)
                                        <tr>
                                            <td>{{ $leave->employee->name ?? 'N/A' }}</td>
                                            <td>{{ $leave->leave_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}</td>
                                            <td>{{ $leave->total_days }}</td>
                                            <td>{{ $leave->reason }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-success approve-btn" data-id="{{ $leave->id }}">
                                                        <i class="ti ti-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $leave->id }}">
                                                        <i class="ti ti-x"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No pending leave requests</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $leaves->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval/Rejection Modal -->
<div class="modal fade" id="actionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalLabel">Confirm Action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="actionMessage">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmApprove" style="display: none;">Approve</button>
                <button type="button" class="btn btn-danger" id="confirmReject" style="display: none;">Reject</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function() {
    let currentLeaveId = null;
    let currentAction = null;

    $('.approve-btn').on('click', function() {
        currentLeaveId = $(this).data('id');
        currentAction = 'approve';
        $('#actionMessage').text('Are you sure you want to approve this leave request?');
        $('#confirmApprove').show();
        $('#confirmReject').hide();
        $('#actionModalLabel').text('Approve Leave');
        $('#actionModal').modal('show');
    });

    $('.reject-btn').on('click', function() {
        currentLeaveId = $(this).data('id');
        currentAction = 'reject';
        $('#actionMessage').text('Are you sure you want to reject this leave request?');
        $('#confirmReject').show();
        $('#confirmApprove').hide();
        $('#actionModalLabel').text('Reject Leave');
        $('#actionModal').modal('show');
    });

    $('#confirmApprove').on('click', function() {
        if (!currentLeaveId) return;
        
        $.ajax({
            url: '/admin/leave/approve/' + currentLeaveId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#actionModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Failed to approve');
                }
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    });

    $('#confirmReject').on('click', function() {
        if (!currentLeaveId) return;
        
        $.ajax({
            url: '/admin/leave/reject/' + currentLeaveId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#actionModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Failed to reject');
                }
            },
            error: function() {
                alert('Something went wrong!');
            }
        });
    });
});
</script>
@endpush