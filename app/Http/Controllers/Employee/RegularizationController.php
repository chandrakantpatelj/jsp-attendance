<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Regularization;
use Carbon\Carbon;

class RegularizationController extends Controller
{
    protected function formatWorkingHoursForDisplay(Attendance $attendance): string
    {
        $raw = $attendance->working_hours;

        if (is_string($raw)) {
            $value = trim($raw);
            if ($value !== '' && !str_contains($value, '-') && preg_match('/^\d{2}:\d{2}:\d{2}$/', $value) === 1) {
                return $value;
            }
        }

        if (is_numeric($raw)) {
            $totalMinutes = (int) round(((float) $raw) * 60);
            $hours = intdiv(max(0, $totalMinutes), 60);
            $minutes = max(0, $totalMinutes) % 60;
            return sprintf('%02d:%02d:00', $hours, $minutes);
        }

        if (is_string($attendance->punch_in_time) && trim($attendance->punch_in_time) !== '') {
            try {
                $tz = config('app.timezone');
                $attendanceDate = Carbon::parse($attendance->attendance_date, $tz)->toDateString();

                $punchIn = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $attendanceDate . ' ' . $attendance->punch_in_time,
                    $tz
                );

                $punchOut = $attendance->punch_out_time
                    ? Carbon::createFromFormat(
                        'Y-m-d h:i:s A',
                        $attendanceDate . ' ' . $attendance->punch_out_time,
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
                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            } catch (\Exception $e) {
                return '00:00:00';
            }
        }

        return '00:00:00';
    }

    public function index()
    {
        $user = auth()->user();
        
        $attendances = Attendance::where('employee_id', $user->id)
            ->orderBy('attendance_date', 'desc')
            ->get();

        foreach ($attendances as $attendance) {
            $attendance->display_working_hours = $this->formatWorkingHoursForDisplay($attendance);
        }
        
        return view('employee.attendance_regularization', compact('attendances'));
    }

    public function store(Request $request)
    {
        // Debug log
        \Log::info('Regularization store method called');
        \Log::info('Request data: ', $request->all());
        
        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'reason' => 'required|string|min:5|max:500',
        ]);

        // Check if a request already exists for this attendance record
        $existing = Regularization::where('attendance_id', $request->attendance_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            \Log::info('Existing request found for attendance_id: ' . $request->attendance_id);
            return response()->json([
                'success' => false,
                'message' => 'A regularization request already exists for this attendance record.'
            ], 400);
        }

        // Get the attendance record to get current times
        $attendance = Attendance::find($request->attendance_id);
        
        $regularization = new Regularization();
        $regularization->user_id = auth()->id();
        $regularization->attendance_id = $request->attendance_id;
        $regularization->reason = $request->reason;
        $regularization->status = 'pending';
        
        // Set requested punch times from the attendance record
        if ($attendance) {
            $regularization->requested_punch_in = $attendance->punch_in_time ? Carbon::parse($attendance->punch_in_time)->format('H:i') : null;
            $regularization->requested_punch_out = $attendance->punch_out_time ? Carbon::parse($attendance->punch_out_time)->format('H:i') : null;
        }
        
        $regularization->save();
        
        \Log::info('Regularization saved with ID: ' . $regularization->id);

        return response()->json([
            'success' => true,
            'message' => 'Regularization request submitted successfully.'
        ]);
    }

    public function exportCsv(Request $request)
    {
        $user = auth()->user();
        
        $attendances = Attendance::where('employee_id', $user->id)
            ->orderBy('attendance_date', 'desc')
            ->get();

        $filename = 'attendance-' . now()->format('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $handle = fopen('php://output', 'w');
        
        fputcsv($handle, ['Date', 'Day', 'Punch In', 'Punch Out', 'Working Hours', 'Status']);

        foreach ($attendances as $attendance) {
            fputcsv($handle, [
                Carbon::parse($attendance->attendance_date)->format('d-m-Y'),
                Carbon::parse($attendance->attendance_date)->format('l'),
                $attendance->punch_in_time ?? 'N/A',
                $attendance->punch_out_time ?? 'N/A',
                $this->formatWorkingHoursForDisplay($attendance),
                ucfirst($attendance->status ?? 'N/A'),
            ]);
        }

        fclose($handle);

        return response()->stream(
            function() use ($handle) {},
            200,
            $headers
        );
    }
}