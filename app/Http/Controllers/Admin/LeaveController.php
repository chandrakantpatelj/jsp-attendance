<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;

class LeaveController extends Controller
{
    /**
     * Display leave approvals page.
     */
    public function approvals()
    {
        $leaves = Leave::with('employee')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.leave-approvals', compact('leaves'));
    }

    /**
     * Approve a leave request.
     */
    public function approve($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->status = 'approved';
            $leave->save();

            return response()->json([
                'success' => true,
                'message' => 'Leave approved successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject a leave request.
     */
    public function reject($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->status = 'rejected';
            $leave->save();

            return response()->json([
                'success' => true,
                'message' => 'Leave rejected successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update leave status (for individual dates within a leave)
     */
    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|integer',
                'date' => 'required|date',
                'leave_type' => 'required|string',
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $date = Carbon::parse($request->date)->format('d-m-Y');
            
            $leave = Leave::where('employee_id', $request->employee_id)->first();
            
            if ($leave) {
                $leaveDates = $leave->leave_dates;
                
                foreach ($leaveDates as $index => $leaveDate) {
                    if ($leaveDate['start_date'] === $date || $leaveDate['end_date'] === $date) {
                        $leaveDates[$index]['status'] = $request->status;
                        $leave->leave_dates = $leaveDates;

                        $statuses = array_values(array_unique(array_map(static function ($item) {
                            return $item['status'] ?? 'pending';
                        }, $leaveDates)));

                        if (in_array('pending', $statuses, true)) {
                            $leave->status = 'pending';
                        } elseif (in_array('rejected', $statuses, true)) {
                            $leave->status = 'rejected';
                        } else {
                            $leave->status = 'approved';
                        }

                        $leave->save();
                        
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Leave status updated successfully.'
                        ]);
                    }
                }
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Leave not found!'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
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