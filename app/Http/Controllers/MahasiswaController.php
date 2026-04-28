<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Krs;

class MahasiswaController extends Controller
{

    public function MahasiswaPage()
{
    $mahasiswa = Auth::user()->mahasiswa;
    $totalSks = Krs::where('mahasiswa_nim', $mahasiswa->nim)
        ->where('semester', $mahasiswa->semester_ke)
        ->with('mata_kuliah')
        ->get()
        ->sum(fn($k) => $k->mata_kuliah->sks ?? 0);

    return view('pages.mahasiswa.dashboard_mahasiswa', compact('mahasiswa', 'totalSks'));
    }
        public function LihatKhs()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $khs = Krs::with(['mata_kuliah', 'nilai'])
            ->where('mahasiswa_nim', $mahasiswa->nim)
            ->get();

        return view('pages.mahasiswa.lihat_khs', compact('mahasiswa', 'khs'));
    }
}
