@extends('layouts.app')
@section('auth-content')
<div class="container">
    <h1>Attendance Management</h1>

    <select id="employeeSelect" class="form-select mb-3">
        <option value="" data-name="">Select Employee</option>
        @foreach($employees as $employee)
        <option value="{{ $employee->id }}" data-name=" {{ $employee->name }}">{{ $employee->name }}</option>
        @endforeach
    </select>
    <button type="button" class="btn btn-success" id="createAttendanceBtn">
        <!-- data-bs-toggle="modal" data-bs-target="#createAttendance" -->
        Create Attendance
    </button>

    <div class="modal fade" id="createAttendance" tabindex="-1" aria-labelledby="createAttendanceLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAttendanceLabel">Create Attendance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Employee:</strong> <span id="modalAttendanceName"></span></p>
                    <form id="attendanceForm"
                        action="{{ isset($attendances->id) ? route('attendance.update', $attendances->id) : route('attendance.store') }}"
                        method="POST">
                        @csrf
                        @if(isset($attendances->id))
                        @method('PUT')
                        @else
                        @method('POST')
                        @endif
                        <input type="hidden" name="attendances_id" id="modalAttendancesId">


                        <div class="mb-3">
                            <label for="attendance_date" class="form-label">Date:</label>
                            <input type="date" name="attendance_date" id="attendance_date"
                                class="form-control @error('attendance_date') is-invalid @enderror"
                                value="{{ old('attendance_date', $attendances->isNotEmpty() ? $attendances->first()->attendance_date : '') }}"
                                required autofocus>

                            @error('attendance_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="punch_in_time" class="form-label">Punch In Time:</label>
                            <input type="time" name="punch_in_time" id="punch_in_time"
                                class="form-control @error('punch_in_time') is-invalid @enderror"
                                value="{{ old('punch_in_time', $attendances->isNotEmpty() ? $attendances->first()->punch_in_time : '') }}"
                                required autofocus>
                            @error('punch_in_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="punch_out_time" class="form-label">Punch Out Time:</label>
                            <input type="time" name="punch_out_time" id="punch_out_time"
                                class="form-control @error('punch_out_time') is-invalid @enderror"
                                value="{{ old('punch_out_time', $attendances->isNotEmpty() ? $attendances->first()->punch_out_time : '') }}"
                                required>
                            @error('punch_out_time')
                            <span class=" invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="present"
                                    {{ old('status', $attendances->isNotEmpty() ? $attendances->first()->status === 'present' : '') ? 'selected' : '' }}>
                                    Present
                                </option>
                                <option value="absent"
                                    {{ old('status', $attendances->isNotEmpty() ? $attendances->first()->status === 'absent' : '') ? 'selected' : '' }}>
                                    Absent
                                </option>
                                <option value="half-day"
                                    {{ old('status', $attendances->isNotEmpty() ? $attendances->first()->status === 'half-day' : '') ? 'selected' : '' }}>
                                    Half-Day
                                </option>
                                <option value=" leave"
                                    {{ old('status', $attendances->isNotEmpty() ? $attendances->first()->status === 'leave' : '') ? 'selected' : '' }}>
                                    Leave
                                </option>
                            </select>

                        </div>

                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Punch In</th>
                <th>Punch Out</th>
                <th>Status</th>
                <th>Working Hours</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
            <tr>
                <td>{{ $attendance->employee->name }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->punch_in_time }}</td>
                <td>{{ $attendance->punch_out_time }}</td>
                <td>{{ $attendance->status }}</td>
                <td>{{ $attendance->working_hours }}</td>
                <td>
                    <button type="button" class=" btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#createAttendance"
                        onclick="loadAttendanceData({{ $attendance->id }})">Edit</button>
                    <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadAttendanceData(attendanceId) {

    $.ajax({
        url: '/attendance/' + attendanceId + '/edit',
        method: 'GET',
        success: function(data) {
            console.log('data', data.employee.name);
            $('#modalAttendanceName').text(data.employee.name);
            $('#attendance_date').val(data.attendance_date);
            $('#punch_in_time').val(data.punch_in_time);
            $('#punch_out_time').val(data.punch_out_time);
            $('#status').val(data.status);
            $('#modalAttendancesId').val(data.id);
            $('#attendanceForm button[type="submit"]').text('Update');

            $('#attendanceForm').attr('action', '/attendance/' + attendanceId + '/update');

            $('#createAttendance').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching attendances data:', error);
            alert('Failed to load attendances data.');
        }
    });
}
$(document).ready(function() {
    $('#createAttendanceBtn').on('click', function() {
        $('#attendanceForm').find('input[type="text"], input[type="date"], input[type="time"], select')
            .val('');
        $('#attendanceForm').find('input[type="hidden"]:not([name="_token"])').val('');
        $('#attendanceForm').find('textarea').val('');
        // $('#attendanceForm button[type="submit"]').text('Submit');


        var selectedOption = $('#employeeSelect option:selected');
        var employeeId = selectedOption.val();
        var employeeName = selectedOption.data('name');

        if (!employeeId) {
            alert('Please select an employee first!');
            return;
        }

        $('#modalAttendancesId').val(employeeId);
        $('#modalAttendanceName').text(employeeName);
        $('#createAttendance').modal('show');
    });
    // flatpickr('#punch_in_time', {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: "h:i K",
    //     minuteIncrement: 1,
    // });

    // flatpickr('#punch_out_time', {
    //     enableTime: true,
    //     noCalendar: true,
    //     dateFormat: "h:i K",
    //     minuteIncrement: 1,
    // });


});
</script>