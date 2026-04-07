<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function MyLeave()
    {
        $user = auth()->user();
        $status = request()->query('status');
        $leaveType = request()->query('leave_type');

        $leavesQuery = Leave::with('employee')->where('employee_id', $user->id);
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $leavesQuery->where('status', $status);
        }

        if (in_array($leaveType, ['First half', 'Second half', 'Full day'], true)) {
            $leavesQuery->where(function ($query) use ($leaveType) {
                $query->where('leave_type', $leaveType)
                    ->orWhere('leave_dates', 'like', '%"leave_type":"' . $leaveType . '"%');
            });
        }

        $leaves = $leavesQuery->latest()->paginate(5)->withQueryString();
        $employees = User::where('role_id', 2)->get();
        return view('employee.myleave', compact('leaves', 'employees', 'status', 'leaveType'));
    }

    /**
     * Export leaves as CSV
     */
    public function csv(Request $request)
    {
        $user = auth()->user();
        $status = $request->query('status');
        $leaveType = $request->query('leave_type');

        $leavesQuery = Leave::with('employee')->where('employee_id', $user->id);
        
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $leavesQuery->where('status', $status);
        }

        if (in_array($leaveType, ['First half', 'Second half', 'Full day'], true)) {
            $leavesQuery->where(function ($query) use ($leaveType) {
                $query->where('leave_type', $leaveType)
                    ->orWhere('leave_dates', 'like', '%"leave_type":"' . $leaveType . '"%');
            });
        }

        $leaves = $leavesQuery->latest()->get();

        $filename = 'my-leave-' . now()->format('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->streamDownload(function () use ($leaves) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Leave Type', 'Start Date', 'End Date', 'Total Days', 'Reason', 'Status']);

            foreach ($leaves as $leave) {
                fputcsv($handle, [
                    $leave->leave_type ?? 'Full day',
                    Carbon::parse($leave->start_date)->format('d M Y'),
                    Carbon::parse($leave->end_date)->format('d M Y'),
                    $leave->total_days,
                    $leave->reason,
                    ucfirst($leave->status),
                ]);
            }

            fclose($handle);
        }, $filename, $headers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leavestatus' => 'required|array|min:1',
            'leavestatus.*' => 'required|in:1,2,3', 
            'leaveStartDate.*' => 'required|date|after_or_equal:today',
            'leaveEndDate.*' => 'required|date|after_or_equal:leaveStartDate.*',
            'leaveTotalDay' => 'required',
            'leaveReason' => 'required|string|min:5|max:255',
        ]);
        
        $employee_id = auth()->user()->id;
    
        $leaveDates = [];
        
        foreach ($request->leaveStartDate as $index => $startDate) {
            $formattedStartDate = \Carbon\Carbon::parse($startDate)->format('d-m-Y');
            $formattedEndDate = \Carbon\Carbon::parse($request->leaveEndDate[$index])->format('d-m-Y');
    
            $totalDays = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($request->leaveEndDate[$index])) + 1;
            $leaveDates[] = [
                'start_date' => $formattedStartDate,
                'end_date' => $formattedEndDate,
                'leave_type' => $this->getLeaveTypeName($request->leavestatus[$index]),
                'status' => 'pending',
            ];
        }

        $startDateForRow = collect($request->leaveStartDate)->min();
        $endDateForRow = collect($request->leaveEndDate)->max();
        $uniqueLeaveTypes = collect($request->leavestatus)->unique()->values();
        $leaveTypeForRow = $uniqueLeaveTypes->count() === 1
            ? $this->getLeaveTypeName((int) $uniqueLeaveTypes->first())
            : 'Full day';
        
        Leave::create([
            'employee_id' => $employee_id,
            'leave_dates' => $leaveDates,
            'start_date' => $startDateForRow,
            'end_date' => $endDateForRow,
            'leave_type' => $leaveTypeForRow,
            'total_days' => $request->leaveTotalDay,
            'reason' => $request->leaveReason,
            'status' => 'pending',
        ]);
    
        // FIXED: Use the correct route name with employee. prefix
        return redirect()->route('employee.my-leave')->with('success', 'Leave request added successfully!');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $status = request()->query('status');

        $leavesQuery = Leave::with('employee')->where('employee_id', $user->id);
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $leavesQuery->where('status', $status);
        }

        $leaves = $leavesQuery->latest()->paginate(5)->withQueryString();
        $employees = User::where('role_id', 2)->get();

        $editLeave = Leave::where('employee_id', $user->id)->findOrFail($id);

        return view('employee.myleave', compact('leaves', 'employees', 'status', 'editLeave'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'leavestatus' => 'required|array|min:1',
            'leavestatus.*' => 'required|in:1,2,3',
            'leaveStartDate.*' => 'required|date',
            'leaveEndDate.*' => 'required|date',
            'leaveTotalDay' => 'required',
            'leaveReason' => 'required|string|min:5|max:255',
        ]);

        $employee_id = auth()->user()->id;
        $leave = Leave::where('employee_id', $employee_id)->findOrFail($id);

        $leaveDates = [];
        foreach ($request->leaveStartDate as $index => $startDate) {
            $formattedStartDate = \Carbon\Carbon::parse($startDate)->format('d-m-Y');
            $formattedEndDate = \Carbon\Carbon::parse($request->leaveEndDate[$index])->format('d-m-Y');

            $leaveDates[] = [
                'start_date' => $formattedStartDate,
                'end_date' => $formattedEndDate,
                'leave_type' => $this->getLeaveTypeName($request->leavestatus[$index]),
                'status' => $leave->leave_dates[$index]['status'] ?? ($leave->status ?? 'pending'),
            ];
        }

        $startDateForRow = collect($request->leaveStartDate)->min();
        $endDateForRow = collect($request->leaveEndDate)->max();
        $uniqueLeaveTypes = collect($request->leavestatus)->unique()->values();
        $leaveTypeForRow = $uniqueLeaveTypes->count() === 1
            ? $this->getLeaveTypeName((int) $uniqueLeaveTypes->first())
            : 'Full day';

        $leave->update([
            'leave_dates' => $leaveDates,
            'start_date' => $startDateForRow,
            'end_date' => $endDateForRow,
            'leave_type' => $leaveTypeForRow,
            'total_days' => $request->leaveTotalDay,
            'reason' => $request->leaveReason,
        ]);

        // FIXED: Use the correct route name with employee. prefix
        return redirect()->route('employee.my-leave')->with('success', 'Leave request updated successfully!');
    }

    public function destroy($id)
    {
        $employee_id = auth()->user()->id;
        $leave = Leave::where('employee_id', $employee_id)->findOrFail($id);
        $leave->delete();

        // FIXED: Use the correct route name with employee. prefix
        return redirect()->route('employee.my-leave')->with('success', 'Leave request deleted successfully!');
    }
    
    private function getLeaveTypeName($value)
    {
        $types = [
            1 => 'First half',
            2 => 'Second half',
            3 => 'Full day',
        ];
    
        return $types[$value] ?? 'Unknown';
    }
}