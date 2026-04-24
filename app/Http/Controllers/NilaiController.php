<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Krs;
use App\Models\Nilai;
use App\Models\MataKuliah;

class NilaiController extends Controller
{
    public function index($kode_mk)
    {
        $dataKrs = Krs::with(['mahasiswa.user', 'nilai'])
            ->where('mk_kode', $kode_mk)
            ->get();

        $matkul = MataKuliah::where('kode_mk', $kode_mk)->firstOrFail();

        return view('dosen.input_nilai', compact('dataKrs', 'matkul'));
    }

    public function simpan(Request $request)
    {

        $request->validate([
            'id_krs'      => 'required|exists:krs,id_krs',
            'nilai_huruf' => 'required|in:A,B+,B,C+,C,D,E',
        ]);

        $bobotMapping = [
            'A'  => 4.0,
            'B+' => 3.5,
            'B'  => 3.0,
            'C+' => 2.5,
            'C'  => 2.0,
            'D'  => 1.0,
            'E'  => 0.0,
        ];

        $bobot = $bobotMapping[$request->nilai_huruf] ?? 0;

        Nilai::updateOrCreate(
            ['krs_id' => $request->id_krs],
            [
                'nilai_huruf' => $request->nilai_huruf,
                'bobot'       => $bobot,
            ]
        );

        return back()->with('success', 'Nilai ' . $request->nilai_huruf . ' berhasil disimpan.');
    }
}
