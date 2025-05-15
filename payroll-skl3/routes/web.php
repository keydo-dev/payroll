<?php

// routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; // Sesuaikan namespace jika berbeda
use App\Http\Controllers\KaryawanPageController;
use App\Http\Controllers\Admin\KaryawanController as AdminKaryawanController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\GajiController as AdminGajiController;
use App\Http\Controllers\HomeController; // Controller baru untuk landing/redirect

// Halaman Utama (Bisa landing atau redirect ke dashboard)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
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
        // Route untuk riwayat absensi bisa jadi bagian dari dashboard atau halaman terpisah
        // Route::get('absensi/riwayat', [KaryawanPageController::class, 'riwayatAbsensi'])->name('absensi.riwayat');
    });

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminKaryawanController::class, 'dashboardAdmin'])->name('dashboard'); // Buat method ini

        // CRUD Karyawan (Contoh resource controller)
        Route::resource('karyawan', AdminKaryawanController::class);

        // Absensi
        Route::get('absensi/rekap', [AdminAbsensiController::class, 'rekapSemuaKaryawanView'])->name('absensi.rekap'); // Method baru untuk view
        Route::post('absensi/manage', [AdminAbsensiController::class, 'createOrUpdateAbsensi'])->name('absensi.manage');


        // Gaji
        Route::get('gaji', [AdminGajiController::class, 'indexGajiView'])->name('gaji.index'); // Method baru untuk list gaji
        Route::get('gaji/hitung', [AdminGajiController::class, 'showHitungForm'])->name('gaji.hitung.form'); // Method baru untuk form hitung
        Route::post('gaji/hitung', [AdminGajiController::class, 'hitungGajiBulanan'])->name('gaji.hitung.submit');
        Route::get('gaji/slip/{gaji}', [AdminGajiController::class, 'showSlipGajiView'])->name('gaji.slip'); // Method baru untuk view slip
    });
});