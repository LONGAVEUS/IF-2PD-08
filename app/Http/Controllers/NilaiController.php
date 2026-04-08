<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index()
    {
       $data = [
    [
        'nim' => '3322301001',
        'nama' => 'Budi Santoso',
        'kode_mk' => 'IF301',
        'matkul' => 'Pemrograman Web'
    ],
    [
        'nim' => '3322301002',
        'nama' => 'Dewi Kartika',
        'kode_mk' => 'IF301',
        'matkul' => 'Pemrograman Web'
    ],
    [
        'nim' => '3322301003',
        'nama' => 'Rizky Maulana',
        'kode_mk' => 'IF301',
        'matkul' => 'Pemrograman Web'
    ],
    [
        'nim' => '3322301004',
        'nama' => 'Siti Aulia',
        'kode_mk' => 'IF301',
        'matkul' => 'Pemrograman Web'
    ],
];

        return view('input_nilai', compact('data'));
    }

    public function simpan(Request $request)
    {
        dd($request->all());
    }
}