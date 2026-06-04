<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;

class KrsMahasiswaController extends Controller
{

    public function isiKrs()
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $mataKuliahTerdaftar = Krs::with('mata_kuliah.dosen.user')
            ->where('mahasiswa_nim', $mahasiswa->nim)
            ->where('semester', $mahasiswa->semester_ke)
            ->get();

        $sudahDipilihCodes = $mataKuliahTerdaftar->pluck('mk_kode')->toArray();

        $mataKuliahTersedia = MataKuliah::with('dosen.user')
            ->where('semester', $mahasiswa->semester_ke)
            ->whereNotIn('kode_mk', $sudahDipilihCodes)
            ->get();

        $nilaiLalu = \App\Models\Nilai::whereHas('krs', function($query) use ($mahasiswa) {
            $query->where('mahasiswa_nim', $mahasiswa->nim)
                  ->where('semester', '<', $mahasiswa->semester_ke);
        })
        ->whereNotNull('bobot')
        ->get();

        $totalSksLalu = $nilaiLalu->sum(function($n) {
            return $n->krs->mata_kuliah->sks ?? 0; });

        $totalKnLalu = $nilaiLalu->sum(function($n) {
            return ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0); });

        $ipkLalu = $totalSksLalu > 0 ? round($totalKnLalu / $totalSksLalu, 2) : 0.00;

        $semesterLalu = $mahasiswa->semester_ke - 1;
        $nilaiSemesterLalu = $nilaiLalu->filter(function($n) use ($semesterLalu) {
            return $n->krs->semester == $semesterLalu;
        });

        $totalSksSemesterLalu = $nilaiSemesterLalu->sum(function($n) {
            return $n->krs->mata_kuliah->sks ?? 0; });

        $totalKnSemesterLalu = $nilaiSemesterLalu->sum(function($n) {
            return ($n->krs->mata_kuliah->sks ?? 0) * ($n->bobot ?? 0); });

        $ipsLalu = $totalSksSemesterLalu > 0 ? round($totalKnSemesterLalu / $totalSksSemesterLalu, 2) : 0.00;

        $infoKrs = [
            'semester_aktif'   => "Semester " . $mahasiswa->semester_ke,
            'nim'              => $mahasiswa->nim,
            'ipk'              => number_format($ipkLalu, 2),
            'ips'              => number_format($ipsLalu, 2),
        ];

        return view('pages.mahasiswa.isi_krs', compact('infoKrs', 'mataKuliahTerdaftar', 'mataKuliahTersedia'));
    }

    public function tambahMataKuliah(Request $request)
    {

        $request->validate([
            'kode_mk' => 'required'
        ]);

        $mahasiswa = Auth::user()->mahasiswa;

        $sudahAda = Krs::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('mk_kode', $request->kode_mk)
            ->where('semester', $mahasiswa->semester_ke)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Mata kuliah ini sudah ditambahkan ke dalam rencana studi Anda!');
        }

        $sksSekarang = Krs::with('mata_kuliah')
            ->where('mahasiswa_nim', $mahasiswa->nim)
            ->where('semester', $mahasiswa->semester_ke)
            ->get()
            ->sum(fn($k) => $k->mata_kuliah->sks ?? 0);

        $matkulBaru = MataKuliah::where('kode_mk', $request->kode_mk)->firstOrFail();
        if (($sksSekarang + $matkulBaru->sks) > 24) {
            return redirect()->back()->with('error', 'Tidak dapat mengambil matakuliah lewat dari maksimum sks! ' );
        }

        Krs::create([
            'mahasiswa_nim' => $mahasiswa->nim,
            'mk_kode'       => $request->kode_mk,
            'semester'      => $mahasiswa->semester_ke,
        ]);


        return redirect()->back()->with('success', 'Mata kuliah berhasil ditambahkan ke rencana studi Anda!');
    }

    public function simpanKrs(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;


        $krsAktif = Krs::where('mahasiswa_nim', $mahasiswa->nim)
            ->where('semester', $mahasiswa->semester_ke)
            ->get();

        if ($krsAktif->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada mata kuliah yang dipilih.');
        }

        foreach ($krsAktif as $krs) {

            $sudahAda = Nilai::where('krs_id', $krs->id_krs)->exists();

            if (!$sudahAda) {
                Nilai::create([
                    'krs_id'      => $krs->id_krs,
                    'nilai_huruf' => null,
                    'bobot'       => null,
                ]);
            }
        }

        return redirect()->route('lihat_khs', ['semester' => $mahasiswa->semester_ke])
            ->with('success', 'KRS berhasil disimpan! Silakan cek draf nilai Anda di KHS.');
    }
    public function hapusMataKuliah($id)
    {

        $krsItem = Krs::where('id_krs', $id)->first();

        if ($krsItem) {

            $krsItem->delete();

            return redirect()->back()->with('success', 'Mata kuliah berhasil dibatalkan dari KRS.');
        }

        return redirect()->back()->with('error', 'Data KRS gagal ditemukan atau sudah dihapus.');
    }
}
