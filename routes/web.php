<?php

use App\Http\Controllers\LaporanTATController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperatorDashboardController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes for Operator
Route::middleware(['auth', 'role:operator'])->group(function () {
    // Dashboard Operator
    Route::get('/operator/dashboard', [LaporanTATController::class, 'index'])->name('operator.dashboard');
    
    // Halaman untuk menambah laporan
    Route::get('/operator/laporan/create', [LaporanTATController::class, 'create'])->name('operator.laporan.create');
    Route::post('/operator/laporan/store', [LaporanTATController::class, 'store'])->name('operator.laporan.store');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:operator'])->group(function () {
    // Dashboard Operator
    Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
    
    // Form untuk membuat laporan
    Route::get('/operator/laporan/create', [OperatorDashboardController::class, 'create'])->name('operator.laporan.create');
});

require __DIR__.'/auth.php';
