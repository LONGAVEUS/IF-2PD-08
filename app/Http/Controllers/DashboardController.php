<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardAdmin(Request $request)
    {

        $selectedSemester = $request->query('semester', 1);


        $totalMahasiswa = Mahasiswa::where('semester_ke', $selectedSemester)->count();

        $totalDosen = MataKuliah::where('semester', $selectedSemester)
                                ->distinct('dosen_nidn')
                                ->count();


        $totalMatkulCount = MataKuliah::where('semester', $selectedSemester)->count();


        $mataKuliahAktif = MataKuliah::where('semester', $selectedSemester)
                                    ->with(['dosen.user'])
                                    ->orderBy('kode_mk', 'asc')
                                    ->paginate(5)
                                    ->withQueryString();

        return view('pages.admin.dashboard_admin', compact(
            'totalMahasiswa',
            'totalDosen',
            'totalMatkulCount',
            'mataKuliahAktif',
            'selectedSemester'
        ));
    }
}
