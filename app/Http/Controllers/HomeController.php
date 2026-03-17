<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Attendance;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index()
     {
         $user = Auth::user();
         $today = now()->format('Y-m-d');
         $attendance = Attendance::where('employee_id', $user->id)
        ->where('attendance_date', $today)
        ->orderByDesc('id')
        ->first();
         $punchData = [
             'isPunchedIn' => $attendance && $attendance->punch_in_time && !$attendance->punch_out_time,
             'punchInTime' => $attendance ? $attendance->punch_in_time : null,
             'punchOutTime' => $attendance ? $attendance->punch_out_time : null,
             'workingHours' => $attendance ? $attendance->working_hours : null,
             'attendanceDate' => $attendance ? $attendance->attendance_date : null,
         ];
         if ($user->role_id == 1) {
             return view('admin.dashboard', compact('user'));
         } elseif ($user->role_id == 2) {
             return view('employee.dashboard', compact('user', 'punchData'));
         }
 
         return redirect()->route('home');
     }


}