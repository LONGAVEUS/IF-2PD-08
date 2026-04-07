<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListItemController;
use App\Http\controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'LoginPage']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/listitem/{id}/{nama}', [ListItemController::class, 'tampilkan']);
