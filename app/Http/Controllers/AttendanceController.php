<?php



namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->get();
        $employees = User::where('role_id', 2)->get();
        return view('admin.attendance', compact('attendances', 'employees'));
    }
    public function create(Request $request)
    {
        $employeeId = $request->query('employee_id');
        $employee = User::find($employeeId);
        return response()->json($employee);
        // return view('admin.attendance.create', compact('employee'));
    }
    public function store(Request $request)
    {

        //dd($request->all());
        //dd($request->punch_in_time, $request->punch_out_time);
        $request->validate([
            'attendances_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'punch_in_time' => 'required',
            'punch_out_time' => 'required',
            //'punch_in_time' => 'required|date_format:H:i',
            //'punch_out_time' => 'required|date_format:H:i|after:punch_in_time',
            'status' => 'required|in:present,absent,half-day,leave',
        ]);

        $punchInTime = $this->normalizeTimeFormat($request->punch_in_time);
        $punchOutTime = $this->normalizeTimeFormat($request->punch_out_time);

        $punchIn = Carbon::createFromFormat('H:i', $punchInTime);
        $punchOut = Carbon::createFromFormat('H:i', $punchOutTime);
        if ($punchOut->lt($punchIn)) {
            $punchOut->addDay();
        }
        $workingHours = $punchOut->diffInMinutes($punchIn) / 60;

        Attendance::create([
            'employee_id' => $request->attendances_id,
            'attendance_date' => $request->attendance_date,
            'punch_in_time' => $request->punch_in_time,
            'punch_out_time' => $request->punch_out_time,
            'status' => $request->status,
            'working_hours' => $workingHours,
        ]);

        return redirect()->route('attendance.index')->with('success', 'Attendance added successfully.');
    }
    protected function normalizeTimeFormat($time)
    {
        // If time includes seconds, remove them
        return substr($time, 0, 5);
    }
    public function edit($id)
    {
        //$attendance = Attendance::findOrFail($id);
        $attendance = Attendance::with('employee')->findOrFail($id);
        return response()->json($attendance);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            //'employee_id' => 'required|exists:users,id',
            'attendance_date' => 'required|date',
            'punch_in_time' => 'required',
            'punch_out_time' => 'required',
            'status' => 'required|in:present,absent,half-day,leave',
        ]);
        $punchInTime = $this->normalizeTimeFormat($request->punch_in_time);
        $punchOutTime = $this->normalizeTimeFormat($request->punch_out_time);

        $punchIn = Carbon::createFromFormat('H:i', $punchInTime);
        $punchOut = Carbon::createFromFormat('H:i', $punchOutTime);
        if ($punchOut->lt($punchIn)) {
            $punchOut->addDay();
        }
        $workingHours = $punchOut->diffInMinutes($punchIn) / 60;
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            // 'employee_id' => $request->employee_id,
            'attendance_date' => $request->attendance_date,
            'punch_in_time' => $request->punch_in_time,
            'punch_out_time' => $request->punch_out_time,
            'status' => $request->status,
            'working_hours' => $workingHours,
        ]);
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');

    }
    public function savePunchData(Request $request)
    {
        //dd($request);
        if (!Auth::check()) {
            return response()->json(['Success' => false, 'Message' => 'Unauthorized']);
        }

        $data = $request->validate([
            'action' => 'required|string|in:punch_in,punch_out',
            'timestamp' => 'required|numeric',
        ]);

        $userId = Auth::id();
        $today = now()->format('Y-m-d');
        $defaultTimezone = 'Asia/Kolkata';

        $timestamp = Carbon::createFromTimestampMs($data['timestamp'], $defaultTimezone);

        if ($data['action'] === 'punch_in') {
            $existingRecord = Attendance::where('employee_id', $userId)->where('attendance_date', $today)->first();
            if ($existingRecord) {
                return response()->json(['Success' => false, 'Message' => 'Already Punched-in']);
            }

            $punchInTimestamp = $timestamp->timestamp;
            $attendance = Attendance::create([
                'employee_id' => $userId,
                'attendance_date' => $today,
                'punch_in_time' => $punchInTimestamp,
                'punch_out_time' => null,
                'status' => 'present',
                'working_hours' => 0,
            ]);

            return response()->json(['success' => true, 'message' => 'Punched in successfully', 'punch_in_time' => $attendance['punch_in_time']]);
        }

        if ($data['action'] === 'punch_out') {
            $attendance = Attendance::where('employee_id', $userId)->where('attendance_date', $today)->first();

            if (!$attendance) {
                return response()->json(['success' => false, 'message' => 'No active punch-in found']);
            }

            if ($attendance->punch_out_time) {
                return response()->json(['success' => false, 'message' => 'You have already punched out for today.']);
            }

            $punchOutTime = Carbon::createFromTimestampMs($request->timestamp);

            $punchInTime = Carbon::createFromTimestamp($attendance->punch_in_time);
            if ($punchOutTime->lt($punchInTime)) {
                $punchOutTime->addDay();
            }
            $timeDiffInSeconds = $punchOutTime->diffInSeconds($punchInTime);

            $hours = floor($timeDiffInSeconds / 3600);
            $minutes = floor(($timeDiffInSeconds % 3600) / 60);
            $seconds = $timeDiffInSeconds % 60;
            dd($timeDiffInSeconds);
            if ($hours == 0 && $minutes == 0 && $seconds > 0) {
                $formattedWorkingHours = "{$seconds} second" . ($seconds > 1 ? 's' : '');
            } else {
                $formattedWorkingHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            }
            $attendance->update([
                'punch_out_time' => $punchOutTime->timestamp,
                'working_hours' => $formattedWorkingHours,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Punched out successfully.',
                'punch_out_time' => $attendance->punch_out_time,
                'working_hours' => $formattedWorkingHours,
            ]);
        }
    }
}