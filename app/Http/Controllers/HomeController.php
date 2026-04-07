<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Regularization;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            return $this->adminDashboard();
        } elseif ($user->role_id == 2) {
            return $this->employeeDashboard($user);
        }

        return redirect()->route('login');
    }

    /**
     * Admin dashboard data - CORRECTED LOGIC FOR MONTHLY ATTENDANCE
     */
    protected function adminDashboard()
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $currentDay = now()->day;
        
        $totalEmployees = User::where('role_id', 2)->count();
        
        // Total leave requests (all time)
        $totalLeaveRequests = Leave::count();

        // Present today (distinct employees with punch_in)
        $presentToday = Attendance::whereDate('attendance_date', $today)
            ->whereNotNull('punch_in_time')
            ->distinct('employee_id')
            ->count('employee_id');

        // On leave today (employees with approved leave covering today)
        $onLeaveToday = Leave::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->distinct('employee_id')
            ->count('employee_id');

        // Late today (if 'late' status exists)
        $lateToday = Attendance::whereDate('attendance_date', $today)
            ->where('status', 'late')
            ->distinct('employee_id')
            ->count('employee_id');
            
        // Absent today (total employees minus present, on leave, and late)
        $absentToday = $totalEmployees - ($presentToday + $onLeaveToday + $lateToday);
        $absentToday = max(0, $absentToday);

        $presentPercentage = $totalEmployees ? round(($presentToday / $totalEmployees) * 100, 1) : 0;
        $leavePercentage = $totalEmployees ? round(($onLeaveToday / $totalEmployees) * 100, 1) : 0;
        $latePercentage = $presentToday ? round(($lateToday / $presentToday) * 100, 1) : 0;

        // Pending approvals
        $pendingLeaves = Leave::where('status', 'pending')->count();
        $pendingLeavesPercentage = $pendingLeaves > 0 ? round(($pendingLeaves / Leave::count()) * 100, 1) : 0;

        $pendingRegularizations = Regularization::where('status', 'pending')->count();
        $pendingRegPercentage = $pendingRegularizations > 0 ? round(($pendingRegularizations / Regularization::count()) * 100, 1) : 0;

        // Monthly attendance data - CORRECTED: Count employees present and absent per month
        $year = request('year', now()->year);
        $selectedYear = $year;
        $monthlyPresent = [];
        $monthlyAbsent = [];
        $monthlyLeave = [];
        
        // Get all employees
        $allEmployees = User::where('role_id', 2)->pluck('id')->toArray();
        
        for ($month = 1; $month <= 12; $month++) {
            // For future months in current year, set all values to 0
            if ($year == now()->year && $month > now()->month) {
                $monthlyPresent[] = 0;
                $monthlyAbsent[] = 0;
                $monthlyLeave[] = 0;
                continue;
            }
            
            // Get start and end date of the month
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            
            // If this is current month, only consider days up to today
            if ($year == now()->year && $month == now()->month) {
                $endDate = Carbon::today();
            }
            
            // Get employees who were present at least once this month
            $presentEmployees = Attendance::whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month)
                ->whereNotNull('punch_in_time')
                ->whereDate('attendance_date', '<=', $endDate)
                ->distinct('employee_id')
                ->pluck('employee_id')
                ->toArray();
            
            // Get employees who were on approved leave this month
            $leaveEmployees = Leave::whereYear('start_date', $year)
                ->whereMonth('start_date', $month)
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', $endDate)
                ->distinct('employee_id')
                ->pluck('employee_id')
                ->toArray();
            
            // Count present employees
            $presentCount = count($presentEmployees);
            $monthlyPresent[] = $presentCount;
            
            // Count leave employees
            $leaveCount = count($leaveEmployees);
            $monthlyLeave[] = $leaveCount;
            
            // Absent employees = total employees - (present + leave)
            $absentCount = $totalEmployees - ($presentCount + $leaveCount);
            $monthlyAbsent[] = max(0, $absentCount);
        }

        // Recent activities for admin dashboard
        $recentLeaves = Leave::with('employee')
            ->latest()
            ->take(5)
            ->get();

        $recentRegularizations = Regularization::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Years for dropdown
        $years = range(now()->year - 2, now()->year + 1);

        return view('admin.dashboard', compact(
            'totalEmployees',
            'totalLeaveRequests',
            'presentToday',
            'onLeaveToday',
            'lateToday',
            'absentToday',
            'presentPercentage',
            'leavePercentage',
            'latePercentage',
            'pendingLeaves',
            'pendingLeavesPercentage',
            'pendingRegularizations',
            'pendingRegPercentage',
            'monthlyPresent',
            'monthlyAbsent',
            'monthlyLeave',
            'recentLeaves',
            'recentRegularizations',
            'years',
            'selectedYear'
        ));
    }

    /**
     * Employee dashboard data
     */
    protected function employeeDashboard($user)
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $currentDay = now()->day;

        // Total days in current month
        $daysInMonth = now()->daysInMonth;
        
        // Get all attendance records for this employee in current month
        $monthlyAttendances = Attendance::where('employee_id', $user->id)
            ->whereYear('attendance_date', $currentYear)
            ->whereMonth('attendance_date', $currentMonth)
            ->get()
            ->keyBy(function($item) {
                return Carbon::parse($item->attendance_date)->day;
            });

        // Calculate present days (days with punch in that have occurred)
        $totalPresent = $monthlyAttendances->count();
        
        // Calculate days that have actually passed so far this month
        $daysPassed = $currentDay;
        
        // Calculate absent days (passed days minus present days)
        $totalAbsent = $daysPassed - $totalPresent;
        $totalAbsent = max(0, $totalAbsent);
        
        // Total leave requests (all time)
        $totalLeaveRequests = Leave::where('employee_id', $user->id)->count();
        
        // Pending leaves count
        $pendingLeaves = Leave::where('employee_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Punch card data for today
        $attendanceToday = Attendance::where('employee_id', $user->id)
            ->whereDate('attendance_date', $today)
            ->first();

        $punchInTime = $attendanceToday?->punch_in_time ?? '--:--';
        $punchOutTime = $attendanceToday?->punch_out_time ?? '--:--';
        
        // Format working hours properly
        $workedHours = '00:00:00';
        if ($attendanceToday) {
            $rawWorkingHours = $attendanceToday->working_hours;
            $isValidHms = is_string($rawWorkingHours) && preg_match('/^\d{2}:\d{2}:\d{2}$/', trim($rawWorkingHours)) === 1;
            $isNegative = is_string($rawWorkingHours) && str_contains($rawWorkingHours, '-');

            if ($isValidHms && !$isNegative) {
                $workedHours = trim($rawWorkingHours);
            } elseif (is_numeric($rawWorkingHours)) {
                $totalMinutes = (int) round(((float) $rawWorkingHours) * 60);
                $hours = intdiv($totalMinutes, 60);
                $minutes = $totalMinutes % 60;
                $workedHours = sprintf('%02d:%02d:00', max(0, $hours), max(0, $minutes));
            } elseif (!empty($attendanceToday->punch_in_time)) {
                try {
                    $tz = config('app.timezone');
                    $attendanceDate = Carbon::parse($attendanceToday->attendance_date, $tz)->toDateString();

                    $punchIn = Carbon::createFromFormat(
                        'Y-m-d h:i:s A',
                        $attendanceDate . ' ' . $attendanceToday->punch_in_time,
                        $tz
                    );

                    $punchOut = $attendanceToday->punch_out_time
                        ? Carbon::createFromFormat(
                            'Y-m-d h:i:s A',
                            $attendanceDate . ' ' . $attendanceToday->punch_out_time,
                            $tz
                        )
                        : Carbon::now($tz);

                    if ($punchOut->lt($punchIn)) {
                        $punchOut->addDay();
                    }

                    $diffSeconds = $punchIn->diffInSeconds($punchOut);
                    $hours = intdiv($diffSeconds, 3600);
                    $minutes = intdiv($diffSeconds % 3600, 60);
                    $seconds = $diffSeconds % 60;
                    $workedHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                } catch (\Exception $e) {
                    $workedHours = '00:00:00';
                }
            }
        }
        
        $isPunchedIn = $attendanceToday && !$attendanceToday->punch_out_time;

        // Work percentage (8-hour day)
        $workPercentage = 0;
        if ($workedHours != '00:00:00') {
            $parts = explode(':', $workedHours);
            $hours = (int)$parts[0];
            $minutes = (int)$parts[1];
            $totalMinutes = $hours * 60 + $minutes;
            $workPercentage = min(100, round(($totalMinutes / (8 * 60)) * 100));
        }

        // Monthly attendance data for chart (all months up to current date)
        $year = request()->get('year', now()->year);
        $selectedYear = $year;
        $monthlyPresentData = [];
        $monthlyAbsentData = [];
        
        for ($i = 1; $i <= 12; $i++) {
            if ($year == now()->year && $i > now()->month) {
                // Future months - set to 0
                $monthlyPresentData[] = 0;
                $monthlyAbsentData[] = 0;
            } else {
                // Past or current month
                $daysInMonth_i = Carbon::create($year, $i)->daysInMonth;
                $lastDayOfMonth = ($year == now()->year && $i == now()->month) ? now()->day : $daysInMonth_i;
                
                $presentCount = Attendance::where('employee_id', $user->id)
                    ->whereYear('attendance_date', $year)
                    ->whereMonth('attendance_date', $i)
                    ->whereDay('attendance_date', '<=', $lastDayOfMonth)
                    ->count();
                
                $monthlyPresentData[] = $presentCount;
                $monthlyAbsentData[] = $lastDayOfMonth - $presentCount;
            }
        }
        
        $years = range(now()->year - 2, now()->year + 1);

        // Recent activities
        $recentActivities = collect();

        $recentLeaves = Leave::where('employee_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
            
        foreach ($recentLeaves as $leave) {
            $recentActivities->push([
                'title' => 'Leave ' . ($leave->leave_type ?? 'request'),
                'time' => $leave->created_at->diffForHumans(),
                'icon' => 'calendar',
                'color' => $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning' : 'danger'),
                'badgeColor' => $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning' : 'danger'),
                'status' => ucfirst($leave->status),
            ]);
        }

        if (class_exists('App\Models\Regularization')) {
            $recentRegularizations = Regularization::where('user_id', $user->id)
                ->latest()
                ->take(3)
                ->get();
            foreach ($recentRegularizations as $reg) {
                $recentActivities->push([
                    'title' => 'Regularization request',
                    'time' => $reg->created_at->diffForHumans(),
                    'icon' => 'adjustments',
                    'color' => $reg->status == 'approved' ? 'success' : ($reg->status == 'pending' ? 'warning' : 'danger'),
                    'badgeColor' => $reg->status == 'approved' ? 'success' : ($reg->status == 'pending' ? 'warning' : 'danger'),
                    'status' => ucfirst($reg->status),
                ]);
            }
        }

        $recentActivities = $recentActivities->sortByDesc('time')->take(5);

        // Punch data for JavaScript
        $punchData = [
            'isPunchedIn' => $isPunchedIn,
            'punchInTime' => $punchInTime,
            'punchOutTime' => $punchOutTime,
            'workingHours' => $workedHours,
            'attendanceDate' => $attendanceToday?->attendance_date ?? $today,
        ];

        return view('employee.dashboard', compact(
            'daysInMonth',
            'daysPassed',
            'totalPresent',
            'totalAbsent',
            'totalLeaveRequests',
            'pendingLeaves',
            'punchInTime',
            'punchOutTime',
            'workedHours',
            'isPunchedIn',
            'workPercentage',
            'monthlyPresentData',
            'monthlyAbsentData',
            'years',
            'selectedYear',
            'recentActivities',
            'punchData'
        ));
    }
}