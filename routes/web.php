<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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

});

require __DIR__ . '/auth.php';