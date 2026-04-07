<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index()
    {
        $attendances = Attendance::with('user')
            ->orderBy('attendance_date', 'desc')
            ->paginate(15);
        
        $employees = User::where('role_id', 2)->get();
        
        return view('admin.leave_management_backup', compact('attendances', 'employees'));
    }

    /**
     * Calculate working hours between punch in and punch out
     */
    private function calculateWorkingHours($punchInTime, $punchOutTime)
    {
        if (empty($punchInTime) || empty($punchOutTime)) {
            return '00:00:00';
        }
        
        try {
            // Clean the time strings - remove any extra spaces
            $punchInTime = trim($punchInTime);
            $punchOutTime = trim($punchOutTime);
            
            // Parse the times with proper format handling
            $punchIn = Carbon::parse($punchInTime);
            $punchOut = Carbon::parse($punchOutTime);
            
            // If punch out is less than punch in, assume it's next day
            if ($punchOut->lt($punchIn)) {
                $punchOut->addDay();
            }
            
            // Calculate difference in minutes
            $diffInMinutes = $punchOut->diffInMinutes($punchIn);
            
            // Ensure positive value
            $diffInMinutes = abs($diffInMinutes);
            
            // Convert to hours and minutes
            $hours = floor($diffInMinutes / 60);
            $minutes = $diffInMinutes % 60;
            
            // Format as HH:MM:00
            return sprintf('%02d:%02d:00', $hours, $minutes);
            
        } catch (\Exception $e) {
            \Log::error('Working hours calculation error: ' . $e->getMessage());
            \Log::error('Punch In: ' . $punchInTime . ', Punch Out: ' . $punchOutTime);
            return '00:00:00';
        }
    }

    /**
     * Format time to ensure consistent format
     */
    private function formatTime($time)
    {
        if (empty($time)) {
            return null;
        }
        
        try {
            // If time is in HH:MM format (from time input), add seconds and AM/PM
            if (preg_match('/^\d{2}:\d{2}$/', $time)) {
                $carbonTime = Carbon::createFromFormat('H:i', $time);
                return $carbonTime->format('h:i:s A');
            }
            
            // Parse the time and format with AM/PM
            $carbonTime = Carbon::parse($time);
            return $carbonTime->format('h:i:s A');
        } catch (\Exception $e) {
            return $time;
        }
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create(Request $request)
    {
        $employeeId = $request->query('employee_id');
        $date = $request->query('date');
        $employee = null;
        $employeeName = '';
        
        if ($employeeId) {
            $employee = User::find($employeeId);
            $employeeName = $employee ? $employee->name : '';
        }
        
        return view('admin.attendance_create', compact('employeeId', 'date', 'employeeName'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'punch_in_time' => 'required',
            'punch_out_time' => 'required',
            'status' => 'required|in:present,absent,half-day,leave',
        ]);

        // Check if attendance already exists
        $existingAttendance = Attendance::where('employee_id', $request->employee_id)
            ->whereDate('attendance_date', $request->attendance_date)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Attendance record already exists for this date.');
        }

        // Format times consistently
        $punchInTime = $this->formatTime($request->punch_in_time);
        $punchOutTime = $this->formatTime($request->punch_out_time);
        
        // Calculate working hours
        $workingHours = $this->calculateWorkingHours($punchInTime, $punchOutTime);

        \Log::info('Creating attendance:', [
            'punch_in' => $punchInTime,
            'punch_out' => $punchOutTime,
            'working_hours' => $workingHours
        ]);

        Attendance::create([
            'employee_id' => $request->employee_id,
            'attendance_date' => $request->attendance_date,
            'punch_in_time' => $punchInTime,
            'punch_out_time' => $punchOutTime,
            'status' => $request->status,
            'working_hours' => $workingHours,
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record created successfully.');
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit($id)
    {
        $attendance = Attendance::with('user')->findOrFail($id);
        
        // Format times for input fields (remove AM/PM for time input)
        if ($attendance->punch_in_time) {
            try {
                $attendance->punch_in_time = Carbon::parse($attendance->punch_in_time)->format('H:i');
            } catch (\Exception $e) {
                // Keep as is
            }
        }
        if ($attendance->punch_out_time) {
            try {
                $attendance->punch_out_time = Carbon::parse($attendance->punch_out_time)->format('H:i');
            } catch (\Exception $e) {
                // Keep as is
            }
        }
        
        return response()->json($attendance);
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'punch_in_time' => 'required',
                'punch_out_time' => 'required',
                'status' => 'required|in:present,absent,half-day,leave',
            ]);

            $attendance = Attendance::findOrFail($id);
            
            // Format times consistently
            $punchInTime = $this->formatTime($request->punch_in_time);
            $punchOutTime = $this->formatTime($request->punch_out_time);
            
            // Calculate working hours
            $workingHours = $this->calculateWorkingHours($punchInTime, $punchOutTime);

            \Log::info('Updating attendance:', [
                'id' => $id,
                'punch_in' => $punchInTime,
                'punch_out' => $punchOutTime,
                'working_hours' => $workingHours
            ]);

            $attendance->update([
                'punch_in_time' => $punchInTime,
                'punch_out_time' => $punchOutTime,
                'status' => $request->status,
                'working_hours' => $workingHours,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Attendance updated successfully.',
                    'data' => $attendance
                ]);
            }

            return redirect()->route('admin.attendance.index')->with('success', 'Attendance record updated successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Attendance update error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Get punch data for a specific employee on a specific date.
     */
    public function getDayPunchData(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|integer|exists:users,id',
                'date' => 'required|date',
            ]);

            $attendance = Attendance::where('employee_id', $request->employee_id)
                ->whereDate('attendance_date', $request->date)
                ->first();

            if (!$attendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'No attendance record found.',
                ]);
            }

            // Format times for input fields
            $punchInTime = $attendance->punch_in_time ? Carbon::parse($attendance->punch_in_time)->format('H:i') : null;
            $punchOutTime = $attendance->punch_out_time ? Carbon::parse($attendance->punch_out_time)->format('H:i') : null;

            return response()->json([
                'success' => true,
                'punch_in_time' => $punchInTime,
                'punch_out_time' => $punchOutTime,
                'working_hours' => $attendance->working_hours,
                'status' => $attendance->status,
                'id' => $attendance->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get leave balance for an employee
     */
    public function leaveBalance($employeeId)
    {
        try {
            $employee = User::findOrFail($employeeId);
            
            $leaves = Leave::where('employee_id', $employeeId)->get();
            
            $pendingLeaves = $leaves->where('status', 'pending')->count();
            $approvedLeaves = $leaves->where('status', 'approved')->count();
            $rejectedLeaves = $leaves->where('status', 'rejected')->count();
            
            $pendingDays = $leaves->where('status', 'pending')->sum('total_days');
            $approvedDays = $leaves->where('status', 'approved')->sum('total_days');
            $rejectedDays = $leaves->where('status', 'rejected')->sum('total_days');

            return response()->json([
                'success' => true,
                'employee' => [
                    'id' => $employee->id,
                    'name' => $employee->name,
                    'designation' => $employee->designation,
                ],
                'requests' => [
                    'total' => $leaves->count(),
                    'pending' => $pendingLeaves,
                    'approved' => $approvedLeaves,
                    'rejected' => $rejectedLeaves,
                ],
                'days' => [
                    'pending' => (float) $pendingDays,
                    'approved' => (float) $approvedDays,
                    'rejected' => (float) $rejectedDays,
                    'total' => (float) ($pendingDays + $approvedDays + $rejectedDays),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}