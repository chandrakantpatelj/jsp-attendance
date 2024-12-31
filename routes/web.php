<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
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

    //Admin route
    Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('employee/{id}/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::delete('employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');


});

require __DIR__ . '/auth.php';