<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Get total days in current month
        $totalDaysInMonth = Carbon::now()->daysInMonth;

        // Today's attendance
        $todayAttendance = Attendance::where('employee_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->first();

        // Stats for current month only
        $totalDays = $totalDaysInMonth;
        
        $totalLeaveRequests = Leave::where('employee_id', $user->id)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        $pendingLeaves = Leave::where('employee_id', $user->id)
            ->where('status', 'pending')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        // Current month present days
        $totalPresent = Attendance::where('employee_id', $user->id)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->where('status', 'present')
            ->count();

        // Current month absent days
        $totalAbsent = Attendance::where('employee_id', $user->id)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->where('status', 'absent')
            ->count();

        // Current month half days
        $totalHalfDay = Attendance::where('employee_id', $user->id)
            ->whereMonth('attendance_date', $currentMonth)
            ->whereYear('attendance_date', $currentYear)
            ->where('status', 'half-day')
            ->count();

        // Punch details
        $punchInTime = $todayAttendance ? $todayAttendance->punch_in_time : null;
        $punchOutTime = $todayAttendance ? $todayAttendance->punch_out_time : null;
        $isPunchedIn = $todayAttendance && !$todayAttendance->punch_out_time;

        // Worked hours & percentage for today
        if ($todayAttendance && $todayAttendance->punch_in_time) {
            $start = Carbon::createFromFormat('h:i:s A', $todayAttendance->punch_in_time);
            $end = $todayAttendance->punch_out_time
                ? Carbon::createFromFormat('h:i:s A', $todayAttendance->punch_out_time)
                : Carbon::now();
            $diff = $start->diff($end);
            $workedHours = $diff->h . 'h ' . $diff->i . 'm';
            $totalSeconds = $end->diffInSeconds($start);
            $expectedSeconds = 9 * 3600; // 9 hours expected work day
            $workPercentage = $expectedSeconds > 0 ? min(100, round(($totalSeconds / $expectedSeconds) * 100)) : 0;
        } else {
            $workedHours = '0h 0m';
            $workPercentage = 0;
        }

        // Year for chart (default to current year)
        $year = request()->get('year', Carbon::now()->year);
        
        // Monthly present data for chart
        $monthlyPresentData = [];
        $monthlyAbsentData = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthlyPresentData[] = Attendance::where('employee_id', $user->id)
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $m)
                ->where('status', 'present')
                ->count();

            $monthlyAbsentData[] = Attendance::where('employee_id', $user->id)
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $m)
                ->where('status', 'absent')
                ->count();
        }

        // Years for dropdown
        $years = range(Carbon::now()->year - 2, Carbon::now()->year + 1);

        // Recent activities - combine leaves and attendance
        $recentLeaves = Leave::where('employee_id', $user->id)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($leave) {
                return [
                    'title' => 'Leave ' . ucfirst($leave->leave_type),
                    'time' => $leave->created_at->diffForHumans(),
                    'icon' => 'calendar',
                    'color' => 'warning',
                    'badgeColor' => $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning'),
                    'status' => ucfirst($leave->status),
                ];
            });

        $recentAttendances = Attendance::where('employee_id', $user->id)
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($attendance) {
                return [
                    'title' => 'Attendance: ' . ucfirst($attendance->status ?? 'present'),
                    'time' => $attendance->attendance_date->diffForHumans(),
                    'icon' => 'clock',
                    'color' => 'info',
                    'badgeColor' => 'info',
                    'status' => ucfirst($attendance->status ?? 'Present'),
                ];
            });

        $recentActivities = collect()
            ->merge($recentLeaves)
            ->merge($recentAttendances)
            ->sortByDesc('time')
            ->take(5)
            ->values()
            ->toArray();

        // Punch data for JavaScript
        $punchData = [
            'isPunchedIn' => $isPunchedIn,
            'punchInTime' => $punchInTime,
            'punchOutTime' => $punchOutTime,
            'workingHours' => $workedHours,
            'attendanceDate' => $today->format('Y-m-d')
        ];

        return view('employee.dashboard', compact(
            'totalDays',
            'totalLeaveRequests',
            'pendingLeaves',
            'totalPresent',
            'totalAbsent',
            'totalHalfDay',
            'punchInTime',
            'punchOutTime',
            'workedHours',
            'workPercentage',
            'isPunchedIn',
            'punchData',
            'monthlyPresentData',
            'monthlyAbsentData',
            'years',
            'recentActivities',
            'year'
        ));
    }
}