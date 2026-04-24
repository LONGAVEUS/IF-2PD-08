<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Krs;

class DosenController extends Controller
{
    public function tampilkan()
    {
        $dosen = Auth::user()->dosen;

        if (!$dosen) {
            return "Data profil dosen tidak ditemukan.";
        }

        $mataKuliah = MataKuliah::where('dosen_nidn', $dosen->nidn)
            ->with(['krs.nilai'])
            ->get()
            ->map(function($mk) {
                $totalMhs = $mk->krs->count();
                $mhsPunyaNilai = $mk->krs->whereNotNull('nilai')->count();

                $mk->sudah_input = ($totalMhs > 0 && $totalMhs === $mhsPunyaNilai);
                $mk->rata_rata = $mk->krs->avg('nilai.bobot') ?? 0;

                return $mk;
            });

        $jumlahMatkul = $mataKuliah->count();
        $nilaiPending = $mataKuliah->where('sudah_input', false)->count();


        $totalMahasiswa = $mataKuliah->sum(fn($mk) => $mk->krs->count());
        $rataRataSemua = $mataKuliah->avg('rata_rata') ?? 0;



        return view('dosen.dashboard_dosen', compact(
            'mataKuliah',
            'jumlahMatkul',
            'nilaiPending',
            'totalMahasiswa',
            'rataRataSemua'
        ));
    }

   public function inputNilai($kode_mk = null)
    {
        $dosen = Auth::user()->dosen;

        $daftarMatkul = MataKuliah::where('dosen_nidn', $dosen->nidn)->get();

        $mahasiswaTerdaftar = null;
        $matkulTerpilih = null;

        if ($kode_mk) {
            $mahasiswaTerdaftar = Krs::with(['mahasiswa.user', 'nilai'])
                ->where('mk_kode', $kode_mk)
                ->get();
            $matkulTerpilih = MataKuliah::where('kode_mk', $kode_mk)->first();
        }

        return view('dosen.input_nilai', compact('daftarMatkul', 'mahasiswaTerdaftar', 'matkulTerpilih'));
    }
}
