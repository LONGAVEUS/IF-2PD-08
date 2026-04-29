<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataMahasiswaController;
use App\Http\Controllers\DataDosenController;
use App\Http\Controllers\DataAdminController;
use App\Http\Controllers\DataMataKuliahController;
use App\Http\Controllers\KrsController;
use App\Http\Controllers\KhsController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KrsMahasiswaController;
use App\Http\Controllers\KhsMahasiswaController;
use App\Http\Controllers\PengaturanKrsController;
use App\Http\Controllers\PengaturanKhsController;
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

        // Mahasiswa
        Route::controller(DataMahasiswaController::class)->group(function () {
            Route::get('/data_mahasiswa', 'index')->name('data_mahasiswa');
            Route::post('/data_mahasiswa/store', 'store')->name('mahasiswa.store');
            Route::put('/data_mahasiswa/{id}/update', 'update')->name('mahasiswa.update');
            Route::delete('/data_mahasiswa/{id}/delete', 'destroy')->name('mahasiswa.destroy');
        });

        // Dosen
        Route::controller(DataDosenController::class)->group(function () {
            Route::get('/data_dosen', 'index')->name('data_dosen');
            Route::post('/data_dosen/store', 'store')->name('dosen.store');
            Route::put('/data_dosen/{id}/update', 'update')->name('dosen.update');
            Route::delete('/data_dosen/{id}/delete', 'destroy')->name('dosen.destroy');
        });

        Route::controller(DataAdminController::class)->group(function () {
            Route::get('/data_admin', 'index')->name('data_admin');
            Route::post('/data_admin/store', 'store')->name('admin.store');
            Route::put('/data_admin/{id}/update', 'update')->name('admin.update');
            Route::delete('/data_admin/{id}/delete', 'destroy')->name('admin.destroy');
        });

        Route::controller(DataMataKuliahController::class)->group(function () {
            Route::get('/data_matkul', 'index')->name('data_matkul');
            Route::post('/data_matkul/store', 'store')->name('matkul.store');
            Route::put('/data_matkul/{id}/update', 'update')->name('matkul.update');
            Route::delete('/data_matkul/{id}/delete', 'destroy')->name('matkul.destroy');
        });

        Route::get('/admin_krs', [PengaturanKrsController::class, 'index'])->name('admin_krs');
        Route::post('/pengaturan-krs/simpan', [PengaturanKrsController::class, 'saveKonfigurasi'])->name('pengaturan_krs.simpan');
        Route::get('/admin_khs', [PengaturanKhsController::class, 'index'])->name('admin_khs');
    });

});
