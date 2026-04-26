<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KrsMahasiswaController;
use App\Http\Controllers\KhsMahasiswaController;
use App\Http\Controllers\PengaturanKrsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'LoginPage'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


Route::middleware('auth')->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'MahasiswaPage'])->name('dashboard_mahasiswa');
        Route::get('/isi_krs', [KrsMahasiswaController::class, 'isiKrs'])->name('isi_krs');
        Route::get('/lihat_khs', [KhsMahasiswaController::class, 'index'])->name('lihat_khs');


        Route::get('/krs', [KrsMahasiswaController::class, 'isiKrs'])->name('mahasiswa.krs');
        Route::post('/krs/tambah', [KrsMahasiswaController::class, 'tambahMataKuliah'])->name('mahasiswa.krs.tambah');
        Route::delete('/krs/{id}/hapus', [KrsMahasiswaController::class, 'hapusMataKuliah'])->name('mahasiswa.krs.hapus');
        Route::post('/krs/{id}/simpan', [KrsMahasiswaController::class, 'simpanKrs'])->name('mahasiswa.krs.simpan');
    });


    Route::prefix('dosen')->group(function () {
        Route::get('/dashboard', [DosenController::class, 'tampilkan'])->name('dashboard_dosen');
        Route::get('/input_nilai/{kode_mk?}', [DosenController::class, 'inputNilai'])->name('input_nilai');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboardAdmin'])->name('dashboard_admin');
        Route::get('/admin_krs', [DashboardController::class, 'pengaturanKrs'])->name('admin_krs');
        Route::get('/data_users', [DashboardController::class, 'dataUsers'])->name('data_users');
        Route::get('/admin_khs', [DashboardController::class, 'pengaturanKhs'])->name('admin_khs');

        Route::post('/pengaturan-krs/simpan', [PengaturanKrsController::class, 'saveKonfigurasi'])->name('pengaturan_krs.simpan');
    });

});
