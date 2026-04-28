<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class KhsMahasiswaController extends Controller
{
     public function index()
    {
        $user = Auth::user();
        $semester = request('semester', 1);

        // Dummy data manual
        $nilai = $this->getData($semester);

        // Hitung ringkasan
        $totalSks = collect($nilai)->sum('sks');
        $totalKn  = collect($nilai)->sum('kn');
        $ips      = $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0;
        $ipk      = $ips; // untuk demo, samakan dulu

        $semesters = [1,2]; // contoh dropdown semester

        return view('pages.mahasiswa.lihat_khs', compact(
            'user','nilai','semester','semesters',
            'totalSks','totalKn','ips','ipk'
        ));
    }

    private function getData($semester)
{
    return [
        (object)[
            'mataKuliah' => (object)['kode_mk' => 'IF101', 'nama_mk' => 'Algoritma & Pemrograman'],
            'sks' => 3, 'nilai_huruf' => 'A', 'bobot' => 4, 'kn' => 12,
        ],
        (object)[
            'mataKuliah' => (object)['kode_mk' => 'IF102', 'nama_mk' => 'Basis Data'],
            'sks' => 3, 'nilai_huruf' => 'B', 'bobot' => 3, 'kn' => 9,
        ],
    ];
}

}
