<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PunchController extends Controller
{
    // public function action(Request $request)
    // {
    //     $data = $request->validate([
    //         'type' => 'required|string|in:in,out',
    //         'timestamp' => 'nullable|integer',
    //     ]);

    //     $user = Auth::guard('api')->user();
    //     if (! $user) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Unauthorized',
    //         ], 401);
    //     }

    //     try {
    //         $tsSeconds = (int) floor(((int) $data['timestamp']) / 1000);
    //         $dt = Carbon::createFromTimestamp($tsSeconds, config('app.timezone'));
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Invalid timestamp',
    //         ], 422);
    //     }

    //     $attendanceDate = $dt->toDateString();
    //     $timeValue = $dt->format('h:i:s A');

    //     $attendance = Attendance::where('employee_id', $user->id)
    //         ->where('attendance_date', $attendanceDate)
    //         ->first();

    //     if ($data['type'] === 'in') {
    //         if ($attendance) {
    //             if ($attendance->status === 'absent') {
    //                 $attendance->update([
    //                     'punch_in_time' => $timeValue,
    //                     'punch_out_time' => null,
    //                     'status' => 'present',
    //                     'working_hours' => '0',
    //                 ]);

    //                 return response()->json([
    //                     'status' => 'success',
    //                     'punchId' => 'p_' . $attendance->id,
    //                 ]);
    //             }

    //             if ($attendance->punch_in_time && $attendance->punch_out_time === null) {
    //                 return response()->json([
    //                     'status' => 'success',
    //                     'punchId' => 'p_' . $attendance->id,
    //                 ]);
    //             }

    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Already punched in',
    //             ], 409);
    //         }

    //         $attendance = Attendance::create([
    //             'employee_id' => $user->id,
    //             'attendance_date' => $attendanceDate,
    //             'punch_in_time' => $timeValue,
    //             'punch_out_time' => null,
    //             'status' => 'present',
    //             'working_hours' => '0',
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'punchId' => 'p_' . $attendance->id,
    //         ]);
    //     }

    //     if ($data['type'] === 'out') {
    //         if (! $attendance || ! $attendance->punch_in_time) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'No active punch-in found',
    //             ], 409);
    //         }

    //         if ($attendance->punch_out_time !== null) {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'punchId' => 'p_' . $attendance->id,
    //             ]);
    //         }

    //         try {
    //             $punchIn = Carbon::createFromFormat('Y-m-d h:i:s A', $attendanceDate . ' ' . $attendance->punch_in_time, config('app.timezone'));
    //             $punchOut = Carbon::createFromFormat('Y-m-d h:i:s A', $attendanceDate . ' ' . $timeValue, config('app.timezone'));
    //             if ($punchOut->lt($punchIn)) {
    //                 $punchOut->addDay();
    //             }

    //             $diffSeconds = $punchOut->diffInSeconds($punchIn);
    //             $workingHours = gmdate('H:i:s', $diffSeconds);
    //         } catch (\Exception $e) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Unable to compute working hours',
    //             ], 422);
    //         }

    //         $attendance->update([
    //             'punch_out_time' => $timeValue,
    //             'working_hours' => $workingHours,
    //         ]);

    //         return response()->json([
    //             'status' => 'success',
    //             'punchId' => 'p_' . $attendance->id,
    //         ]);
    //     }

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => 'Invalid type',
    //     ], 422);
    // }

    public function action(Request $request)
    {
        // 1️⃣ Validation (datetime / timestamp OPTIONAL)
        $data = $request->validate([
            'type' => 'required|string|in:in,out',
            'timestamp' => 'nullable|integer|min:1',
            'datetime' => 'nullable|string',
            'timezone' => 'nullable|string',
        ]);

        // 2️⃣ Auth user
        $user = Auth::guard('api')->user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        // 3️⃣ DateTime resolve (AUTO if client not send)
        try {
            $appTz = config('app.timezone');
            $clientTz = $data['timezone'] ?? $appTz;

            if (!empty($data['datetime'])) {

                $dt = Carbon::parse($data['datetime'], $clientTz);
                $dt->setTimezone($appTz);
            } elseif (!empty($data['timestamp'])) {

                $timestamp = (int) $data['timestamp'];
                $tsSeconds = $timestamp > 1000000000000
                    ? (int) floor($timestamp / 1000)
                    : $timestamp;

                $dt = Carbon::createFromTimestamp(
                    $tsSeconds,
                    $clientTz
                );

                $dt->setTimezone($appTz);
            } else {
                // 🔥 AUTO server time
                $dt = Carbon::now($appTz);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid date/time',
            ], 422);
        }

        // 4️⃣ Prepare values
        $attendanceDate = $dt->toDateString();
        $timeValue = $dt->format('h:i:s A');

        // 5️⃣ Get latest open attendance (for duplicate punch-in / punch-out)
        $openAttendance = Attendance::where('employee_id', $user->id)
            ->whereNotNull('punch_in_time')
            ->whereNull('punch_out_time')
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->first();

        // ============================
        // ⏱️ PUNCH IN
        // ============================
        if ($data['type'] === 'in') {

            // If there is an open punch, do not create a new entry
            if ($openAttendance) {
                return response()->json([
                    'status' => 'success',
                    'punchId' => 'p_' . $openAttendance->id,
                ]);
            }

            // If today record exists with absent status, update it instead of creating a new one
            $absentAttendanceToday = Attendance::where('employee_id', $user->id)
                ->where('attendance_date', $attendanceDate)
                ->where('status', 'absent')
                ->orderByDesc('id')
                ->first();

            if ($absentAttendanceToday) {
                $absentAttendanceToday->update([
                    'punch_in_time' => $timeValue,
                    'punch_out_time' => null,
                    'status' => 'present',
                    'working_hours' => '00:00:00',
                ]);

                return response()->json([
                    'status' => 'success',
                    'punchId' => 'p_' . $absentAttendanceToday->id,
                ]);
            }

            // Create a NEW attendance entry for every new punch-in session
            $attendance = Attendance::create([
                'employee_id' => $user->id,
                'attendance_date' => $attendanceDate,
                'punch_in_time' => $timeValue,
                'punch_out_time' => null,
                'status' => 'present',
                'working_hours' => '00:00:00',
            ]);

            return response()->json([
                'status' => 'success',
                'punchId' => 'p_' . $attendance->id,
            ]);
        }

        // ============================
        // ⏱️ PUNCH OUT
        // ============================
        if ($data['type'] === 'out') {

            // Always punch-out the latest open punch
            $attendance = $openAttendance;

            if (! $attendance || ! $attendance->punch_in_time) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No active punch-in found',
                ], 409);
            }

            // Already punched out → safe return
            if ($attendance->punch_out_time !== null) {
                return response()->json([
                    'status' => 'success',
                    'punchId' => 'p_' . $attendance->id,
                ]);
            }

            try {
                $tz = config('app.timezone');

                $punchIn = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $attendance->attendance_date . ' ' . $attendance->punch_in_time,
                    $tz
                );

                $punchOut = $dt->copy()->setTimezone($tz);

                // 🌙 Night shift support
                if ($punchOut->lt($punchIn)) {
                    $punchOut->addDay();
                }

                // ✅ CORRECT ORDER
                $diffSeconds = $punchIn->diffInSeconds($punchOut);

                $hours   = intdiv($diffSeconds, 3600);
                $minutes = intdiv($diffSeconds % 3600, 60);
                $seconds = $diffSeconds % 60;

                $workingHours = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to compute working hours',
                ], 422);
            }

            $attendance->update([
                'punch_out_time' => $timeValue,
                'working_hours' => $workingHours,
            ]);

            return response()->json([
                'status' => 'success',
                'punchId' => 'p_' . $attendance->id,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid type',
        ], 422);
    }

    public function history(Request $request)
    {
        $data = $request->validate([
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $limit = (int) ($data['limit'] ?? 20);

        $user = Auth::guard('api')->user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $tz = config('app.timezone');

        $attendances = Attendance::where('employee_id', $user->id)
            ->whereNotNull('punch_in_time')
            ->orderByDesc('attendance_date')
            ->orderByDesc('id')
            ->limit(min(200, $limit * 2))
            ->get();

        $events = [];

        foreach ($attendances as $attendance) {
            try {
                $punchIn = Carbon::createFromFormat(
                    'Y-m-d h:i:s A',
                    $attendance->attendance_date . ' ' . $attendance->punch_in_time,
                    $tz
                );

                $events[] = [
                    'id' => 'p_' . $attendance->id . '_in',
                    'type' => 'in',
                    'timestamp' => ((int) $punchIn->timestamp) * 1000,
                    '_sort' => ((int) $punchIn->timestamp) * 1000,
                ];

                if ($attendance->punch_out_time !== null) {
                    $punchOut = Carbon::createFromFormat(
                        'Y-m-d h:i:s A',
                        $attendance->attendance_date . ' ' . $attendance->punch_out_time,
                        $tz
                    );

                    if ($punchOut->lt($punchIn)) {
                        $punchOut->addDay();
                    }

                    $events[] = [
                        'id' => 'p_' . $attendance->id . '_out',
                        'type' => 'out',
                        'timestamp' => ((int) $punchOut->timestamp) * 1000,
                        '_sort' => ((int) $punchOut->timestamp) * 1000,
                    ];
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        usort($events, function (array $a, array $b) {
            return ($b['_sort'] ?? 0) <=> ($a['_sort'] ?? 0);
        });

        $history = array_slice($events, 0, $limit);
        $history = array_map(function (array $item) {
            unset($item['_sort']);
            return $item;
        }, $history);

        return response()->json([
            'history' => $history,
        ]);
    }
}
