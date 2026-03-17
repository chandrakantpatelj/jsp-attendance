<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;
use Carbon\Carbon;

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
        //$leaves = Leave::with('employee')->get();
        $employees = User::where('role_id', 2)->get();
        return view('employee.myleave', compact('leaves', 'employees', 'status', 'leaveType'));
    }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'leavestatus' => 'required|in:1,2,3',
    //         'leaveStartDate' => 'required|date|after_or_equal:today',
    //         'leaveEndDate' => 'required|date|after_or_equal:leaveStartDate',
    //         'leaveTotalDay' => 'required',
    //         'leaveReason' => 'required|string|min:5|max:255',
    //     ]);
    //     $employee_id = auth()->user()->id;
    //     Leave::create([
    //         'employee_id' => $employee_id,
    //         'start_date' => $request->leaveStartDate,
    //         'end_date' => $request->leaveEndDate,
    //         'leave_type' => $request->leavestatus,
    //         'total_days' => $request->leaveTotalDay,
    //         'reason' => $request->leaveReason,
    //         'status' => 'pending',
    //     ]);

    //     return redirect()->route('my-leave')->with('success', 'Leave request added successfully!');
    // }
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
        if ($validated === false) {
            dd($request->errors());
        }
        $employee_id = auth()->user()->id;
    
        $leaveDates = [];
        
        foreach ($request->leaveStartDate as $index => $startDate) {
            $formattedStartDate = \Carbon\Carbon::parse($startDate)->format('d-m-Y');
            $formattedEndDate = \Carbon\Carbon::parse($request->leaveEndDate[$index])->format('d-m-Y');
    
            // Calculate the number of days for this leave
            $totalDays = \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($request->leaveEndDate[$index])) + 1;
            $leaveDates[] = [
                'start_date' => $formattedStartDate,
                'end_date' => $formattedEndDate,
                'leave_type' => $this->getLeaveTypeName($request->leavestatus[$index]),
                'status' => 'pending',
                //'days' => $totalDays,
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
    
        return redirect()->route('my-leave')->with('success', 'Leave request added successfully!');
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

        return redirect()->route('my-leave')->with('success', 'Leave request updated successfully!');
    }

    public function destroy($id)
    {
        $employee_id = auth()->user()->id;
        $leave = Leave::where('employee_id', $employee_id)->findOrFail($id);
        $leave->delete();

        return redirect()->route('my-leave')->with('success', 'Leave request deleted successfully!');
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
    
    public function updateStatus(Request $request)
    {
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
            return response()->json([
                'status' => 'success',
                'message' => 'Leave status updated successfully.'
            ]);
        }
    
        return response()->json(['message' => 'Leave not found!'], 404);
    }


}