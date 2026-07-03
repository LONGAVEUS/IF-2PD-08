<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;

class DosenController extends Controller
{
    // Read - dashboard dosen
    public function tampilkan()
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return "Data profil dosen tidak ditemukan.";
        }

        // Mengambil kueri data matakuliah terproses lewat model
        $mataKuliah = MataKuliah::dataDashboard($dosen->nidn);

        // Menghitung statistik ringkasan lewat model
        $statistik = MataKuliah::hitungStatistik($mataKuliah);

        return view('pages.dosen.dashboard_dosen', array_merge(
            ['mataKuliah' => $mataKuliah],
            $statistik
        ));
    }
}
