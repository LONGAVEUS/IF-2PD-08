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



        return view('pages.dosen.dashboard_dosen', compact(
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

        return view('pages.dosen.input_nilai', compact('daftarMatkul', 'mahasiswaTerdaftar', 'matkulTerpilih'));
    }

    public function simpanNilai(Request $request)
{
    $krsIds = $request->krs_id;
    $nilaiAngkas = $request->nilai_angka;

    foreach ($krsIds as $i => $krsId) {
        $angka = $nilaiAngkas[$i];

        if ($angka === null || $angka === '') continue;

        $angka = (int) $angka;

        if ($angka >= 85) { $huruf = 'A'; $bobot = 4.0; }
        elseif ($angka >= 75) { $huruf = 'B'; $bobot = 3.0; }
        elseif ($angka >= 65) { $huruf = 'C'; $bobot = 2.0; }
        elseif ($angka >= 55) { $huruf = 'D'; $bobot = 1.0; }
        else { $huruf = 'E'; $bobot = 0.0; }

        \App\Models\Nilai::updateOrCreate(
            ['krs_id' => $krsId],
            ['nilai_huruf' => $huruf, 'bobot' => $bobot]
        );
    }

    return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
}
}