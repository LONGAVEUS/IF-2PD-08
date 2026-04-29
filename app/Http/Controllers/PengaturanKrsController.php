<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanKrsController extends Controller
{

    public function index()
    {
        $config = (object) [
            'semester' => session('semester', 1),
            'max_sks' => session('max_sks', 24)
        ];
        return view('pages.admin.pengaturan_krs', compact('config'));
    }

    public function saveKonfigurasi(Request $request)
    {
        $request->validate([
            'semester' => 'required|integer|min:1|max:14',
            'max_sks' => 'required|integer|min:1|max:100',
        ]);

        session([
            'semester' => $request->semester,
            'max_sks' => $request->max_sks,
        ]);

        return redirect()->back()->with('success', 'Konfigurasi berhasil disimpan.');
    }
}
