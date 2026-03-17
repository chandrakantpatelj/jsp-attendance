<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function AttendanceRegularization()
    {
        $userId = Auth::id();
    
        $attendance = Attendance::where('employee_id', $userId)
            ->orderBy('attendance_date', 'asc')
            ->get()
            ->groupBy('attendance_date');
    
        return view('employee.attendance_regularization', ['attendance' => $attendance]);
    }

    public function AttendanceRegularizationAdmin(Request $request)
    {
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y'); 
        $month = $request->input('month', $currentMonth);
        $year = $request->input('year', $currentYear);
        $firstDayOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $lastDayOfMonth = Carbon::create($year, $month, 1)->endOfMonth();
        // $attendance = Attendance::with('employee')
        //     ->whereMonth('attendance_date', $month) 
        //     ->whereYear('attendance_date', $year)
        //     ->orderBy('attendance_date', 'asc')
        //     ->get()
        //     ->groupBy('attendance_date');
        $employees = User::where('role_id', 2)->orderBy('name')->get(['id', 'name']);

        $attendance = Attendance::with('employee')
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->orderBy('attendance_date', 'asc')
            ->get()
            ->groupBy('employee_id');
    
        return view('admin.employee-attendance', ['employees' => $employees, 'attendance' => $attendance, 'month' => $month, 'year' => $year]);
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

        $attendanceByEmployee = Attendance::with('employee')
            ->whereMonth('attendance_date', $month)
            ->whereYear('attendance_date', $year)
            ->orderBy('attendance_date', 'asc')
            ->get()
            ->groupBy('employee_id');

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

                    // Admin decision overrides weekend.
                    if ($dayRecords->contains(static fn($r) => ($r->status ?? null) === 'leave')) {
                        $row[] = 'A';
                        continue;
                    }
                    if ($dayRecords->contains(static fn($r) => ($r->status ?? null) === 'half-day')) {
                        $row[] = 'P(H)';
                        continue;
                    }

                    $isWeekend = $date->isWeekend();
                    $isSecondSaturday = $date->isSaturday() && $date->day > 7 && $date->day <= 14;
                    if ($isWeekend && !$isSecondSaturday) {
                        $row[] = 'O';
                        continue;
                    }

                    $row[] = $dayRecords->count() > 0 ? 'P' : 'A';
                }

                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $fileName, $headers);
    }

     
    public function MyLeave()
    {
        return view('employee.myleave');
    }
}