<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'leave_dates',
        'start_date',
        'end_date',
        'leave_type',
        'total_days',
        'reason',
        'status',
    ];

    protected $casts = [
        'leave_dates' => 'array',
    ];

    /**
     * Get the employee that owns the leave.
     */
    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}