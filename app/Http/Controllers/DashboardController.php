<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function dashboardAdmin(Request $request)
{
    // Validasi role tetap dipertahankan
    if (Auth::user()->role !== 'admin') { abort(403); }

    // 1. Tangkap pilihan semester dari dropdown (default ke semester 2)
    $selectedSemester = $request->query('semester', 2);

    // 2. Hitung statistik berdasarkan semester yang dipilih
    $totalMahasiswa = Krs::where('semester', $selectedSemester)
                        ->distinct('mahasiswa_nim')
                        ->count();

    $totalDosen = MataKuliah::where('semester', $selectedSemester)
                        ->distinct('dosen_nidn')
                        ->count();

    $totalMatkulCount = MataKuliah::where('semester', $selectedSemester)->count();

    // 3. Ambil daftar mata kuliah aktif untuk tabel di dashboard
    $mataKuliahAktif = MataKuliah::where('semester', $selectedSemester)
                        ->with(['dosen.user']) // Mengambil nama dosen pengampu
                        ->get();

    // 4. Kirim semua data ke View
    return view('pages.admin.dashboard_admin', compact(
        'totalMahasiswa',
        'totalDosen',
        'totalMatkulCount',
        'mataKuliahAktif',
        'selectedSemester'
    ));
}
}
