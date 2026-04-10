<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function MahasiswaPage() {
        return view('mahasiswa.dashboard_mahasiswa');
    }

    public function dataKrs() {
        return view('mahasiswa.isi_krs');

    }

    public function LihatKhs() {
        return view('mahasiswa.lihat_khs');
    }
}
