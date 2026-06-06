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
    $totalSks = 0;
    $sksMax = 0;
    $ips = 0;
    $ipk = 0;
    $jumlahSemester = 0;

    return view('pages.mahasiswa.dashboard_mahasiswa',
        compact('mahasiswa','totalSks','ips','ipk','sksMax','jumlahSemester'));
}

}
