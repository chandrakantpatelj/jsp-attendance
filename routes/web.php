<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role == 1) {
            dd($user->role);
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 2) {
            dd($user->role);
            return redirect()->route('employee.dashboard');
        }
    }
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    //Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/attendance-regularization', [ProfileController::class, 'AttendanceRegularization'])->name('attendance-regularization');

    //Admin route employee
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

    //Admin route Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::post('attendance/{id}/update', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');

    //Employee route leave 
    Route::get('/my-leave', [LeaveController::class, 'MyLeave'])->name('my-leave');
    Route::get('my-leave/create', [LeaveController::class, 'create'])->name('my-leave.create');
    Route::post('my-leave/store', [LeaveController::class, 'store'])->name('my-leave.store');
    Route::get('my-leave/{id}/edit', [LeaveController::class, 'edit'])->name('my-leave.edit');
    Route::post('my-leave/{id}/update', [LeaveController::class, 'update'])->name('my-leave.update');
    Route::delete('attendancemy-leave/{id}', [LeaveController::class, 'destroy'])->name('my-leave.destroy');

});

require __DIR__ . '/auth.php';