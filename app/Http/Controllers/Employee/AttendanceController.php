<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Leave;
use App\Models\Regularization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Handle punch-in via dedicated route.
     */
    public function punchIn(Request $request)
    {
        $request->merge(['action' => 'punch_in']);
        return $this->savePunchData($request);
    }

    /**
     * Handle punch-out via dedicated route.
     */
    public function punchOut(Request $request)
    {
        $request->merge(['action' => 'punch_out']);
        return $this->savePunchData($request);
    }

    /**
     * Save punch data with working hours calculation
     */
    public function savePunchData(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $data = $request->validate([
            'action' => 'required|string|in:punch_in,punch_out',
            'timestamp' => 'required|string',
        ]);

        $userId = Auth::id();
        $timeString = $request->timestamp;

        try {
            $carbonDate = Carbon::parse($timeString);
            $carbonDate->setTimezone(config('app.timezone'));

            $formattedTime = $carbonDate->format('h:i:s A');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid timestamp format']);
        }

        $today = $carbonDate->toDateString();

        // Check for existing open attendance
        $openAttendance = Attendance::where('employee_id', $userId)
            ->whereDate('attendance_date', $today)
            ->whereNotNull('punch_in_time')
            ->whereNull('punch_out_time')
            ->orderByDesc('id')
            ->first();

        if ($data['action'] === 'punch_in') {
            if ($openAttendance) {
                return response()->json(['success' => false, 'message' => 'Already punched in']);
            }

            $existingAttendance = Attendance::where('employee_id', $userId)
                ->whereDate('attendance_date', $today)
                ->first();

            if ($existingAttendance) {
                $existingAttendance->update([
                    'punch_in_time' => $formattedTime,
                    'punch_out_time' => null,
                    'working_hours' => '00:00:00',
                ]);
            } else {
                Attendance::create([
                    'employee_id' => $userId,
                    'attendance_date' => $today,
                    'punch_in_time' => $formattedTime,
                    'punch_out_time' => null,
                    'status' => 'present',
                    'working_hours' => '00:00:00',
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Punched in successfully']);
        }

        if ($data['action'] === 'punch_out') {
            if (!$openAttendance) {
                return response()->json(['success' => false, 'message' => 'No active punch-in found']);
            }

            try {
                // Parse punch in time (stored in 12-hour format)
                $punchInTime = Carbon::createFromFormat('h:i:s A', $openAttendance->punch_in_time);
                
                // Parse punch out time (also in 12-hour format)
                $punchOutTime = Carbon::createFromFormat('h:i:s A', $formattedTime);
                
                // If punch out time is earlier than punch in, it might be next day
                if ($punchOutTime->lessThan($punchInTime)) {
                    $punchOutTime->addDay();
                }
                
                // Calculate difference in minutes for better accuracy
                $diffInMinutes = $punchOutTime->diffInMinutes($punchInTime);
                
                // Convert to hours and minutes
                $hours = floor($diffInMinutes / 60);
                $minutes = $diffInMinutes % 60;
                
                // Format as HH:MM:00 (seconds set to 00 for display)
                $workingHours = sprintf('%02d:%02d:00', $hours, $minutes);
                
                // Update attendance record
                $openAttendance->update([
                    'punch_out_time' => $formattedTime,
                    'working_hours' => $workingHours,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Punched out successfully',
                    'working_hours' => $workingHours,
                    'punch_out_time' => $formattedTime,
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Punch out calculation error: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error calculating working hours: ' . $e->getMessage()
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }

    /**
     * Store a new attendance regularization request from employee.
     */
    public function storeRegularization(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'correct_punch_in' => 'required|date_format:H:i',
            'correct_punch_out' => 'required|date_format:H:i|after:correct_punch_in',
            'reason' => 'required|string|max:500',
        ]);

        // Check if a pending or approved regularization already exists
        $existingRegularization = Regularization::where('attendance_id', $request->attendance_id)
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRegularization) {
            return redirect()->back()->with('error', 'A regularization request already exists for this attendance record.');
        }

        // Create the regularization request
        Regularization::create([
            'attendance_id' => $request->attendance_id,
            'user_id'       => Auth::id(),
            'requested_punch_in'  => $request->correct_punch_in,
            'requested_punch_out' => $request->correct_punch_out,
            'reason'        => $request->reason,
            'status'        => 'pending',
        ]);

        return redirect()->back()->with('success', 'Regularization request submitted successfully.');
    }
}