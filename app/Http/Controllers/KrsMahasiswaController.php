<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Krs;

class KrsMahasiswaController extends Controller
{

    public function isiKrs()
{
    $mahasiswa = Auth::user()->mahasiswa;

    // Query ke database
    $mataKuliahTerdaftar = Krs::with('mata_kuliah.dosen.user')
        ->where('mahasiswa_nim', $mahasiswa->nim)
        ->get();

    // Kalau hasil query kosong, isi dummy
    if ($mataKuliahTerdaftar->isEmpty()) {
        $mataKuliahTerdaftar = collect([
            (object)[
                'id' => 1,
                'mk_kode' => 'IF101',
                'mata_kuliah' => (object)[
                    'nama_mk' => 'Algoritma & Pemrograman',
                    'sks' => 3,
                    'dosen' => (object)[
                        'user' => (object)['name' => 'Dr. Budi Santoso']
                    ]
                ]
            ],
            (object)[
                'id' => 2,
                'mk_kode' => 'IF102',
                'mata_kuliah' => (object)[
                    'nama_mk' => 'Basis Data',
                    'sks' => 3,
                    'dosen' => (object)[
                        'user' => (object)['name' => 'Dr. Sari']
                    ]
                ]
            ],
        ]);
    }

    // Query matakuliah tersedia (boleh dummy juga kalau belum ada DB)
    $sudahDipilihCodes = $mataKuliahTerdaftar->pluck('mk_kode')->toArray();
    $mataKuliahTersedia = MataKuliah::with('dosen.user')
        ->where('semester', $mahasiswa->semester_ke)
        ->whereNotIn('kode_mk', $sudahDipilihCodes)
        ->get();

    if ($mataKuliahTersedia->isEmpty()) {
        $mataKuliahTersedia = collect([
            (object)[
                'kode_mk' => 'IF103',
                'nama_mk' => 'Pemrograman Web',
                'sks' => 3,
                'dosen' => (object)[
                    'user' => (object)['name' => 'Pak Andi']
                ]
            ]
        ]);
    }

    $infoKrs = [
        'batas_pengisian'  => '25 - 01 - 2026',
        'semester_aktif'   => "Semester " . $mahasiswa->semester_ke,
        'nim'              => $mahasiswa->nim,
        'ipk'              => number_format($mahasiswa->ip_kumulatif ?? 0, 2),
        'ips'              => number_format($mahasiswa->ip_semester ?? 0, 2),
    ];

    return view('pages.mahasiswa.isi_krs', compact('infoKrs', 'mataKuliahTerdaftar', 'mataKuliahTersedia'));
}

}
