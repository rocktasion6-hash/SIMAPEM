<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\WargaAIChatController;
use App\Http\Controllers\AiComplaintImproveController;
use App\Enums\UserRole;
/*
|--------------------------------------------------------------------------
| Web Routes SIMAPEM
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
    });

// Middleware auth memastikan hanya user yang sudah login bisa masuk
Route::middleware(['auth'])->group(function () {

    /**
     * 1. ROLE: WARGA (Penyampai Laporan)
     */
    Route::prefix('warga')->name('warga.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'warga'])->name('dashboard');
        Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/create', [ComplaintController::class, 'create'])->name('complaints.create');
        Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
        Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
        Route::get('/complaints/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaints.edit');
        Route::put('/complaints/{complaint}', [ComplaintController::class, 'update'])->name('complaints.update');
        Route::delete('/complaints/{complaint}', [ComplaintController::class, 'destroy'])->name('complaints.destroy');
    });

    Route::post('/warga/ai-chat', [WargaAIChatController::class, 'chat'])
    ->middleware('auth')
    ->name('warga.ai.chat');

    /**
     * 2. ROLE: FRONT OFFICE (Verifikator & Validasi)
     */
    Route::prefix('fo')->name('fo.')->group(function () {
        Route::get('/verifikasi', [VerificationController::class, 'index'])->name('verifikasi.index');
        Route::patch('/verifikasi/{complaint}', [VerificationController::class, 'update'])->name('verifikasi.update');
    });

    /**
     * 3. ROLE: KASI (Penanggung Jawab / Penugasan)
     */
    Route::prefix('kasi')->name('kasi.')->group(function () {
        Route::get('/assignment', [AssignmentController::class, 'index'])->name('assignment.index');
        Route::post('/assignment/{complaint}', [AssignmentController::class, 'store'])->name('assignment.store');
    });

    /**
     * 4. ROLE: PELAKSANA (Petugas Lapangan)
     */
    Route::prefix('pelaksana')->name('pelaksana.')->group(function () {
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{complaint}', [TaskController::class, 'show'])->name('tasks.show');
        Route::patch('/tasks/{complaint}', [TaskController::class, 'update'])->name('tasks.update');
    });

    /**
     * 5. ROLE: KADIS (Monitoring / Dashboard)
     */
    Route::prefix('kadis')->name('kadis.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/complaints', [DashboardController::class, 'complaints'])->name('complaints.index');
        Route::get('/complaints/{complaint}', [DashboardController::class, 'showComplaint'])->name('complaints.show');
    });

    Route::get('/logout', function () {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
        return redirect('/');
    });

    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
});

// Rute autentikasi bawaan Laravel (Login, Logout, Register)
require __DIR__.'/auth.php';