<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MataKuliah;
use App\Models\Nilai;

class NilaiController extends Controller
{
    // Read - Menampilkan halaman input nilai mahasiswa
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
                // Mengambil daftar mahasiswa lewat model matakuliah

                $mahasiswaTerdaftar = MataKuliah::mhsTerdaftar($kode_mk, $selectedSemester);
            }
        }

        return view('pages.dosen.input_nilai', compact(
            'daftarMatkul',
            'mahasiswaTerdaftar',
            'matkulTerpilih',
            'selectedSemester'
        ));
    }

    // Update - Menyimpan akumulasi nilai inputan dosen
    public function simpanNilai(Request $request)
    {
        $request->validate([
            'krs_id' => 'required|array',
            'nilai_angka' => 'required|array',
            'nilai_angka.*' => 'nullable|numeric|min:0|max:100',
        ]);

        if (!$request->krs_id) {
            return redirect()->back()->with('error', 'Tidak ada data nilai yang diproses.');
        }

        // Memproses simpan data massal lewat model nilai

        Nilai::simpanBanyakNilai($request->krs_id, $request->nilai_angka);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan!');
    }
}
