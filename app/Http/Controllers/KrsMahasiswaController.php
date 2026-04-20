<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\KrsDetail;
use App\Models\Krs;

class KrsMahasiswaController extends Controller
{
    /*Halaman Isi KRS Mahasiswa*/
    public function isiKrs()
    {
        $user = Auth::user();

        // Ambil KRS aktif milik mahasiswa di semester ini
        $krs = Krs::where('mahasiswa_nim', $user->nim)
                  ->where('semester_id', $user->semester_id)
                  ->first();

        // Mata kuliah yang sudah dipilih di KRS ini
        $mataKuliahTerdaftar = $krs
            ? KrsDetail::with(['mataKuliah.dosen'])
                       ->where('krs_id', $krs->id)
                       ->get()
            : collect();

        // Semua mata kuliah tersedia (untuk popup pilih MK)
        // Exclude yang sudah dipilih
        $sudahDipilihIds = $mataKuliahTerdaftar->pluck('mata_kuliah_id')->toArray();

        $mataKuliahTersedia = MataKuliah::with('dosen')
            ->where('semester', $user->semester)
            ->whereNotIn('id', $sudahDipilihIds)
            ->get();

        // Info pengisian
        $infoKrs = [
            'mulai_pengisian'  => $krs?->mulai_pengisian?->format('d - m - Y') ?? '-',
            'batas_pengisian'  => $krs?->batas_pengisian?->format('d - m - Y') ?? '-',
            'semester'         => $user->semester ?? 'Genap 2025/2026',
            'ipk'              => number_format($user->ip_kumulatif ?? 0, 2),
            'ips'              => number_format($user->ip_semester   ?? 0, 2),
        ];

        return view('mahasiswa.isi_krs', compact(
            'infoKrs',
            'mataKuliahTerdaftar',
            'mataKuliahTersedia',
            'krs'
        ));
    }

    /*Tambah mata kuliah ke KRS*/
    public function tambahMataKuliah(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
        ]);

        $user = Auth::user();

        // Buat KRS jika belum ada
        $krs = Krs::firstOrCreate(
            [
                'mahasiswa_id' => $user->id,
                'semester'     => $user->semester,
            ],
            [
                'mulai_pengisian' => now(),
                'batas_pengisian' => now()->addDays(14),
                'status'          => 'draft',
            ]
        );

        // Cek duplikat
        $sudahAda = KrsDetail::where('krs_id', $krs->id)
                             ->where('mata_kuliah_id', $request->mata_kuliah_id)
                             ->exists();

        if ($sudahAda) {
            return back()->with('error', 'Mata kuliah sudah ada di KRS Anda.');
        }

        KrsDetail::create([
            'krs_id'         => $krs->id,
            'mata_kuliah_id' => $request->mata_kuliah_id,
        ]);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    /*Hapus mata kuliah dari KRS*/
    public function hapusMataKuliah($krsDetailId)
    {
        $user   = Auth::user();
        $detail = KrsDetail::whereHas('krs', fn($q) =>
                      $q->where('mahasiswa_id', $user->id)
                  )->findOrFail($krsDetailId);

        $detail->delete();

        return back()->with('success', 'Mata kuliah berhasil dihapus dari KRS.');
    }

    /*Simpan / submit KRS*/
    public function simpanKrs($krsId)
    {
        $user = Auth::user();
        $krs  = Krs::where('id', $krsId)
                   ->where('mahasiswa_id', $user->id)
                   ->firstOrFail();

        $krs->update(['status' => 'submitted']);

        return back()->with('success', 'KRS berhasil disimpan.');
    }
}