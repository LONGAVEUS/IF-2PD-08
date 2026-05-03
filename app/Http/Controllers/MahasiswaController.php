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

    // Dummy data untuk demo dashboard
    $totalSks = 6;
    $sksMax = 24;
    $ips = 3.5;
    $ipk = 3.5;
    $jumlahSemester = 8;

    return view('pages.mahasiswa.dashboard_mahasiswa',
        compact('mahasiswa','totalSks','ips','ipk','sksMax','jumlahSemester'));
}

}
