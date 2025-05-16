<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanPageController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\GajiController as AdminGajiController;
use App\Http\Controllers\HomeController;

// Halaman Utama (Redirect ke dashboard atau login)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes - PERBAIKAN DI SINI
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Middleware untuk proteksi route
Route::middleware(['auth'])->group(function () {
    // Karyawan Routes
    Route::middleware(['karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('dashboard', [KaryawanPageController::class, 'dashboard'])->name('dashboard');
        Route::post('clock-in', [KaryawanPageController::class, 'clockIn'])->name('clock.in');
        Route::post('clock-out', [KaryawanPageController::class, 'clockOut'])->name('clock.out');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminKaryawanController::class, 'dashboardAdmin'])->name('dashboard'); 

        // CRUD Karyawan
        Route::resource('karyawan', AdminKaryawanController::class);

        // Absensi
        Route::get('absensi/rekap', [AdminAbsensiController::class, 'rekapSemuaKaryawanView'])->name('absensi.rekap');
        Route::post('absensi/manage', [AdminAbsensiController::class, 'createOrUpdateAbsensi'])->name('absensi.manage');

        // Gaji
        Route::get('gaji', [AdminGajiController::class, 'indexGajiView'])->name('gaji.index');
        Route::get('gaji/hitung', [AdminGajiController::class, 'showHitungForm'])->name('gaji.hitung.form');
        Route::post('gaji/hitung', [AdminGajiController::class, 'hitungGajiBulanan'])->name('gaji.hitung.submit');
        Route::get('gaji/slip/{gaji}', [AdminGajiController::class, 'showSlipGajiView'])->name('gaji.slip');
    });
});