<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    // Dashboard utama
    public function index()
    {
        return view('dashboard_admin');
    }

    // Data User (Mahasiswa + Dosen)
    public function dataUsers()
    {
        $users = User::all(); // ambil semua user

        return view('data_users', compact('users'));
    }
}
