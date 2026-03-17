@extends('layouts.app')
@section('auth-content')

<body>
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
                    <div class="calendar-header  d-flex justify-content-between align-items-center ">
                        <h5 class="mb-0">Attendance Regularization</h5>
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="avatar">
                                <span><i class="ti ti-adjustments-horizontal"></i></span>
                            </div>
                            <div class="calendar-csvfile ms-3">
                                <h5 class="mb-0"> <i class="ti ti-file-analytics"></i>CSV files</h5>
                            </div>
                        </div>

                    </div>


                    <div class="container-xxl flex-grow-1">
                        <div class="col app-calendar-content">
                            <div class="card shadow-none border-0">
                                <div class="card-body pb-0">
                                    <h1>All Attendance Records</h1>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Punch In</th>
                                                <th>Punch Out</th>
                                                <th>Working Hours</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($attendance as $date => $records)
                                                <tr>
                                                    <td rowspan="{{ $records->count() }}">{{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}</td>
                                                    @foreach ($records as $key => $record)
                                                        @if ($key > 0)
                                                            <tr>
                                                        @endif
                                                        <td>{{ $record->punch_in_time }}</td>
                                                        <td>{{ $record->punch_out_time ?? 'N/A' }}</td>
                                                        <td>{{ $record->working_hours ?? 'N/A' }}</td>
                                                        <td>
                                                            <a href="{{ route('attendance-regularization') }}" class="btn btn-primary">Request Regularization</a>
                                                        </td>
                                                        @if ($key > 0)
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No attendance records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                    <!-- FullCalendar -->
                                    <div id='calendar'></div>
                                </div>
                            </div>

                            <!-- FullCalendar Offcanvas -->
                            <div id="addEventSidebar">
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
    <!-- / Layout wrapper -->
 @endsection