<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function AttendanceRegularizationAdmin(Request $request)
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');
        $month = $request->input('month', $currentMonth);
        $year = $request->input('year', $currentYear);

        // Get all employees
        $employees = User::where('role_id', 2)->orderBy('name')->get(['id', 'name']);

        // Get all attendance records for the selected month and year
        $attendanceRecords = Attendance::with('employee')
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->orderBy('attendance_date', 'asc')
            ->get();

        // Group attendance by employee_id
        $attendance = $attendanceRecords->groupBy('employee_id');

        return view('admin.employee-attendance', [
            'employees' => $employees,
            'attendance' => $attendance,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function AttendanceRegularizationAdminCsv(Request $request)
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        $month = (int) $request->input('month', $currentMonth);
        $year = (int) $request->input('year', $currentYear);

        if ($month < 1 || $month > 12 || $year < 2000 || $year > 2100) {
            abort(400, 'Invalid month/year.');
        }

        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        $employees = User::where('role_id', 2)->orderBy('name')->get(['id', 'name']);

        $attendanceRecords = Attendance::with('employee')
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->orderBy('attendance_date', 'asc')
            ->get();

        $attendanceByEmployee = $attendanceRecords->groupBy('employee_id');

        $fileName = 'employee-attendance-' . $year . '-' . str_pad((string) $month, 2, '0', STR_PAD_LEFT) . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return response()->streamDownload(function () use ($employees, $attendanceByEmployee, $year, $month, $daysInMonth) {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }

            // UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            $headerRow = ['Employee Name'];
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $headerRow[] = (string) $i;
            }
            fputcsv($handle, $headerRow);

            foreach ($employees as $employee) {
                $records = $attendanceByEmployee->get($employee->id, collect());
                $row = [$employee->name];

                for ($i = 1; $i <= $daysInMonth; $i++) {
                    $date = Carbon::create($year, $month, $i);
                    $dateString = $date->format('Y-m-d');

                    $dayRecords = $records->filter(static function ($item) use ($dateString) {
                        $itemDate = $item->attendance_date ?? null;
                        if (empty($itemDate)) return false;
                        return Carbon::parse($itemDate)->toDateString() === $dateString;
                    });

                    if ($dayRecords->isNotEmpty()) {
                        $attendance = $dayRecords->first();
                        
                        if ($attendance->status === 'leave') {
                            $row[] = 'L';
                        } elseif ($attendance->status === 'half-day') {
                            $row[] = 'P(H)';
                        } elseif ($attendance->punch_in_time && !$attendance->punch_out_time) {
                            $row[] = 'P*';
                        } elseif ($attendance->punch_in_time && $attendance->punch_out_time) {
                            $row[] = 'P';
                        } else {
                            $row[] = 'A';
                        }
                    } else {
                        $isWeekend = $date->isWeekend();
                        $isSecondSaturday = $date->isSaturday() && $date->day > 7 && $date->day <= 14;
                        
                        if ($isWeekend && !$isSecondSaturday) {
                            $row[] = 'O';
                        } else {
                            $row[] = 'A';
                        }
                    }
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $fileName, $headers);
    }
}