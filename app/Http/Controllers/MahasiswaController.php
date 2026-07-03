<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Krs;

class MahasiswaController extends Controller
{
    // Read - Menampilkan halaman dashboard utama mahasiswa
    public function MahasiswaPage()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        // Mengambil seluruh ringkasan metrik dashboard secara akurat lewat model KRS
        $data = Krs::dataDashboard($mahasiswa->nim, $mahasiswa->semester_ke);

        return view('pages.mahasiswa.dashboard_mahasiswa', compact('data'))->with([
            'ips'            => $data['ips'],
            'ipk'            => $data['ipk'],
            'totalSks'       => $data['totalSks'],
            'sksMax'         => $data['sksMax'],
            'jumlahSemester' => $data['jumlahSemester']
        ]);
    }
}
