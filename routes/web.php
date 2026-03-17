<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsEmployee;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('auth.login');
// });


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
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/', function () {
//     if (Auth::check()) {
//         $user = Auth::user();
//         if ($user->role_id == 1) {
//             return redirect()->route('admin.dashboard');
//         } elseif ($user->role_id == 2) {
//             return redirect()->route('employee.dashboard');
//         }
//     }
//     return view('auth.login');
// })->name('login');
Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->role_id == 1
            ? redirect()->route('admin.dashboard')
            : redirect()->route('employee.dashboard');
    }

    return redirect()->route('login');
});
Route::middleware('auth')->group(function () {
     Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
         Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
         //Admin route employee
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    
        //Admin route Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance/store', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('attendance/{id}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::post('attendance/{id}/update', [AttendanceController::class, 'update'])->name('attendance.update');
        Route::delete('attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
        Route::get('/employee-attendance', [ProfileController::class, 'AttendanceRegularizationAdmin'])->name('employee-attendance');
        Route::get('/employee-attendance/csv', [ProfileController::class, 'AttendanceRegularizationAdminCsv'])->name('employee-attendance.csv');
        Route::post('/employee-attendance/regularize', [AttendanceController::class, 'regularizeDayStatus'])->name('employee-attendance.regularize');
        Route::get('/employee-attendance/punch', [AttendanceController::class, 'getDayPunchData'])->name('employee-attendance.punch');
        Route::get('/leave-balance/{employee}', [AttendanceController::class, 'leaveBalance'])->name('leave.balance');
        Route::post('/leave/approve/{id}', [AttendanceController::class, 'approve'])->name('leave.approve');
        Route::post('/leave/reject/{id}', [AttendanceController::class, 'reject'])->name('leave.reject');

        
        Route::post('/update-leave-status', [LeaveController::class, 'updateStatus'])->name('update.leave.status');
    });
    
    
       Route::middleware(['auth', IsEmployee::class])->prefix('employee')->group(function () {
   
        Route::get('/dashboard', [HomeController::class, 'index'])->name('employee.dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/attendance-regularization', [ProfileController::class, 'AttendanceRegularization'])->name('attendance-regularization');
    
        
    
        //Employee route leave 
        Route::get('/my-leave', [LeaveController::class, 'MyLeave'])->name('my-leave');
        Route::get('my-leave/create', [LeaveController::class, 'create'])->name('my-leave.create');
        Route::post('my-leave/store', [LeaveController::class, 'store'])->name('my-leave.store');
        Route::get('my-leave/{id}/edit', [LeaveController::class, 'edit'])->name('my-leave.edit');
        Route::put('my-leave/{id}', [LeaveController::class, 'update'])->name('my-leave.update');
        Route::delete('my-leave/{id}', [LeaveController::class, 'destroy'])->name('my-leave.destroy');
    
        Route::post('/save-punch-data', [AttendanceController::class, 'savePunchData'])->name('savePunchData');

    });


});

require __DIR__ . '/auth.php';