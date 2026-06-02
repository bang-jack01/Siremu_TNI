<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Dashboard_clientController;
use App\Http\Controllers\PrajuritController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Database Connected!";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});

// redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/client/profil', [ProfilController::class, 'client'])
        ->name('client.profil');
});


// ==================== AUTH ====================
// matiin register bawaan
Auth::routes(['register' => false]);

// register custom
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register-step-one', [RegisterController::class, 'registerStepOne'])->name('register.step.one');
Route::get('/verify-otp', [RegisterController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [RegisterController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/set-password', [RegisterController::class, 'showPasswordForm'])->name('set.password.form');
Route::post('/set-password', [RegisterController::class, 'setPassword'])->name('set.password');

// ==================== ADMIN ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/profil', [ProfilController::class, 'admin'])->name('admin.profil');
    Route::get('/admin/reset-password/{id}', [ProfilController::class, 'showResetPasswordForm'])->name('admin.reset-password');
    Route::post('/admin/reset-password/{id}', [ProfilController::class, 'updatePassword'])->name('admin.reset-password.update');
    
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::delete('/bulk-delete', [AdminController::class, 'bulkDelete'])->name('bulkDelete');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
        Route::get('/data', [AdminController::class, 'data'])->name('data');
        Route::get('/data/create', [AdminController::class, 'createData'])->name('data.create');
        Route::post('/data/store', [AdminController::class, 'storeData'])->name('data.store');
        Route::get('/monitoring', [AdminController::class, 'monitoring'])->name('monitoring');
        Route::get('/export-excel', [AdminController::class, 'exportExcel'])->name('exportExcel');
        Route::get('/chart-data', [AdminController::class, 'getChartData'])->name('chartData');

    });
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/notif/read-all', [NotificationController::class, 'markAllRead'])->name('notif.readAll');
    Route::delete('/notif/clear-read', [NotificationController::class, 'clearRead'])->name('notif.clearRead');
    Route::delete('/notif/delete/{id}', [NotificationController::class, 'delete'])->name('notif.delete');
});


// ==================== DASHBOARD & CLIENT ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [Dashboard_clientController::class, 'index'])->name('dashboard');
    Route::get('/input-data', [PrajuritController::class, 'create'])->name('input.data'); 
    Route::post('/input-data/store', [PrajuritController::class, 'store'])->name('input.store');
    Route::get('/input-data/edit/{id}', [PrajuritController::class, 'edit'])->name('input.edit'); 
    Route::put('/input-data/update/{id}', [PrajuritController::class, 'update'])->name('input.update'); 
});

// dashboard client
Route::get('/client/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('client.dashboard');
Route::get('/test123', function () {
    return 'OK';
});

