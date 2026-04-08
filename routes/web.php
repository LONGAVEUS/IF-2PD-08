<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'LoginPage']);
Route::get('/dashboard', [DashboardController::class, 'index']);

// Mahasiswa

// Dosen
Route::get('/dashboard_dosen', [DosenController::class, 'tampilkan']);
Route::get('/input_nilai', [DosenController::class, 'inputNilai']);
Route::post('/input_nilai', [NilaiController::class, 'simpan'])->name('nilai.simpan');

// Data Users
Route::get('/data_users', [DashboardController::class, 'dataUsers']);

// Admin
Route::view('/dashboard_admin', 'admin.dashboard');
Route::view('/admin_krs', 'admin.pengaturan_krs');
