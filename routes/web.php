<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\NilaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListItemController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'LoginPage']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/listitem/{id}/{nama}', [ListItemController::class, 'tampilkan']);

// Dosen
Route::get('/dashboard-dosen', [DosenController::class, 'tampilkan']);
Route::get('/input-nilai', [DosenController::class, 'inputNilai']);
Route::post('/input-nilai', [NilaiController::class, 'simpan'])->name('nilai.simpan');

// Data Users
Route::get('/data-users', [DashboardController::class, 'dataUsers']);

// Admin
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/krs', 'admin.pengaturan_krs');