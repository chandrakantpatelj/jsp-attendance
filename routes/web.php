<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role == 2) {
            return redirect()->route('employee.dashboard');
        }
    }
    return view('auth.login');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/attendance-regularization', [ProfileController::class, 'AttendanceRegularization'])->name('attendance-regularization');
    Route::get('/my-leave', [ProfileController::class, 'MyLeave'])->name('my-leave');

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

});

require __DIR__ . '/auth.php';