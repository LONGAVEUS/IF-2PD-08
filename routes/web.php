<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// 1. Redirect Utama
Route::get('/', function () {
    return redirect('/login');
});

// 2. Rute Khusus Tamu (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'LoginPage'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// 3. Rute Khusus User (Sudah Login)
Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Mahasiswa
    Route::get('/dashboard_mahasiswa', [MahasiswaController::class, 'MahasiswaPage'])->name('dashboard_mahasiswa');
    Route::get('/isi_krs', [MahasiswaController::class, 'dataKrs'])->name('isi_krs');
    Route::get('/lihat_khs', [MahasiswaController::class, 'LihatKhs'])->name('lihat_khs');

    // Dosen
    Route::get('/dashboard_dosen', [DosenController::class, 'tampilkan'])->name('dashboard_dosen');
    Route::get('/input_nilai', [DosenController::class, 'inputNilai'])->name('input_nilai');
    Route::post('/input_nilai', [NilaiController::class, 'simpan'])->name('nilai.simpan');

    // Admin
    Route::get('/dashboard_admin', [DashboardController::class, 'dashboardAdmin'])->name('dashboard_admin');
    Route::get('/admin_krs', [DashboardController::class, 'pengaturanKrs'])->name('admin_krs');
    Route::get('/data_users', [DashboardController::class, 'dataUsers'])->name('data_users');
    Route::get('/admin_khs', [DashboardController::class, 'pengaturanKhs'])->name('admin_khs');

});


