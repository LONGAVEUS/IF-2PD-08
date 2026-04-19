<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboardAdmin()
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return view('admin.dashboard_admin');
    }

    public function dataUsers()
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        $users = User::all();
        return view('admin.data_users', compact('users'));
    }

    public function pengaturanKrs()
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return view('admin.pengaturan_krs');
    }

    public function pengaturanKhs()
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        return view('admin.pengaturan_khs');
    }
}
