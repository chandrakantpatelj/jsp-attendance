<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Leave;

class LeaveController extends Controller
{
    public function MyLeave()
    {
        $leaves = Leave::with('employee')->get();
        $employees = User::where('role_id', 2)->get();
        return view('employee.myleave', compact('leaves', 'employees'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'leavestatus' => 'required|in:1,2,3',
            'leaveStartDate' => 'required|date|after_or_equal:today',
            'leaveEndDate' => 'required|date|after_or_equal:leaveStartDate',
            'leaveTotalDay' => 'required|numeric|min:1',
            'leaveReason' => 'required|string|min:5|max:255',
        ]);
        $employee_id = auth()->user()->id;
        Leave::create([
            'employee_id' => $employee_id,
            'start_date' => $request->leaveStartDate,
            'end_date' => $request->leaveEndDate,
            'leave_type' => $request->leavestatus,  // Assuming 'leavestatus' corresponds to 'leave_type'
            'reason' => $request->leaveReason,
            'status' => 'pending',
        ]);

        return redirect()->route('my-leave')->with('success', 'Leave request added successfully!');
    }

}