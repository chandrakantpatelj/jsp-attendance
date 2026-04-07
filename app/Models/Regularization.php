<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regularization extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'regularizations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attendance_id',
        'user_id',
        'requested_punch_in',
        'requested_punch_out',
        'reason',
        'status',
    ];

    /**
     * Get the attendance record that owns the regularization request.
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    /**
     * Get the user (employee) that created the regularization request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'requested_punch_in' => 'string',
        'requested_punch_out' => 'string',
    ];
}