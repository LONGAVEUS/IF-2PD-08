<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListItemController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'LoginPage']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/listitem/{id}/{nama}', [ListItemController::class, 'tampilkan']);
Route::get('/dashboard-dosen', [DosenController::class, 'tampilkan']);
Route::get('/input-nilai', [DosenController::class, 'inputNilai']);
Route::get('/data-users', [DashboardController::class, 'dataUsers']);
Route::get('/test-nilai', [NilaiController::class, 'index']);
Route::post('/input-nilai', [NilaiController::class, 'simpan'])->name('nilai.simpan');