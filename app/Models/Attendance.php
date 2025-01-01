<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}