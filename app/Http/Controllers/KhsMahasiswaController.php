<?php

namespace App\Http\Controllers;

use App\Models\Krs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KhsMahasiswaController extends Controller
{
    // Read - Menampilkan KHS mahasiswa
    public function tampilKhs(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];
        $selectedSemester = $request->get('semester', 1);

        // Menggunakan method
        $nilai = Krs::ambilKhs($mahasiswa->nim, $selectedSemester);

        $totalSks = $nilai->sum(fn($n) => $n->krs->mata_kuliah->sks ?? 0);
        $totalKn = $nilai->sum(fn($n) => ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0));

        $ips = $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0.00;
        $ipk = Krs::hitungIpk($mahasiswa->nim);

        return view('pages.mahasiswa.lihat_khs', compact(
            'user',
            'nilai',
            'selectedSemester',
            'semesters',
            'totalSks',
            'totalKn',
            'ips',
            'ipk'
        ));
    }
}
