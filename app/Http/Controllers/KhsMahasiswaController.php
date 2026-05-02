<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class KhsMahasiswaController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        // daftar semester statis/dummy
        $semesters = [1,2,3,4,5,6,7,8];
        $selectedSemester = 1; // default semester

        // Dummy data manual
        $nilai = $this->getData($selectedSemester);

        // Hitung ringkasan
        $totalSks = collect($nilai)->sum('sks');
        $totalKn  = collect($nilai)->sum('kn');
        $ips      = $totalSks > 0 ? round($totalKn / $totalSks, 2) : 0;
        $ipk      = $ips; // untuk demo, samakan dulu

        return view('pages.mahasiswa.lihat_khs', compact(
            'user','nilai','selectedSemester','semesters',
            'totalSks','totalKn','ips','ipk'
        ));
    }

    private function getData($selectedSemester)
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
