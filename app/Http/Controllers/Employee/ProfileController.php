<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
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

    /**
     * Display attendance records for the logged-in employee with optional date filtering.
     */
    public function AttendanceRegularization(Request $request)
    {
        $userId = Auth::id();
        $query = Attendance::where('employee_id', $userId);

        // Apply date filters if provided
        if ($request->filled('from')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $query->whereDate('attendance_date', '>=', $from);
        }

        if ($request->filled('to')) {
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereDate('attendance_date', '<=', $to);
        }

        // Order by date descending (most recent first) and group by date
        $attendances = $query->orderBy('attendance_date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->attendance_date)->toDateString();
            });

        return view('employee.attendance_regularization', [
            'attendance' => $attendances,
            'from' => $request->from,
            'to' => $request->to,
        ]);
    }

    /**
     * Export attendance records as CSV for the logged-in employee.
     */
    public function AttendanceRegularizationCsv(Request $request)
    {
        $userId = Auth::id();
        $query = Attendance::where('employee_id', $userId);

        // Apply same filters as the index page
        if ($request->filled('from')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $query->whereDate('attendance_date', '>=', $from);
        }

        if ($request->filled('to')) {
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereDate('attendance_date', '<=', $to);
        }

        $attendances = $query->orderBy('attendance_date', 'desc')->get();

        $filename = 'attendance-regularization-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->streamDownload(function () use ($attendances) {
            $handle = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Headers
            fputcsv($handle, ['Date', 'Punch In', 'Punch Out', 'Working Hours']);

            foreach ($attendances as $record) {
                fputcsv($handle, [
                    Carbon::parse($record->attendance_date)->format('d M Y'),
                    $record->punch_in_time ?? '--',
                    $record->punch_out_time ?? '--',
                    $record->working_hours ?? '--',
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    public function MyLeave()
    {
        return view('employee.myleave');
    }
}