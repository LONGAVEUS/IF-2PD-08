<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Krs;
use App\Models\Mahasiswa;

class MahasiswaController extends Controller
{
    public function MahasiswaPage()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $nim = $mahasiswa->nim;
        $semesterAktif = $mahasiswa->semester_ke;

        // Total SKS semester aktif
        $totalSks = Krs::where('mahasiswa_nim', $nim)
            ->where('semester', $semesterAktif)
            ->with('mata_kuliah')
            ->get()
            ->sum(fn($krs) => $krs->mata_kuliah->sks);

        // IPS semester aktif (rata-rata bobot)
        $ips = Krs::where('mahasiswa_nim', $nim)
            ->where('semester', $semesterAktif)
            ->with('nilai')
            ->get()
            ->avg(fn($krs) => $krs->nilai?->bobot);
        $ips = $ips ? round($ips, 2) : 0;

        // IPK (rata-rata bobot semua semester)
        $ipk = Krs::where('mahasiswa_nim', $nim)
            ->with('nilai')
            ->get()
            ->avg(fn($krs) => $krs->nilai?->bobot);
        $ipk = $ipk ? round($ipk, 2) : 0;

        // Jumlah semester yang sudah ditempuh
        $jumlahSemester = Krs::where('mahasiswa_nim', $nim)
            ->distinct('semester')
            ->count('semester');

        // Batas maksimal SKS (aturan kampus, misalnya 24)
        $sksMax = 24;

        return view('pages.mahasiswa.dashboard_mahasiswa', compact(
            'ips',
            'ipk',
            'totalSks',
            'sksMax',
            'jumlahSemester'
        ));
    }
}
