<?php
namespace App\Http\Controllers;

use App\Models\Krs;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboardAdmin(Request $request)
    {
        if (Auth::user()->role !== 'admin') { abort(403); }

        $selectedSemester = $request->query('semester', 2);

        $totalMahasiswa = Krs::where('semester', $selectedSemester)->distinct('mahasiswa_nim')->count();
        $totalDosen = MataKuliah::where('semester', $selectedSemester)->distinct('dosen_nidn')->count();
        $totalMatkulCount = MataKuliah::where('semester', $selectedSemester)->count();

        $mataKuliahAktif = MataKuliah::where('semester', $selectedSemester)->with(['dosen.user'])->get();

        return view('pages.admin.dashboard_admin', compact(
            'totalMahasiswa', 'totalDosen', 'totalMatkulCount', 'mataKuliahAktif', 'selectedSemester'
        ));
    }
}
