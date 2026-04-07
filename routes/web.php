<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\RegularizationController as AdminRegularizationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Employee\AttendanceController as EmployeeAttendanceController;
use App\Http\Controllers\Employee\LeaveController as EmployeeLeaveController;
use App\Http\Controllers\Employee\ProfileController as EmployeeProfileController;
use App\Http\Controllers\Employee\RegularizationController as EmployeeRegularizationController;
use App\Http\Controllers\PendingApprovalsController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsEmployee;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

// Optional artisan command routes
Route::get('/run-mark-absent', function () {
    Artisan::call('attendance:mark-absent');
    return "Absent employees have been marked!";
});

Route::get('/fix-password', function () {
    $user = \App\Models\User::where('email', 'chandrakant7389@gmail.com')->first();
    $user->password = bcrypt('admin@123');
    $user->save();
    return 'Password fixed';
});

// Home redirection based on role
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_id == 2) {
            return redirect()->route('employee.dashboard');
        }
    }
    return view('auth.login');
})->name('home');

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Admin routes
    Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Employee management
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('/employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('/employee/export/csv', [EmployeeController::class, 'exportCsv'])->name('employee.csv');

        // Attendance management (list view)
        Route::get('/attendance', [AdminAttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance/store', [AdminAttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{id}/edit', [AdminAttendanceController::class, 'edit'])->name('attendance.edit');
        Route::post('/attendance/{id}/update', [AdminAttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('/attendance/{id}', [AdminAttendanceController::class, 'destroy'])->name('attendance.destroy');

        // Employee attendance & regularization (admin view)
        Route::get('/employee-attendance', [AdminProfileController::class, 'AttendanceRegularizationAdmin'])->name('employee-attendance');
        Route::get('/employee-attendance/csv', [AdminProfileController::class, 'AttendanceRegularizationAdminCsv'])->name('employee-attendance.csv');
        Route::get('/employee-attendance/punch', [AdminAttendanceController::class, 'getDayPunchData'])->name('employee-attendance.punch');

        // Leave approvals
        Route::post('/leave/approve/{id}', [AdminLeaveController::class, 'approve'])->name('leave.approve');
        Route::post('/leave/reject/{id}', [AdminLeaveController::class, 'reject'])->name('leave.reject');
        Route::post('/update-leave-status', [AdminLeaveController::class, 'updateStatus'])->name('update.leave.status');

        // Pending approvals routes
        Route::get('/leave-approvals', [PendingApprovalsController::class, 'leaveApprovals'])->name('leave-approvals');
        Route::get('/regularizations', [AdminRegularizationController::class, 'index'])->name('regularizations');
        Route::post('/regularizations/{id}/approve', [AdminRegularizationController::class, 'approve'])->name('regularizations.approve');
        Route::post('/regularizations/{id}/reject', [AdminRegularizationController::class, 'reject'])->name('regularizations.reject');
    });

    // ========== EMPLOYEE ROUTES - FIXED ==========
    Route::middleware(['auth', IsEmployee::class])->prefix('employee')->name('employee.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile', [EmployeeProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [EmployeeProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [EmployeeProfileController::class, 'destroy'])->name('profile.destroy');

        // ========== ATTENDANCE REGULARIZATION - USING CORRECT CONTROLLER ==========
        Route::get('/attendance-regularization', [EmployeeRegularizationController::class, 'index'])->name('attendance-regularization');
        Route::get('/attendance-regularization/csv', [EmployeeRegularizationController::class, 'exportCsv'])->name('attendance-regularization.csv');
        Route::post('/attendance-regularization', [EmployeeRegularizationController::class, 'store'])->name('attendance-regularization.store');

        // Punch routes
        Route::post('/punch-in', [EmployeeAttendanceController::class, 'punchIn'])->name('punch-in');
        Route::post('/punch-out', [EmployeeAttendanceController::class, 'punchOut'])->name('punch-out');

        // My Leave (CRUD)
        Route::get('/my-leave', [EmployeeLeaveController::class, 'MyLeave'])->name('my-leave');
        Route::get('/my-leave/csv', [EmployeeLeaveController::class, 'csv'])->name('my-leave.csv');
        Route::get('/my-leave/create', [EmployeeLeaveController::class, 'create'])->name('my-leave.create');
        Route::post('/my-leave/store', [EmployeeLeaveController::class, 'store'])->name('my-leave.store');
        Route::get('/my-leave/{id}/edit', [EmployeeLeaveController::class, 'edit'])->name('my-leave.edit');
        Route::put('/my-leave/{id}', [EmployeeLeaveController::class, 'update'])->name('my-leave.update');
        Route::delete('/my-leave/{id}', [EmployeeLeaveController::class, 'destroy'])->name('my-leave.destroy');

        // Punch data (existing)
        Route::post('/save-punch-data', [EmployeeAttendanceController::class, 'savePunchData'])->name('save-punch-data');
    });
});

// Include auth routes
require __DIR__ . '/auth.php';