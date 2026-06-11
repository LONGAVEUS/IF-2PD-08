<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Krs;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function inputNilai(Request $request, $kode_mk = null)
    {
        $dosen = Auth::user()->dosen;
        $selectedSemester = $request->get('semester');

        if (!$kode_mk) {
            $kode_mk = $request->get('kode_mk');
        }

        $daftarMatkul = MataKuliah::where('dosen_nidn', $dosen->nidn)->get();
        $mahasiswaTerdaftar = null;
        $matkulTerpilih = null;

        if ($kode_mk) {
            $matkulTerpilih = MataKuliah::where('kode_mk', $kode_mk)
                ->where('dosen_nidn', $dosen->nidn)
                ->first();

            if ($matkulTerpilih) {
                $mahasiswaQuery = Krs::with(['mahasiswa.user', 'nilai'])
                    ->where('mk_kode', $kode_mk);

                if ($selectedSemester) {
                    $mahasiswaQuery->where('semester', $selectedSemester);
                }

                $mahasiswaTerdaftar = $mahasiswaQuery->get();
            }
        }

        return view('pages.dosen.input_nilai', compact(
            'daftarMatkul',
            'mahasiswaTerdaftar',
            'matkulTerpilih',
            'selectedSemester'
        ));
    }

    public function simpanNilai(Request $request)
    {
        $request->validate([
            'krs_id' => 'required|array',
            'nilai_angka' => 'required|array',
            'nilai_angka.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $krsIds = $request->krs_id;
        $nilaiAngkas = $request->nilai_angka;

        if (!$krsIds) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang diproses.');
        }

        foreach ($krsIds as $i => $krsId) {
            $angka = $nilaiAngkas[$i];

            if ($angka === null || $angka === '') continue;

            $evaluasi = new KonverterNilaiResmi($angka);
            $hasilGrading = $evaluasi->hitungGrade();

            Nilai::updateOrCreate(
                ['krs_id' => $krsId],
                [
                    'nilai_huruf' => $hasilGrading['huruf'],
                    'bobot' => $hasilGrading['bobot']
                ]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}

abstract class EvaluasiAkademik
{
    protected $nilaiAngka;

    public function __construct($nilaiAngka)
    {
        $this->nilaiAngka = (int) $nilaiAngka;
    }

    abstract public function hitungGrade();
}

class KonverterNilaiResmi extends EvaluasiAkademik
{
    public function hitungGrade()
    {
        if ($this->nilaiAngka >= 85) {
            return ['huruf' => 'A', 'bobot' => 4.0];
        } elseif ($this->nilaiAngka >= 80) {
            return ['huruf' => 'A-', 'bobot' => 3.7];
        } elseif ($this->nilaiAngka >= 75) {
            return ['huruf' => 'B+', 'bobot' => 3.3];
        } elseif ($this->nilaiAngka >= 70) {
            return ['huruf' => 'B', 'bobot' => 3.0];
        } elseif ($this->nilaiAngka >= 65) {
            return ['huruf' => 'B-', 'bobot' => 2.7];
        } elseif ($this->nilaiAngka >= 60) {
            return ['huruf' => 'C+', 'bobot' => 2.3];
        } elseif ($this->nilaiAngka >= 55) {
            return ['huruf' => 'C', 'bobot' => 2.0];
        } elseif ($this->nilaiAngka >= 50) {
            return ['huruf' => 'C-', 'bobot' => 1.7];
        } elseif ($this->nilaiAngka >= 45) {
            return ['huruf' => 'D+', 'bobot' => 1.3];
        } elseif ($this->nilaiAngka >= 40) {
            return ['huruf' => 'D', 'bobot' => 1.0];
        } else {
            return ['huruf' => 'E', 'bobot' => 0.0];
        }
    }
}