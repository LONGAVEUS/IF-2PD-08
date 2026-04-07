<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListItemController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'LoginPage']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/listitem/{id}/{nama}', [ListItemController::class, 'tampilkan']);
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/krs', 'admin.pengaturan_krs');