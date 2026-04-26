<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanKrsController extends Controller
{
    public function saveKonfigurasi(Request $request)
    {
        $request->validate([
            'semester' => 'required|integer|min:1|max:14',
            'max_sks' => 'required|integer|min:1|max:100',
        ]);

        // sementara simpan di session (frontend demo)
        session([
            'semester' => $request->semester,
            'max_sks' => $request->max_sks,
        ]);

        return redirect()->back()->with('success', 'Konfigurasi berhasil disimpan.');
    }
}
