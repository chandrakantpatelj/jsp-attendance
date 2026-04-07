@extends('layouts.app')

@section('auth-content')
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('admin.sidebar')
        <div class="layout-page">
            @include('admin.header')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="fw-bold py-3 mb-4">Pending Regularization Requests</h4>

                    <div class="card">
                        <div class="card-body">
                            @if($regularizations->isEmpty())
                                <div class="text-center py-5">
                                    <i class="ti ti-calendar-off fs-1 d-block mb-3 text-muted"></i>
                                    <h6>No pending regularization requests</h6>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Date</th>
                                                <th>Reason</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($regularizations as $reg)
                                            <tr>
                                                <td>{{ $reg->user->name ?? 'N/A' }}</td>
                                                <td>{{ $reg->attendance ? \Carbon\Carbon::parse($reg->attendance->attendance_date)->format('d M Y') : 'N/A' }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($reg->reason, 50) }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-success approve-btn" data-id="{{ $reg->id }}">
                                                        Approve
                                                    </button>
                                                    <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $reg->id }}">
                                                        Reject
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.approve-btn').on('click', function() {
        let id = $(this).data('id');
        if (confirm('Approve this request?')) {
            $.ajax({
                url: '/admin/regularizations/' + id + '/approve',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error approving request');
                }
            });
        }
    });

    $('.reject-btn').on('click', function() {
        let id = $(this).data('id');
        if (confirm('Reject this request?')) {
            $.ajax({
                url: '/admin/regularizations/' + id + '/reject',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error rejecting request');
                }
            });
        }
    });
});
</script>
@endsection