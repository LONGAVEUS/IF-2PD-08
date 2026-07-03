<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Read - menampilkan halaman dashboard utama admin
    public function dashboardAdmin(Request $request)
    {
        $selectedSemester = $request->query('semester', 1);

        // Ambil seluruh data ringkasan dashboard lewat model Admin
        $data = Admin::dataDashboard($selectedSemester);

        return view('pages.admin.dashboard_admin', array_merge(
            ['selectedSemester' => $selectedSemester],
            $data
        ));
    }
}
