<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KhsMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;


        $semesters = [1, 2, 3, 4, 5, 6, 7, 8];


        $selectedSemester = $request->get('semester', 1);

        $nilai = Nilai::with(['krs' => function($query) use ($mahasiswa, $selectedSemester) {
            $query->where('mahasiswa_nim', $mahasiswa->nim)
                  ->where('semester', $selectedSemester);
        }, 'krs.mata_kuliah'])
        ->whereHas('krs', function($query) use ($mahasiswa, $selectedSemester) {
            $query->where('mahasiswa_nim', $mahasiswa->nim)
                  ->where('semester', $selectedSemester);
        })
        ->get();


        $totalSks = $nilai->sum(function($n) {
            return $n->krs->mata_kuliah->sks ?? 0;
        });

        $totalKn = $nilai->sum(function($n) {
            $sks = $n->krs->mata_kuliah->sks ?? 0;
            return $sks * ($n->bobot ?? 0);
        });

        // Hitung IPS
        $ips = $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0.00;

        // Hitung IPK Riil
        $semuaNilaiLolos = Nilai::whereHas('krs', function($query) use ($mahasiswa) {
            $query->where('mahasiswa_nim', $mahasiswa->nim);
        })
        ->whereNotNull('bobot') 
        ->get();

        $totalSksKumulatif = $semuaNilaiLolos->sum(function($n) {
            return $n->krs->mata_kuliah->sks ?? 0; });

        $totalKnKumulatif = $semuaNilaiLolos->sum(function($n) {
            return ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0); });

        $ipk = $totalSksKumulatif > 0 ? round($totalKnKumulatif / $totalSksKumulatif, 2) : 0.00;

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
