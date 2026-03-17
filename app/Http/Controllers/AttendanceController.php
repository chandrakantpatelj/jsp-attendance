<?php







namespace App\Http\Controllers;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\Leave;

use App\Models\Attendance;

use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    protected function normalizeTimeForInput(?string $time, string $dateString): ?string
    {
        if (!is_string($time) || trim($time) === '') {
            return null;
        }

        $time = trim($time);

        if (preg_match('/^\d{2}:\d{2}$/', $time) === 1) {
            return $time;
        }

        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $time) === 1) {
            return substr($time, 0, 5);
        }

        $tz = config('app.timezone');
        $formats = [
            'Y-m-d h:i:s A',
            'Y-m-d h:i A',
            'Y-m-d H:i:s',
            'Y-m-d H:i',
        ];

        foreach ($formats as $format) {
            try {
                $carbon = Carbon::createFromFormat($format, $dateString . ' ' . $time, $tz);
                return $carbon->format('H:i');
            } catch (\Exception $e) {
                // ignore
            }
        }

        try {
            $carbon = Carbon::parse($dateString . ' ' . $time, $tz);
            return $carbon->format('H:i');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function getAttendanceDayStatusOverride(int $employeeId, string $dateString): ?string
    {
        $dayStatuses = Attendance::where('employee_id', $employeeId)
            ->whereDate('attendance_date', $dateString)
            ->pluck('status')
            ->filter()
            ->map(static fn($s) => is_string($s) ? strtolower($s) : $s);

        if ($dayStatuses->contains('leave')) {
            return 'leave';
        }

        if ($dayStatuses->contains('half-day')) {
            return 'half-day';
        }

        return null;
    }

    public function index()

    {

        $attendances = Attendance::with('employee')->get();

        $employees = User::where('role_id', 2)->get();

        // $leaves = User::where('role_id', 2)->get();

        $status = request()->query('status');

        $leaveType = request()->query('leave_type');

        $name = request()->query('name');

        $leavesQuery = Leave::whereHas('employee', function ($query) {

            $query->where('role_id', 2);
        })->with('employee');

        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $leavesQuery->where('status', $status);
        }

        if (in_array($leaveType, ['First half', 'Second half', 'Full day'], true)) {
            $leavesQuery->where(function ($query) use ($leaveType) {
                $query->where('leave_type', $leaveType)
                    ->orWhere('leave_dates', 'like', '%"leave_type":"' . $leaveType . '"%');
            });
        }

        if (is_string($name) && trim($name) !== '') {
            $search = trim($name);
            $leavesQuery->whereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }

        $leaves = $leavesQuery->latest()->paginate(5)->withQueryString();

        return view('admin.attendance', compact('attendances', 'employees', 'leaves', 'status', 'leaveType', 'name'));
    }

    public function regularizeDayStatus(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|integer|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,half-day,leave',
            'punch_in_time' => 'nullable|required_if:status,present,half-day|date_format:H:i',
            'punch_out_time' => 'nullable|required_if:status,present,half-day|date_format:H:i',
        ]);

        $employee = User::where('role_id', 2)->findOrFail($data['employee_id']);
        $dateString = Carbon::parse($data['date'])->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', $dateString)
            ->orderByDesc('id')
            ->first();

        if ($data['status'] === 'leave') {
            if (!$attendance) {
                Attendance::create([
                    'employee_id' => $employee->id,
                    'attendance_date' => $dateString,
                    'punch_in_time' => null,
                    'punch_out_time' => null,
                    'status' => 'leave',
                    'working_hours' => '00:00:00',
                ]);

                return response()->json(['success' => true]);
            }

            Attendance::where('employee_id', $employee->id)
                ->whereDate('attendance_date', $dateString)
                ->update([
                    'status' => 'leave',
                    'punch_in_time' => null,
                    'punch_out_time' => null,
                    'working_hours' => '00:00:00',
                ]);

            return response()->json(['success' => true]);
        }

        $punchInTime = $this->normalizeTimeFormat($data['punch_in_time']);
        $punchOutTime = $this->normalizeTimeFormat($data['punch_out_time']);

        $punchIn = Carbon::createFromFormat('H:i', $punchInTime);
        $punchOut = Carbon::createFromFormat('H:i', $punchOutTime);
        if ($punchOut->lt($punchIn)) {
            $punchOut->addDay();
        }

        $diffSeconds = $punchIn->diffInSeconds($punchOut);
        $hours = intdiv($diffSeconds, 3600);
        $minutes = intdiv($diffSeconds % 3600, 60);
        $seconds = $diffSeconds % 60;
        $workingHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

        if (!$attendance) {
            Attendance::create([
                'employee_id' => $employee->id,
                'attendance_date' => $dateString,
                'punch_in_time' => $punchInTime,
                'punch_out_time' => $punchOutTime,
                'status' => $data['status'],
                'working_hours' => $workingHours,
            ]);

            return response()->json(['success' => true]);
        }

        $attendance->update([
            'status' => $data['status'],
            'punch_in_time' => $punchInTime,
            'punch_out_time' => $punchOutTime,
            'working_hours' => $workingHours,
        ]);

        return response()->json(['success' => true]);
    }

    public function getDayPunchData(Request $request)
    {
        $data = $request->validate([
            'employee_id' => 'required|integer|exists:users,id',
            'date' => 'required|date',
        ]);

        $employee = User::where('role_id', 2)->findOrFail($data['employee_id']);
        $dateString = Carbon::parse($data['date'])->toDateString();

        $attendance = Attendance::where('employee_id', $employee->id)
            ->whereDate('attendance_date', $dateString)
            ->orderByDesc('id')
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => true,
                'punch_in_time' => null,
                'punch_out_time' => null,
                'working_hours' => null,
            ]);
        }

        $punchIn = $this->normalizeTimeForInput($attendance->punch_in_time, $dateString);
        $punchOut = $this->normalizeTimeForInput($attendance->punch_out_time, $dateString);
        $workingHours = $attendance->working_hours;

        // If working_hours is numeric (some flows store decimal hours), do best-effort formatting.
        if (is_numeric($workingHours)) {
            $totalMinutes = (int) round(((float) $workingHours) * 60);
            $hours = intdiv($totalMinutes, 60);
            $minutes = $totalMinutes % 60;
            $workingHours = sprintf('%02d:%02d:00', $hours, $minutes);
        }

        // If working hours is empty but times exist, compute a display value.
        if ((!is_string($workingHours) || trim($workingHours) === '') && $punchIn && $punchOut) {
            try {
                $in = Carbon::createFromFormat('H:i', $punchIn);
                $out = Carbon::createFromFormat('H:i', $punchOut);
                if ($out->lt($in)) {
                    $out->addDay();
                }
                $diffSeconds = $in->diffInSeconds($out);
                $hours = intdiv($diffSeconds, 3600);
                $minutes = intdiv($diffSeconds % 3600, 60);
                $seconds = $diffSeconds % 60;
                $workingHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            } catch (\Exception $e) {
                $workingHours = null;
            }
        }

        return response()->json([
            'success' => true,
            'punch_in_time' => $punchIn,
            'punch_out_time' => $punchOut,
            'working_hours' => $workingHours,
            'status' => $attendance->status,
        ]);
    }

    public function leaveBalance($employee)
    {
        $employeeModel = User::where('role_id', 2)->findOrFail($employee);

        $leaves = Leave::where('employee_id', $employeeModel->id)->get(['id', 'status', 'total_days']);

        $sumByStatus = $leaves->groupBy('status')->map(static function ($items) {
            return (float) $items->sum(static function ($leave) {
                return (float) ($leave->total_days ?? 0);
            });
        });

        return response()->json([
            'employee' => [
                'id' => $employeeModel->id,
                'name' => $employeeModel->name,
                'designation' => $employeeModel->designation,
            ],
            'requests' => [
                'total' => $leaves->count(),
                'pending' => (int) $leaves->where('status', 'pending')->count(),
                'approved' => (int) $leaves->where('status', 'approved')->count(),
                'rejected' => (int) $leaves->where('status', 'rejected')->count(),
            ],
            'days' => [
                'pending' => (float) ($sumByStatus['pending'] ?? 0),
                'approved' => (float) ($sumByStatus['approved'] ?? 0),
                'rejected' => (float) ($sumByStatus['rejected'] ?? 0),
                'total' => (float) $leaves->sum(static function ($leave) {
                    return (float) ($leave->total_days ?? 0);
                }),
            ],
        ]);
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

        ]);



        $punchInTime = $this->normalizeTimeFormat($request->punch_in_time);

        $punchOutTime = $this->normalizeTimeFormat($request->punch_out_time);



        $punchIn = Carbon::createFromFormat('H:i', $punchInTime);

        $punchOut = Carbon::createFromFormat('H:i', $punchOutTime);

        if ($punchOut->lt($punchIn)) {

            $punchOut->addDay();
        }

        $workingHours = $punchOut->diffInMinutes($punchIn) / 60;


        $dateString = Carbon::parse($request->attendance_date)->toDateString();
        $statusOverride = $this->getAttendanceDayStatusOverride((int) $request->attendances_id, $dateString);



        Attendance::create([

            'employee_id' => $request->attendances_id,

            'attendance_date' => $request->attendance_date,

            'punch_in_time' => $request->punch_in_time,

            'punch_out_time' => $request->punch_out_time,

            'status' => $statusOverride ?? 'present',

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

            $cleanedTimeString = preg_replace('/\s+\([^\)]+\)$/', '', $timeString);

            $carbonDate = Carbon::parse($cleanedTimeString);
            $carbonDate->setTimezone(config('app.timezone'));

            $formattedTime = $carbonDate->format('h:i:s A');
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Invalid timestamp format']);
        }

        $today = $carbonDate->toDateString();

        $statusOverride = $this->getAttendanceDayStatusOverride((int) $userId, $today);

        // **Check if an attendance record already exists**

        $attendance = Attendance::where('employee_id', $userId)
            ->where('attendance_date', $today)
            ->orderByDesc('id')
            ->first();

        $openAttendance = Attendance::where('employee_id', $userId)
            ->where('attendance_date', $today)
            ->whereNotNull('punch_in_time')
            ->whereNull('punch_out_time')
            ->orderByDesc('id')
            ->first();

        // ✅ **If Punch-In**

        if ($data['action'] === 'punch_in') {
            if ($openAttendance) {
                return response()->json(['success' => false, 'message' => 'Already punched in']);
            }

            if ($attendance && $attendance->status === 'absent' && !$attendance->punch_in_time) {
                $attendance->update([
                    'punch_in_time' => $formattedTime,
                    'status' => $statusOverride ?? 'present',
                ]);

                return response()->json(['success' => true, 'message' => 'Absent status updated to Present and Punch-In recorded']);
            }

            // **Insert new Punch-In record if no record exists**

            Attendance::create([
                'employee_id' => $userId,
                'attendance_date' => $today,
                'punch_in_time' => $formattedTime,
                'punch_out_time' => null,
                'status' => $statusOverride ?? 'present',
                'working_hours' => 0,
            ]);

            return response()->json(['success' => true, 'message' => 'Punched in successfully']);
        }

        // ✅ **If Punch-Out**
        if ($data['action'] === 'punch_out') {
            $attendance = $openAttendance;

            if (!$attendance || !$attendance->punch_in_time) {
                return response()->json(['success' => false, 'message' => 'No active punch-in found']);
            }

            $punchOutTime = $formattedTime;

            try {
                $tz = config('app.timezone');
                $punchIn = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $attendance->attendance_date . ' ' . $attendance->punch_in_time,
                    $tz
                );

                $punchOut = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $attendance->attendance_date . ' ' . $punchOutTime,
                    $tz
                );

                if ($punchOut->lt($punchIn)) {
                    $punchOut->addDay();
                }

                $diffSeconds = $punchIn->diffInSeconds($punchOut);
                $hours = intdiv($diffSeconds, 3600);
                $minutes = intdiv($diffSeconds % 3600, 60);
                $seconds = $diffSeconds % 60;
                $formattedWorkingHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

                $attendance->update([
                    'punch_out_time' => $punchOutTime,
                    'working_hours' => $formattedWorkingHours,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Punched out successfully',
                    'punch_out_time' => $punchOutTime,
                    'working_hours' => $formattedWorkingHours,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to punch out',
                ]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid action']);
    }

    public function approve($id)
    {
        $leave = Leave::find($id);


        if (!$leave) {

            return response()->json(['success' => false, 'message' => 'Leave not found.']);
        }




        $leave->status = 'approved';

        if (is_array($leave->leave_dates)) {
            $leaveDates = $leave->leave_dates;
            foreach ($leaveDates as $index => $item) {
                $leaveDates[$index]['status'] = 'approved';
            }
            $leave->leave_dates = $leaveDates;
        }

        $leave->save();



        return response()->json(['success' => true, 'message' => 'Leave approved successfully.']);
    }

    public function reject($id)
    {
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json(['success' => false, 'message' => 'Leave not found.']);
        }

        $leave->status = 'rejected';

        if (is_array($leave->leave_dates)) {
            $leaveDates = $leave->leave_dates;
            foreach ($leaveDates as $index => $item) {
                $leaveDates[$index]['status'] = 'rejected';
            }
            $leave->leave_dates = $leaveDates;
        }

        $leave->save();

        return response()->json(['success' => true, 'message' => 'Leave rejected successfully.']);
    }
}
