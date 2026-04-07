<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== REAL DATA FROM YOUR DATABASE =====
        
        // Total employees (role_id = 2)
        $totalEmployees = User::where('role_id', 2)->count(); // 18

        // Total leave requests
        $totalLeaveRequests = Leave::count(); // 11

        // Pending leaves
        $pendingLeaves = Leave::where('status', 'pending')->count(); // 3 (IDs 25,26,30)

        // Today's attendance
        $today = Carbon::today(); // 2026-03-13
        $presentToday = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'present')
            ->count(); // 1 (ID 19)
        $absentToday = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'absent')
            ->count(); // 0

        // Monthly Present vs Absent data for 2026
        $year = request()->get('year', 2026); // Default to 2026
        
        $monthlyPresentData = [];
        $monthlyAbsentData = [];
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        for ($m = 1; $m <= 12; $m++) {
            // Count present for each month
            $present = Attendance::whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $m)
                ->where('status', 'present')
                ->count();
            
            // Count absent for each month  
            $absent = Attendance::whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $m)
                ->where('status', 'absent')
                ->count();

            $monthlyPresentData[] = $present;
            $monthlyAbsentData[] = $absent;
        }

        // Years for dropdown
        $years = [2024, 2025, 2026, 2027];

        // Recent activities - with null checks
        $recentLeaves = Leave::with('employee')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($leave) {
                $employeeName = $leave->employee ? $leave->employee->name : 'Unknown Employee';
                
                return [
                    'title' => 'Leave: ' . $employeeName . ' (' . ($leave->leave_type ?? 'N/A') . ')',
                    'time' => $leave->created_at ? $leave->created_at->diffForHumans() : 'N/A',
                    'icon' => 'calendar',
                    'color' => 'warning',
                    'badgeColor' => $leave->status == 'approved' ? 'success' : ($leave->status == 'rejected' ? 'danger' : 'warning'),
                    'status' => ucfirst($leave->status ?? 'pending'),
                ];
            });

        $recentAttendances = Attendance::with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($attendance) {
                $userName = $attendance->user ? $attendance->user->name : 'Unknown Employee';
                
                return [
                    'title' => 'Attendance: ' . $userName . ' (' . ucfirst($attendance->status ?? 'present') . ')',
                    'time' => $attendance->attendance_date ? $attendance->attendance_date->diffForHumans() : 'N/A',
                    'icon' => 'clock',
                    'color' => 'info',
                    'badgeColor' => 'info',
                    'status' => ucfirst($attendance->status ?? 'Present'),
                ];       
            });

        $recentActivities = $recentLeaves->merge($recentAttendances)->sortByDesc('time')->take(5);

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalLeaveRequests',
            'pendingLeaves',
            'presentToday',
            'absentToday',
            'monthlyPresentData',
            'monthlyAbsentData',
            'monthLabels',
            'years',
            'recentActivities',
            'year'
        ));
    }
}