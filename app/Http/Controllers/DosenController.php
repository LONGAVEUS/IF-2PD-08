<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;

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

        return view('pages.dosen.dashboard_dosen', compact(
            'mataKuliah',
            'jumlahMatkul',
            'nilaiPending',
            'totalMahasiswa',
            'rataRataSemua'
        ));
    }
}
