<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_date',
        'punch_in_time',
        'punch_out_time',
        'status',
        'working_hours',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    /**
     * Get the employee that owns the attendance record.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * Get the user that owns the attendance record (alias for employee).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}