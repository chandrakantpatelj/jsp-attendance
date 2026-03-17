<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $token = Auth::guard('api')->attempt([
            'business_email' => $data['email'],
            'password' => $data['password'],
        ]);

        if (! $token) {
            return response()->json([
                'success' => false,
                'message' => trans('auth.failed'),
            ], 401);
        }

        $user = Auth::guard('api')->user();

        return response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => Auth::guard('api')->user(),
        ]);
    }
    
    public function logout(Request $request)
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }

    public function status(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $tz = config('app.timezone');

        $today = Carbon::now($tz)->toDateString();

        $openAttendance = Attendance::where('employee_id', $user->id)
            ->where('attendance_date', $today)
            ->whereNotNull('punch_in_time')
            ->whereNull('punch_out_time')
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->first();

        $isPunchedIn = (bool) $openAttendance;
        $punchInTime = null;
        $punchOutTime = null;
        $activeSession = null;
        $session = 'off';

        $firstInToday = Attendance::where('employee_id', $user->id)
            ->where('attendance_date', $today)
            ->whereNotNull('punch_in_time')
            ->orderBy('attendance_date')
            ->orderBy('id')
            ->first();

        if ($firstInToday) {
            try {
                $firstIn = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $firstInToday->attendance_date . ' ' . $firstInToday->punch_in_time,
                    $tz
                );
                $punchInTime = ((int) $firstIn->timestamp) * 1000;
            } catch (\Exception $e) {
                $punchInTime = null;
            }
        }

        $lastOutToday = Attendance::where('employee_id', $user->id)
            ->where('attendance_date', $today)
            ->whereNotNull('punch_out_time')
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->first();

        if ($lastOutToday) {
            try {
                $lastOut = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $lastOutToday->attendance_date . ' ' . $lastOutToday->punch_out_time,
                    $tz
                );
                $punchOutTime = ((int) $lastOut->timestamp) * 1000;
            } catch (\Exception $e) {
                $punchOutTime = null;
            }
        }

        if ($openAttendance) {
            $session = 'on';
            $activeSession = 'sess_' . $openAttendance->id;
        }

        return response()->json([
            'isPunchedIn' => $isPunchedIn,
            'punchInTime' => $punchInTime,
            'punchOutTime' => $punchOutTime,
            'activeSession' => $activeSession,
            'session' => $session,
        ]);
    }
}
