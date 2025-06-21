<?php

use App\Http\Controllers\LaporanTATController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OperatorDashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Response;
use PHPUnit\Framework\Constraint\Operator;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserManagementController;

Route::get('/', function () {
    return view('auth.login');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Routes for Operator
// Route::middleware(['auth', 'role:operator'])->group(function () {
//     // Dashboard Operator
//     Route::get('/operator/dashboard', [LaporanTATController::class, 'index'])->name('operator.dashboard');

//     // Halaman untuk menambah laporan
//     Route::get('/operator/laporan/create', [LaporanTATController::class, 'create'])->name('operator.laporan.create');
//     Route::post('/operator/laporan/store', [LaporanTATController::class, 'store'])->name('operator.laporan.store');
// });

// Profile Routes
Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');\
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
});

Route::middleware(['auth', 'role:operator'])->group(function () {
    Route::get('/operator/dashboard', [OperatorDashboardController::class, 'index'])->name('operator.dashboard');
    Route::get('/operator/laporan/preview/{id}', [OperatorDashboardController::class, 'previewLaporan'])->name('operator.laporan.preview');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/files/preview/{filename}', [OperatorDashboardController::class, 'preview'])->name('files.preview');
    Route::post('/operator/laporan/store', [OperatorDashboardController::class, 'store'])->name('operator.laporan.store');
    Route::get('/operator/laporan/create', [OperatorDashboardController::class, 'create'])->name('operator.laporan.create');
    Route::get('/operator/laporan/{id}/edit', [OperatorDashboardController::class, 'editlaporan'])->name('operator.laporan.edit');
    Route::put('/operator/laporan/{id}', [OperatorDashboardController::class, 'update'])->name('operator.laporan.update');
    Route::delete('/operator/hapus/{id}', [OperatorDashboardController::class, 'destroy'])->name('operator.laporan.delete');


});
Route::get('/csrf-token', function () {
    return Response::json(['csrf_token' => csrf_token()]);
});

Route::middleware('auth')->group(function () {});


Route::get('/table', function () {
    return view('operator.table');
})->name('operator.table');
Route::middleware(['auth', 'role:admin_bnn'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/laporan/{id}', [AdminController::class, 'show'])->name('admin.laporan.show');
        Route::get('/laporan/{id}/approve', [AdminController::class, 'approve'])->name('admin.laporan.approve');
        Route::get('/laporan/{id}/reject', [AdminController::class, 'reject'])->name('admin.laporan.reject');
        Route::get('/admin/surat-masuk', [AdminController::class, 'suratMasuk'])->name('admin.suratmasuk');
        Route::post('/laporan/{id}/terima', [AdminController::class, 'terima'])->name('admin.terima');
        Route::post('/laporan/{id}/tolak', [AdminController::class, 'tolak'])->name('admin.tolak');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
        Route::post('/admin/laporan/{id}/setujui', [AdminController::class, 'setujui'])->name('admin.laporan.setujui');
        Route::post('/admin/laporan/{id}/tolak', [AdminController::class, 'tolak'])->name('admin.laporan.tolak');
        Route::get('/admin/laporan/{id}/detail', [AdminController::class, 'show'])->name('admin.laporan.detail');
        Route::get('/admin/laporan/{id}/preview/{field}', [AdminController::class, 'preview'])->name('admin.laporan.preview');
        Route::get('admin/laporan/{id}/hasilpreview/{field}', [AdminController::class, 'previewDokumen'])->name('admin.laporan.preview');
        Route::get('/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [UserManagementController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::get('/users/show/{id}', [UserManagementController::class, 'show'])->name('admin.users.show');
        Route::post('/users/{userId}/reset-password', [UserManagementController::class, 'resetPassword'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        
    });
});


require __DIR__ . '/auth.php';
