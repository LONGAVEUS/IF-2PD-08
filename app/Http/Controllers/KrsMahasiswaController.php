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

        $mataKuliahTerdaftar = Krs::with('mata_kuliah.dosen.user')
            ->where('mahasiswa_nim', $mahasiswa->nim)
            ->get();


        $sudahDipilihCodes = $mataKuliahTerdaftar->pluck('mk_kode')->toArray();
        $mataKuliahTersedia = MataKuliah::with('dosen.user')
            ->where('semester', $mahasiswa->semester_ke)
            ->whereNotIn('kode_mk', $sudahDipilihCodes)
            ->get();


        $infoKrs = [
            'batas_pengisian'  => '25 - 01 - 2026',
            'semester_aktif'   => "Semester " . $mahasiswa->semester_ke,
            'nim'              => $mahasiswa->nim,
            'ipk'              => number_format($mahasiswa->ip_kumulatif ?? 0, 2),
            'ips'              => number_format($mahasiswa->ip_semester ?? 0, 2),
        ];

        return view('pages.mahasiswa.isi_krs', compact('infoKrs', 'mataKuliahTerdaftar', 'mataKuliahTersedia'));
    }

    public function tambahMataKuliah(Request $request)
    {
        $request->validate(['kode_mk' => 'required|exists:mata_kuliah,kode_mk']);
        $mahasiswa = Auth::user()->mahasiswa;


        $cek = Krs::where('mahasiswa_nim', $mahasiswa->nim)->where('mk_kode', $request->kode_mk)->exists();
        if ($cek) return back()->with('error', 'Mata kuliah sudah ada.');

        $mk = MataKuliah::where('kode_mk', $request->kode_mk)->first();

        Krs::create([
            'mahasiswa_nim' => $mahasiswa->nim,
            'mk_kode'       => $request->kode_mk,
            'semester'      => $mk->semester,
        ]);

        return back()->with('success', 'Berhasil ditambahkan.');
    }

    public function hapusMataKuliah($idKrs)
    {
        $krs = Krs::where('id_krs', $idKrs)
                  ->where('mahasiswa_nim', Auth::user()->mahasiswa->nim)
                  ->firstOrFail();

        $krs->delete();
        return back()->with('success', 'Berhasil dihapus.');
    }
}
